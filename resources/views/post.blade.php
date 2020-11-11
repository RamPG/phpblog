@extends('layouts.index')
@section('title')
    {{ $post->title }}
@endsection
@section('posts')
    <div class="col-lg-8">

        <!-- Title -->
        <h1 class="mt-4">{{ $post->title }}</h1>

        <hr>

        <!-- Date/Time -->
        <p>Создано: {{ $post->created_at }}</p>

        <hr>

        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{ asset('storage/' . $post->thumbnail) }}" alt="">
        <p> {{ $post->content }} </p>
        <hr>

        <!-- Post Content -->
        <hr>

        <!-- Comments Form -->
        <div class="card my-4">
            <h5 class="card-header">Оставить комментарий:</h5>
            <div class="card-body">
                <form method="post" action="{{ route('comments.store') }}">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}" />
                    <div class="form-group">
                        <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </form>
            </div>
        </div>

        <!-- Single Comment -->
        @foreach($comments as $comment)
            <div class="media mb-4">
                <img class="d-flex mr-3 rounded-circle" src="{{ asset('storage/' . $comment->user->avatar) }}" height="50" width="50">
                <div class="media-body">
                    <h5 class="mt-0">{{ $comment->user->name }}</h5>
                    {{ $comment->comment }}
                </div>
            </div>
        @endforeach


        <!-- Comment with nested comments -->
    </div>
@endsection
