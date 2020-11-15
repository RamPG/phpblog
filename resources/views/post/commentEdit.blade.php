@extends('layouts.index')
@section('title')
    Редактирование комментария
@endsection
@section('posts')
    <form role="form" method="post" action="{{ route('comment.update', ['comment' => $comment->id]) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="content">Текст</label>
            <textarea
                class="form-control"
                name="content"
                id="content"
                placeholder="Введите текст"
                cols="5"
                rows="5"
            >{{ $comment->content }}</textarea>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-block">Обновить</button>
        </div>
    </form>
@endsection
