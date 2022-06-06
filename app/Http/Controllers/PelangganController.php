<?php

namespace App\Http\Controllers;


use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
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
        $keyword = $request->input('search');

        $pelanggan = Pelanggan::select('*')
            ->where('created_by',$user->id)
            ->orderBy('id',"DESC")
            ->when($keyword != "", function ($query) use($keyword) {
                return $query->where('name', 'LIKE', '%' . $keyword . '%');
            })->paginate(10);

        $pelanggan->makeHidden('created_at');
        $pelanggan->makeHidden('updated_at');
        $pelanggan->makeHidden('deleted_at');
        //dd($users);

        if ($pelanggan){
            $res['message'] = 'Data pelanggan berhasil didapatkan!';
            $res['http_status'] = 200;
            $res['status'] = "OK";
            $res['data'] = $pelanggan;

        }else{
            $res['message'] = 'Tidak ada data';
            $res['http_status'] = 202;
            $res['status'] = "Failed";
            $res['data'] = [];

        }

        return response()->json($pelanggan, $res['http_status']);
    }


    public function store(Request $request){
        $user = User::where('token',$request->input('token'))->first();

        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'alamat' => 'required',
        ]);
        $request_data = $request->all();
        unset($request_data['token']);
        $request_data['created_by'] = $user->id;


        if (Pelanggan::create($request_data)){
            $res['message'] = 'Tambah pelanggan berhasil!';
            $res['status'] = "OK";
            $res['http_status'] = 200;
        }else {
            $res['message'] = 'Tambah pelanggan gagal!';
            $res['status'] = "Failed";
            $res['http_status'] = 202;
        }

        return response()->json($res, $res['http_status']);
    }

    public function update(Request $request){
        $user = User::where('token',$request->input('token'))->first();
        $barang = Barang::findOrFail($request->input('id_barang'));

        $this->validate($request, [
            'name' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'satuan' => 'required',
        ]);
        $request_data = $request->all();
        unset($request_data['token']);

        if ($barang->update($request_data)){
            $res['message'] = 'Ubah barang berhasil ';
            $res['status'] = "OK";
            $res['http_status'] = 200;
        }else{
            $res['message'] = 'Ubah barang gagal, coba lagi nanti';
            $res['status'] = "Failed";
            $res['http_status'] = 202;
        }

        return response()->json($res, $res['http_status']);
    }

    public function delete(Request $request){
        //$user = User::where('token',$request->input('token'))->first();
        $barang = Barang::findOrFail($request->input('id_barang'));

        $delete = $barang->delete();
        if ($delete){
            $res['message'] = 'Hapus barang berhasil!';
            $res['status'] = "OK";
            $res['http_status'] = 200;
        }else{
            $res['message'] = 'Hapus barang gagal!';
            $res['status'] = "Failed";
            $res['http_status'] = 202;
        }

        return response()->json($res, $res['http_status']);
    }

}
