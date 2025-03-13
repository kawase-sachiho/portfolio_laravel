@extends('layouts.app')
@section('content')
<div class="m-3 p-3">
    <h3 class="title-text mb-3">LONG TERM GOAL EDIT</h3>
    <form action="{{ route('goals.long.update',$long_goal) }}" method="post"> 
    @csrf
    <div class="mb-3"> 
        <label for="long_term_goal_name" class="sub-title-text">項目名</label> 
        <input type="text" name="long_term_goal_name" id="long_term_goal_name" class="form-control @error('long_term_goal_name') is-invalid @enderror" value="{{$long_goal->long_term_goal_name}}"> 
        @error('long_term_goal_name')
            <div id="validateLongTermGoalName" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
    </div> 
    <div class="mb-3"> 
        <label for="expire_date" class="sub-title-text">期限日</label> 
        <input type="date" name="expire_date" id="expire_date" class="form-control @error('expire_date') is-invalid @enderror" value="{{$long_goal->expire_date->format('Y-m-d')}}">
        @error('expire_date')
            <div id="validateExpireDate" class="invalid-feedback">
                {{ $message }}
            </div> 
            @enderror 
    </div> 
    <div class="mb-3"> 
        <label for="finished_date" class="sub-title-text">完了日</label> 
        <input type="date" name="finished_date" id="finished_date" class="form-control @error('finished_date') is-invalid @enderror" value="{{old('finished_date',!is_null($long_goal->finished_date) ? $long_goal->finished_date->format('Y-m-d') : '') }}"> 
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