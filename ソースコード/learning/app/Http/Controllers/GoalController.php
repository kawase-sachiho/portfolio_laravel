<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LongGoalRequest;
use App\Http\Requests\ShortGoalRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\LongSchedule;
use App\Models\ShortSchedule;
use Carbon\Carbon;


class GoalController extends Controller
{
    /**
     * ユーザーIDのチェックを行う
     * @param LongSchedule $long_goal
     * @return void 
     * @throws HttpException  */
    private function checkLongTermGoalUserID(LongSchedule $long_goal, int $status = 404)
    {
        //ログイン中のIDと長期目標のユーザーIDが正しいかをチェックする
        if (Auth::user()->id != $long_goal->user_id) {
            abort($status);
        }
    }

    /**  ユーザーIDのチェックを行う
     * @param ShortSchedule $short_goal
     * @return void 
     * @throws HttpException  */
    private function checkShortTermGoalUserID(ShortSchedule $short_goal, int $status = 404)
    {
        //ログイン中のIDと短期目標のユーザーIDが正しいかをチェックする
        if (Auth::user()->id != $short_goal->user_id) {
            abort($status);
        }
    }

    /**目標一覧画面表示
     * @return view
     */
    public function index()
    {
        $d = Carbon::now();
        $long_goals = LongSchedule::where('user_id', Auth::id())->orderBy('expire_date', 'asc')->paginate(1);
        foreach ($long_goals as $long_goal) {
            //長期目標の期限日と本日の日付の差分を取得する
            $long_goal_diff_days = Carbon::create($long_goal->expire_date->format('Y-m-d'))->diffInDays(Carbon::create($d->format('Y-m-d')));
            $long_goal->long_goal_diff_days = $long_goal_diff_days;
        }
        foreach ($long_goals as $long_goal) {
            if ($long_goal->expire_date < date('Y-m-d') && is_null($long_goal->finished_date)) {
                //期限日が今日を過ぎていて、かつ、完了日がnullのとき、期限日を過ぎたレコードの背景色を変える
                $class = "text-danger";
            } elseif (!is_null($long_goal->finished_date)) {
                //完了日に値があるときは、完了したレコードの文字に打消し線を入れる
                $class = "del";
            } else {
                $class = "";
            }
            $long_goal->class = $class;
        }
        return view('goals.index', compact('long_goals'));
    }

    /**
     * 長期目標の追加画面表示
     * @return view
     */
    public function createLongGoal()
    {
        return view('goals.long.create');
    }

    /** 
     * 長期目標の追加処理
     * @param LongGoalRequest $request 
     * @return void   */
    public function storeLongGoal(LongGoalRequest $request)
    {
        $long_goal = new LongSchedule();
        $long_goal->fill($request->all());
        $long_goal->user_id = Auth::user()->id;
        $long_goal->registration_date = date('Y-m-d');
        $long_goal->save();
        return redirect(route('goals.index'));
    }

    /**
     * 長期目標の修正画面表示
     * @param LongSchedule $long_goal 
     * @return view
     */
    public function editLongGoal(LongSchedule $long_goal)
    {
        $this->checkLongTermGoalUserID($long_goal);
        return view('goals.long.edit', compact('long_goal'));
    }

    /**
     * 長期目標の更新処理
     * @param LongSchedule $long_goal
     * LongGoalRequest $request 
     * @return void
     */
    public function updateLongGoal(LongSchedule $long_goal, LongGoalRequest $request)
    {
        $this->checkLongTermGoalUserID($long_goal);
        $long_goal->fill($request->all())->save();
        return redirect(route('goals.index'));
    }

    /** 長期目標の削除処理
     * @param Request $request 
     * @return void
    */
    public function destroyLongGoal(Request $request)
    {
        //長期目標に付随する短期目標が存在する長期目標は削除せずにリダイレクトする
        $short_goals = ShortSchedule::where('long_schedule_id', $request->id)->where('user_id', Auth::id())->first();
        if (!is_null($short_goals)) {
            return redirect(route('goals.index'))->with('flash_message', '長期目標を削除する前に、短期目標をすべて削除してください');
        }
        //長期目標に付随する短期目標がなければ削除する
        else {
            LongSchedule::where('id', $request->id)->where('user_id', Auth()->id())->delete();
            return redirect(route('goals.index'));
        }
    }

    /**
     * 短期目標の追加画面表示
     * @return view
     */
    public function createShortGoal()
    {
        $long_goals = LongSchedule::where('user_id', Auth::id())->orderby('expire_date', 'asc')->get();
        return view('goals.short.create', compact('long_goals'));
    }

    /**
     * 短期目標の追加処理
     * @param ShortGoalRequest $request 
     * @return void
     */
    public function storeShortGoal(ShortGoalRequest $request)
    {
        $short_goal = new ShortSchedule();
        $short_goal->fill($request->all());
        $short_goal->user_id = Auth::user()->id;
        $short_goal->registration_date = date('Y-m-d');
        $short_goal->save();
        return redirect(route('goals.index'));
    }

    /** 
     * 短期目標の修正画面表示
     * @param ShortSchedule $short_goal
     * @return view
     */
    public function editShortGoal(ShortSchedule $short_goal)
    {
        $this->checkShortTermGoalUserID($short_goal);
        $long_goals = LongSchedule::where('user_id', Auth()->id())->orderby('expire_date', 'asc')->get();
        return view('goals.short.edit', compact('short_goal', 'long_goals'));
    }

    /**
     * 短期目標の更新処理
     * @param ShortSchedule $short_goal
     * ShortGoalRequest $request 
     * @return void   */
    public function updateShortGoal(ShortSchedule $short_goal, ShortGoalRequest $request)
    {
        $this->checkShortTermGoalUserID($short_goal);
        $short_goal->fill($request->all())->save();
        return redirect(route('goals.index'));
    }

    /**
     * 短期目標の削除処理
     * @param Request $request 
     * @return void
     */
    public function destroyShortGoal(Request $request)
    {
        ShortSchedule::where('id', $request->id)->where('user_id', Auth()->id())->delete();
        return redirect(route('goals.index'));
    }
}
