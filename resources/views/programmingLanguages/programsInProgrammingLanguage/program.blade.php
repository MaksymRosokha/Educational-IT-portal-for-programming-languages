@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/css/program.css"/>
    @parent
@endsection

@section('scripts')
    <script src="/js/hamburgerMenuForProgram.js" defer></script>
@endsection

@section('title')
    @if(isset($currentLesson) && !empty($currentLesson))
        {{ $currentLesson->title }}
    @else
        {{ $program->name }}
    @endif
@endsection

@section('content')
    <div class="program">

        <ol class="program__list-of-lessons list-of-lessons">
            <div class="list-of-lessons__hamburger-menu hamburger-menu">
                <span class="hamburger-menu__decoration"></span>
            </div>
            <a class="link-to-program" href="{{ route('programInProgrammingLanguage', ['programID' => $program->id]) }}">Програма</a>
            <h3 class="list-of-lessons__title">Уроки:</h3>
            @foreach($lessons as $lesson)
                <li class="list-of-lessons__lesson lesson
                @if(isset($currentLesson) && !empty($currentLesson))
                    @if($lesson->id === $currentLesson->id)
                        lesson--active
                    @endif
                @endif">
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
            @if(isset($currentLesson) && !empty($currentLesson))
                @include('lessons.lesson', ['lesson' => $currentLesson])
            @else
                <div class="program__main-info">
                    <img class="program__image"
                         src="/storage/images/programming languages/programs in programming languages/images/{{ $program->image }}"
                         alt="">
                    <h2 class="program__name">{{ $program->name }}</h2>
                </div>
                <p class="program__description">{{ $program->description }}</p>
            @endif
        </div>
    </div>
@endsection