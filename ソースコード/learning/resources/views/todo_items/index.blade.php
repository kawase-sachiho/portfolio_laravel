@extends('layouts.app')
@section('content')
<div class="m-3 p-3">
    <h3 class="title-text mb-3">TODO LIST</h3>
    <!--ユーザーがタスクを登録していない場合-->
    @if(!isset($todo_items[0]))
    <p>項目が登録されていません</p>
    <!--ユーザーがタスクを登録している場合-->
    @else
    <table class="table table-responsive table-striped">
        <tr class="row sub-title-text">
            <th class="col-md-4">項目名</th>
            <th class="col-md-2">登録日</th>
            <th class="col-md-2">期限日(残日数)</th>
            <th class="col-md-2">完了日</th>
            <th class="col-md-2">操作</th>
        </tr>
        @foreach ($todo_items as $todo_item)
        <tr class="row main-text {{$todo_item->class}}">
            <td class="col-md-4">{{ $todo_item->item_name }}</td>
            <td class="col-md-2">{{$todo_item->registration_date->format('Y年m月d日')}} </td>
            <td class="col-md-2">{{ $todo_item->expire_date->format('Y年m月d日') }}<br>
            <!--タスクの期限日が本日より前の場合-->    
            @if($todo_item->expire_date->format('Y-m-d') < date('Y-m-d'))
                    ({{$todo_item->todo_item_diff_days}}日前)
            <!--タスクの期限日が本日より後の場合-->
                    @else
                    (残り{{$todo_item->todo_item_diff_days}}日)
                    @endif</td>
            <td class="col-md-2">{{ !is_null($todo_item->finished_date) ? $todo_item->finished_date->format('Y年m月d日') : '未' }}</td>
            <td class="col-md-2 text-center last-td">
                <div class="row">
                    <div class="col-auto"><a href="{{ route('todo_items.edit', $todo_item) }}" class="btn btn-warning btn-lg">修正</a></div>
                    <div class="col-auto">
                        <form action="{{ route('todo_items.destroy',$todo_item->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $todo_item->id }}">
                            <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('本当に削除しますか？');">削除</button>
                        </form>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $todo_items->links() }}
    @endif
    <div class="text-left">
        <a href="{{ route('todo_items.create') }}" class="btn btn-primary btn-lg">新規項目作成</a>
    </div>
</div>
@endsection