<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use Livewire\WithPagination;

class Tablepengeluaran extends Component
{
    use WithPagination;

    public $model;
    public $name;
    public $pengeluaran;
    public $idpengeluaran = '';
    public $tanggal = '';
    public $keterangan = '';
    public $total = '';
    public $isOpen = 0;
    public $perPage = 10;
    public $sortField = "tanggal";
    public $sortAsc = false;
    public $search = '';
    public $action;
    public $button;
    protected $listeners = ["deleteItem" => "delete_item"];
    protected $rules = ['keterangan' => 'required', 'total' => 'required|numeric', 'tanggal' => 'required'];
    protected $messages = [
        'tanggal.required' => 'Tanggal tidak boleh kosong',
        'keterangan.required' => 'Keterangan tidak boleh kosong',
        'total.required' => 'total tidak boleh kosong',
        'total.numeric' => 'total harus berupa angka'
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
            case 'pengeluaran':
                $pengeluarans = $this->model::search($this->search)->select('*', 'tanggal as tgl')
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);
                return [
                    "view" => 'livewire.table.pengeluaran', //resource view
                    "pengeluarans" => $pengeluarans, //users dikirm ke user.blade ke data tabel
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => 'showModal()',
                            'create_new_text' => 'Pengeluaran',
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
        $this->keterangan = '';
        $this->total = '';
        $this->idpengeluaran = '';
    }
    public function store()
    {
        $data = [
            'tanggal' => $this->tanggal,
            'keterangan' => $this->keterangan,
            'total' => $this->total,
        ];
        $this->validate();
        $this->model::updateOrCreate(['id' => $this->idpengeluaran], $data);
        $this->clearVar();
        $this->emit('saved'); /* Untuk Menampilkan Message Toast ke x-jet-nofity-message di modal */
        $this->hideModal();
    }
    public function edit($id)
    {
        $cari = $this->model::findOrFail($id);
        $this->idpengeluaran = $id;
        $this->tanggal = date('Y-m-d', strtotime($cari->tanggal));
        $this->keterangan = $cari->keterangan;
        $this->total = $cari->total;
        $this->showModal();
    }
    public function mount()
    {
        $this->tanggal = gmdate('Y-m-d');
        $this->button = create_button($this->action, "pengeluaran");
        // this button untuk menampilkan emit atau message toast 
    }
    public function render()
    {
        $data = $this->get_pagination_data();
        return view($data['view'], $data);
    }
}
