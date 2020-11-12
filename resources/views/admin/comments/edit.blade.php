@extends('layouts.admin')
@section('title')
    Редактирование комментария
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Редактор комментария</h3>
        </div>
        <!-- /.card-header -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form role="form" method="post" action="{{ route('admin.comment.update', ['comment' => $comment->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="content">Комментарий</label>
                    <textarea
                        class="form-control"
                        name="content"
                        id="content"
                        placeholder="Введите текст"
                        cols="10"
                        rows="10"
                    >{{ $comment->content }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Обновить</button>
            </div>
        </form>
    </div>
@endsection
