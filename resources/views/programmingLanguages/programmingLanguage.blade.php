@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/css/programming_language.css">
@endsection

@section('title')
    {{ $programmingLanguage->name }}
@endsection

@section('content')
    <article class="programming-language">
        <img class="programming-language__logo"
             src="/storage/images/programmingLanguages/logos/{{ $programmingLanguage->logo }}"
             alt="Логотип мови програмування {{ $programmingLanguage->name }}">
        <h2 class="programming-language__name">{{ $programmingLanguage->name }}</h2>
        <p class="programming-language__description">{{ $programmingLanguage->description }}</p>
        <ol class="programming-language__programs">
            @foreach($programmingLanguage->programs as $program)
                <li class="program-in-programming-language program-in-programming-language__content">
                    <a class="program-in-programming-language__link"
                       href="{{ route('programInProgrammingLanguage', ['programID' => $program->id]) }}"
                       title="{{ $program->name }}">
                        <img class="program-in-programming-language__image"
                             src="/storage/images/programmingLanguages/programsInProgrammingLanguages/images/{{ $program->image }}"
                             alt="">
                        <h4 class="program-in-programming-language__name">
                            {{ $program->name }}
                        </h4>
                    </a>
                </li>
            @endforeach
        </ol>
    </article>
@endsection