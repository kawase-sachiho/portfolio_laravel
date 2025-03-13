@extends('layouts.app')
@section('content')
<div class="m-3 p-3">
<h3 class="title-text mb-3">NEW CATEGORY</h3>
<form action="{{ route('categories.store') }}" method="post"> 
    @csrf 
    <div class="mb-3"> 
        <label for="category_name" class="sub-title-text">カテゴリー名</label> 
        <input type="text" name="category_name" id="category_name" value="{{old('category_name')}}" class="form-control @error('category_name') is-invalid @enderror">
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