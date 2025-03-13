@extends('layouts.app')
@section('content')
<div class="container-md">
    <!--セッションにメッセージがある場合、フラッシュメッセージを表示する-->
    @if (session('flash_message'))
    <div class="space mb-3" style="height:40px;">
        <div class="flash_message alert alert-success">
            {{ session('flash_message') }}
        </div>
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header title-text">
                    USER INFO EDIT
                </div>
                <div class="card-body">
                    <form action="{{route('users.update')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" class="" value="{{$user->id}}">
                        <div class="row mb-3">
                            <label for="inputName" class="col-sm-2 col-form-label main-text">Name</label>
                            <div class="col-sm-10 text-danger">
                                <input type="text" value="{{old('name',$user->name)}}" name="name" class="form-control" id="inputName">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail1" class="col-sm-2 col-form-label main-text">Email</label>
                            <div class="col-sm-10 text-danger">
                                <input type="email" name="email" value="{{old('email',$user->email)}}" class="form-control" id="inputEmail1">
                                @error('email')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword1" class="col-sm-2 col-form-label main-text">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" id="inputPassword1">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword2" class="col-sm-2 col-form-label main-text">Password Confirm</label>
                            <div class="col-sm-10 text-danger">
                                <input type="password" name="password_confirmation" class="form-control" id="inputPassword2">
                                @error('password')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-lg">登録</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection