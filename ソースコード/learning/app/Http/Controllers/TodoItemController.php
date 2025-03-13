<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TodoItem;
use Carbon\Carbon;

class TodoItemController extends Controller
{
   /**
    * ユーザーIDのチェックを行う
    * @param TodoItem $todo_item 
    * @return void 
    * @throws HttpException
    */
    private function checkUserID(TodoItem $todo_item, int $status = 404)
    {
        // ログインユーザーIDとタスクのユーザーIDが異なるとき 
        if (Auth::user()->id != $todo_item->user_id) {
            // HTTPレスポンスステータスコードを返却 
            abort($status);
        }
    }

    /**
     * タスクリストの表示
     * @return view
     */
    public function index()
    {
        $todo_items = TodoItem::where('user_id', Auth::id())->orderBy('expire_date', 'asc')->paginate(20);
        $d = Carbon::now();
        //タスクの期限日と本日の日付の差分を取得する
        foreach ($todo_items as $todo_item) {
            $todo_item_diff_days = Carbon::create($todo_item->expire_date->format('Y-m-d'))->diffInDays(Carbon::create($d->format('Y-m-d')));
            $todo_item->todo_item_diff_days = $todo_item_diff_days;
        }
        foreach ($todo_items as $todo_item) {
            if ($todo_item->expire_date < date('Y-m-d') && is_null($todo_item->finished_date)) {
                //期限日が今日を過ぎていて、かつ、完了日がnullのとき、期限日を過ぎたレコードの背景色を変える
                $class = "text-danger";
            } elseif (!is_null($todo_item->finished_date)) {
                //完了日に値があるときは、完了したレコードの文字に打消し線を入れる
                $class = "del";
            } else {
                $class = "";
            }
            $todo_item->class = $class;
        }
        return view('todo_items.index', compact('todo_items'));
    }

    /**
     * タスク追加画面表示
     * @return view
     */
    public function create()
    {
        return view('todo_items.create');
    }

    /**
     * タスクの追加処理
     * @param TodoItemRequest $request 
     * @return void
     */
    public function store(TodoItemRequest $request)
    {
        $todo_item = new TodoItem();
        $todo_item->fill($request->all());
        $todo_item->user_id = Auth::user()->id;
        $todo_item->registration_date = date('Y-m-d');
        $todo_item->save();
        return redirect(route('todo_items.index'));
    }

    /**
     * タスクの修正画面表示
     * @param TodoItem $todo_item 
     * @return view
     */
    public function edit(TodoItem $todo_item)
    {
        $this->checkUserID($todo_item);
        return view('todo_items.edit', compact('todo_item'));
    }

    /**
     * タスクの更新処理
     * @param
     * TodoItemRequest $request
     * TodoItem $todo_item 
     * @return void
     */
    public function update(TodoItemRequest $request, TodoItem $todo_item)
    {
        $this->checkUserID($todo_item);
        $todo_item->fill($request->all())->save();
        return redirect(route('todo_items.index'));
    }

    /**
     * タスクの削除処理
     * @param Request $request 
     * @return void
     */
    public function destroy(Request $request)
    {
        TodoItem::where('id', $request->id)->where('user_id', Auth()->id())->delete();
        return redirect(route('todo_items.index'));
    }
}
