@extends('layout.app')

@section('content')

    <h1>View content of post</h1>
    <a href="/post">BACK</a>
    <div>{{ $post->title }}</div>
    <div>{{ $post->body }}</div>
    <div>{{ $post->created_at }}</div>

@endsection
