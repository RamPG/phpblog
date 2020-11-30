@extends('layouts.index')
@section('title')
    Главная страница
@endsection
@section('posts')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <div class="col-md-8">
            @foreach($posts as $post)
                <div class="card mb-4">
                    <img class="card-img-top" src="{{ asset('storage/' . $post->thumbnail) }}" width="750" height="300">
                    <div class="card-body">
                        <h2 class="">{{ $post->title }}</h2>
                        <p class="card-text">{{ $post ->description }}</p>
                        <a href="{{ route('post.show', ['slug' => $post->slug]) }}" class="btn btn-primary">Читать
                            полностью &rarr;</a>
                    </div>
                    <div class="card-footer text-muted">
                        Создано: {{ $post->created_at->format('H:i:s d.m.Y') }}
                    </div>
                </div>
            @endforeach
        <!-- Pagination -->
            {{ $posts->onEachSide(1)->links('pagination::bootstrap-4') }}
        </div>
@endsection
