@section('styles')
    <link rel="stylesheet" href="/css/lesson.css"/>
@endsection

<div class="current-lesson">
    <h2 class="current-lesson__title">{{ $lesson->title }}</h2>
    <div class="current-lesson__content">{!! $lesson->content !!}</div>
</div>
