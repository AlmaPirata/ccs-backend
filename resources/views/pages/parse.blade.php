@extends('layouts.main-layout')

@section('title', 'CCS test')

@section('content')
    <a href="/" class="btn btn-outline-primary mb-4">Вернуться</a>
    <p>Спаршено новостей: {{ $count }}</p>
    @php
        dd($data);
    @endphp
@endsection
