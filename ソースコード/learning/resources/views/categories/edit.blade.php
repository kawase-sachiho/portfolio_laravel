@extends('layouts.app')

@section('content')
<div class="p-3 m-3">
    <h3 class="title-text mb-3">CATEGORY EDIT</h3>
    <form action="{{ route('categories.update',$category) }}" method="post">
        @csrf
        @method('PATCH') 
        <div class="mb-3">
            <label for="category_name" class="sub-title-text">カテゴリー名</label>
            <input type="text" name="category_name" id="category_name" class="form-control @error('category_name') is-invalid @enderror" value="{{ old('category_name',$category->category_name) }}">
            @error('category_name')
            <div id="validateCategoryName" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror 
        </div>
        <button class="btn btn-primary btn-lg" type="submit">送信</button>
    </form>
</div>
@endsection