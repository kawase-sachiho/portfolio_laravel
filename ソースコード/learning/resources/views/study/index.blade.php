@extends('layouts.app')
@section('content')
<div class="m-3">
    <h3 class="text-center title-text">{{($d->format('Y/m/d'))}}</h3>
    <div class="row my-3 main-text">
        <div class="col-md-6 col-lg-4">
            <p class="sub-title-text">長期目標</p>
            <!--ユーザーが長期目標を設定していない場合-->
            @if(!isset($long_goal))
            <p>※長期目標が設定されていません</p>
            <!--ユーザーが長期目標を登録している場合-->
            @else
            <ul>
                <li class="@if(!is_null($long_goal->finished_date)) del
                @elseif($long_goal->expire_date->format('Y-m-d') < date('Y-m-d') && is_null($long_goal->finished_date)) text-danger                    
                @endif">
                    {{$long_goal->long_term_goal_name}}
                    @if($long_goal->expire_date->format('Y-m-d') < date('Y-m-d')) {{"(期限日：".$long_goal_diff_days."日前)"}}
                        @else {{"(残り日数：".$long_goal_diff_days."日)"}} @endif
                        </li>
            </ul>
            @endif
            <p class="sub-title-text">短期目標</p>
            <!--ユーザーが短期目標を登録していない場合-->
            @if(!isset($short_goals[0]))
            <p>※短期目標が設定されていません</p>
            <!--ユーザーが短期目標を登録している場合-->
            @else
            @foreach($short_goals as $short_goal)
            <ul>
                <li class="@if(!is_null($short_goal->finished_date)) del 
                @elseif($short_goal->expire_date->format('Y-m-d') < date('Y-m-d') && is_null($short_goal->finished_date)) text-danger                    
                @endif">
                    {{$short_goal->short_term_goal_name}}
                    @if($short_goal->expire_date->format('Y-m-d') < date('Y-m-d')) {{"(期限日：".$short_goal->short_goal_diff_days."日前)"}}
                        @else {{"(残り日数：".$short_goal->short_goal_diff_days."日)"}} @endif
                        </li>
            </ul>
            @endforeach
            @endif
        </div>
        <div class="col-md-6 col-lg-4">
            <p class="sub-title-text">TODO項目</p>
            <!--ユーザーがタスクを登録していない場合-->
            @if(!isset($todo_items[0]))
            <p>※項目が設定されていません</p>
            @endif
            <!--ユーザーが短期目標を登録している場合-->
            @foreach($todo_items as $todo_item)
            <ul>
                <li class="@if(!is_null($todo_item->finished_date)) del 
                @endif">{{$todo_item->item_name}}</li>
            </ul>
            @endforeach
        </div>
        <!--カレンダーの表示-->
        <div class="col-md-12 col-lg-4">
            <div class="justify-content-between">
                <div class="text-center calendar-description">
                    <a href="{{url()->current().'?year='.$previousMonth->format('Y').'&month='.$previousMonth->format('m')}}">prev</a>
                    <strong class="mx-4">{{$thisMonth->format('Y/n')}}</strong>
                    <a href="{{url()->current().'?year='.$nextMonth->format('Y').'&month='.$nextMonth->format('m')}}">next</a>
                </div>
            </div>
            <div class="my-3">
                <div class="calendar-grid calendar-description">
                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thr', 'Fri', 'Sat'] as $weekName)
                    <div class="week-block">
                        {{$weekName}}
                    </div>
                    @endforeach
                    @foreach($calendarDays as $calendarDay)
                    @if($calendarDay['show'])
                    <div class="day-block">
                        <button class="button-day 
                    @foreach($blogs as $blog)
                    @if($calendarDay['date']->format('Y-m-d')==$blog->learning_date->format('Y-m-d') && $blog->study_time>=5)most_study_day
                    @elseif($calendarDay['date']->format('Y-m-d')==$blog->learning_date->format('Y-m-d') && $blog->study_time>=3)more_study_day
                    @elseif($calendarDay['date']->format('Y-m-d')==$blog->learning_date->format('Y-m-d') && $blog->study_time>=1)study_day
                    @endif 
                    @endforeach"
                            type="button" data-date="{{$calendarDay['date']->format('Y-m-d')}}">{{$calendarDay['date']->format('j')}}</button>
                    </div>
                    @else
                    <div class="day-block"></div>
                    @endif
                    @endforeach
                </div>
                <p class="calendar-description text-center mt-3">学習時間 <span style="color:mediumseagreen" ;>■</span>5時間以上
                    <span style="color:springgreen;">■</span>3時間以上
                    <span style="color:palegreen;">■</span>1時間以上
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div style="width:75%;">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        var barCtx = document.getElementById('barChart');
        var barConfig = {
            type: 'bar',
            data: {
                labels: @js($labels),
                datasets: [{
                    label: '学習時間',
                    data: @js($data),
                    backgroundColor:
                        'springgreen',
                    borderWidth: 1
            }]
          },
        };
        let barChart = new Chart(barCtx, barConfig);
    </script>
    @endsection