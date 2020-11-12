@extends('layouts.admin')
@section('title')
    Список комментариев
@endsection
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">

            <h3 class="card-title">Список комментариев</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Имя пользователя</th>
                    <th>Комментарий</th>
                    <th>Дата создания</th>
                    <th>Действие</th>
                </tr>
                </thead>
                @foreach($comments as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td>{{ $comment->user->name }}</td>
                        <td>{{ $comment->content }}</td>
                        <td>{{ $comment->created_at }}</td>
                        <td class="column">
                            <a
                                class="btn btn-info btn-block"
                                href="{{ route('admin.comment.edit', ['comment' => $comment->id]) }}"
                            >
                                Редактировать
                            </a>
                            <form action="{{ route('admin.comment.destroy', ['comment' => $comment->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-block">
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tbody>
                </tbody>
            </table>
            {{ $comments->onEachSide(1)->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
