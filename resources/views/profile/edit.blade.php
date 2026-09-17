<x-app-layout>
    <x-slot name="header">
        <h2>Profil Saya</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto space-y-5">
        <div class="card">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="card">
            @include('profile.partials.update-password-form')
        </div>

        <div class="card border-danger-500/30">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>