@extends('layouts.app')
@section('content')
<!--セッションにメッセージがあればフラッシュメッセージを表示する-->
@if (session('flash_message'))
    <div class="space" style="height:40px;">
        <div class="flash_message alert alert-danger">
            {{ session('flash_message') }}
        </div>
    </div>
    @endif
<div class="m-3 p-3">
    <h3 class="title-text mb-3">SCHEDULE</h3>
    <!--ユーザーが目標が設定していない場合-->
    @if(!isset($long_goals[0]))
    <p>目標が設定されていません。</p>
    <!--ユーザーが目標を設定している場合-->
    @else
    <table class="table table-responsive">
        <tr class="row sub-title-text">
            <th class="col-md-4">目標</th>
            <th class="col-md-2">登録日</th>
            <th class="col-md-2">期限日(残日数)</th>
            <th class="col-md-2">完了日</th>
            <th class="col-md-2 last-td">操作</th>
        </tr>
        @foreach ($long_goals as $long_goal)
        <tr class="row sub-title-text">
            <th class="col-md-12 bg-secondary-subtle">長期目標</th>
        </tr>
        <tr class="row main-text {{ $long_goal->class }}">
            <td class="col-md-4">{{ $long_goal->long_term_goal_name }}</td>
            <td class="col-md-2">{{$long_goal->registration_date->format('Y年m月d日')}}</td>
            <td class="col-md-2">{{$long_goal->expire_date->format('Y年m月d日')}}
                <br>
                <!--長期目標の期限日が本日より前の場合-->
                @if($long_goal->expire_date->format('Y-m-d') < date('Y-m-d'))
                    {{"(期限日：".$long_goal->long_goal_diff_days."日前)"}}
                    <!--長期目標の期限日が本日より後の場合-->
                    @else {{"(残り".$long_goal->long_goal_diff_days."日)"}}@endif
            </td>
            <td class="col-md-2">{{!is_null($long_goal->finished_date) ? $long_goal->finished_date->format('Y年m月d日') : '未' }}</td>
            <td class="col-md-2 text-center last-td">
                <div class="row">
                    <div class="col-auto"><a href="{{route('goals.long.edit',$long_goal)}}" class="btn btn-lg btn-warning">修正</a></div>
                    <div class="col-auto">
                        <form action="{{route('goals.long.destroy')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $long_goal->id }}">
                            <button type="submit" class="btn btn-lg btn-danger" onclick="return confirm('本当に削除しますか？');">削除</button>
                        </form>
                    </div>
            </td>
        </tr>
        <tr class="row sub-title-text">
            <th class="col-md-12 bg-secondary-subtle ">短期目標</th>
        </tr>
        @foreach($long_goal->schedule as $short_goal)
        <tr class="row main-text 
        {{$short_goal->expire_date < date('Y-m-d') && is_null($short_goal->finished_date) ? 'text-danger' : '' }}
        {{!is_null($short_goal->finished_date) ? 'del' : '' }}">
            <td class="col-md-4">{{$short_goal->short_term_goal_name}}</td>
            <td class="col-md-2">{{$short_goal->registration_date->format('Y年m月d日')}}</td>
            <td class="col-md-2">{{$short_goal->expire_date->format('Y年m月d日')}}<br>
                <!--短期目標の期限日が本日より前の場合-->
                @if($short_goal->expire_date->format('Y-m-d') < date('Y-m-d'))
                    ({{\Carbon\Carbon::create($short_goal->expire_date->format('Y-m-d'))->diffInDays(\Carbon\Carbon::now()->format('Y-m-d'))}}日前)
                    <!--短期目標の期限日が本日より後の場合-->
                    @else
                    (残り{{\Carbon\Carbon::create($short_goal->expire_date->format('Y-m-d'))->diffInDays(\Carbon\Carbon::now()->format('Y-m-d'))}}日)
            </td>
            @endif
            <td class="col-md-2">{{!is_null($short_goal->finished_date) ? $short_goal->finished_date->format('Y年m月d日') : '未'}}</td>
            <td class="col-md-2 text-center last-td">
                <div class="row">
                    <div class="col-auto"><a href="{{route('goals.short.edit',$short_goal)}}" class="btn btn-lg btn-warning">修正</a>
                    </div>
                    <div class="col-auto">
                        <form action="{{route('goals.short.destroy')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $short_goal->id }}">
                            <button type="submit" class="btn btn-lg btn-danger" onclick="return confirm('本当に削除しますか？');">削除</button>
                        </form>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
        @endforeach
    </table>
    <div class="justify-content-center">
        {{ $long_goals->links() }}
    </div>
    @endif
    <div class="text-start">
        <a href="{{route('goals.long.create')}}" class="btn btn-lg btn-primary btn-lg m-3">長期目標の設定</a>
        <a href="{{route('goals.short.create')}}" class="btn btn-lg btn-primary btn-lg m-3">短期目標の設定</a>
    </div>
</div>
@endsection