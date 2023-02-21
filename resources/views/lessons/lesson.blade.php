@extends('layouts.app')

@section('css_file')
    /css/lesson.css
@endsection()

@section('title')
    {{ $lesson->title }}
@endsection

@section('content')
    <div class="lesson">
        <h2 class="lesson__title">{{ $lesson->title }}</h2>
        <p class="lesson__content">{!! $lesson->content !!}</p>
    </div>
@endsection
