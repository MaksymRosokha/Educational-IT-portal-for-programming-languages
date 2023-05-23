@extends('layouts.app')

@section('title', 'Питання та відповіді')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/questions.css') }}">
    @parent
@endsection

@section('scripts')
    @auth('web')
        <script src="{{ asset('js/textareaAutoScroll.js') }}" defer></script>
        <script src="{{ asset('js/questionsAndAnswers/question.js') }}" defer></script>
    @endauth
@endsection

@section('content')
    <section class="questions-and-answers">
        <h2 class="questions-and-answers__title">Питання та відповіді</h2>
        @auth('web')
            <form class="questions-and-answers__create-question create-question"
                  action="{{ route('createQuestion') }}"
                  method="POST">
                <input type="text"
                       name="title"
                       id="title"
                       class="create-question__input-title"
                       required
                       maxlength="200"
                       placeholder="Заголовок питання">
                <textarea name="description"
                          id="description"
                          placeholder="Опис питання"
                          maxlength="5000"
                          class="create-question__input-description"></textarea>
                <button id="create-question"
                        class="create-question__submit"
                        type="submit">
                    Створити
                </button>
            </form>
        @endauth
        <div class="questions-and-answers__questions">
            @include("questionsAndAnswers.generateQuestions", [$questions])
        </div>
    </section>
@endsection