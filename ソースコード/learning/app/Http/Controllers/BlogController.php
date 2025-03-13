<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;

class BlogController extends Controller
{

    /** 
     * ユーザーIDのチェックを行う
     * @param Blog $blog 
     * @return void 
     * @throws HttpException
     */
    private function checkUserID(Blog $blog, int $status = 404)
    {
        // ログインユーザーIDとタスクのユーザーIDが異なるとき 
        if (Auth::user()->id != $blog->user_id) {
            // HTTPレスポンスステータスコードを返却 
            abort($status);
        }
    }
    /**
     * ブログの一覧表示
     *  @return view
     */
    public function index()
    {
        $blogs = Blog::where('user_id', Auth::id())->orderBy('learning_date', 'desc')->paginate(10);
        return view('blogs.index', compact('blogs'));
    }

    /**
     * ブログ追加画面表示
     * @return view
     */
    public function create()
    {
        return view('blogs.create');
    }

    /**
     * ブログ追加処理
     * @param BlogRequest $request 
     * @return void
     */
    public function store(BlogRequest $request)
    {
        $learning_date = $request->learning_date." 00:00:00";
        $registered_blog = Blog::where('user_id', Auth()->id())->where('learning_date', $learning_date)->get();
        //同じ日のブログが存在した場合は登録せずリダイレクトする
        if (count($registered_blog) >= 1) {
            $request->flash();
            return redirect()->route('blogs.create')->with('flash_message', '同じ日のblogが既に存在します');
        } else {
            $blog = new Blog();
            $blog->fill($request->all());
            $blog->user_id = Auth::user()->id;
            $blog->save();
            return redirect()->route('blogs.show', $blog);
        }
    }

    /**
     * ブログの詳細確認画面表示
     * @param Blog $blog
     * @return view
     */
    public function show(Blog $blog)
    {
        $this->checkUserID($blog);
        //エスケープ処理をしてから、特定の記号をhtmlタグへ変換し、表示画面で反映させる
        $str = htmlspecialchars($blog->content);
        $blog->content = preg_replace('/(@{3})(.*)(@{3})/', '<span style="color:red;">\\2</span>', $str);
        $blog->content = preg_replace('/(\-{3})(.*)(\-{3})/', '<span style="text-decoration:underline;">\\2</span>', $blog->content);
        $blog->content = preg_replace('/(\*{3})(.*)(\*{3})/', '<strong>\\2</strong>', $blog->content);
        return view('blogs.show', compact('blog'));
    }

    /** ブログの修正画面表示
     *  @param Blog $blog
     *  @return view
     */
    public function edit(Blog $blog)
    {
        $this->checkUserID($blog);
        return view('blogs.edit', compact('blog'));
    }

    /**
     * ブログの更新処理
     * @param  Blog $blog
     * BlogRequest $request 
     * @return void
     */
    public function update(Blog $blog, BlogRequest $request)
    {
        $learning_date = $request->learning_date." 00:00:00";
        $registered_blog = Blog::where('user_id', Auth()->id())->where('learning_date', $learning_date)->where('id','!=',$blog->id)->get();
        //同じ日のブログが存在した場合(更新対象のブログは除く)、登録せずリダイレクトする
        if (count($registered_blog) >= 1) {
            $request->flash();
            return redirect()->route('blogs.edit',$blog)->with('flash_message', '同じ日のblogが既に存在します');
        } else {
            $this->checkUserID($blog);
            $blog->fill($request->all())->save();
            return redirect()->route('blogs.show', $blog);
        }
    }

    /**
     * ブログの削除処理
     * @param BlogRequest $request 
     * @return void */
    public function destroy(Request $request)
    {
        Blog::where('id', $request->id)->where('user_id', Auth()->id())->delete();
        return redirect(route('blogs.index'));
    }
}
