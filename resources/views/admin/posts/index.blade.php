@extends('admin.layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header justify-content-between">

            <h3 class="card-title">Таблица постов</h3>
        </div>
        <a class="btn btn-primary" href="{{ route('admin.posts.create') }}">Создать пост</a>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Заголовок</th>
                    <th>Описание</th>
                    <th>Действие</th>
                </tr>
                </thead>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->description }}</td>
                        <td>
                            <a
                                class="btn btn-info btn-sm float-left mr-1"
                                href="{{ route('admin.posts.edit', ['post' => $post->id]) }}"
                            >
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i
                                        class="fas fa-trash-alt"></i>
                                </button>
                            </form>

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
