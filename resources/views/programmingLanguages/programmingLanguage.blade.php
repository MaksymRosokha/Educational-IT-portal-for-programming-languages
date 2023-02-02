@extends('layouts.app')

@section('title')
    {{ $programmingLanguage->name }}
@endsection()

@section('content')
    <h3>{{ $programmingLanguage->name }}</h3>'
    <img src="/storage/images/programming languages/logos/{{ $programmingLanguage->logo }}" alt="Logo is not found">
    <p>{{ $programmingLanguage->description }}</p>
@endsection()