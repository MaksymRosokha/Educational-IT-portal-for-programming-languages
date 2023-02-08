@extends('layouts.app')

@section('title')
    {{ $lesson->title }}
@endsection

@section('content')
    <div>
        <h2>{{ $lesson->title }}</h2>
        <p>{!! $lesson->content !!}</p>
    </div>
@endsection
