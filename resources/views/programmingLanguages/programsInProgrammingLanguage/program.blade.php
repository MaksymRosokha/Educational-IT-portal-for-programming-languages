@extends('layouts.app')

@section('css_file')
    /css/program.css
@endsection

@section('title')
    {{ $program->name }}
@endsection

@section('content')
    <div class="program">

        <ol class="program__list-of-lessons list-of-lessons">
            <h3 class="list-of-lessons__title">Уроки:</h3>
            @foreach($program->lessons as $lesson)
                <li class="list-of-lessons__lesson lesson">
                    <a class="lesson__link"
                       href="{{ route('lesson', ['lessonID' => $lesson->id]) }}">
                        <div class="lesson__content">
                            {{ $lesson->sequence_number }}.{{ $lesson->title }}
                        </div>
                    </a>
                </li>
            @endforeach
        </ol>

        <div class="program__content">
            <div class="program__main-info">
                <img class="program__image"
                     src="/storage/images/programming languages/programs in programming languages/images/{{ $program->image }}"
                     alt="">
                <h2 class="program__name">{{ $program->name }}</h2>
            </div>
            <p class="program__description">{{ $program->description }}</p>
        </div>
    </div>
@endsection