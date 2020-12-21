@extends('layouts.index')
@section('title')
    Профиль
@endsection
@section('posts')
    <div class="container">
        <img src="{{ '/storage/' . $user->avatar }}" class="img-thumbnail"/>
    </div>
    <div class="container">
        <h2 class="d-block">Имя: {{ $user->name }}</h2>
        <h6 class="d-block">Почтовый ящик: {{ $user->email }}</h6>
        @if(Auth::user()->id === $user->id)
            <a
                class="btn btn-info"
                href="{{ route('user.edit') }}"
            >
                Редактировать
            </a>
            <a
                class="btn btn-info"
                href="{{ route('changeEmailForm') }}"
            >
                Изменить почту
            </a>
            <a
                class="btn btn-info"
                href="{{ route('changePasswordForm') }}"
            >
                Изменить пароль
            </a>
        @endif
        <h3>Комментарии</h3>
    </div>
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
