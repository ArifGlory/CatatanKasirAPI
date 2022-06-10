<?php

namespace App\Http\Controllers;


use App\Models\Barang;
use App\Models\Hutang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HutangController extends Controller
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

    public function anyData(Request $request){
        $user = User::where('token',$request->input('token'))->first();
        //tap untuk menjaga paginationnya tetep ada, walau data nya ada yang diubah
        $hutang = tap(Hutang::leftJoin('pelanggan', 'pelanggan.id', '=', 'hutang.pelanggan_id')
            ->select('hutang.*','pelanggan.name as nama_pelanggan','pelanggan.id as id_pelanggan')
            ->where('hutang.user_id',$user->id)
            ->paginate(20))
            ->map(function ($item){
                $waktu_hutang = Carbon::createFromFormat('Y-m-d H:i:s',$item->created_at)->format('d F Y');
                $item->tgl_hutang = $waktu_hutang;
                return $item;
            });

        if ($hutang){
            $res['message'] = 'Data hutang berhasil didapatkan!';
            $res['http_status'] = 200;
            $res['status'] = "OK";
            $res['data'] = $hutang;
        }else{
            $res['message'] = 'Tidak ada data';
            $res['http_status'] = 202;
            $res['status'] = "Failed";
            $res['data'] = [];

        }

        return response()->json($hutang, $res['http_status']);
    }

    public function store(Request  $request){
        $user = User::where('token',$request->input('token'))->first();
        $requestData = $request->all();

        $data_hutang = array(
            'user_id'  => $user->id,
            'pelanggan_id'  => $requestData['id_pelanggan'],
            'pelanggan_type'  => $requestData['pelanggan_type'],
            'hutang'  => $requestData['hutang'],
        );
        $hutang = Hutang::create($data_hutang);

        if ($hutang){
            $res['message'] = 'Data hutang berhasil ditambahkan!';
            $res['http_status'] = 200;
            $res['status'] = "OK";
        }else{
            $res['message'] = 'Tidak ada data';
            $res['http_status'] = 202;
            $res['status'] = "Failed";
        }

        return response()->json($hutang, $res['http_status']);
    }


}
