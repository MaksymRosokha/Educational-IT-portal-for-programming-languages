@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="/css/programming_language.css"/>
@endsection

@section('title')
    {{ $programmingLanguage->name }}
@endsection()

@section('content')
    <div class="programming-language">
        <div class="programming-language__content">
            <img class="programming-language__logo"
                 src="/storage/images/programming languages/logos/{{ $programmingLanguage->logo }}" alt="">
            <h2 class="programming-language__name">{{ $programmingLanguage->name }}</h2>
            <p class="programming-language__description">{{ $programmingLanguage->description }}</p>
            <div class="programming-language__programs">
                @foreach($programmingLanguage->programs as $program)
                    <div class="program-in-programming-language program-in-programming-language__content">
                        <a class="program-in-programming-language__link"
                           href="{{ route('programInProgrammingLanguage', ['programID' => $program->id]) }}">
                            <img class="program-in-programming-language__image"
                                 src="/storage/images/programming languages/programs in programming languages/images/{{ $program->image }}"
                                 alt="">
                            <h4 class="program-in-programming-language__name">
                                {{ $program->name }}
                            </h4>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection()