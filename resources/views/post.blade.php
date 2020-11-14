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
        @auth
            <div class="card my-4">
                <h5 class="card-header">Оставить комментарий:</h5>
                <div class="card-body">
                    <form method="post" action="{{ route('comment.store') }}">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}"/>
                        <div class="form-group">
                            <textarea name="content" id="content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </form>
                </div>
            </div>
        @endauth
    <!-- Single Comment -->
        @foreach($comments as $comment)
            <div class="media mb-4">
                <img class="d-flex mr-3 rounded-circle" src="{{ asset('storage/' . $comment->user->avatar) }}"
                     height="50" width="50">
                <div class="media-body">
                    <h5 class="mt-0">
                        <a href="{{ route('user', ['id' => $comment->user_id]) }}">
                            {{ $comment->user->name }}
                        </a>
                    </h5>
                    {{ $comment->content }}<br>
                    <div class="row">
                        <p>
                            Дата: {{ $comment->created_at }}
                        </p>
                        @if($comment->user_id === Auth::user()->id)
                            <form method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">
                                    Удалить
                                </button>
                            </form>
                            <button class="btn btn-info">
                                Редактировать
                            </button>
                        @endif
                    </div>

                </div>
            </div>
    @endforeach
    {{ $comments->onEachSide(1)->links('pagination::bootstrap-4') }}
    <!-- Comment with nested comments -->
    </div>
@endsection
