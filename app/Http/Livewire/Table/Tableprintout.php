<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use Livewire\WithPagination;


class Tableprintout extends Component
{
    use WithPagination;

    public $model;
    public $name;
    public $perPage = 10;
    public $sortField = "created_at";
    public $sortAsc = false;
    public $search = '';
    public $action;
    public $button;
    protected $listeners = ["deleteItem" => "delete_item"];
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
            case 'printout':
                $printouts = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);
                return [
                    "view" => 'livewire.table.printout', //resource view
                    "printouts" => $printouts, //users dikirm ke pemasukan.blade ke data tabel
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => '',
                            'create_new_text' => '',
                            'export' => '#',
                            'export_text' => ''
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
    public function mount()
    {
        $this->button = create_button($this->action, "printout");
        // this button untuk menampilkan emit atau message toast 

    }
    public function render()
    {

        $data = $this->get_pagination_data();
        return view($data['view'], $data);
    }
}
