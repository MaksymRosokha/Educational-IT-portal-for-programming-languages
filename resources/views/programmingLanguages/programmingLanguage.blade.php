@extends('layouts.app')

@section('title', $programmingLanguage->name)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/editorContent.css') }}">
    <link rel="stylesheet" href="{{ asset('css/programming_language.css') }}">
@endsection

@section('content')
    <article class="programming-language">
        @if($isAdmin)
            <admin-panel title="Мова програмування"
                         class="programming-language__admin-panel admin-panel">
                <button-with-modal-window button-text="Редагувати"
                                          title="Редагування мови програмування"
                                          class="admin-panel__button">
                    <programming-language-updater link="{{ route('updateProgrammingLanguage') }}"
                                                  programming-language="{{ $programmingLanguage }}">
                    </programming-language-updater>
                </button-with-modal-window>
                <button-with-modal-window button-text="Видалити"
                                          title="Видалення мови програмування"
                                          class="admin-panel__button">
                    <delete-confirmation link="{{ route('deleteProgrammingLanguage') }}"
                                         id="{{ $programmingLanguage->id }}">
                    </delete-confirmation>
                </button-with-modal-window>
            </admin-panel>
        @endif
        <img class="programming-language__logo"
             src="{{ asset('storage/images/programmingLanguages/logos/' . $programmingLanguage->logo) }}"
             alt="Логотип мови програмування {{ $programmingLanguage->name }}">
        <h2 class="programming-language__name">{{ $programmingLanguage->name }}</h2>
        <pre class="programming-language__description editor-content">{!! $programmingLanguage->description !!}</pre>
        @if($isAdmin)
            <admin-panel title="Програми для мови програмування"
                         class="programming-language__admin-panel admin-panel">
                <button-with-modal-window button-text="Створити"
                                          title="Створення програми для мови програмування"
                                          class="admin-panel__button">
                    <program-in-programming-language-creator link="{{ route('createProgramInProgrammingLanguage') }}"
                                                             programming-language-id="{{ $programmingLanguage->id }}">
                    </program-in-programming-language-creator>
                </button-with-modal-window>
            </admin-panel>
        @endif

        @if(session('result'))
            <div class="programming-language__alert alert alert-success">
                {{ session('result') }}
            </div>
        @endif
        <ol class="programming-language__programs">
            @foreach($programmingLanguage->programs as $program)
                <li class="program-in-programming-language program-in-programming-language__content">
                    <a class="program-in-programming-language__link"
                       href="{{ route('programInProgrammingLanguage', ['programID' => $program->id]) }}"
                       title="{{ $program->name }}">
                        <img class="program-in-programming-language__image"
                             src="{{ asset('storage/images/programsInProgrammingLanguages/' . $program->image) }}"
                             alt="Логотип програми {{ $program->name }}">
                        <h4 class="program-in-programming-language__name">
                            {{ $program->name }}
                        </h4>
                    </a>
                </li>
            @endforeach
        </ol>
    </article>
@endsection