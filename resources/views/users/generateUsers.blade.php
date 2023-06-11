@if(count($users) == 0)
    <span class="users__not-found">Нікого не вдалося знайти</span>
@else
    @foreach($users as $user)
        <div class="users__user user">
            <div class="user__avatar avatar">
                <img class="avatar__image"
                     src="{{ asset('storage/images/users/avatars/' . $user->avatar) }}"
                     alt="Аватар користувача {{ $user->login }}">
            </div>
            <table class="user__text-info">
                <tr class="user__info-block">
                    <th class="user__name-of-info">Id:</th>
                    <td class="user__info">{{ $user->id }}</td>
                </tr>
                <tr class="user__info-block">
                    <th class="user__name-of-info">Email:</th>
                    <td class="user__info">{{ $user->email }}</td>
                </tr>
                <tr class="user__info-block">
                    <th class="user__name-of-info">Логін:</th>
                    <td class="user__info">{{ $user->login }}</td>
                </tr>
                <tr class="user__info-block">
                    <th class="user__name-of-info">Ім'я:</th>
                    <td class="user__info">{{ $user->name }}</td>
                </tr>
                @if(!empty($user->blocked_until))
                    <tr class="user__info-block">
                        <th class="user__name-of-info">Заблокований до:</th>
                        <td class="user__info">{{ $user->blocked_until }}</td>
                    </tr>
                @endif
                <tr class="user__info-block">
                    <th class="user__name-of-info">Дата народження:</th>
                    <td class="user__info">{{ $user->date_of_birthday }}</td>
                </tr>
                <tr class="user__info-block">
                    <th class="user__name-of-info">Про користувача:</th>
                    <td class="user__info">{{ $user->about_me }}</td>
                </tr>
                <tr class="user__info-block">
                    <th class="user__name-of-info">Дата створення:</th>
                    <td class="user__info">{{ $user->created_at }}</td>
                </tr>
                <tr class="user__info-block">
                    <th class="user__name-of-info">Дата оновлення:</th>
                    <td class="user__info">{{ $user->updated_at }}</td>
                </tr>
            </table>

            <div class="user__additional-abilities additional-abilities">
                <div class="additional-abilities__ability view-profile">
                    <a href="{{ route('user', ['login' => $user->login]) }}" class="view-profile__link">
                        Переглянути профіль
                    </a>
                </div>
                <div class="additional-abilities__ability role">
                    <label class="role__name">Роль:</label>
                    <select data-user-id="{{ $user->id }}" class="role__selector" name="role">
                        <option class="role__point" value="user">
                            Користувач
                        </option>
                        <option class="role__point" value="admin" @if($user->admin === 1) selected @endif>
                            Адміністратор
                        </option>
                    </select>
                </div>
                <button class="additional-abilities__ability block-user-button" data-user="{{ $user->id }}">
                    Заблокувати
                    <span id="block-user-modal-window-{{ $user->id }}"></span>
                </button>
                @if($user->blocked_until !== null)
                    <button class="additional-abilities__ability unlock-user-button" data-user="{{ $user->id }}">
                        Розблокувати
                        <span id="unlock-user-modal-window-{{ $user->id }}"></span>
                    </button>
                @endif
                <button class="additional-abilities__ability delete-user-button" data-user="{{ $user->id }}">
                    Видалити
                    <span id="delete-user-modal-window-{{ $user->id }}"></span>
                </button>
            </div>
        </div>
    @endforeach
@endif
@if(count($users) !== $countOfUsers)
    <img src="{{ asset('storage/images/loader.gif') }}" alt="Завантаження..." class="users__loader">
@endif