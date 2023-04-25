@section('styles')
    <link rel="stylesheet" href="/css/lesson.css">
@endsection

<article class="current-lesson">
    <h2 class="current-lesson__title">{{ $lesson->title }}</h2>
    <pre class="current-lesson__content">{!! $lesson->content !!}</pre>
</article>
