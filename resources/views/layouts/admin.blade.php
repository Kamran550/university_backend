<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

    @fluxAppearance
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800 antialiased">
    <flux:sidebar sticky collapsible class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700 w-64">
        <flux:sidebar.header class="py-4">
            <flux:sidebar.brand
                href="#"
                logo="https://fluxui.dev/img/demo/logo.png"
                logo:dark="https://fluxui.dev/img/demo/dark-mode-logo.png"
                name="{{ config('app.name', 'Online University') }}"
            />
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>
        <flux:sidebar.nav class="space-y-1">
            <flux:sidebar.item icon="home" href="#" current class="py-3">Dashboard</flux:sidebar.item>
            <flux:sidebar.item icon="academic-cap" href="#" class="py-3">Tələbələr</flux:sidebar.item>
            <flux:sidebar.item icon="users" href="#" class="py-3">Müəllimlər</flux:sidebar.item>
            <flux:sidebar.item icon="book-open" href="#" class="py-3">Kurslar</flux:sidebar.item>
            <flux:sidebar.item icon="rectangle-group" href="#" class="py-3">Qruplar</flux:sidebar.item>
            <flux:sidebar.item icon="calendar" href="#" class="py-3">Təqvim</flux:sidebar.item>
            <flux:sidebar.item icon="inbox" badge="5" href="#" class="py-3">Mesajlar</flux:sidebar.item>
        </flux:sidebar.nav>
        <flux:sidebar.spacer />
        <flux:sidebar.nav class="space-y-1">
            <flux:sidebar.item icon="cog-6-tooth" href="#" class="py-3">Tənzimləmələr</flux:sidebar.item>
            <flux:sidebar.item icon="information-circle" href="#" class="py-3">Yardım</flux:sidebar.item>
        </flux:sidebar.nav>
        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:sidebar.profile avatar="https://fluxui.dev/img/demo/user.png" name="{{ auth()->user()->name ?? 'Admin' }}" />
            <flux:menu>
                <flux:menu.item icon="user-circle" href="#">Profil</flux:menu.item>
                <flux:menu.separator />
                <flux:menu.item icon="arrow-right-start-on-rectangle" href="#">Çıxış</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />
        <flux:dropdown position="top" align="start">
            <flux:profile avatar="https://fluxui.dev/img/demo/user.png" name="{{ auth()->user()->name ?? 'Admin' }}" />
            <flux:menu>
                <flux:menu.item icon="user-circle" href="#">Profil</flux:menu.item>
                <flux:menu.separator />
                <flux:menu.item icon="arrow-right-start-on-rectangle" href="#">Çıxış</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:header>
    <flux:main>
        {{ $slot }}
    </flux:main>

    @fluxScripts
    @livewireScripts
</body>


</html>