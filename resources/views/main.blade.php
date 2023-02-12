@extends('layouts.app')

@section('title')
    Навчальний IT-портал для мов програмування
@endsection

@section('css_file')
    /css/main.css
@endsection

@section('content')
    <a href="{{ route('programming_languages') }}">Мови програмування</a>
@endsection