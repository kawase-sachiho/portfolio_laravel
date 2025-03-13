@extends('layouts.app')
@section('content')
<div class="p-4">
    <h3 class="title-text mb-3">NEW NOTE</h3>
    <!--ユーザーがカテゴリーを登録している場合-->
    @if(isset($categories[0]))
    <form action="{{ route('notes.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="sub-title-text">タイトル</label>
            <input type="text" name="title" id="title" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror">
            @error('title')
            <div id="validateTitle" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="registration_date" class="sub-title-text">登録日</label>
            <input type="date" name="registration_date" id="registration_date" value="{{old('registration_date')}}" class="form-control @error('registration_date') is-invalid @enderror">
            @error('registration_date')
            <div id="validateRegistrationDate" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="sub-title-text">内容</label>
            <textarea name="content" id="content" rows="10" class="form-control @error('content') is-invalid @enderror">{{old('content')}}</textarea>
            @error('content')
            <div id="validateContent" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3 main-text">
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
            <label for="category_id" class="sub-title-text">カテゴリー</label>
            <select name="category_id" id="category_id" class="form-control input-md" type="select">
                @foreach($categories as $category)
                <!--カテゴリーを送信した履歴があればその値を選択する-->
                @if(old('category_id')==$category->id)
                <option value="{{$category->id}}" selected>{{$category->category_name}}</option>
                @else
                <option value="{{$category->id}}">{{$category->category_name}}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="row mb-3">
            <div class="col-auto">
                <label for="image" class="sub-title-text">画像</label>
            </div>
            <div class="col-auto">
                <input id="image" type="file" name="image" class="@error('image') is-invalid @enderror">
                @error('image')
                <div id="validateImage" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <button class="btn btn-primary btn-lg" type="submit">送信</button>
    </form>
    <!--ユーザーがカテゴリーを登録していない場合-->
    @else
    <p>カテゴリーの作成を先に行ってください</p>
    <a href="{{ route('categories.create') }}" class="btn btn-lg btn-primary">新規カテゴリー作成</a>
    @endif
</div>
@endsection