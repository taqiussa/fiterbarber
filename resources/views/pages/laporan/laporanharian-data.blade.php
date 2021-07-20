<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Laporan Pemasukan') }}</h1>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Laporan</a></div>
            <div class="breadcrumb-item"><a href="#">Pemasukan</a></div>
            <div class="breadcrumb-item"><a href="{{ route('laporanharian') }}">Laporan Pemasukan</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:laporanharian />
    </div>
</x-app-layout>
