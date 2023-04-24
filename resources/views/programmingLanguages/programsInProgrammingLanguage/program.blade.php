@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/css/program.css">
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
    <section class="program">
        <h2 class="visibility-hidden">{{ $program->name }}</h2>
        <aside class="program__list-of-lessons list-of-lessons">
            <div class="list-of-lessons__hamburger-menu hamburger-menu">
                <span class="hamburger-menu__decoration"></span>
            </div>
            <a class="link-to-program"
               href="{{ route('programInProgrammingLanguage', ['programID' => $program->id]) }}">Програма</a>
            <h3 class="list-of-lessons__title">Уроки:</h3>
            <ol class="list-of-lessons__lessons">
                @foreach($lessons as $lesson)
                    <li class="list-of-lessons__lesson lesson
                @if(isset($currentLesson) && !empty($currentLesson))
                    @if($lesson->id === $currentLesson->id)
                        lesson--active
                    @endif
                @endif">
                        <a class="lesson__link"
                           href="{{ route('lesson', ['lessonID' => $lesson->id]) }}"
                           title="{{ $lesson->title }}">
                            <div class="lesson__content">
                                {{ $lesson->sequence_number }}.{{ $lesson->title }}
                            </div>
                        </a>
                    </li>
                @endforeach
            </ol>
        </aside>

        <div class="program__content">
            @if(isset($currentLesson) && !empty($currentLesson))
                @include('lessons.lesson', ['lesson' => $currentLesson])
            @else
                <admin-panel title="Програма для мови програмування"
                             class="program__admin-panel admin-panel">
                    <button-with-modal-window button-text="Редагувати"
                                              title="Редагування програми для мови програмування"
                                              class="admin-panel__button">
                        <program-in-programming-language-updater link="{{ route('updateProgramInProgrammingLanguage') }}"
                                                                 program="{{ $program }}">
                        </program-in-programming-language-updater>
                    </button-with-modal-window>
                </admin-panel>
                <article class="program__content">
                    <div class="program__main-info">
                        <img class="program__image"
                             src="/storage/images/programmingLanguages/programsInProgrammingLanguages/images/{{ $program->image }}"
                             alt="Зображення програми {{ $program->name }}">
                        <h2 class="program__name">{{ $program->name }}</h2>
                    </div>
                    <pre class="program__description">{!! $program->description !!}</pre>
                </article>
            @endif
        </div>
    </section>
@endsection