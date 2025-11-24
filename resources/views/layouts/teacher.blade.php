<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Teacher Panel</title>

    @fluxAppearance
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800 antialiased">
    <flux:sidebar sticky collapsible class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.header>
            <flux:sidebar.brand
                href="#"
                logo="https://fluxui.dev/img/demo/logo.png"
                logo:dark="https://fluxui.dev/img/demo/dark-mode-logo.png"
                name="{{ config('app.name', 'Online University') }}"
            />
            <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
        </flux:sidebar.header>
        <flux:sidebar.nav>
            <flux:sidebar.item icon="home" href="#" current>Dashboard</flux:sidebar.item>
            <flux:sidebar.item icon="academic-cap" href="#">Tələbələr</flux:sidebar.item>
            <flux:sidebar.item icon="users" href="#">Müəllimlər</flux:sidebar.item>
            <flux:sidebar.item icon="book-open" href="#">Kurslar</flux:sidebar.item>
            <flux:sidebar.item icon="document-text" href="#">Dərslər</flux:sidebar.item>
            <flux:sidebar.group expandable icon="clipboard-document-list" heading="İmtahanlar" class="grid">
                <flux:sidebar.item href="#">İmtahan Cədvəli</flux:sidebar.item>
                <flux:sidebar.item href="#">Nəticələr</flux:sidebar.item>
                <flux:sidebar.item href="#">Suallar</flux:sidebar.item>
            </flux:sidebar.group>
            <flux:sidebar.item icon="rectangle-group" href="#">Qruplar</flux:sidebar.item>
            <flux:sidebar.item icon="calendar" href="#">Təqvim</flux:sidebar.item>
            <flux:sidebar.item icon="inbox" badge="5" href="#">Mesajlar</flux:sidebar.item>
        </flux:sidebar.nav>
        <flux:sidebar.spacer />
        <flux:sidebar.nav>
            <flux:sidebar.item icon="cog-6-tooth" href="#">Tənzimləmələr</flux:sidebar.item>
            <flux:sidebar.item icon="information-circle" href="#">Yardım</flux:sidebar.item>
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