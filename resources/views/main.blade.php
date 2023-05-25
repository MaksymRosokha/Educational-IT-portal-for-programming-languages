@extends('layouts.app')

@section('title', 'Навчальний IT-портал для мов програмування')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection

@section('content')
    <section class="main">
        @if(session('deleteUserResult'))
            <div class="main__alert alert alert-success">
                {{ session('deleteUserResult') }}
            </div>
        @endif
        <h2 class="main__title">Навчальний IT-портал для мов програмування</h2>

        <section class="main__about-project about-project">
            <h3 class="about-project__title">Про проєкт</h3>
            <p class="about-project__paragraph">Ласкаво просимо на "Навчальний IT-портал для мов програмування"! Наш сайт є ідеальним місцем для всіх, хто бажає освоїти навички програмування та розвинути свої IT-здібності.</p>
            <p class="about-project__paragraph">На нашому порталі ми надаємо широкий спектр навчальних матеріалів і ресурсів, що допоможуть вам вивчити різноманітні мови програмування. Ми розуміємо, що світ IT швидко змінюється, тому наш контент оновлюється постійно, щоб відповідати сучасним тенденціям та новим технологіям.</p>
            <p class="about-project__paragraph">Наш сайт надає вам можливість ознайомитися з основами програмування та вивчити різноманітні мови програмування, такі як Python, Java, JavaScript, C++, Ruby та багато інших. Ми стежимо за тим, щоб матеріали були легкими для розуміння та доступними для різних рівнів навичок - від початківців до досвідчених розробників.</p>
            <p class="about-project__paragraph">Окрім навчальних матеріалів, ми також пропонуємо вам можливість спілкуватися з іншими учасниками нашої спільноти. Форуми дозволять вам обговорювати питання, ділитися знаннями та вирішувати проблеми разом з іншими програмістами.</p>
            <p class="about-project__paragraph">Наша мета — зробити навчання програмування простим, захопливим і доступним для всіх. Ми віримо, що кожна людина може стати успішним програмістом, якщо отримає відповідні знання та підтримку.</p>
            <p class="about-project__paragraph">Тож, якщо ви зацікавлені у вивченні мов програмування та розвитку своєї IT-кар'єри, запрошуємо вас приєднатися до нашого "Навчального IT-порталу для мов програмування". Розпочати свою навчальну подорож і отримувати доступ до високоякісного навчального вмісту, який вас зацікавить.</p>
            <p class="about-project__paragraph">Завдяки "Навчальному IT-порталу для мов програмування", ви зможете розширити свої знання та вміння у сфері програмування, незалежно від вашого досвіду чи попередньої освіти. Наша мета - зробити процес навчання захопливим, цікавим та ефективним.</p>
            <p class="about-project__paragraph">Приєднуйтесь до нашого навчального порталу вже сьогодні та розпочинайте свій шлях до успіху у сфері програмування!</p>
        </section>

        <section class="main__programming-languages programming-languages">
            <h3 class="programming-languages__title">Мови програмування</h3>
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

            @if(session('result'))
                <div class="main__alert alert alert-success">
                    {{ session('result') }}
                </div>
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
        <section class="main__statistics statistics">
            <h3 class="statistics__title">Статистика</h3>
            <div class="statistics__items">
                <div class="statistics__item">
                    <span class="statistics__item-name">Мов програмування:</span>
                    <span class="statistics__item-value">{{ $statistics['programmingLanguages'] }}</span>
                </div>
                <div class="statistics__item">
                    <span class="statistics__item-name">Програм:</span>
                    <span class="statistics__item-value">{{ $statistics['programs'] }}</span>
                </div>
                <div class="statistics__item">
                    <span class="statistics__item-name">Уроків:</span>
                    <span class="statistics__item-value">{{ $statistics['lessons'] }}</span>
                </div>
                <div class="statistics__item">
                    <span class="statistics__item-name">Користувачів:</span>
                    <span class="statistics__item-value">{{ $statistics['users'] }}</span>
                </div>
            </div>
        </section>
    </section>
@endsection