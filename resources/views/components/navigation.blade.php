<nav>
    <div class="nav-links">
        <x-partials.nav-link
                href="/customers"
                :active="request()->is('customers*')"
        >
            {{ __('app.customers') }}
        </x-partials.nav-link>

        <x-partials.nav-link
                href="/contracts"
                :active="request()->is('contracts*')"
        >
            {{ __('app.maintenance_contracts') }}
        </x-partials.nav-link>

        <x-partials.nav-link
                href="/services"
                :active="request()->is('services*')"
        >
            {{ __('app.services') }}
        </x-partials.nav-link>

        @can('viewAny', \App\Models\User::class)
            <x-partials.nav-link
                    href="/users"
                    :active="request()->is('users*')"
            >
                {{ __('app.users') }}
            </x-partials.nav-link>
        @endcan
    </div>

    <div class="user-area">
        <div class="dropdown-wrapper">
            <form class="block" method="POST" action="{{ route('users.update.language', auth()->user()->id) }}"
                  x-data="{
                  language: '{{ auth()->user()->preferred_language }}',
                  translations: { en: '{{ __('app.en') }}', de: '{{ __('app.de') }}' },
                  get alternativeLanguage() {
                      return this.language === 'en' ? 'de' : 'en';
                  }
              }"
                  @submit.prevent="$refs.languageForm.submit()" x-ref="languageForm">
                @csrf
                @method('PUT')

                <input type="hidden" name="preferred_language" x-ref="languageInput" :value="language">

                <x-dropdown.field align="left" width="48">
                    <x-slot name="trigger">
                        <x-dropdown.button>
                            <span x-text="translations[language]"></span>
                        </x-dropdown.button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown.link href="#"
                                         @click.prevent="language = alternativeLanguage; $refs.languageForm.submit()">
                            <span x-text="translations[alternativeLanguage]"></span>
                        </x-dropdown.link>
                    </x-slot>
                </x-dropdown.field>
            </form>
            <x-partials.nav-link
                    href="{{ route('user.profile.edit', auth()->user()->id) }}"
                    :active="request()->routeIs('user.profile.edit')"
            >
                {{ __('app.profile') }}
            </x-partials.nav-link>

            @auth()
                <form class="block" method="POST" action="/logout">
                    @csrf
                    <button>{{ __('app.logout') }}</button>
                </form>

            @endauth
        </div>
    </div>
</nav>