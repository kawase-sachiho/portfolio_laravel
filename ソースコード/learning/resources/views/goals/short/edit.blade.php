@extends('layouts.app')

<style>
    input[type="date"] {
        width: 200px;
    }
</style>

@section('content')
<div class="m-3 p-3">
    <h3 class="title-text mb-3">SHORT TERM GOAL EDIT</h3>
    <form action="{{ route('goals.short.update',$short_goal) }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="short_term_goal_name" class="sub-title-text">項目名</label>
            <input type="text" name="short_term_goal_name" id="short_term_goal_name" class="form-control @error('short_term_goal_name') is-invalid @enderror" value="{{old('short_term_goal_name',$short_goal->short_term_goal_name)}}">
            @error('short_term_goal_name')
            <div id="validateShortTermGoalName" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="expire_date" class="sub-title-text">期限日</label>
            <input type="date" name="expire_date" id="expire_date" class="form-control @error('finished_date') is-invalid @enderror" value="{{old('expire_date',$short_goal->expire_date->format('Y-m-d'))}}">
        </div>
        <div class="mb-3">
            <label for="finished_date" class="sub-title-text">完了日</label>
            <input type="date" name="finished_date" id="finished_date" class="form-control" value="{{old('finished_date',!is_null($short_goal->finished_date) ? $short_goal->finished_date->format('Y-m-d') : '')}}">
            @error('finished_date')
            <div id="validateFinishedDate" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="long_schedule_id" class="sub-title-text">長期目標</label>
            <select name="long_schedule_id" class="form-control input-md" type="select">
                @foreach($long_goals as $long_goal)
                <!--長期目標を送信した履歴があればその値を選択する-->
                @if(old('long_schedule_id')==$long_goal->id)
                <option value="{{$long_goal->id}}" selected>{{$long_goal->long_term_goal_name}}</option>
                <!--長期目標を送信した履歴がない場合、登録済の長期目標を選択する-->
                @elseif(!is_null(old('long_schedule_id')) && ($long_goal->id==$short_goal->long_schedule_id))
                <option value="{{$long_goal->id}}" selected>{{$long_goal->long_term_goal_name}}</option>
                @else
                <option value="{{$long_goal->id}}">{{$long_goal->long_term_goal_name}}</option>
                @endif
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary btn-lg" type="submit">送信</button>
    </form>
</div>
@endsection