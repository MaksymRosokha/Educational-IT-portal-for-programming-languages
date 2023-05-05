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
                <lesson-deleter
                        link="{{ route('deleteLesson') }}"
                        id="{{ $lesson->id }}">
                </lesson-deleter>
            </button-with-modal-window>
        </admin-panel>
    @endif

    <h2 class="current-lesson__title">{{ $lesson->title }}</h2>
    <pre class="current-lesson__content editor-content">{!! $lesson->content !!}</pre>
</article>
