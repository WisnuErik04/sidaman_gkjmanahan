<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
        @php
            if (auth()->user()->role == 'admin') {
                $routeDashboard = 'admin.dashboard';
            } elseif (auth()->user()->role == 'majelis') {
                $routeDashboard = 'admin.dashboard';
            } else {
                $routeDashboard = 'warga.dashboard';
            }
        @endphp
        <a href="{{ route($routeDashboard) }}"
            class="mr-5 flex items-center space-x-2" >
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="route($routeDashboard)" :current="request()->routeIs($routeDashboard)" >{{ __('Dashboard') }}</flux:navlist.item>
            </flux:navlist.group>
            @if (auth()->user()->role == 'admin' || auth()->user()->role == 'majelis')
                <flux:spacer />
                {{-- <flux:navlist.item icon="academic-cap" :href="route('student.index')"
                    :current="request()->routeIs('student.index')" >{{ __('Student Management') }}
                </flux:navlist.item>
                <flux:navlist.item icon="bars-3-bottom-left" :href="route('grade.index')"
                    :current="request()->routeIs('grade.index')" >{{ __('Grade Management') }}
                </flux:navlist.item> --}}

                <flux:navlist.group expandable :heading="__('Warga')" class="grid">
                    <flux:navlist.item :href="route('keluarga.index')"
                        :current="request()->routeIs('keluarga.*')" >{{ __('Keluarga') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('anggota.index')"
                        :current="request()->routeIs('anggota.*')" >{{ __('Anggota') }}
                    </flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group expandable :heading="__('Laporan')" class="grid">
                    <flux:navlist.item :href="route('export_keluarga.index')"
                        :current="request()->routeIs('export_keluarga.*')" >{{ __('Keluarga') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('export_anggota.index')"
                        :current="request()->routeIs('export_anggota.*')" >{{ __('Anggota') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            @endif

            @if (auth()->user()->role == 'admin')
                <flux:spacer />
                <flux:navlist.group expandable :heading="__('Master Data')" class="grid">
                    <flux:navlist.item :href="route('blok.index')"
                        :current="request()->routeIs('blok.*')" >{{ __('Blok') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('gol_darah.index')"
                        :current="request()->routeIs('gol_darah.*')" >{{ __('Golongan Darah') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('hobi.index')"
                        :current="request()->routeIs('hobi.*')" >{{ __('Hobi') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('hubungan_keluarga.index')"
                        :current="request()->routeIs('hubungan_keluarga.*')" >{{ __('Hubungan Keluarga') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('ijazah.index')"
                        :current="request()->routeIs('ijazah.*')" >{{ __('Ijazah') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('jarak_rumah.index')"
                        :current="request()->routeIs('jarak_rumah.*')" >{{ __('Jarak Rumah') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('pekerjaan.index')"
                        :current="request()->routeIs('pekerjaan.*')" >{{ __('Pekerjaan') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('pendapatan.index')"
                        :current="request()->routeIs('pendapatan.*')" >{{ __('Pendapatan') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('penyakit.index')"
                        :current="request()->routeIs('penyakit.*')" >{{ __('Penyakit') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('perkawinan.index')"
                        :current="request()->routeIs('perkawinan.*')" >{{ __('Perkawinan') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('tempat_babtis.index')"
                        :current="request()->routeIs('tempat_babtis.*')" >{{ __('Tempat babtis') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('tempat_sidi.index')"
                        :current="request()->routeIs('tempat_sidi.*')" >{{ __('Tempat sidi') }}
                    </flux:navlist.item>
                    
              
                </flux:navlist.group>

                <flux:navlist.item icon="shield-check" :href="route('user.index')"
                    :current="request()->routeIs('user.*')" >{{ __('Akun Pengguna') }}
                </flux:navlist.item>
            @endif
                
            @if (auth()->user()->role == 'warga')
                <flux:spacer />
                <flux:navlist.group expandable :heading="__('Menu Utama')" class="grid">
                    <flux:navlist.item :href="route('warga_keluarga.view')"
                        :current="request()->routeIs('warga_keluarga.*')" >{{ __('Keluarga') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('warga_anggota.index')"
                        :current="request()->routeIs('warga_anggota.*')" >{{ __('Data Pribadi') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            @endif

            {{-- <flux:navlist.item icon="calendar-days" :href="route('attendance.page')"
                :current="request()->routeIs('attendance.page')" >{{ __('Attendance Management') }}
            </flux:navlist.item> --}}
        </flux:navlist>

        <flux:spacer />

        {{-- <flux:navlist variant="outline">
            <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit"
                target="_blank">
                {{ __('Repository') }}
            </flux:navlist.item>

            <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits" target="_blank">
                {{ __('Documentation') }}
            </flux:navlist.item>
        </flux:navlist> --}}

        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" >{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" >{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
    <x-toaster-hub />
    @livewireScripts
    @stack('scripts')
    @livewire('wire-elements-modal')
    {{-- <script src="../../node_modules/lodash/lodash.min.js"></script>
    <script src="../../node_modules/vanilla-calendar-pro/index.js"></script> --}}
</body>

</html>