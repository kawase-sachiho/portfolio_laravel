@extends('layouts.app')
@section('content')
<div class="m-3 p-3">
    <h3 class="title-text mb-3">TODO EDIT</h3>
    <form action="{{ route('todo_items.update',$todo_item) }}" method="post"> 
    @csrf
    @method('PATCH') 
    <div class="mb-3"> 
        <label for="item_name" class="sub-title-text">項目名</label> 
        <input type="text" name="item_name" id="item_name" class="form-control @error('item_name') is-invalid @enderror" value="{{old('item_name',$todo_item->item_name)}}">
        @error('item_name')
            <div id="validateItemName" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror 
    </div> 
    <div class="mb-3"> 
        <label for="expire_date" class="sub-title-text">期限日</label> 
        <input type="date" name="expire_date" id="expire_date" class="form-control @error('expire_date') is-invalid @enderror" value="{{old('expire_date',$todo_item->expire_date->format('Y-m-d'))}}"> 
        @error('expire_date')
            <div id="validateExpireDate" class="invalid-feedback">
                {{ $message }}
            </div> 
            @enderror
    </div> 
    <div class="mb-3"> 
        <label for="finished_date" class="sub-title-text">完了日</label> 
        <input type="date" name="finished_date" id="finished_date" class="form-control @error('finished_date') is-invalid @enderror" value="{{old('finished_date',!is_null($todo_item->finished_date) ? $todo_item->finished_date->format('Y-m-d') : '')}}"> 
        @error('finished_date')
            <div id="validateFinishedDate" class="invalid-feedback">
                {{ $message }}
            </div> 
            @enderror
    </div>
    <button class="btn btn-primary btn-lg" type="submit">送信</button>  
</form> 
</div>
@endsection