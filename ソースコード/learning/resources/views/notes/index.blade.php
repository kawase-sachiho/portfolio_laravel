@extends('layouts.app')
@section('content')
<div class="m-3 p-3">
    <h3 class="title-text mb-3">NOTE LIST</h3>
    <!--カテゴリー、またはキーワード検索があった場合に表示-->
    <div class="row mb-3">
    <div class="col-auto title-text">{{!empty($select_category->category_name) ?
    " CATEGORY : ".$select_category->category_name : ''}}</div>
    <div class="lh-1 d-lg-none"><br></div>                
       <div class="col-auto title-text"> {{!empty($keywords) ?
    " KEYWORD : ".$keywords : ''}}
       </div>
       </div>   
        <form action="" method="get" class="row mb-3">
                <div class="col-auto">
                    <label for="category_id" class="col-auto sub-title-text">CATEGORY</label>
                </div>
                <!--カテゴリーが未登録の場合-->
                @if(!isset($categories[0]))
                <div class="col-auto main-text">未登録</div>
                @else
                <!--カテゴリーが登録されていればセレクトボックスボックスを表示する-->
                <div class="col-auto">
                    <select name="category_id" id="category_id" class="col-auto form-control input-md" type="select">
                    <option value="">カテゴリーを選択…</option>    
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" @if(isset($select_category) && $category->id == $select_category->id) selected @endif>{{$category->category_name}}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="lh-1 d-lg-none"><br></div>
                <div class="col-auto sub-title-text">SEARCH</div>
                
                <div class="lh-1 col-auto">
                    <input type="text" name="keyword" placeholder="キーワードを入力…" class="form-control" value="@if(isset($keywords)){{$keywords}}@endif">
                </div>
                <div class="lh-1 d-lg-none"><br></div>
                <div class="col-auto">
                    <input type="submit" class="btn btn-lg btn-primary form-control" value="検索">
                </div>
                <div class="lh-1 d-lg-none"><br></div>
                <div class="col-auto"><a href="{{ route('notes.index') }}" class="btn btn-lg btn-warning">検索条件をリセットする</a>
                </div>

        </form>
    <div class="text-end mb-3">
        <a href="{{route('categories.index')}}" class="btn btn-lg btn-success">カテゴリーの管理</a>
    </div>
    <!--ユーザーがノートを登録していない場合-->
    @if(!isset($notes[0]))
    <p>該当するノートはありません。</p>
    @else
    <!--ユーザーがノートを登録している場合-->
    <div class="row">
        <table class="table table-responsive table-striped">
            <tr class="row sub-title-text">
                <th class="col-md-6">タイトル</th>
                <th class="col-md-3">登録日</th>
                <th class="col-md-3">操作</th>
            </tr>
            @foreach ($notes as $note)
            <tr class="row main-text">
                <td class="col-md-6">{{ is_null($note->title) ? "No title" : $note->title }}</td>
                <td class="col-md-3">{{ $note->registration_date->format('Y年m月d日') }}</td>
                <td class="col-md-3 last-td">
                    <div class="row">
                        <div class="col-auto"><a href="{{ route('notes.show', $note) }}" class="btn btn-lg btn-success">詳細</a></div>
                        <div class="col-auto">
                            <a href="{{ route('notes.edit', $note) }}" class="btn btn-lg btn-warning">修正</a>
                        </div>
                        <div class="col-auto">
                            <form action="{{ route('notes.destroy',$note->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $note->id }}">
                                <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('本当に削除しますか？');">削除</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
        {{ $notes->appends(request()->query())->links() }}
        @endif
        <div class="text-start">
            <a href="{{ route('notes.create') }}" class="btn btn-lg btn-primary">新規記事作成</a>
        </div>
    </div>
    @endsection