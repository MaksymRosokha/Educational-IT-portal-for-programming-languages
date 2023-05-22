@extends('layouts.app')

@section('title', 'Питання та відповіді')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/answers.css') }}">
    @parent
@endsection

@section('scripts')
    @auth('web')
        <script src="{{ asset('js/textareaAutoScroll.js') }}" defer></script>
        <script src="{{ asset('js/questionsAndAnswers/answer.js') }}" defer></script>
    @endauth
@endsection

@section('content')
    <section class="answers-to-questions">
        <div class="answers-to-questions__question question">
            <h2 class="question__title">{{ $question->title }}</h2>
            <div class="question__author">
                @include('users.author', ['user' => $question->user])
            </div>
            <pre class="question__description">{{ $question->description }}</pre>
            <div class="question__additional-info additional-info">
                <span class="additional-info__date additional-info__date--date-of-creating">
                    Створено: {{ $question->created_at }}
                </span>
                @if($question->created_at != $question->updated_at)
                    <span class="additional-info__date additional-info__date--date-of-editing">
                        Відредаговано: {{ $question->updated_at }}
                    </span>
                @endif
            </div>
        </div>
        @auth('web')
            <form class="answers-to-questions__create-answer create-answer"
                  action="{{ route('createAnswer') }}"
                  method="POST">
            <textarea name="text"
                      id="text"
                      placeholder="Напишіть відповідь"
                      class="create-answer__input-text"
                      required></textarea>
                <button id="create-answer"
                        class="create-answer__submit"
                        type="submit"
                        data-question-id="{{ $question->id }}">
                    Відповісти
                </button>
            </form>
        @endauth
        <div class="answers-to-questions__answers answers">
            @include("questionsAndAnswers.generateAnswers", [$answers])
        </div>
    </section>
@endsection