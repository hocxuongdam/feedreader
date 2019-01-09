@extends('layout.app')

@section('content')

<div class="flex-center position-ref full-height">
    <h1>LIST OF POSTS</h1>

    @if(count($posts) > 0)
        @foreach($posts as $post)
            <a href="/post/{{$post->id}}">{{ $post->title }}</a>
        @endforeach
        {{ $posts->links() }}
    @else
        <div>There is no post</div>
    @endif
</div>

@endsection
