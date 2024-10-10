<div class="nav-wrapper">

    <nav class="nav-link-wrapper">
        <x-partials.nav-link
                href="/customers"
                :active="request()->is('customers')"
        >
            {{ __('app.customers') }}
        </x-partials.nav-link>

        <x-partials.nav-link
                href="/contracts"
                :active="request()->is('contracts')"
        >
            {{ __('app.maintenance_contracts') }}
        </x-partials.nav-link>

        <x-partials.nav-link
                href="/services"
                :active="request()->is('services')"
        >
            {{ __('app.services') }}
        </x-partials.nav-link>

        <x-partials.nav-link
                href="/users"
                :active="request()->is('users')"
        >
            {{ __('app.users') }}
        </x-partials.nav-link>
    </nav>

    <div class="profile">
        <div>{{ __('app.profile') }}</div>
        <div>{{ __('app.language') }}</div>
        <div>{{ __('app.login') }}</div>
        <div>{{ __('app.logout') }}</div>
    </div>
</div>