@extends('layouts.default')
@section('title', '微博详情')
@section('content')
    <div class="row">
        <div class="col-md-offset-2 col-md-12">
            <div class="col-md-12">
                <div class="col-md-offset-2 col-md-12">
                    <section class="user_info">
                        @include('shared._statuses_info',['status'=>$status,'users'=>$user])
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection