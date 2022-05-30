<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function register(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:6',
            'name' => 'required|min:2',
            'nama_umkm' => 'required|min:2',
            'phone' => 'required',
            'alamat' => 'required',
        ]);

        $email = $request->input("email");
        $password = $request->input("password");
        $name = $request->input("name");

        $hashPwd = Hash::make($password);
        $data = [
            "email" => $email,
            "password" => $hashPwd,
            "name" => $name,
            "phone" => $request->input("phone"),
            "nama_umkm" => $request->input("nama_umkm"),
            "alamat" => $request->input("alamat"),
        ];

        if (User::create($data)) {
            $res['message'] = 'Pendaftaran berhasil!';
            $res['status'] = "OK";
            $res['http_status'] = 200;
        } else {
            $res['message'] = 'pendaftaran gagal!';
            $res['status'] = "Failed";
            $res['http_status'] = 202;
        }

        return response()->json($res, $res['http_status']);
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $email = $request->input("email");
        $password = $request->input("password");

        $user = User::where("email", $email)->first();

        if (!$user) {
            $out = [
                "message" => "login failed, email tidak terdaftar",
                "status" => "Failed",
                "status" => "Failed",
                "http_status"    => 202,
                "token"  => ""
            ];
            return response()->json($out, $out['code']);
        }

        if (Hash::check($password, $user->password)) {
            $newtoken  = $this->generateRandomString();

            $user->update([
                'token' => $newtoken
            ]);

            $out = [
                "message" => "login sukses",
                "status" => "OK",
                "http_status"    => 200,
                "token"  => $newtoken
            ];
        } else {
            $out = [
                "message" => "login gagal",
                "status" => "Failed",
                "http_status"    => 202,
                "token"  => ""
            ];
        }

        return response()->json($out, $out['http_status']);
    }


    function generateRandomString($length = 80)
    {
        $karakkter = '012345678dssd9abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $panjang_karakter = strlen($karakkter);
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $karakkter[rand(0, $panjang_karakter - 1)];
        }
        return $str;
    }

    public function logout(Request $request){
        $token = $request->input('token');

        $user = User::where("token", $token)->first();

        if ($user == null) {
            $res['message'] = 'user tidak ditemukan!';
            $res['status'] = "Failed";
            $res['http_status'] = 200;

        }else{
            $update =  $user->update([
            'token' => null
            ]);

            if($update) {
                $res['message'] = 'berhasil logout!';
                $res['status'] = "OK";
                $res['http_status'] = 200;

            } else {
                $res['message'] = 'gagal merubah data, terjadi kesalahan di db';
                $res['status'] = "Failed";
                $res['http_status'] = 200;
            }

        }

        return response()->json($res, $res['http_status']);
    }
}
