<li>
    <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}">
    <a href="{{ route('users.show', $user->id) }}" class="username">{{ $user->name }}</a>

    @can('adminDestroy', $user)
        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}

            <button type="submit" class="btn btn-sm btn-danger delete-btn">刪除</button>
        </form>
    @endcan
</li>