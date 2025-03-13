@extends('layouts.app')
@section('content')
<div class="m-3 p-3">
    <h1 class="title-text mb-3">BLOG LIST</h1>
    <!--ユーザーが記事を登録していない場合-->
    @if(!isset($blogs[0]))
    <p>記事がありません。</p>
    @else
    <!--ユーザーが記事を登録している場合-->
    <table class="table table-responsive table-striped">
        <tr class="row sub-title-text">
            <th class="col-md-5">タイトル</th>
            <th class="col-md-2">学習日</th>
            <th class="col-md-2">学習時間</th>
            <th class="col-md-3">操作</th>
        </tr>
        @foreach ($blogs as $blog)
        <tr class="row main-text">
            <td class="col-md-5">{{ is_null($blog->title) ? "No title" : $blog->title }}</td>
            <td class="col-md-2">{{ $blog->learning_date->format('Y年m月d日') }}</td>
            <td class="col-md-2">{{$blog->study_time}}時間</td>
            <td class="col-md-3 last-td">
                <div class="row">
                    <div class="col-auto"><a href="{{ route('blogs.show', $blog) }}" class="btn btn-lg btn-success">詳細</a>
                    </div>
                    <div class="col-auto"><a href="{{ route('blogs.edit', $blog) }}" class="btn btn-lg btn-warning">修正</a></div>
                    <div class="col-auto">
                        <form action="{{ route('blogs.destroy',$blog->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $blog->id }}">
                            <input type="submit" class="btn btn-danger btn-lg" value="削除" onclick="return confirm('本当に削除しますか？');">
                        </form>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $blogs->links() }}
    @endif
    <div class="text-left">
        <a href="{{ route('blogs.create') }}" class="btn btn-primary btn-lg">新規記事作成</a>
    </div>
</div>

@endsection