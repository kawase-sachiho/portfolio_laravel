@extends('layouts.app')
@section('content')
<div class="m-3 p-3">
    <h3 class="title-text mb-3">NEW SHORT TERM GOAL</h3>
    @if(isset($long_goals[0]))
    <form action="{{ route('goals.short.store') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="short_term_goal_name" class="sub-title-text">短期目標</label>
            <input type="text" name="short_term_goal_name" id="short_term_goal_name" value="{{old('short_term_goal_name')}}" class="form-control @error('short_term_goal_name') is-invalid @enderror">
            @error('short_term_goal_name')
            <div id="validateShortTermGoalName" class="invalid-feedback">
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
        <div class="mb-3">
            <label for="long_schedule_id" class="sub-title-text">長期目標</label>
            <select name="long_schedule_id" long_schedule_id" class="form-control input-md" type="select">
                @foreach($long_goals as $long_goal)
                <!--長期目標を送信した履歴があればその値を選択する-->
                @if(old('long_schedule_id')==$long_goal->id)
                <option value="{{$long_goal->id}}" selected>{{$long_goal->long_term_goal_name}}</option>
                @else
                <option value="{{$long_goal->id}}">{{$long_goal->long_term_goal_name}}</option>
                @endif
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary btn-lg" type="submit">送信</button>
    </form>
    @else
    <p>長期目標を先に設定してください</p>
    <a href="{{route('goals.long.create')}}" class="btn btn-lg btn-primary m-3">長期目標の設定</a>
</div>
@endif
</div>
@endsection