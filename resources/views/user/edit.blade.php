@extends('layouts.index')
@section('title')
    Редактирование профиля
@endsection
@section('posts')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <img src="{{ '/storage/' . $user->avatar }}" class="img-thumbnail"/>
        <form method="post" action="{{ route('user.update') }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="avatar">Изменить фото профиля</label>
                <input
                    type="file"
                    class="form-control"
                    name="avatar"
                    id="avatar"
                >
            </div>
            <div class="form-group">
                <label for="name">Имя</label>
                <input
                    type="text"
                    class="form-control"
                    name="name"
                    id="name"
                    placeholder="Введите имя"
                    value="{{ $user->name }}">
            </div>
            <button type="submit" class="btn btn-primary">Обновить</button>
        </form>
    </div>
@endsection
