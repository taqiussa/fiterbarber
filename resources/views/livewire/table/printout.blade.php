<div>
    <x-data-tableku :data="$data" :model="$printouts">
        <x-slot name="head">
            <tr>
                <th>#</th>
                <th><a wire:click.prevent="sortBy('tanggal_mulai')" role="button" href="#">
                    Tanggal Mulai
                    @include('components.sort-icon', ['field' => 'tanggal_mulai'])</th>
                <th><a wire:click.prevent="sortBy('tanggal_akhir')" role="button" href="#">
                    Tanggal Akhir
                    @include('components.sort-icon', ['field' => 'tanggal_akhir'])</th>
                <th><a wire:click.prevent="sortBy('jumlah')" role="button" href="#">
                    Jumlah
                    @include('components.sort-icon', ['field' => 'jumlah'])</th>
                <th><a wire:click.prevent="sortBy('total')" role="button" href="#">
                    Total
                    @include('components.sort-icon', ['field' => 'total'])</th>
                <th><a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                    Dibuat
                    @include('components.sort-icon', ['field' => 'created_at'])</th>
                <th>Action</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($printouts as $key => $p)
                <tr x-data="window.__controller.dataTableController({{ $p->id }})">
                    <td>{{ $printouts->firstItem() + $key }}</td>
                    <td>{{ $p->tanggal_mulai }}</td>
                    <td>{{ $p->tanggal_akhir }}</td>
                    <td>{{ $p->jumlah }}</td>
                    <td>Rp. {{ number_format($p->total, 0, ".", ".") . ",-" }}</td>
                    <td>{{ $p->created_at }}</td>
                    <td class="whitespace-no-wrap row-action--icon">
                        <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="text-red-500 fa fa-16px fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-data-tableku>
    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
</div>
