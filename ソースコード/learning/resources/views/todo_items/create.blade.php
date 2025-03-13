@extends('layouts.app')
@section('content')
<div class="m-3 p-3">
<h3 class="title-text mb-3">NEW TODO</h3>
<form action="{{ route('todo_items.store') }}" method="post"> 
    @csrf 
    <div class="mb-3"> 
        <label for="title" class="sub-title-text">項目名</label> 
        <input type="text" name="item_name" id="item_name" value="{{old('item_name')}}" class="form-control @error('item_name') is-invalid @enderror"> 
        @error('item_name')
            <div id="validateItemName" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
    </div> 
    <div class="mb-3"> 
        <label for="expire_date" class="sub-title-text">期限日</label> 
        <input type="date" name="expire_date" id="expire_date" value="{{old('expire_date')}}" class="form-control @error('expire_date') is-invalid @enderror">
        @error('expire_date')
            <div id="validateExpireDate" class="invalid-feedback">
                {{ $message }}
            </div> 
            @enderror
        </div> 
    <button class="btn btn-primary btn-lg" type="submit">送信</button>  
</form> 
</div>
@endsection