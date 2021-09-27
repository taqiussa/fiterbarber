<?php

namespace App\Http\Livewire;

use App\Models\Bon;
use App\Models\Keterangan;
use App\Models\Libur;
use App\Models\Pegawai;
use App\Models\Pemasukan;
use Livewire\Component;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;


class Laporanpemasukan extends Component
{
    public $bulan;
    public $tahun;
    public $pegawai_id;
    public $keterangan_id;
    public $nama;
    public $keterangan;
    public $jumlah;
    public $jumlah2;
    public $total;
    public $bln;
    public $bon;
    public $libur;
    public $potongan;
    public $gaji;
    public $totalgaji;
    public $totalbonus;
    public $vocer;

    public function render()
    {

        $data = [
            'ket' => Keterangan::where('jenis', 'pemasukan')->get(),
            'pegawai' => Pegawai::get(),
            'now' => date('Y'),
        ];
        if (!empty($this->keterangan_id)) {

            $cari = Keterangan::find($this->keterangan_id);
            $jml = Pemasukan::whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->where('pegawai_id', $this->pegawai_id)->where('keterangan_id', $this->keterangan_id)->sum('jumlah');
            $vcr = Pemasukan::whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->where('pegawai_id', $this->pegawai_id)->where('keterangan_id', $this->keterangan_id)->sum('vocer');
            $tot = Pemasukan::whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->where('pegawai_id', $this->pegawai_id)->where('keterangan_id', $this->keterangan_id)->sum('total');
            $bn = Bon::whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->where('pegawai_id', $this->pegawai_id)->sum('jumlah');
            $lbr = Libur::whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->where('pegawai_id', $this->pegawai_id)->sum('jumlah');
            $peg = Pegawai::find($this->pegawai_id);
            $this->nama = $peg->nama;
            $this->bln = date('M', strtotime($this->tahun . '-' . $this->bulan . '-01'));
            $this->keterangan = $cari->namaket;
            $this->jumlah = intval($jml) + intval($vcr);
            $this->total = $tot;
            $this->libur = $lbr;
            $this->bon = $bn;
            $this->vocer = $vcr;
            $this->jumlah2 = $jml;
            if ($this->jumlah > 349) {
                $bonus = $this->jumlah - 350;
                $this->totalbonus = 50000 + ($bonus * 2000);
            } else {
                $this->totalbonus = 0;
            }
            if ($this->libur > 5) {
                $perlibur = 50000;
                $jumlahlibur = intval($this->libur) - 5;
                $this->potongan = $jumlahlibur * $perlibur;
                $this->totalgaji = $this->gaji + $this->totalbonus - $this->potongan - $this->bon;
            } else {
                $this->potongan = 0;
                $this->totalgaji = $this->gaji + $this->totalbonus - $this->potongan - $this->bon;
            }
        }
        return view('livewire.laporan.laporanpemasukan', $data);
    }

    public function print()
    {
        //request data
        $bulan = date('M', strtotime($this->tahun . '-' . $this->bulan . '-10'));
        // $totalpotong = Transaksi::whereMonth('tanggal', $request->month)->whereYear('tanggal', $request->tahun)->where('nama', $nama)->where('keterangan', $request->ket)->get()->sum('jumlah');

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
        // $printer->text($nama . "\n");
        $printer->feed();

        /* Title of receipt */
        $printer->setEmphasis(true);
        $printer->text("FITER BARBER INVOICE\n");
        $printer->setEmphasis(false);

        /* Information for the receipt */
        $items = array(
            new item("Nama", $this->nama),
            new item("Bulan", $bulan . " " . $this->tahun),
            new item("Libur", $this->libur . ' X'),
            new item("Total Potong", $this->jumlah2 . ' Kepala'),
            new item("Total Vocer", $this->vocer . ' Kepala'),
            new item("Gaji", 'Rp. ' . number_format($this->gaji, 0, ".", ".") . ",-"),
            new item("Bonus", 'Rp. ' . number_format($this->totalbonus, 0, ".", ".") . ",-"),
            new item("Bon", 'Rp. ' . number_format($this->bon, 0, ".", ".") . ",-"),
            new item("Pot. Libur", 'Rp. ' . number_format($this->potongan, 0, ".", ".") . ",-"),
            new item("Total Gaji", 'Rp. ' . number_format($this->totalgaji, 0, ".", ".") . ",-"),
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
    }
    public function printlabel()
    {

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
        $printer->feed();
        /* Title of receipt */
        $printer->setEmphasis(true);
        // $printer->text("FITER BARBER INVOICE\n");
        $printer->setTextSize(2,2);
        $printer->text("Barber Puguh\n");
        $printer->setEmphasis(false);
        $printer->setTextSize(1,1);
        $date = gmdate('M Y');
        $printer->feed();
        // $printer->text($date . "\n");

        /* Cut the receipt and open the cash drawer */
        $printer->cut();
        $printer->pulse();

        $printer->close();

        /* Copy it over to the printer */
        copy($file, "//localhost/Gudang");
        // copy($file, "//localhost/EPSONTU");
        unlink($file);
        // return redirect('/laporan');
    }
    public function print2()
    {

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
        $printer->feed();
        /* Title of receipt */
        $printer->setEmphasis(true);
        $printer->text("FITER BARBER INVOICE\n");
        $printer->setTextSize(2,2);
        $printer->text($this->nama . "\n");
        $printer->setEmphasis(false);
        $printer->setTextSize(1,1);
        $date = gmdate('M Y');
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
    }

}
