@extends('layouts.main-layout')

@section('title', $news->title)

@section('content')
    @include('includes.categories')
    <div>
        <a href="{{route('getNewsByCategory', $slug_category)}}" class="btn btn-outline-primary mb-4">Назад</a>
    </div>
    <h1>{{ $news->title }}</h1>
    @if($news->image['path'])
        <picture>
            <img src="{{ $news->image['path'] }}" alt="photo 1">
        </picture>
    @endif
    <article>
        {!! $news->text !!}
    </article>

@endsection
