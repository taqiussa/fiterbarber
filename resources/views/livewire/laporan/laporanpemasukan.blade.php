<div class="card card-body">
    <div class="mb-2 -mx-3 md:flex">
        <div class="px-3 mb-6 md:w-1/2 md:mb-0">
            <label class="block mb-2 text-xs font-bold tracking-wide uppercase text-grey-darker" for="grid-state">
                Bulan
                </label>
                <select wire:model="bulan" class="w-full px-2 py-2 border rounded shadow appearance-non">
                    <option value="">Pilih Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
        </div>
        <div class="px-3 md:w-1/2">
            <label class="block mb-2 text-xs font-bold tracking-wide uppercase text-grey-darker" for="grid-state">
                Tahun
                </label>
                <select wire:model="tahun" class="w-full px-2 py-2 border rounded shadow appearance-non">
                    <option value="">Tahun</option>
                    @for ($i = 2020; $i <= $now; $i++)
                    <option value="{{ $i }}">{{ $i}}</option>
                    @endfor
                </select>
        </div>
        <div class="px-3 md:w-1/2">
            <label class="block mb-2 text-xs font-bold tracking-wide uppercase text-grey-darker" for="grid-state">
            Nama Pegawai
            </label>
            <select wire:model="pegawai_id" class="w-full px-2 py-2 border rounded shadow appearance-non">
                <option value="">Pilih Pegawai</option>
                @foreach ($pegawai as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="px-3 md:w-1/2">
            <label class="block mb-2 text-xs font-bold tracking-wide uppercase text-grey-darker" for="grid-state">
            Keterangan
            </label>
            <select wire:model="keterangan_id" class="w-full px-2 py-2 border rounded shadow appearance-non">
                <option value="">Pilih Keterangan</option>
                @foreach ($ket as $p)
                    <option value="{{ $p->id }}">{{ $p->namaket }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="mb-2 -mx-3 md:flex">
        <div class="px-3 mb-6 md:w-1/2 md:mb-0">
            <label class="block mb-2 text-xs font-bold tracking-wide uppercase text-grey-darker" for="grid-state">
                GAJI
            </label>
            <input wire:model="gaji" type="text" class="w-1/3 px-2 py-2 border rounded shadow appearance-non" id="gaji" autocomplete="off" placeholder="Gaji"> 
        </div>
    </div>

    <!-- component -->
    <div class="flex items-center">
        <div class="w-full py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex flex-col w-full mb-2 space-y-2 lg:flex-row lg:space-x-2 lg:space-y-0 lg:mb-4">
                <div class="w-full lg:w-1/4">
                    <div class="w-full p-4 bg-white border border-gray-100 rounded-lg shadow-info widget dark:bg-gray-900 dark:border-gray-800">
                        <div class="flex flex-row items-center justify-between">
                            <div class="flex flex-col">
                                <div class="text-xs font-light text-gray-500 uppercase">
                                    Rekap {{ $bln .' '. $tahun   }}
                                 </div>
                                 <div class="text-xl font-bold">
                                     {{ $nama }}
                                 </div>
                            </div>
                            <svg class="text-gray-500 stroke-current" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12">
                                </polyline>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-1/4">
                    <div class="w-full p-4 bg-white border border-gray-100 rounded-lg shadow-info widget dark:bg-gray-900 dark:border-gray-800">
                        <div class="flex flex-row items-center justify-between">
                            <div class="flex flex-col">
                                <div class="text-xs font-light text-gray-500 uppercase">
                                   Jumlah {{ $keterangan   }}
                                </div>
                                <div class="text-xl font-bold">
                                    {{ $jumlah }} + {{ $vocer }}
                                </div>
                            </div>
                            <svg class="text-gray-500 stroke-current" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2">
                                </path>
                                <circle cx="9" cy="7" r="4">
                                </circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87">
                                </path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-1/4">
                    <div class="w-full p-4 bg-white border border-gray-100 rounded-lg shadow-info widget dark:bg-gray-900 dark:border-gray-800">
                        <div class="flex flex-row items-center justify-between">
                            <div class="flex flex-col">
                                <div class="text-xs font-light text-gray-500 uppercase">
                                    Total Pemasukan
                                </div>
                                <div class="text-xl font-bold">
                                    Rp. {{ number_format($total, 0, ".", ".") . ",-" }}
                                </div>
                            </div>
                            <svg class="text-gray-500 stroke-current" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                <<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-1/4">
                    <div class="w-full p-4 bg-white border border-gray-100 rounded-lg shadow-success widget dark:bg-gray-900 dark:border-gray-800">
                        <div class="flex flex-row items-center justify-between">
                            <div class="flex flex-col">
                                <div class="text-xs font-light text-gray-500 uppercase">
                                    Libur {{ $libur.'X , Bon :' }}
                                </div>
                                <div class="text-xl font-bold">
                                    Rp. {{ number_format($bon, 0, ".", ".") . ",-" }}
                                </div>
                            </div>
                            <svg class="text-gray-500 stroke-current" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-2 -mx-3 md:flex">
        <div class="px-3 mb-6 text-right md:w-1/2 md:mb-0 col">
            <a role="button" wire:click="print()" class="shadow-none -ml- btn btn-info"><i class="fa fa-16px fa-file-import"> Print Gaji</i></a>
        </div>
    </div>
    <div class="mb-2 -mx-3 md:flex">
        <div class="px-3 mb-6 text-right md:w-1/2 md:mb-0 col">
            <a role="button" wire:click="print2()" class="shadow-none -ml- btn btn-info"><i class="fa fa-16px fa-file-import"> Print Label</i></a>
        </div>
    </div>
</div>
