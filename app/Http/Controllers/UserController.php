<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WaliSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        return "anda berhasil login";
    }

    public function update(Request $request){
        $token = $request->input('token');

        $user = User::where("token", $token)->first();
        $request_data = $request->all();
        unset($request_data['token']);

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $photo = round(microtime(true) * 1000) . '.' . $image->getClientOriginalExtension();
            $image->move('img/sekolah/', $photo);
            $request_data['foto'] = $photo;
        }
        if ($request->hasFile('foto_pengasuh')) {
            $image = $request->file('foto_pengasuh');
            $photo = round(microtime(true) * 1000) . '.' . $image->getClientOriginalExtension();
            $image->move('img/pengasuh/', $photo);
            $request_data['foto_pengasuh'] = $photo;
        }

        $update = $user->update($request_data);

        if($update) {
            $res['message'] = 'berhasil merubah data!';
            $res['status'] = "OK";
            $res['http_status'] = 200;

        } else {
            $res['message'] = 'gagal merubah data, terjadi kesalahan di db';
            $res['status'] = "Failed";
            $res['http_status'] = 200;
        }

        return response()->json($res, $res['http_status']);
    }

    public function detail(Request $request){
        $token = $request->input('token');

        $user = User::where("token", $token)->first();

        if ($user){
            unset($user['password']);
            $res['message'] = 'Data berhasil didapatkan!';
            $res['http_status'] = 200;
            $res['status'] = "OK";
            $res['data'] = $user;
        }else{
            $res['message'] = 'Tidak ada data';
            $res['http_status'] = 200;
            $res['status'] = "Failed";
            $res['data'] = [];
        }

        return response()->json($res, $res['http_status']);
    }

    public function detailWaliSantri(Request $request){
        $token = $request->input('token');

        $user = WaliSantri::where("token", $token)->first();

        if ($user){
            unset($user['password']);
            unset($user['created_at']);
            unset($user['updated_at']);

            $res['message'] = 'Data berhasil didapatkan!';
            $res['http_status'] = 200;
            $res['status'] = "OK";
            $res['data'] = $user;
        }else{
            $res['message'] = 'Tidak ada data';
            $res['http_status'] = 200;
            $res['status'] = "Failed";
            $res['data'] = [];
        }

        return response()->json($res, $res['http_status']);
    }
}
