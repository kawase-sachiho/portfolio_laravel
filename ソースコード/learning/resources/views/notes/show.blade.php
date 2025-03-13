@extends('layouts.app')
@section('content')
<div class="m-3 p-3">
<h1 class="title-text text-center mb-3">NOTE</h1>
    <table class="table table-responsive table-borderless">
        <tr class="row">
            <th class="col-md-2 sub-title-text">タイトル</th>
            <td class="col-md-10 main-text">{{is_null($note->title) ? "No title" : $note->title}}</td>
        </tr>
        <tr class="row">
            <th class="col-md-2 sub-title-text">登録日</th>
            <td class="col-md-10 main-text">{{$note->registration_date->format('Y年m月d日') }}</td>
        </tr>
        <tr class="row">
            <th class="col-md-2 sub-title-text">本文</th>
            <td class="col-md-10 main-text">{!! nl2br($note->content) !!}</td>
        </tr>
        <!--ノートに画像が登録されている場合は表示する-->
        @if(!is_null($note->image))
        <tr class="row">
            <th class="col-md-2 sub-title-text">画像</th>
            <td class="col-md-10- main-text">
                <img src="{{ Storage::url($note->image)}}" width="100%">
            </td>
        </tr>
        @endif
    </table>
    <div class="text-end">
    <a href="{{route('notes.index')}}" class="btn btn-primary btn-lg">back</a>
    </div>
</div>
@endsection