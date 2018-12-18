<div class="jumbotron">
    @if(empty($status))
        <h3>发布博客</h3>
        <form action="{{ route('statuses.store') }}" class="form-group" method="post">
            {{ csrf_field() }}
            @include('shared._error')
            <div class="form-group">
                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
            </div>
            <textarea name="text_content" id="" cols="30" rows="10" class="form-control">{{ old('text_content') }}</textarea>
            <div class="form-group">
                <button type="submit" class="btn btn-primary pull-right">提交</button>
            </div>
        </form>
        @else
        <h3>修改博客</h3>
        <form action="{{ route('statuses.update',$status->id) }}" class="form-group" method="post" onsubmit="return confirm('确定要删除吗')">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            @include('shared._error')
            <div class="form-group">
                <input type="text" class="form-control" name="title" value="{{ $status->title }}">
            </div>
            <textarea name="text_content"  cols="30" rows="10" class="form-control">{{ $status->text_content }}</textarea>
            <div class="form-group">
                <button type="submit" class="btn btn-primary pull-right">提交</button>
            </div>
        </form>
    @endif

</div>