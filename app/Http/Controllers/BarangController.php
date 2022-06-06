<?php

namespace App\Http\Controllers;


use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BarangController extends Controller
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

        $barang = Barang::select('*')
            ->where('created_by',$user->id)
            ->paginate(10);

        $barang->makeHidden('created_at');
        $barang->makeHidden('updated_at');
        //dd($users);

        if ($barang){
            $res['message'] = 'Data barang berhasil didapatkan!';
            $res['http_status'] = 200;
            $res['status'] = "OK";
            $res['data'] = $barang;

        }else{
            $res['message'] = 'Tidak ada data';
            $res['http_status'] = 202;
            $res['status'] = "Failed";
            $res['data'] = [];

        }

        return response()->json($barang, $res['http_status']);
    }

    public function store(Request $request){
        $user = User::where('token',$request->input('token'))->first();

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
        $request_data['created_by'] = $user->id;

        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $photo = round(microtime(true) * 1000) . '.' . $image->getClientOriginalExtension();
            $image->move('img/barang/', $photo);
            $request_data['picture'] = $photo;
        }

        if (Barang::create($request_data)){
            $res['message'] = 'Tambah barang berhasil!';
            $res['status'] = "OK";
            $res['http_status'] = 200;
        }else {
            $res['message'] = 'Tambah barang gagal!';
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
