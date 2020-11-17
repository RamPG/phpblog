@extends('layouts.index')
@section('title')
    Редактирование комментария
@endsection
@section('posts')
    @if(count($matchPosts))
        <h1>Найденные посты</h1>
        <div class="col-md-8">
            @foreach($matchPosts as $matchPost)
                <div class="card mb-4">
                    <img class="card-img-top" src="{{ asset('storage/' . $matchPost->thumbnail) }}" width="750"
                         height="300">
                    <div class="card-body">
                        <h2 class="">{{ $matchPost->title }}</h2>
                        <p class="card-text">{{ $matchPost ->description }}</p>
                        <a href="{{ route('post.show', ['slug' => $matchPost->slug]) }}" class="btn btn-primary">Читать
                            полностью &rarr;</a>
                    </div>
                    <div class="card-footer text-muted">
                        Создано: {{ $matchPost->created_at->format('H:i:s d.m.Y') }}
                    </div>
                </div>
            @endforeach
        <!-- Pagination -->
            {{ $matchPosts->onEachSide(1)->links() }}
        </div>
    @else
        <h1>Ничего не найдено</h1>
    @endif
@endsection
