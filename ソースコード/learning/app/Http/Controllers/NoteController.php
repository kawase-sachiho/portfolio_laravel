<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NoteRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Note;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    /**
     * ユーザーIDのチェックを行う
     * @param Note $note
     * @param integer $status
     * @return void
     * @throws HttpException
     */
    private function checkUserID(Note $note, int $status = 404)
    {
        // ログインユーザーIDとノートのユーザーIDが異なるとき 
        if (Auth::user()->id != $note->user_id) {
            // HTTPレスポンスステータスコードを返却 
            abort($status);
        }
    }
    /**
     * ノート一覧画面表示
     * @param Request $request
     * @return view
     */
    public function index(Request $request)
    {
        $categories = Category::where('user_id', Auth::id())->orderBy('category_name', 'asc')->get();
        if (isset($request->category_id)) {
            //カテゴリーで検索された場合
            $notes = Note::where('user_id', Auth::id())->where('category_id', $request->category_id)->orderBy('registration_date', 'desc')->paginate(10);
            $select_category = Category::where('user_id', Auth::id())->where('id', $request->category_id)->first();
            return view('notes.index', compact('notes', 'select_category', 'categories'));
        } elseif (isset($request->keyword)) {
            $keywords = $request->keyword;
            //全角スペースを半角スペースに変換
            $spaceConversion = mb_convert_kana($keywords, 's');
            //スペースやカンマ区切りで検索ワードを配列に格納
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
            //キーワードが1つの場合
            $query = Note::whereRaw("(title || content) LIKE ? ", '%' . $wordArraySearched[0] . '%');
            if (count($wordArraySearched) > 1) {
                //キーワードが2つ以上の場合
                for ($i = 1; $i < count($wordArraySearched); $i++) {
                    $query->whereRaw("(title || content) LIKE ? ", '%' . $wordArraySearched[$i] . '%');
                }
            }
            $notes = $query->where('user_id', Auth::id())->orderBy('registration_date', 'desc')->paginate(10);
            return view('notes.index', compact('notes', 'categories', 'keywords'));
        } else {
            /*検索条件なしの場合 */
            $notes = Note::where('user_id', Auth::id())->orderBy('registration_date', 'desc')->paginate(10);
            return view('notes.index', compact('notes', 'categories'));
        }
    }
    /**
     * ノートの追加画面表示
     * @param Note $note
     * @return void
     */
    public function create(Note $note)
    {
        $categories = Category::where('user_id', Auth::id())->orderBy('category_name', 'asc')->get();
        return view('notes.create', compact('note', 'categories'));
    }
    /**
     * ノートの追加処理
     * @param NoteRequest $request 
     * @return void
     */
    public function store(NoteRequest $request)
    {
        $note = new Note();
        $note->fill($request->all());
        //画像が送信されてきた場合は保存する
        if (request('image')) {
            $filename = request()->file('image')->getClientOriginalName();
            $note->image = request('image')->storeAs('public/images', $filename);
        }
        $note->user_id = Auth::user()->id;
        $note->save();
        return redirect()->route('notes.show', $note);
    }
    /** 
     * ノートの詳細確認画面表示
     * @param Note $note 
     * @return view
     */
    public function show(Note $note)
    {
        $this->checkUserID($note);
        //エスケープ処理をしてから、特定の記号をhtmlタグへ変換し、表示画面で反映させる
        $str = htmlspecialchars($note->content);
        $note->content = preg_replace('/(@{3})(.*)(@{3})/', '<span style="color:red;">\\2</span>', $str);
        $note->content = preg_replace('/(\-{3})(.*)(\-{3})/', '<span style="text-decoration:underline;">\\2</span>', $note->content);
        $note->content = preg_replace('/(\*{3})(.*)(\*{3})/', '<strong>\\2</strong>', $note->content);
        return view('notes.show', compact('note'));
    }
    /**
     * ノートの修正画面表示
     * @param Note $note 
     * @return view
     */
    public function edit(Note $note)
    {
        $this->checkUserID($note);
        $categories = Category::where('user_id', Auth::id())->orderBy('category_name', 'asc')->get();
        return view('notes.edit', compact('note', 'categories'));
    }
    /**
     * ノートの更新処理
     *
     * @param NoteRequest $request
     * @param Note $note
     * @return void
     */
    public function update(NoteRequest $request, Note $note)
    {
        $this->checkUserID($note);
        $note = Note::find($request->id);
        $note->title = $request->title;
        $note->registration_date = $request->registration_date;
        $note->content = $request->content;
        $note->category_id = $request->category_id;
        //画像を削除するにチェックが入っていた場合はファイルを削除する
        if(request('image_del')==1){
            Storage::delete($note->image);
            $note->image=null;
        }
        //画像が送信されてきた場合は保存する
        if (request('image')) {
            $filename = request()->file('image')->getClientOriginalName();
            $note->image = request('image')->storeAs('public/images', $filename);
        }
        $note->save();
        return redirect()->route('notes.show', $note);
    }
    /**
     * ノートの削除処理
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        $note = Note::find($request->id);
        //ノートに画像が登録されている場合は、ノートの削除と同時に画像も削除する
        if(!is_null($note->image)){
            Storage::delete($note->image);
        }
        Note::where('id', $request->id)->where('user_id', Auth()->id())->delete();
        return redirect(route('notes.index'));
    }
}
