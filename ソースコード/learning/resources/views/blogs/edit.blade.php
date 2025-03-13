@extends('layouts.app')
@section('content')
<!--セッションにエラーメッセージがあればフラッシュメッセージを表示する-->
@if (session('flash_message'))
<div class="space" style="height:40px;">
    <div class="flash_message alert alert-danger">
        {{ session('flash_message') }}
    </div>
</div>
@endif
<div class="m-3 p-3">
    <h3 class="title-text mb-3">BLOG EDIT</h3>
    <form action="{{ route('blogs.update',$blog) }}" method="post">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="title" class="sub-title-text">タイトル</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title',$blog->title) }}">
            @error('title')
            <div id="validateTitle" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="row mb-3">
            <div class="col-auto">
                <label for="learning_date" class="sub-title-text">学習日</label>
            </div>
            <div class="col-auto">
                <input type="date" name="learning_date" id="learning_date" class="form-control @error('learning_date') is-invalid @enderror" value="{{ old('learning_date',$blog->learning_date->format('Y-m-d')) }}">
                @error('learning_date')
                <div id="validateLearningDate" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-auto"><label for="study_time" class="sub-title-text">学習時間</label></div>
            <div class="col-auto">
                <select name="study_time" id="study_time" class="form-control input-md" type="select">
                    @for($i=0;$i<=24;$i++)
                        <!--学習時間を送信した履歴があった場合はその値をセレクトさせる-->
                        @if(old('study_time')==$i)
                        <option value="{{$i}}" selected>{{$i}}</option>
                        <!--学習時間を送信した履歴がない場合は登録済の学習時間をセレクトさせる-->
                        @elseif(is_null(old('study_time')) && $i==$blog->study_time)
                        <option value="{{$i}}" selected>{{$i}}</option>
                        @else
                        <option value="{{$i}}">{{$i}}</option>
                        @endif
                        @endfor
                </select>
            </div>
            <div class="col-auto sub-title-text">時間</div>
        </div>
        <div class="mb-3">
            <label for="content" class="sub-title-text">内容</label>
            <textarea name="content" id="content" rows="5" class="form-control @error('content') is-invalid @enderror">{{ old('content',$blog->content) }}</textarea>
            @error('content')
            <div id="validateContent" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="main-text mb-3">
            <div class="row">
                <div class="col-auto">
                    <p>赤字：@@@</p>
                </div>
                <div class="col-auto">
                    <p>太字：***</p>
                </div>
                <div class="col-auto">
                    <p>下線：---</p>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="comment" class="sub-title-text">感想</label>
            <input type="text" name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror" value="{{ old('comment',$blog->comment) }}">
            @error('comment')
            <div id="validateComment" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <button class="btn btn-primary btn-lg" type="submit">送信</button>
    </form>
</div>
@endsection