<?php

namespace App\Http\Controllers;

use App\Models\Bon;
use App\Models\Keterangan;
use App\Models\Libur;
use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Http\Controllers\Items;
use App\Models\Pegawai;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;


class PemasukanController extends Controller
{
    public function index()
    {
        return view('pages.transaksi.pemasukan-data', [
            'pemasukan' => Pemasukan::class
        ]);
    }
    public function indexapi()
    {
        $pemasukans = Pemasukan::with('pegawai', 'keterangan')->orderBy('tanggal', 'desc')->get();
        $fendi = Pemasukan::where('pegawai_id',1)->orderBy('tanggal', 'desc')->get();
        $bayu = Pemasukan::where('pegawai_id',2)->orderBy('tanggal', 'desc')->get();
        $budi = Pemasukan::where('pegawai_id', 3)->orderBy('tanggal', 'desc')->get();
        return response()->json([
            'status' => 200,
            // 'pemasukans' => $pemasukans,
            'fendi' => $fendi,
            'bayu' => $bayu,
            'budi' => $budi,
        ]);
    }
    public function showapi($id)
    {
        $pemasukan = Pemasukan::find($id);
        return response()->json([
            'pemasukan' => $pemasukan,
            'status' => 200
        ]);
    }
    public function updateapi(Request $request, $id)
    {
        Pemasukan::find($id)->update($request->only([
            'tanggal',
            'pegawai_id',
            'keterangan_id',
            'jumlah',
            'harga',
            'total',
            'komentar',
            'vocer',
            'tanggalsimpan'
        ]));
        return response()->json([
            'messages' => 'Berhasil Update',
            'status' => 200
        ]);
    }
    public function storeapi(Request $request)
    {
        Pemasukan::create($request->only([
            'tanggal',
            'pegawai_id',
            'keterangan_id',
            'jumlah',
            'harga',
            'total',
            'komentar',
            'vocer',
            'tanggalsimpan'
        ]));
        return response()->json([
            'messages' => 'Berhasil Menyimpan Data Pemasukan',
            'status' => 200
        ]);
    }
    public function destroyapi($id)
    {
        $pemasukan = Pemasukan::find($id);
        $pemasukan->delete();
        return response()->json([
            'messages' => 'Berhasil Menghapus Data',
            'status' => 200
        ]);
    }
    public function lappemasukan($pegawai, $bulan, $tahun, $keterangan)
    {
        $libur = Libur::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('pegawai_id', $pegawai)->sum('jumlah');
        $bon = Bon::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('pegawai_id', $pegawai)->sum('jumlah');
        $pemasukan = Pemasukan::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('pegawai_id', $pegawai)->sum('total');
        $jumlah = Pemasukan::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('pegawai_id', $pegawai)->sum('jumlah');
        $vocer = Pemasukan::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('pegawai_id', $pegawai)->sum('vocer');
        $total = intval($jumlah) + intval($vocer);
        $ket = Keterangan::find($keterangan);
        return response()->json([
            'libur' => $libur,
            'bon' => $bon,
            'pemasukan' => $pemasukan,
            'jumlah' => $jumlah,
            'totaljumlah' => $total,
            'vocer' => $vocer,
            'keterangan' => $ket->namaket,
        ]);
    }
    public function pemasukangraph(){
        $tahun = gmdate('Y');
        $fendi = [
            Pemasukan::whereMonth('tanggal',1)->whereYear('tanggal',$tahun)->where('pegawai_id',1)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',2)->whereYear('tanggal',$tahun)->where('pegawai_id',1)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',3)->whereYear('tanggal',$tahun)->where('pegawai_id',1)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',4)->whereYear('tanggal',$tahun)->where('pegawai_id',1)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',5)->whereYear('tanggal',$tahun)->where('pegawai_id',1)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',6)->whereYear('tanggal',$tahun)->where('pegawai_id',1)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',7)->whereYear('tanggal',$tahun)->where('pegawai_id',1)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',8)->whereYear('tanggal',$tahun)->where('pegawai_id',1)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',9)->whereYear('tanggal',$tahun)->where('pegawai_id',1)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',10)->whereYear('tanggal',$tahun)->where('pegawai_id',1)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',11)->whereYear('tanggal',$tahun)->where('pegawai_id',1)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',12)->whereYear('tanggal',$tahun)->where('pegawai_id',1)->sum('jumlah'),
        ];
        $bayu = [
            Pemasukan::whereMonth('tanggal',1)->whereYear('tanggal',$tahun)->where('pegawai_id',2)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',2)->whereYear('tanggal',$tahun)->where('pegawai_id',2)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',3)->whereYear('tanggal',$tahun)->where('pegawai_id',2)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',4)->whereYear('tanggal',$tahun)->where('pegawai_id',2)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',5)->whereYear('tanggal',$tahun)->where('pegawai_id',2)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',6)->whereYear('tanggal',$tahun)->where('pegawai_id',2)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',7)->whereYear('tanggal',$tahun)->where('pegawai_id',2)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',8)->whereYear('tanggal',$tahun)->where('pegawai_id',2)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',9)->whereYear('tanggal',$tahun)->where('pegawai_id',2)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',10)->whereYear('tanggal',$tahun)->where('pegawai_id',2)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',11)->whereYear('tanggal',$tahun)->where('pegawai_id',2)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',12)->whereYear('tanggal',$tahun)->where('pegawai_id',2)->sum('jumlah'),
        ];
        $budi = [
            Pemasukan::whereMonth('tanggal',1)->whereYear('tanggal',$tahun)->where('pegawai_id',3)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',2)->whereYear('tanggal',$tahun)->where('pegawai_id',3)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',3)->whereYear('tanggal',$tahun)->where('pegawai_id',3)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',4)->whereYear('tanggal',$tahun)->where('pegawai_id',3)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',5)->whereYear('tanggal',$tahun)->where('pegawai_id',3)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',6)->whereYear('tanggal',$tahun)->where('pegawai_id',3)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',7)->whereYear('tanggal',$tahun)->where('pegawai_id',3)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',8)->whereYear('tanggal',$tahun)->where('pegawai_id',3)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',9)->whereYear('tanggal',$tahun)->where('pegawai_id',3)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',10)->whereYear('tanggal',$tahun)->where('pegawai_id',3)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',11)->whereYear('tanggal',$tahun)->where('pegawai_id',3)->sum('jumlah'),
            Pemasukan::whereMonth('tanggal',12)->whereYear('tanggal',$tahun)->where('pegawai_id',3)->sum('jumlah'),
        ];
        return response()->json([
            'fendi' => $fendi,
            'bayu' => $bayu,
            'budi' => $budi,
        ]);
    }
    public function print($pegawai, $bulan, $tahun)
    {
        $caripegawai = Pegawai::find($pegawai);
        $nama = $caripegawai->nama;
        $libur = Libur::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('pegawai_id', $pegawai)->sum('jumlah');
        $bon = Bon::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('pegawai_id', $pegawai)->sum('jumlah');
        $pemasukan = Pemasukan::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('pegawai_id', $pegawai)->sum('total');
        $jumlah = Pemasukan::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('pegawai_id', $pegawai)->sum('jumlah');
        $vocer = Pemasukan::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('pegawai_id', $pegawai)->sum('vocer');
        $total = intval($jumlah) + intval($vocer);
        $gaji = 1000000;
        //request data
        $bulans = date('M', strtotime($tahun . '-' . $bulan . '-10'));
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
        $printer->text("Puguh - Pegandon\n");
        $printer->text("Karangayu - Cepiring\n");
        // $printer->text($nama . "\n");
        $printer->feed();

        /* Title of receipt */
        $printer->setEmphasis(true);
        $printer->text("FITER BARBER \n");
        $printer->setEmphasis(false);

        /* Information for the receipt */
        $items = array(
            new Items("Nama", $nama),
            new Items("Bulan", $bulans . " " . $tahun),
            new Items("Libur", $libur . ' X'),
            new Items("Total Potong", $jumlah . ' Kepala'),
            new Items("Total Vocer", $vocer . ' Kepala'),
            new Items("Gaji", 'Rp. ' . number_format($gaji, 0, ".", ".") . ",-"),
            new Items("Bonus", 'Rp. ' . number_format($this->totalbonus, 0, ".", ".") . ",-"),
            new Items("Bon", 'Rp. ' . number_format($bon, 0, ".", ".") . ",-"),
            new Items("Pot. Libur", 'Rp. ' . number_format($this->potongan, 0, ".", ".") . ",-"),
            new Items("Total Gaji", 'Rp. ' . number_format($this->totalgaji, 0, ".", ".") . ",-"),
        );
        $date = gmdate('d M Y');

        /* Items */
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setEmphasis(true);
        $printer->text(new Items('', '')); //Rp
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
}
