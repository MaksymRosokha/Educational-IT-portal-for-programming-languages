@foreach($answers as $answer)
    <div class="answers__answer answer">
        <div class="answer__author">
            @include('users.author', ['user' => $answer->user])
        </div>
        <pre class="answer__text">{{ $answer->text }}</pre>
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
        @auth('web')
            <div class="question__additional-abilities additional-abilities">
                @if($answer->user->id === auth()->user()->id)
                    <button class="additional-abilities__button update-answer-button" data-answer="{{ $answer->id }}">
                        Редагувати
                        <span id="update-modal-window-{{ $answer->id }}"></span>
                    </button>
                @endif
                @if($answer->user->id === auth()->user()->id || auth()->user()->admin === 1)
                    <button class="additional-abilities__button delete-answer-button" data-answer="{{ $answer->id }}">
                        Видалити
                        <span id="delete-modal-window-{{ $answer->id }}"></span>
                    </button>
                @endif
            </div>
        @endauth
    </div>
@endforeach
@if(count($answers) !== $countOfAnswers)
    <img src="{{ asset('storage/images/loader.gif') }}" alt="Завантаження..." class="answers__loader">
@endif