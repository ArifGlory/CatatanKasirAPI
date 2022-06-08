<?php

namespace App\Http\Controllers;


use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $transaksi = Transaksi::join('pelanggan', 'pelanggan.id', '=', 'transaksi.pelanggan_id')
            ->where('transaksi.user_id',$user->id)
            ->paginate(20);

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


}
