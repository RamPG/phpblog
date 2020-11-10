@extends('layouts.admin')
@section('title')
    Редактирование статьи
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Редактор статьи</h3>
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
        <form role="form" method="post" action="{{ route('admin.posts.update', ['post' => $post->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Заголовок</label>
                    <input
                        type="text"
                        class="form-control"
                        name="title"
                        id="title"
                        placeholder="Введите заголовок"
                        value="{{ $post->title }}">
                </div>
                <div class="form-group">
                    <label for="content">Текст</label>
                    <textarea
                        class="form-control"
                        name="content"
                        id="content"
                        placeholder="Введите текст"
                        cols="10"
                        rows="10"
                    >{{ $post->content }}</textarea>
                </div>
                <div class="form-group">
                    <label for="thumbnail">Картинка</label>
                    <input
                        type="file"
                        class="form-control"
                        name="thumbnail"
                        id="thumbnail"
                        placeholder="Добавьте картинку">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Обновить</button>
            </div>
        </form>
    </div>
@endsection
