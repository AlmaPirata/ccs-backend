@extends('layouts.main-layout')

@section('title', 'CCS test')

@section('content')
    @include('includes.categories')
    @foreach($news_array as $news)
        <div class="card mb-4">
            <div class="card-header">
                <a href="{{ route('getNewsByCategory', $news->category['id']) }}">{{ $news->category['title'] }}</a>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $news->title }}</h5>
                <p class="card-text">{{ Str::limit($news->text, 200, '...') }}</p>
                <a href="{{ route('getNews', [$news->category['id'], $news->slug]) }}" class="btn btn-primary">Читать новость</a>
            </div>
        </div>
    @endforeach

    {{$news_array->links('vendor.pagination.bootstrap-4')}}
@endsection
