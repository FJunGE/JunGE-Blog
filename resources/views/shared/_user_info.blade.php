<a href="{{ route('users.show', $user->id) }}">
    <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="gravatar">
</a>
<h1>{{ $user->name }}</h1>
<form action="">

</form>
@if(Auth::user()->id !== $user->id)
    @if(Auth::user()->isFollow($user->id))
        <form action="{{ route('user.unfollower',$user->id) }}" method="post">
            {{ csrf_field() }}
            <button class="btn btn-danger" type="submit">取消关注</button>
            <button class="btn btn-success" disabled="disabled">对方已关注了你</button>
        </form>
        @else
        <form action="{{ route('user.follower',$user->id) }}" method="post">
            {{ csrf_field() }}
            <button class="btn btn-primary" type="submit">关注</button>
        </form>
    @endif
@endif