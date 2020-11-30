@extends('layouts.admin')
@section('title')
    Просмотр статьи
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Просмотр статьи</h3>
        </div>
        <div class="col-lg-8">

            <!-- Title -->
            <h1 class="mt-4">{{ $post->title }}</h1>

            <hr>

            <!-- Date/Time -->
            <p>Создано: {{ $post->created_at }}</p>

            <hr>

            <!-- Preview Image -->
            <img class="img-fluid rounded" src="{{ asset('storage/' . $post->thumbnail) }}" alt="">
            <p> {{ $post->content }} </p>
            <hr>

            <!-- Post Content -->
            <hr>


@endsection
