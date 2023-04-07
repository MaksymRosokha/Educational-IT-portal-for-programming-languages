@extends('layouts.app')

@section('title', 'Навчальний IT-портал для мов програмування')

@section('styles')
    <link rel="stylesheet" href="/css/main.css">
@endsection

@section('content')
    <section class="programming-languages">
        <h2 class="programming-languages__title">Мови програмування</h2>

        <ol class="programming-languages__list">
            @foreach($programmingLanguages as $programmingLanguage)
                <li class="programming-language__content">
                    <a class="programming-language__link"
                       href="{{ route('programming_language', $programmingLanguage->id) }}"
                       title="{{ $programmingLanguage->name }}">
                        <img class="programming-language__logo"
                             src="/storage/images/programmingLanguages/logos/{{ $programmingLanguage->logo }}"
                             alt="">
                        <h3 class="programming-language__name">
                            {{ $programmingLanguage->name }}
                        </h3>
                    </a>
                </li>
            @endforeach
        </ol>
    </section>
@endsection