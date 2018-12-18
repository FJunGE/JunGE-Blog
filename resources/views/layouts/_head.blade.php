<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="{{ route('home') }}">Laravel 5.7</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="nav navbar-nav mr-auto navbar-right">
            @if(Auth::user())
                <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">用户列表</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                       {{ Auth::user()->name }} <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('users.show', Auth::user()->id) }}">个人中心</a></li>
                        <li><a href="{{ route('users.edit', Auth::user()->id) }}">编辑资料</a></li>
                        <li class="divider"></li>
                        <li>
                            <a id="logout" href="#">
                                <form action="{{ route('logout') }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                                </form>
                            </a>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('login') }}">登录</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('help') }}">帮助</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            @endif
        </ul>
        <form class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" style="margin-top: 10px;">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">搜索</button>
        </form>
    </div>
</nav>