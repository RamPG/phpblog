@extends('admin.layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Таблица постов</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Action</th>
                </tr>
                </thead>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->slug }}</td>
                        <td>
                            <a
                                class="btn btn-info btn-sm float-left mr-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Подтвердите удаление')">
                                <i
                                    class="fas fa-trash-alt"></i>
                            </button>
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
