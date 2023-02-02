@extends('layouts.app')

@section('title')
    Мови програмування
@endsection()

@section('content')
    <h2>Мови програмування</h2>

    @foreach($programmingLanguages as $programmingLanguage)
        <h3>{{ $programmingLanguage->name }}</h3>
    @endforeach

@endsection