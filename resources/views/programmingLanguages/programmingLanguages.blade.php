@extends('layouts.app')

@section('title')
    Мови програмування
@endsection()

@section('content')
    <h2>Мови програмування</h2>

    @foreach($programmingLanguages as $programmingLanguage)
        <img src="/storage/images/programming languages/logos/{{ $programmingLanguage->logo }}" alt="Logo is not found">
        <h3><a href="{{ route('programming_language', $programmingLanguage->id) }}">{{ $programmingLanguage->name }}</a></h3>
    @endforeach

@endsection