@extends('layouts.app')

@section('title', 'Навчальний IT-портал для мов програмування')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection

@section('content')
    <section class="programming-languages">
        <h2 class="programming-languages__title">Мови програмування</h2>
        @if($isAdmin)
            <admin-panel title="Мови програмування"
                         class="programming-languages__admin-panel admin-panel">
                <button-with-modal-window button-text="Створити"
                                          title="Створення мови програмування"
                                          class="admin-panel__button">
                    <programming-language-creator link="{{ route('createProgrammingLanguage') }}">
                    </programming-language-creator>
                </button-with-modal-window>
            </admin-panel>
        @endif

        <ol class="programming-languages__list">
            @foreach($programmingLanguages as $programmingLanguage)
                <li class="programming-language__content">
                    <a class="programming-language__link"
                       href="{{ route('programming_language', $programmingLanguage->id) }}"
                       title="{{ $programmingLanguage->name }}">
                        <img class="programming-language__logo"
                             src="{{ asset('storage/images/programmingLanguages/logos/' . $programmingLanguage->logo) }}"
                             alt="Логотип мови програмування {{ $programmingLanguage->name }}">
                        <h3 class="programming-language__name">
                            {{ $programmingLanguage->name }}
                        </h3>
                    </a>
                </li>
            @endforeach
        </ol>
    </section>
@endsection