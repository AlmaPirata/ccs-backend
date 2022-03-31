@extends('layouts.main-layout')

@section('title', 'CCS test')

@section('content')
    @php
        echo '<pre style="background: #333;
    text-align: left;
    color: #fff;
    font-size: 11px;
    padding: 20px;
    max-height: 500px;
    overflow: auto">';
        //print_r($data);
        echo '</pre>';
    @endphp
@endsection
