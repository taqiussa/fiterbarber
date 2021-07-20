<div class="card card-body shadow-dark">
    <div class="w-full py-2 mx-auto mb-2 md:flex max-w-7xl sm:px-6 lg:px-8">
        <div class="px-3 mb-6 md:w-1/2 md:mb-0">
            <label class="block mb-2 text-xs font-bold tracking-wide uppercase text-grey-darker" for="grid-state" >
                Tanggal
                </label>
                <div class="flex flex-col w-1/2 mx-1 mb-2 text-center border-b border-teal-500">
                    <input wire:model.debounce.200ms='tanggalmulai' type="date" class="w-full px-1 py-1 mr-3 leading-tight text-gray-700 bg-transparent border-none appearance-none focus:outline">
                </div>
        </div>
        <div class="px-3 mb-6 md:w-1/2 md:mb-0">
            <label class="block mb-2 text-xs font-bold tracking-wide uppercase text-grey-darker" for="grid-state">
                Sampai dengan
                </label>
                <div class="flex flex-col w-1/2 mx-1 mb-2 text-center border-b border-teal-500">
                    <input wire:model.debounce.200ms='tanggalakhir' type="date" class="w-full px-1 py-1 mr-3 leading-tight text-gray-700 bg-transparent border-none appearance-none focus:outline">
                </div>
        </div>
        <div class="px-3 md:w-1/2">
            <label class="block mb-2 text-xs font-bold tracking-wide uppercase text-grey-darker" for="grid-state">
                pilih laporan
                </label>
                <select wire:model='pilihlaporan'  class="w-full px-2 py-2 border rounded shadow appearance-non">
                    <option value=""> Pilih Laporan </option>
                    @foreach ($pegawai as $p)
                    <option value="{{ $p->id }}"> {{ $p->nama }} </option>
                    @endforeach
                </select>
        </div>
    </div>
    @if ($isPemasukan)
    @include('livewire.modal.tabel-pemasukan')
    @endif 
</div>