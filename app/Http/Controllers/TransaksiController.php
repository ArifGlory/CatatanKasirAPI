<?php

namespace App\Http\Controllers;


use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TransaksiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->middleware('login');
    }

    public function index(){
        return "welcome";
    }

    public function store(Request  $request){

        $requestData = $request->all();
        $user = User::where('token',$request->input('token'))->first();

        $data_transaksi = array(
          'user_id'  => $user->id,
          'pelanggan_id'  => $requestData['id_pelanggan'],
          'pelanggan_type'  => $requestData['pelanggan_type'],
          'total_bayar'  => $requestData['total_bayar'],
        );
        $transaksi = Transaksi::create($data_transaksi);
        $total_untung = 0;

        foreach ($requestData['list_keranjang'] as $val){
            $total_untung = $total_untung + $val['untung'];
            $data_detail = array(
                'user_id' => $user->id,
                'pelanggan_id' => $requestData['id_pelanggan'],
                'transaksi_id' => $transaksi->id,
                'barang_id' => $val['id_barang'],
                'untung' => $val['untung'],
                'subtotal' => $val['subtotal'],
            );
            TransaksiDetail::create($data_detail);

            //kurangi stok barang
            $barang = Barang::where('id',$val['id_barang'])->first();
            $new_stok = $barang->stok - $val['jumlah_beli'];
            $update_barang = array(
              'stok' => $new_stok
            );
            $barang->update($update_barang);
        }

        $data_update = array(
          'total_untung'  => $total_untung
        );
        $transaksi->update($data_update);

        $res['message'] = 'Transaksi berhasil!';
        $res['http_status'] = 200;
        $res['status'] = "OK";
       // $res['data'] = $requestData;

        return response()->json($res, $res['http_status']);
    }

    public function history(Request  $request){
        $user = User::where('token',$request->input('token'))->first();
        //tap untuk menjaga paginationnya tetep ada, walau data nya ada yang diubah
        $transaksi = tap(Transaksi::leftJoin('pelanggan', 'pelanggan.id', '=', 'transaksi.pelanggan_id')
            ->select('transaksi.*','pelanggan.name as nama_pelanggan','pelanggan.id as id_pelanggan')
            ->where('transaksi.user_id',$user->id)
            ->paginate(30))
            ->map(function ($item){
                $waktu_transaksi = Carbon::createFromFormat('Y-m-d H:i:s',$item->created_at)->format('d F Y');
                $item->tgl_transaksi = $waktu_transaksi;
                return $item;
            });

        if ($transaksi){
            $res['message'] = 'Data transaksi berhasil didapatkan!';
            $res['http_status'] = 200;
            $res['status'] = "OK";
            $res['data'] = $transaksi;
        }else{
            $res['message'] = 'Tidak ada data';
            $res['http_status'] = 202;
            $res['status'] = "Failed";
            $res['data'] = [];

        }

        return response()->json($transaksi, $res['http_status']);
    }

    public function detailTransaksi(Request $request){
        $details = TransaksiDetail::leftJoin('barang', 'barang.id', '=', 'transaksi_detail.barang_id')
            ->select('transaksi_detail.*','barang.name as nama_barang','barang.id as id_barang','barang.picture')
            ->where('transaksi_detail.transaksi_id',$request->input('transaksi_id'))
            ->get();

        if ($details){
            $res['message'] = 'Detail transaksi berhasil didapatkan!';
            $res['http_status'] = 200;
            $res['status'] = "OK";
            $res['data'] = $details;
        }else{
            $res['message'] = 'Tidak ada data';
            $res['http_status'] = 202;
            $res['status'] = "Failed";
            $res['data'] = [];

        }

        return response()->json($res, $res['http_status']);
    }

    public function chartData(Request $request){
        $user = User::where('token',$request->input('token'))->first();
        $current_month = date('m');

        $transaksi =  Transaksi::where('user_id',$user->id)
            ->whereMonth('transaksi.created_at', '=', $current_month)
            //->groupBy('created_at')
            ->groupBy(DB::raw('Date(created_at)'))
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as "jumlah"')
            ));

        if ($transaksi){
            $res['message'] = 'Detail transaksi berhasil didapatkan!';
            $res['http_status'] = 200;
            $res['status'] = "OK";
            $res['data'] = $transaksi;
        }else{
            $res['message'] = 'Tidak ada data';
            $res['http_status'] = 202;
            $res['status'] = "Failed";
            $res['data'] = [];

        }

        return response()->json($res, $res['http_status']);
    }

    public function totalUntung(Request  $request){
        $user = User::where('token',$request->input('token'))->first();
        $total_untung =  Transaksi::where('transaksi.user_id',$user->id)
            ->sum('total_untung');

        if ($total_untung){
            $res['message'] = 'Data total untung berhasil didapatkan!';
            $res['http_status'] = 200;
            $res['status'] = "OK";
            $res['data'] = $total_untung;
        }else{
            $res['message'] = 'Tidak ada data';
            $res['http_status'] = 202;
            $res['status'] = "Failed";
            $res['data'] = [];

        }

        return response()->json($res, $res['http_status']);
    }

    public function report(Request  $request){
        $user = User::where('token',$request->input('token'))->first();
        $from = $request->input('dari');
        $until = $request->input('sampai');

        $transaksi = Transaksi::leftJoin('pelanggan', 'pelanggan.id', '=', 'transaksi.pelanggan_id')
            ->select('transaksi.*','pelanggan.name as nama_pelanggan','pelanggan.id as id_pelanggan')
            ->where('transaksi.user_id',$user->id)
            ->where('transaksi.created_at','>=',$from)
            ->where('transaksi.created_at','<=',$until)
            ->get()
            ->map(function ($item){
                $waktu_transaksi = Carbon::createFromFormat('Y-m-d H:i:s',$item->created_at)->format('d F Y');
                $item->tgl_transaksi = $waktu_transaksi;
                return $item;
            });

        if ($transaksi){
            $res['message'] = 'Data transaksi berhasil didapatkan!';
            $res['http_status'] = 200;
            $res['status'] = "OK";
            $res['data'] = $transaksi;
        }else{
            $res['message'] = 'Tidak ada data';
            $res['http_status'] = 202;
            $res['status'] = "Failed";
            $res['data'] = [];

        }

        return response()->json($res, $res['http_status']);
    }

    public function printReport(Request  $request){
        $user = User::where('token',$request->input('token'))->first();
        $from = $request->input('dari');
        $until = $request->input('sampai');

        $dari = Carbon::createFromFormat('Y-m-d',$from)->format('d F Y');
        $sampai = Carbon::createFromFormat('Y-m-d',$until)->format('d F Y');
        $today = date('Y-m-d');
        $now = Carbon::createFromFormat('Y-m-d',$today)->format('d F Y');

        $transaksi = Transaksi::leftJoin('pelanggan', 'pelanggan.id', '=', 'transaksi.pelanggan_id')
            ->select('transaksi.*','pelanggan.name as nama_pelanggan','pelanggan.id as id_pelanggan')
            ->where('transaksi.user_id',$user->id)
            ->where('transaksi.created_at','>=',$from)
            ->where('transaksi.created_at','<=',$until)
            ->get()
            ->map(function ($item){
                $waktu_transaksi = Carbon::createFromFormat('Y-m-d H:i:s',$item->created_at)->format('d F Y');
                $item->tgl_transaksi = $waktu_transaksi;
                return $item;
            });

        $data = array(
            'untung' => $transaksi,
            'user' => $user,
            'dari' => $dari,
            'sampai' => $sampai,
            'now' => $now,
        );

        $pdf = PDF::loadView('laporan_untung',$data);

        return $pdf->download('report_untung.pdf');
    }


}
