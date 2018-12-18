<li id="status-{{ $status->id }}">
    <div class="status_show">
        <a href="{{ route('users.show', $user->id )}}">
            <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="gravatar"/>
        </a>
        <span class="user">
        <a href="{{ route('users.show', $user->id )}}">{{ $user->name }}</a>
        </span>
            <span class="timestamp">
        {{ $status->created_at->diffForHumans() }}
        </span>
        <a href="{{ route('statuses.show', $status->id) }}">
            <span class="content">{{ $status->title }}</span>
        </a>
        @can('destroy',$status)
            <form action="{{ route('statuses.destroy',$status->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <button class="btn btn-danger destroy">删除</button>
            </form>
        @endcan
        @can('update',$status)
            <a class="btn btn-success destroy" href="{{ route('statuses.edit',$status->id) }}">修改</a>
        @endcan
    </div>

</li>