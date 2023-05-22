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
    </div>
@endforeach