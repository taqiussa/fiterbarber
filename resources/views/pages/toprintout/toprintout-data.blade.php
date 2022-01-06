<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('To Print Out') }}</h1>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">To Print Out</a></div>
            <div class="breadcrumb-item"><a href="#">Print Out</a></div>
            <div class="breadcrumb-item"><a href="{{ route('toprintout') }}">To Print Out</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:toprintout />
    </div>
</x-app-layout>
