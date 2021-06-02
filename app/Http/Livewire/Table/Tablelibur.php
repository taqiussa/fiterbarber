<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pegawai;

class Tablelibur extends Component
{
    use WithPagination;

    public $model;
    public $name;
    public $libur;
    public $idlibur = '';
    public $tanggal = '';
    public $pegawai_id = '';
    public $jumlah = 1;
    public $keterangan = '';
    public $isOpen = 0;
    public $perPage = 10;
    public $sortField = "libur.tanggal";
    public $sortAsc = false;
    public $search = '';
    public $action;
    public $button;
    protected $listeners = ["deleteItem" => "delete_item"];
    protected $rules = [
        'tanggal' => 'required',
        'pegawai_id' => 'required',
        'jumlah' => 'required|numeric',
    ];
    protected $messages = [
        'tanggal.required' => 'tanggal tidak boleh kosong',
        'pegawai_id.required' => 'Pegawai tidak boleh kosong',
        'jumlah.required' => 'Jumlah tidak boleh kosong',
        'jumlah.numeric' => 'Jumlah harus berupa angka',
    ];
    public function showModal()
    {
        $this->isOpen = true;
    }
    public function hideModal()
    {
        $this->resetErrorBag();
        $this->clearVar();
        $this->isOpen = false;
    }
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function get_pagination_data()
    {
        switch ($this->name) {
            case 'libur':
                $liburs = $this->model::search($this->search)
                    ->join('pegawai', 'pegawai.id', '=', 'libur.pegawai_id')
                    ->select(
                        'pegawai.nama as nama',
                        'libur.jumlah as jumlah',
                        'libur.id as id',
                        'libur.keterangan as keterangan',
                        'libur.tanggal as tanggallibur'
                    )->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                $pegawai = Pegawai::get();
                return [
                    "view" => 'livewire.table.libur', //resource view
                    "liburs" => $liburs, //users dikirm ke libur.blade ke data tabel
                    "pegawai" => $pegawai, //pegawai dikirm ke modal-libur.blade untuk select pegawai
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => 'showModal()',
                            'create_new_text' => 'libur',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;

            default:
                # code...
                break;
        }
    }

    public function delete_item($id)
    {
        $data = $this->model::find($id);

        if (!$data) {
            $this->emit("deleteResult", [
                "status" => false,
                "message" => "Gagal menghapus data " . $this->name
            ]);
            return;
        }
        $data->delete();
        $this->emit("deleteResult", [
            "status" => true,
            "message" => "Data " . $this->name . " berhasil dihapus!"
        ]);
    }
    public function clearVar()
    {
        $this->tanggal = gmdate('Y-m-d');
        $this->pegawai_id = '';
        $this->jumlah = 1;
        $this->keterangan = '';
        $this->idlibur = '';
    }
    public function store()
    {

        $data = [
            'tanggal' => $this->tanggal,
            'pegawai_id' => $this->pegawai_id,
            'jumlah' => $this->jumlah,
            'keterangan' => $this->keterangan,
        ];
        $this->validate();
        $this->model::updateOrCreate(['id' => $this->idlibur], $data);
        $this->clearVar();
        $this->emit('saved'); /* Untuk Menampilkan Message Toast ke x-jet-nofity-message di modal */
        $this->hideModal();
    }
    public function edit($id)
    {
        $cari = $this->model::findOrFail($id);
        $this->idlibur = $id;
        $this->tanggal = date('Y-m-d', strtotime($cari->tanggal));
        $this->pegawai_id = $cari->pegawai_id;
        $this->jumlah = $cari->jumlah;
        $this->keterangan = $cari->keterangan;
        $this->showModal();
    }
    public function mount()
    {
        $this->tanggal = gmdate('Y-m-d');
        $this->button = create_button($this->action, "libur");
        // this button untuk menampilkan emit atau message toast 

    }
    public function render()
    {

        $data = $this->get_pagination_data();
        return view($data['view'], $data);
    }
}
