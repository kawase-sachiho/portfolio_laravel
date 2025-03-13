@extends('layouts.app')
@section('content')
<div class="m-3 p-3">
    <h3 class="title-text mb-3">NEW LONG TERM GOAL</h3>
    <form action="{{ route('goals.long.store') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="long_term_goal_name" class="sub-title-text">長期目標</label>
            <input type="text" name="long_term_goal_name" id="long_term_goal_name" value="{{old('long_term_goal_name')}}" class="form-control @error('long_term_goal_name') is-invalid @enderror">
            @error('long_term_goal_name')
            <div id="validateLongTermGoalName" class="invalid-feedback">
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
</div>
</form>
</div>
@endsection