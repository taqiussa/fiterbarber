<?php

namespace App\Http\Livewire;

use App\Models\Pemasukan;
use App\Models\Printout;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
class Toprintout extends Component
{
    public $tanggal_mulai;
    public $tanggal_akhir;

    public function render()
    {
        return view('livewire.toprintout.toprintout');
    }
    public function mount()
    {
        $this->tanggal_mulai = gmdate('Y-m-d');
        $this->tanggal_akhir = gmdate('Y-m-d');

    }
    public function printout(){
        $jml = Pemasukan::where('pegawai_id',1)->whereBetween('tanggal',[$this->tanggal_mulai, $this->tanggal_akhir])->sum('jumlah');
        $vcr = Pemasukan::where('pegawai_id',1)->whereBetween('tanggal',[$this->tanggal_mulai, $this->tanggal_akhir])->sum('vocer');
        $jumlah = $jml + $vcr ;
        $total = 6000 * $jumlah;
        /* Open file */
        $tmpdir = sys_get_temp_dir();
        $file =  tempnam($tmpdir, 'cetak');

        /* Do some printing */
        $connector = new FilePrintConnector($file);
        $printer = new Printer($connector);

        /* Print Logo */

        $img = EscposImage::load('images/logoputih.png');
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->bitImageColumnFormat($img);
        // $printer->feed();
        /* Name of shop */
        $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Fiter Barber\n");
        $printer->selectPrintMode();
        $printer->text("Ngampel Kulon - Ngampel\n");
        $printer->text("Karangayu - Cepiring\n");
        $printer->text("Puguh - Pegandon\n");
        // $printer->text($nama . "\n");
        $printer->feed();

        /* Title of receipt */
        $printer->setEmphasis(true);
        $printer->text("FITER BARBER INVOICE\n");
        $printer->setEmphasis(false);

        /* Information for the receipt */
        $items = array(
            new item("Nama", 'Fendi'),
            new item("Dari",  Carbon::parse($this->tanggal_mulai)->translatedFormat('l, d M y')),
            new item("Sampai", Carbon::parse($this->tanggal_akhir)->translatedFormat('l, d M y')),
            new item("Total Potong", $jml . ' Kepala'),
            new item("Total Vocer", $vcr . ' Kepala'),
            new item("======", "======"),
            new item("Jumlah Total", $jumlah . ' Kepala'),
            new item("Tarif", 'Rp. 6.000,-'),
            new item("Gaji", 'Rp. ' . number_format($total, 0, ".", ".") . ",-"),
        );
        $date = gmdate('d M Y');

        /* Items */
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setEmphasis(true);
        $printer->text(new item('', '')); //Rp
        $printer->setEmphasis(false);
        foreach ($items as $item) {
            $printer->text($item);
        }
        $printer->feed();

        /* Footer */
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Fiter Barber\n");
        // $printer->text("Tampan dan Berani\n");
        $printer->feed();
        $printer->text($date . "\n");

        /* Cut the receipt and open the cash drawer */
        $printer->cut();
        $printer->pulse();

        $printer->close();

        /* Copy it over to the printer */
        copy($file, "//localhost/Gudang");
        // copy($file, "//localhost/EPSONTU");
        unlink($file);
        // return redirect('/laporan');

        $data = [
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_akhir' => $this->tanggal_akhir,
            'jumlah' => $jumlah,
            'total' => $total,
        ];
        Printout::create($data);
    }
}
