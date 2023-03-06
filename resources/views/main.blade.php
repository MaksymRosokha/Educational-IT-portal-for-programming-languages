@extends('layouts.app')

@section('title')
    Навчальний IT-портал для мов програмування
@endsection

@section('styles')
    <link rel="stylesheet" href="/css/main.css"/>
@endsection

@section('content')
    <div class="programming-languages">
        <h2 class="programming-languages__title">Мови програмування</h2>

        <div class="programming-languages__list">
            @foreach($programmingLanguages as $programmingLanguage)
                <div class="programming-language__content">
                    <a class="programming-language__link"
                       href="{{ route('programming_language', $programmingLanguage->id) }}">
                        <img class="programming-language__logo"
                             src="/storage/images/programming languages/logos/{{ $programmingLanguage->logo }}"
                             alt="">
                        <h3 class="programming-language__name">
                            {{ $programmingLanguage->name }}
                        </h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection