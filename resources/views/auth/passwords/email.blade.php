@extends("layouts.default")
@section("title","重置用户密码")

@section("content")
    <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>重置用户密码</h5>
            </div>
            <div class="panel-body">
                @if(session("status"))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <labels for="email" class="col-md-4 control-label">邮箱：</labels>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">发送重置密码邮件</button>
                </form>
            </div>
        </div>
    </div>
@endsection