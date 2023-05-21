@extends('layouts.app')

@section('title', 'Питання та відповіді')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/answers.css') }}">
    @parent
@endsection

@section('content')
    <section class="answers-to-questions">
        <div class="answers-to-questions__question question">
            <h2 class="question__title">{{ $question->title }}</h2>
            <div class="question__author">
                @include('users.author', ['user' => $question->user])
            </div>
            <pre class="question__description">{!! $question->description !!}}</pre>
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
        <div class="answers-to-questions__answers answers">
            @foreach($answers as $answer)
                <div class="answers__answer answer">
                    <div class="answer__author">
                        @include('users.author', ['user' => $answer->user])
                    </div>
                    <pre class="answer__text">{!! $answer->text !!}}</pre>
                    <div class="answer__additional-info additional-info">
                        <span class="additional-info__date additional-info__date--date-of-creating">
                            Створено: {{ $answer->created_at }}
                        </span>
                        @if($answer->created_at != $answer->updated_at)
                            <span class="additional-info__date additional-info__date--date-of-editing">
                                Відредаговано: {{ $answer->updated_at }}
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection