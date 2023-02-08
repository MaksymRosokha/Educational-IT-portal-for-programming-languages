@extends('layouts.app')

@section('title')
    {{ $program->name }}
@endsection

@section('content')
    <div>
        <h2>{{ $program->name }}</h2>
        <img src="/storage/images/programming languages/programs in programming languages/images/{{ $program->image }}"
             alt="Image not found">
        <p>{{ $program->description }}</p>

        <ul>
            @foreach($program->lessons as $lesson)
                <li><a href="{{ route('lesson', ['lessonID' => $lesson->id]) }}">{{ $lesson->title }}</a></li>
            @endforeach
        </ul>
    </div>
@endsection