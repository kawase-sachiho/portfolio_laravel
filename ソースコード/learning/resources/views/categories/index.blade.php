@extends('layouts.app')
@section('content')
<!--セッションにメッセージがあればフラッシュメッセージを表示する-->
@if (session('flash_message'))
<div class="space" style="height:40px;">
    <div class="flash_message alert alert-danger">
        {{ session('flash_message') }}
    </div>
</div>
@endif
<!--ユーザーがカテゴリーを登録していない場合-->
@if(!isset($categories[0]))
    <p>カテゴリーが未登録です。</p>
@else
<!--ユーザーがカテゴリーを登録している場合-->
<div class="m-3 p-3">
    <h3 class="title-text mb-3">CATEGORY LIST</h3>
    <table class="table table-responsive">
        <tr class="row sub-title-text">
            <th class="col-6">カテゴリー名</th>
            <th class="col-2"></th>
            <th class="col-2"></th>
            <th class="col-2"></th>
        </tr>
        @foreach ($categories as $category)
        <tr class="row main-text">
            <td class="col-6">{{ $category->category_name }}</td>
            <td class="col-2"></td>
            <td class="col-2 text-center"><a href="{{ route('categories.edit', $category) }}" class="btn btn-lg btn-warning">修正</a></td>
            <td class="col-2 text-center">
                <form action="{{ route('categories.destroy',$category->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{ $category->id }}">
                    <button type="submit" class="btn btn-lg btn-danger" onclick="return confirm('本当に削除しますか？');">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $categories->links() }}
@endif
    <div class="text-start">
        <a href="{{ route('categories.create', $category) }}" class="btn btn-lg btn-primary">新規カテゴリー作成</a>
    </div>
</div>
@endsection