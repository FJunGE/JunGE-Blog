@extends('layouts.default')
@section('title','index')
@section('content')
    @if(Auth::check())
        @include('shared._status_form',['status'=>isset($status)?$status:''])
        @else
        <div class="jumbotron">
            <h1>Laravel 5.7</h1>
            <p>
                Blog开启
            </p>
            <p>
                <a class="btn btn-lg btn-success" href="{{ route('users.create') }}" role="button">现在注册</a>
            </p>
        </div>
    @endif
@endsection