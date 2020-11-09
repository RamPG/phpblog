@extends('layouts.index')

@section('posts')
    <div class="col-md-8">

        <h1 class="my-4">Page Heading
            <small>Secondary Text</small>
        </h1>

        @foreach($posts as $post)
        <div class="card mb-4">
            <img class="card-img-top" src="{{ asset('storage/' . $post->thumbnail) }}" alt="Card image cap">
            <div class="card-body">
                <h2 class="card-title">{{ $post->title }}</h2>
                <p class="card-text">{{ $post ->description }}</p>
                <a href="#" class="btn btn-primary">Read More &rarr;</a>
            </div>
            <div class="card-footer text-muted">
                Posted on {{ $post->created_at }}
                <a href="#">Start Bootstrap</a>
            </div>
        </div>
        @endforeach
        <!-- Pagination -->
        {{ $posts->onEachSide(1)->links('pagination::bootstrap-4') }}

    </div>
@endsection
