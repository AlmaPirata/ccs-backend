@extends('layouts.main-layout')

@section('title', 'CCS test')

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <p class="card-text">Парсинг занимает порядка 30 секунд</p>
            <a href="{{ route('parse') }}">Спарсить новости</a>
        </div>
    </div>

    @include('includes.categories')

    @foreach($news_array as $news)
        <div class="card mb-4">
            <div class="card-header">
                <a href="{{ route('getNewsByCategory', $news->category_id) }}">{{ $news->category['title'] }}</a>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $news->title }}</h5>
                <p class="card-text">{{ Str::limit(strip_tags(html_entity_decode($news->text, ENT_HTML5)), 200, '...') }}</p>
                <a href="{{ route('getNews', [$news->category_id, $news->slug]) }}" class="btn btn-primary">Читать новость</a>
            </div>
        </div>
    @endforeach

    {{$news_array->links('vendor.pagination.bootstrap-4')}}
@endsection
