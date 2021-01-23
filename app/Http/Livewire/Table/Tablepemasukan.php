<?php

namespace App\Http\Livewire\Table;

use App\Models\Keterangan;
use App\Models\Pegawai;
use App\Models\Pemasukan;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;

use function PHPUnit\Framework\isEmpty;

class Tablepemasukan extends Component
{
    use WithPagination;

    public $model;
    public $name;
    public $pemasukan;
    public $idpemasukan = '';
    public $tanggal = '';
    public $pegawai_id = '';
    public $keterangan_id = '';
    public $jumlah = '';
    public $harga = '';
    public $total = '';
    public $komentar = '';
    public $isOpen = 0;
    public $perPage = 10;
    public $sortField = "pemasukan.tanggal";
    public $sortAsc = false;
    public $search = '';
    public $action;
    public $button;
    protected $listeners = ["deleteItem" => "delete_item"];
    protected $rules = [
        'tanggal' => 'required',
        'pegawai_id' => 'required',
        'keterangan_id' => 'required',
        'jumlah' => 'required|numeric',
        'harga' => 'required',
        'total' => 'required',
    ];
    protected $messages = [
        'tanggal.required' => 'tanggal tidak boleh kosong',
        'pegawai_id.required' => 'Pegawai tidak boleh kosong',
        'keterangan_id.required' => 'Keterangan tidak boleh kosong',
        'jumlah.required' => 'Jumlah tidak boleh kosong',
        'jumlah.numeric' => 'Jumlah harus berupa angak',
        'harga.required' => 'Harga tidak boleh kosong',
        'total.required' => 'Total tidak boleh kosong',
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
            case 'pemasukan':
                $pemasukans = $this->model::search($this->search)
                    ->join('pegawai', 'pegawai.id', '=', 'pemasukan.pegawai_id')
                    ->join('keterangan', 'keterangan.id', '=', 'pemasukan.keterangan_id')
                    ->select(
                        'pegawai.nama as namapegawai',
                        'keterangan.namaket as keterangan',
                        'pemasukan.jumlah as jumlahpemasukan',
                        'pemasukan.total as totalpemasukan',
                        'pemasukan.id as id',
                        'pemasukan.komentar as komentarpemasukan',
                        'pemasukan.tanggal as tanggalpemasukan'
                    )->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                $pegawai = Pegawai::get();
                $ket = Keterangan::where('jenis', 'pemasukan')->get();
                if (!empty($this->keterangan_id)) {
                    $cariharga = Keterangan::find($this->keterangan_id);
                    $this->harga = $cariharga->harga;
                }
                $this->total = intval($this->harga) * intval($this->jumlah);
                return [
                    "view" => 'livewire.table.pemasukan', //resource view
                    "pemasukans" => $pemasukans, //users dikirm ke pemasukan.blade ke data tabel
                    "pegawai" => $pegawai, //pegawai dikirm ke modal-pemasukan.blade untuk select pegawai
                    "ket" => $ket, //ket dikirm ke modal-pemasukan.blade untuk select keterangan
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => 'showModal()',
                            'create_new_text' => 'Tambah pemasukan',
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
        $this->keterangan_id = '';
        $this->jumlah = '';
        $this->harga = '';
        $this->total = '';
        $this->komentar = '';
        $this->idpemasukan = '';
    }
    public function store()
    {

        $data = [
            'tanggal' => $this->tanggal,
            'pegawai_id' => $this->pegawai_id,
            'keterangan_id' => $this->keterangan_id,
            'jumlah' => $this->jumlah,
            'harga' => $this->harga,
            'total' => $this->total,
            'komentar' => $this->komentar,
        ];
        $this->validate();
        $this->model::updateOrCreate(['id' => $this->idpemasukan], $data);
        $this->clearVar();
        $this->emit('saved'); /* Untuk Menampilkan Message Toast ke x-jet-nofity-message di modal */
        $this->hideModal();
    }
    public function edit($id)
    {
        $cari = $this->model::findOrFail($id);
        $this->idpemasukan = $id;
        $this->tanggal = date('Y-m-d', strtotime($cari->tanggal));
        $this->pegawai_id = $cari->pegawai_id;
        $this->keterangan_id = $cari->keterangan_id;
        $this->jumlah = $cari->jumlah;
        $this->harga = $cari->harga;
        $this->total = $cari->total;
        $this->komentar = $cari->komentar;
        $this->showModal();
    }
    public function mount()
    {
        $this->button = create_button($this->action, "pemasukan");
        // this button untuk menampilkan emit atau message toast 

    }
    public function render()
    {

        $data = $this->get_pagination_data();
        return view($data['view'], $data);
    }
}
