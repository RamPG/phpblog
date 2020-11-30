@extends('layouts.admin')
@section('title')
    Таблица статей
@endsection
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">

            <h3 class="card-title">Таблица статей</h3>
        </div>
        <a class="btn btn-primary" href="{{ route('admin.post.create') }}">Создать статью</a>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Заголовок</th>
                    <th>Описание</th>
                    <th>Дата создания</th>
                    <th>Действие</th>
                </tr>
                </thead>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->description }}</td>
                        <td>{{ $post->created_at }}</td>
                        <td class="column">
                            <a
                                class="btn btn-info btn-block"
                                href="{{ route('admin.post.show', ['post' => $post->id]) }}"
                            >
                                Просмотреть
                            </a>
                            <a
                                class="btn btn-info btn-block"
                                href="{{ route('admin.post.edit', ['post' => $post->id]) }}"
                            >
                                Редактировать
                            </a>
                            <form action="{{ route('admin.post.destroy', ['post' => $post->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-block">
                                    Удалить
                                </button>
                            </form>
                            <a
                                class="btn btn-info btn-block"
                                href="{{ route('admin.post.comments', ['post' => $post->id]) }}"
                            >
                                Открыть комментарии
                            </a>

                        </td>
                    </tr>
                @endforeach
                <tbody>
                </tbody>
            </table>
            {{ $posts->onEachSide(1)->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
