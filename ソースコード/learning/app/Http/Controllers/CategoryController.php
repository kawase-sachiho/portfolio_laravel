<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Note;

class CategoryController extends Controller
{
    /**
     * ユーザーIDのチェックを行う
     * @param Category $category
     * @param integer $status
     * @return void
     * @throws HttpException
     */
    private function checkUserID(Category $category, int $status = 404)
    {
        // ログインユーザーIDとタスクのユーザーIDが異なるとき 
        if (Auth::user()->id != $category->user_id) {
            // HTTPレスポンスステータスコードを返却 
            abort($status);
        }
    }
    /**
     * カテゴリー一覧表示
     * @return view
     */
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())->orderBy('learning_date', 'desc')->paginate(5);
        return view('categories.index', compact('categories'));
    }
    /**
     * カテゴリーの追加画面表示
     * @param Category $category
     * @return view
     */
    public function create(Category $category)
    {
        return view('categories.create', compact('category'));
    }
    /**
     * カテゴリーの追加処理
     * @param CategoryRequest $request
     * @return void
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->fill($request->all());
        $category->user_id = Auth::user()->id;
        $category->save();
        return redirect(route('categories.index'));
    }
    /**
     * カテゴリーの修正画面表示
     * @param Category $category  
     * @return view
     */
    public function edit(Category $category)
    {
        $this->checkUserID($category);
        return view('categories.edit', compact('category'));
    }
    /**
     *  カテゴリーの更新処理
     * @param Category $category
     * @param CategoryRequest $request
     * @return void
     */
    public function update(Category $category, CategoryRequest $request)
    {
        $this->checkUserID($category);
        $category->fill($request->all())->save();
        return redirect(route('categories.index'));
    }
    /**
     * カテゴリーの削除処理
     * @param Request $request 
     * @return void
     */
    public function destroy(Request $request)
    {
        //カテゴリーに付随するノートがあれば削除しない
        $notes = Note::where('category_id', $request->id)->where('user_id', Auth::id())->first();
        if (!is_null($notes)) {
            return redirect(route('categories.index'))->with('flash_message', 'カテゴリー内のノートを削除してから実行してください');
        }
        //カテゴリーに付随するノートがなければ削除する
        else {
            Category::where('id', $request->id)->where('user_id', Auth()->id())->delete();
            return redirect(route('categories.index'));
        }
    }
}
