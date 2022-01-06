<div class="card card-body">
    <div class="mb-2 -mx-3 md:flex">
        <div class="px-3 mb-6 md:w-1/2 md:mb-0">
            <label class="block mb-2 text-xs font-bold tracking-wide uppercase text-grey-darker" for="grid-state">
                Tanggal Mulai
                </label>
            <input wire:model.defer="tanggal_mulai" type="date" class="w-full px-2 py-2 border rounded shadow appearance-non">
        </div>
        <div class="px-3 mb-6 md:w-1/2 md:mb-0">
            <label class="block mb-2 text-xs font-bold tracking-wide uppercase text-grey-darker" for="grid-state">
                Tanggal Akhir
                </label>
            <input wire:model.defer="tanggal_akhir" type="date" class="w-full px-2 py-2 border rounded shadow appearance-non">
        </div>
        <div class="px-3 md:w-1/2 mt-2">
            <button wire:click.prevent="printout()" type="button" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-white bg-green-600 border border-gray-300 rounded-md shadow-sm hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Print
            </button>
        </div>
    </div>
</div>