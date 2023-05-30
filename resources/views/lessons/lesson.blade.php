@section('styles')
    <link rel="stylesheet" href="{{ asset('css/editorContent.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lesson.css') }}">
@endsection

<article class="current-lesson">
    @if($isAdmin)
        <admin-panel title="Урок"
                     class="current-lesson__admin-panel admin-panel">
            <button-with-modal-window button-text="Редагувати"
                                      title="Редагування уроку"
                                      class="admin-panel__button">
                <lesson-updater
                        link="{{ route('updateLesson') }}"
                        lesson="{{ $lesson }}">
                </lesson-updater>
            </button-with-modal-window>
            <button-with-modal-window button-text="Видалити"
                                      title="Видалення уроку"
                                      class="admin-panel__button">
                <delete-confirmation
                        link="{{ route('deleteLesson') }}"
                        id="{{ $lesson->id }}">
                </delete-confirmation>
            </button-with-modal-window>
        </admin-panel>
    @endif

    <h2 class="current-lesson__title">{{ $lesson->title }}</h2>
    <pre class="current-lesson__content editor-content">{!! $lesson->content !!}</pre>
    @auth('web')
        @if($lesson->test != null)
            <span class="current-lesson__testing-title">Тестування</span>
            <form class="current-lesson__testing-block testing" action="{{ route('calculateTest') }}" method="POST">
                @csrf

                @if(isset($testResult) && !empty($testResult))
                    <div class="testing__last-result last-result">
                        <span class="last-result__text">Результат: </span>
                        <span class="last-result__result">
                            {{ $testResult->relative_result }} або {{ $testResult->percentage_result }}
                        </span>
                    </div>
                @endif

                <input type="hidden" name="test_id" value="{{ $lesson->test->id }}">

                @foreach($lesson->test->questions as $question)
                    <div class="testing__test test">
                        <span class="test__question">{{$question->text}}</span>
                        <div class="test__answers answers">
                            @foreach($question->answerOptions as $answer)
                                <div class="answers__answer answer">
                                    <input id="{{$answer->id}}--answer"
                                           type="radio"
                                           name="{{$question->id}}"
                                           class="answer__radio"
                                           value="{{$answer->id}}"
                                           required>
                                    <label for="{{$answer->id}}--answer" class="answer__label">
                                        {{$answer->text}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <button type="submit" class="testing__submit">Відправити</button>
            </form>
            @if(isset($isAdmin) && $isAdmin)
                <button-with-modal-window button-text="Видалити тестування"
                                          title="Видалення тестування"
                                          class="current-lesson__delete-test">
                    <delete-confirmation
                            link="{{ route('deleteTest') }}"
                            id="{{ $lesson->test->id }}">
                    </delete-confirmation>
                </button-with-modal-window>
            @endif
        @else
            @if(isset($isAdmin) && $isAdmin)
                @if(session('deleteTestResult'))
                    <div class="current-lesson__alert alert alert-success">
                        {{ session('deleteTestResult') }}
                    </div>
                @endif
                <button-with-modal-window class="current-lesson__create-test"
                                          button-text="Створити тестування"
                                          title="Створення тестування">
                    <test-creator lesson-id="{{ $lesson->id }}"
                                  link="{{ route('createTest') }}"></test-creator>
                </button-with-modal-window>
            @endif
        @endif
    @endauth
</article>