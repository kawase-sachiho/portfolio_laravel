<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TodoItem;
use App\Models\Blog;
use App\Models\LongSchedule;
use App\Models\ShortSchedule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
class StudyController extends Controller
{
    /**
     *  TOP画面の表示
     *  @param Request $request
     *  @return view
     */
    public function __invoke(Request $request)
    {
        /*カレンダーに対するデータの取得 */
        //表示したい年（デフォルトは今日の年）
        $year = $request->input('year') ?? Carbon::today()->format('Y');
        //表示したい月（デフォルトは今日の月）
        $month = $request->input('month') ?? Carbon::today()->format('m');

        //表示する年月の初日
        $calendarYm = Carbon::Create($year, $month, 01, 00, 00, 00);
        //カレンダーの日付を$calendarDaysの配列に集める
        $calendarDays = [];
        //月初の日付が日曜日ではないときの、追加する前月カレンダーの日付
        if ($calendarYm->dayOfWeek != 0) {
            $calendarStartDay = $calendarYm->copy()->subDays($calendarYm->dayOfWeek);
            for ($i = 0; $i < $calendarYm->dayOfWeek; $i++) {
                $calendarDays[] = ['date' => $calendarStartDay->copy()->addDays($i), 'show' => false, 'status' => false];
            }
        }
        //当月の日付
        for ($i = 0; $i < $calendarYm->daysInMonth; $i++) {
            if ($calendarYm->copy()->addDays($i) >= Carbon::now()) {
                $show = true;
                $status = true;
            } else {
                $show = true;
                $status = false;
            }
            $calendarDays[] = ['date' => $calendarYm->copy()->addDays($i), 'show' => $show, 'status' => $status];
        }
        //月末の日付が土曜日ではないときの、追加する翌月カレンダーの日付
        if ($calendarYm->copy()->endOfMonth()->dayOfWeek != 6) {
            for ($i = $calendarYm->copy()->endOfMonth()->dayOfWeek + 1; $i < 7; $i++) {
                $calendarDays[] = ['date' => $calendarYm->copy()->addDays($i), 'show' => false, 'status' => false];
            }
        }
        /* 学習時間のグラフに関するデータの取得 */
        //半年分の月データを入れる
        $month_past = Carbon::now()->subMonths(5)->format('Y-m-d');
        $month_now = Carbon::now()->format('Y-m-d');
        $period = CarbonPeriod::create($month_past, "1 month", $month_now);

        foreach ($period as $key => $value) {
            $past_months[] = $value->format('m');
        }
        foreach ($period as $key => $value) {
            $labels[] = $value->format('m月');
        }
        foreach ($past_months as $past_month) {
            $data[] = Blog::whereMonth('learning_date', $past_month)->where('user_id', Auth::id())->sum('study_time');
        }
        /* 目標・TODO項目に関するデータの取得 */
        $d = Carbon::today();
        $todo_items = TodoItem::whereDate('expire_date', '=', $d)->where('user_id', Auth::id())->orderBy('expire_date', 'asc')->get();
        $blogs = Blog::where('user_id', Auth::id())->get();
        $long_goal = LongSchedule::orderBy('expire_date', 'asc')->where('user_id', Auth::id())->first();
        if (isset($long_goal->id)) {
            //長期目標が設定されていた場合
            //長期目標の期限日と本日の日付の差分を取得する
            $long_goal_diff_days = Carbon::create($long_goal->expire_date->format('Y-m-d'))->diffInDays(Carbon::create($d->format('Y-m-d')));
            //長期目標に付随する短期目標を取得する
            $short_goals = ShortSchedule::where('long_schedule_id', $long_goal->id)->where('user_id', Auth::id())->orderBy('expire_date', 'asc')->get();
            //長期目標の期限日と本日の日付の差分を取得する
            foreach ($short_goals as $short_goal) {
                $short_goal_diff_days = Carbon::create($short_goal->expire_date->format('Y-m-d'))->diffInDays(Carbon::create($d->format('Y-m-d')));
                $short_goal->short_goal_diff_days = $short_goal_diff_days;
            }
            return view('study.index', compact('d', 'blogs', 'todo_items', 'long_goal', 'long_goal_diff_days', 'short_goals', 'labels', 'data'), [
                'calendarDays' => $calendarDays, //集めた日付
                'previousMonth' => $calendarYm->copy()->subMonth(), //前月
                'nextMonth' => $calendarYm->copy()->addMonth(), //翌月
                'thisMonth' => $calendarYm, //当月
            ]);
            //目標が設定されていない場合、日付の差分や短期目標は取得しない
        } else {
            return view('study.index', compact('d', 'blogs', 'todo_items', 'long_goal', 'labels', 'data'), [
                'calendarDays' => $calendarDays, //集めた日付
                'previousMonth' => $calendarYm->copy()->subMonth(), //前月
                'nextMonth' => $calendarYm->copy()->addMonth(), //翌月
                'thisMonth' => $calendarYm, //当月
            ]);
        }
    }
}
