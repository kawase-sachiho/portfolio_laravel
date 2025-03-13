@extends('layouts.app')
@section('content')
<div class="p-4">
    <h3 class="title-text mb-3">NOTE EDIT</h3>
    <form action="{{ route('notes.update',$note) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <input type="hidden" name="id" value="{{$note->id}}">
        <div class="mb-3">
            <label for="title" class="sub-title-text">タイトル</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title',$note->title) }}">
            @error('title')
            <div id="validateTitle" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="registration_date" class="sub-title-text">学習日</label>
            <input type="date" name="registration_date" id="registration_date" class="form-control @error('registration_date') is-invalid @enderror" value="{{ old('registration_date',$note->registration_date->format('Y-m-d')) }}">
            @error('registration_date')
            <div id="validateRegistrationDate" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="sub-title-text">内容</label>
            <textarea name="content" id="content" rows="10" class="form-control @error('content') is-invalid @enderror">{{old('content',$note->content) }}</textarea>
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
            <label for="category_id" class="sub-title-text">カテゴリー</label>
            <select name="category_id" id="category_id" class="form-control input-md" type="select">
                @foreach($categories as $category)
                <!--カテゴリーを送信した履歴があればその値を選択する-->
                @if(old('category_id')==$category->id)
                <option value="{{$category->id}}" selected>{{$category->category_name}}</option>
                <!--カテゴリーを送信した履歴がなければ、登録済の値を選択する-->
                @elseif(is_null(old('category_id')) && ($category->id==$note->category_id))
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
            @if(!is_null($note->image))
            <p class="text-danger">既に画像が登録されているため、画像を登録した場合は上書きされます。</p>
            @endif
            @if(!is_null($note->image))
            <div class="row mb-3">
                <div class="col-auto">
                    <label class="form-check-label" for="imageDeleteConfirm">
                        現在登録されている画像を削除しますか？
                    </label>
                </div>
                <div class="col-auto form-check">
                    <input class="form-check-input" id="imageDeleteConfirm" type="radio" name="image_del" value="0" checked>いいえ
                </div>
                <div class="col-auto form-check">
                    <input class="form-check-input" id="imageDeleteConfirm" type="radio" name="image_del" value="1">はい
                </div>
            </div>
            @endif
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
</div>
@endsection