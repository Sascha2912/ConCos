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

        <x-partials.nav-link
                href="/users"
                :active="request()->is('users*')"
        >
            {{ __('app.users') }}
        </x-partials.nav-link>
    </div>

    <div class="user-area">
        <div class="dropdown-wrapper">
            <form class="block" method="POST" action="{{ route('users.update.language', auth()->user()->id) }}"
                  x-data
                  @submit.prevent="$refs.languageForm.submit()" x-ref="languageForm">
                @csrf
                @method('PUT')

                <x-dropdown.field align="left" width="48">
                    <x-slot name="trigger">
                        <x-dropdown.button>
                            @if(auth()->user()->preferred_language === 'en')
                                {{ __('app.en') }}
                            @elseif(auth()->user()->preferred_language === 'de')
                                {{ __('app.de') }}
                            @endif
                        </x-dropdown.button>
                    </x-slot>

                    <x-slot name="content">
                        @if(auth()->user()->preferred_language !== 'en')
                            <x-dropdown.link href="#" @click.prevent="$refs.languageForm.submit()"
                                             @click="$refs.languageInput.value = 'en'">{{ __('app.en') }}</x-dropdown.link>
                        @endif

                        @if(auth()->user()->preferred_language !== 'de')
                            <x-dropdown.link href="#" @click.prevent="$refs.languageForm.submit()"
                                             @click="$refs.languageInput.value = 'de'">{{ __('app.de') }}</x-dropdown.link>
                        @endif
                    </x-slot>

                </x-dropdown.field>

            </form>
            <x-partials.nav-link
                    href="{{ route('user.profile.edit') }}"
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