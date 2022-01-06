<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Data Print Out') }}</h1>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Print Out</a></div>
            <div class="breadcrumb-item"><a href="{{ route('tabelprint') }}">Tabel Print Out</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:table.tableprintout name="printout" :model="$printout" /> 
        {{-- Name user merupakan Case switch di tablepegawai.php --}}
        {{-- Model user merupakan tempat pengisian nama model di tablepegawai.php --}}
    </div>
</x-app-layout>
