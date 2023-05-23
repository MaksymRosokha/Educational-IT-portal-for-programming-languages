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
                    <button-with-modal-window class="additional-abilities__button"
                                              button-text="Редагувати"
                                              title="Редагування">
                        <answer-updater link="{{ route('updateAnswer') }}"
                                        answer="{{ $answer }}">
                        </answer-updater>
                    </button-with-modal-window>
                @endif
                @if($answer->user->id === auth()->user()->id || auth()->user()->admin === 1)
                    <button-with-modal-window class="additional-abilities__button"
                                              button-text="Видалити"
                                              title="Видалення">
                        <answer-deleter link="{{ route('deleteAnswer') }}"
                                          id="{{ $answer->id }}">
                        </answer-deleter>
                    </button-with-modal-window>
                @endif
            </div>
        @endauth
    </div>
@endforeach