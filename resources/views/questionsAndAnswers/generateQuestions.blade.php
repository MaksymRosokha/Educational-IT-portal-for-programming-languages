@foreach($questions as $question)
    <div class="questions-and-answers__question question">
        <div class="question__author">
            @include('users.author', ['user' => $question->user])
        </div>
        <div class="question__text">
            <a href="{{ route('answers', ['questionID' => $question->id]) }}"
               class="question__link-to-answers">{{ $question->title }}</a>
        </div>
        <div class="question__additional-info additional-info">
            <span class="additional-info__date additional-info__date--date-of-creating">
                Створено: {{ $question->created_at }}
            </span>
            @if($question->created_at != $question->updated_at)
                <span class="additional-info__date additional-info__date--date-of-editing">
                    Відредаговано: {{ $question->updated_at }}
                </span>
            @endif
            <span class="additional-info__count-of-answers">Відповіді: {{ count($question->answers) }}</span>
        </div>
    </div>
@endforeach
@if(count($questions) !== $countOfQuestions)
    <img src="{{ asset('storage/images/loader.gif') }}" alt="Завантаження..." class="questions-and-answers__loader">
@endif