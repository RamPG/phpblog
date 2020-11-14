@extends('layouts.index')
@section('title')
    Профиль
@endsection
@section('posts')
    <div class="container">
        <img src="{{ '/storage/' . $user->avatar }}" class="img-thumbnail"/>
        <div>
            <form method="post" action="">
                <div class="form-group">
                    <label for="thumbnail">Изменить фото профиля</label>
                    <input
                        type="file"
                        class="form-control"
                        name="avatar"
                        id="avatar"
                    >
                </div>
            </form>
        </div>
    </div>
    <div class="userData ml-3">
        <h2 class="d-block">Имя: {{ $user->name }}</h2>
        <h6 class="d-block">Почтовый ящик: {{ $user->email }}</h6>
    </div>
    <h3>Комментарии</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Комментарий</th>
            <th>Название статьи</th>
            <th>Дата создания</th>
            <th>Действие</th>
        </tr>
        </thead>
        @foreach($comments as $comment)
        <tr>
            <td>{{ $comment->content }}</td>
            <td>{{ $comment->post->title }}</td>
            <td>{{ $comment->updated_at  }}</td>
            <td class="column">
                <a
                    class="btn btn-info btn-block"
                    href="{{ route('post.show', ['slug' => $comment->post->slug]) }}"
                >
                    Открыть статью
                </a>
            </td>
        </tr>
        @endforeach
        <tbody>
        </tbody>
    </table>
    {{ $comments->onEachSide(1)->links('pagination::bootstrap-4') }}
@endsection