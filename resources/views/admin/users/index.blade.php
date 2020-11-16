@extends('layouts.admin')
@section('title')
    Таблица пользователей
@endsection
@section('content')
    <div class="card">
        <div class="card-header justify-content-between">

            <h3 class="card-title">Таблица пользователей</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Имя</th>
                    <th>Почта</th>
                    <th>Дата создания</th>
                    <th>Действие</th>
                </tr>
                </thead>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td class="column">
                            <a
                                class="btn btn-info btn-block"
                                href="{{ route('admin.user.edit', ['user' => $user->id]) }}"
                            >
                                Редактировать
                            </a>
                            <form action="{{ route('admin.user.destroy', ['user' => $user->id]) }}" method="post">
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
            {{ $users->onEachSide(1)->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
