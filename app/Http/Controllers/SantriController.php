<?php

namespace App\Http\Controllers;


use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SantriController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        //$this->middleware('login');
    }

    public function index(){
        return "welcome";
    }

    public function anyData(Request $request){

        $email_wali = $request->input('email_wali');

        $santri = Santri::select('users.id AS id_sekolah','users.name as nama_pesantren','santri.*')
            ->join('users', 'users.id', '=', 'santri.id_pesantren')
            ->where('santri.email_wali_santri',$email_wali)
            ->paginate(10);

        $santri->makeHidden('created_at');
        $santri->makeHidden('updated_at');
        $santri->makeHidden('id');
        //dd($users);

        if ($santri){
            $res['message'] = 'Data santri berhasil didapatkan!';
            $res['code'] = 200;
            $res['status'] = "OK";
            $res['result'] = $santri;

        }else{
            $res['message'] = 'Tidak ada data';
            $res['code'] = 202;
            $res['status'] = "Failed";
            $res['result'] = [];

        }

        return response()->json($santri, $res['code']);
    }

    public function kitabSantri(Request $request){
        $id_santri = $request->input('id_santri');

        $kitab = KitabSantri::select('kitab.nama_kitab','kitab.keterangan','kitab_milik_santri.*')
            ->join('kitab', 'kitab.id_kitab', '=', 'kitab_milik_santri.id_kitab')
            ->where('kitab_milik_santri.id_santri',$id_santri)
            ->paginate(10);

        if ($kitab){
            $res['message'] = 'Data kitab berhasil didapatkan!';
            $res['code'] = 200;
            $res['status'] = "OK";
            $res['result'] = $kitab;

        }else{
            $res['message'] = 'Tidak ada data';
            $res['code'] = 202;
            $res['status'] = "Failed";
            $res['result'] = [];

        }

        return response()->json($kitab, $res['code']);
    }

    public function pelanggaran(Request $request){
        $id_santri = $request->input('id_santri');

        $pelanggaran = Pelanggaran::select('pelanggaran.*')
            ->where('pelanggaran.id_santri',$id_santri)
            ->paginate(10);

        if ($pelanggaran){
            $res['message'] = 'Data pelanggaran berhasil didapatkan!';
            $res['code'] = 200;
            $res['status'] = "OK";
            $res['result'] = $pelanggaran;

        }else{
            $res['message'] = 'Tidak ada data';
            $res['code'] = 202;
            $res['status'] = "Failed";
            $res['result'] = [];

        }

        return response()->json($pelanggaran, $res['code']);
    }

    public function prestasi(Request $request){
        $id_santri = $request->input('id_santri');

        $prestasi = Prestasi::select('prestasi.*')
            ->where('prestasi.id_santri',$id_santri)
            ->paginate(10);

        if ($prestasi){
            $res['message'] = 'Data prestasi berhasil didapatkan!';
            $res['code'] = 200;
            $res['status'] = "OK";
            $res['result'] = $prestasi;

        }else{
            $res['message'] = 'Tidak ada data';
            $res['code'] = 202;
            $res['status'] = "Failed";
            $res['result'] = [];

        }

        return response()->json($prestasi, $res['code']);
    }

    public function pembayaran(Request $request){
        $id_santri = $request->input('id_santri');

        $pembayaran = Pembayaran::select('pembayaran.*')
            ->where('pembayaran.id_santri',$id_santri)
            ->paginate(10);

        if ($pembayaran){
            $res['message'] = 'Data pembayaran berhasil didapatkan!';
            $res['code'] = 200;
            $res['status'] = "OK";
            $res['result'] = $pembayaran;

        }else{
            $res['message'] = 'Tidak ada data';
            $res['code'] = 202;
            $res['status'] = "Failed";
            $res['result'] = [];

        }

        return response()->json($pembayaran, $res['code']);
    }

    public function jadwal(Request $request){
        $id_pesantren = $request->input('id_pesantren');

        $jadwal = Jadwal::select('*')
            ->where('id_pesantren',$id_pesantren)
            ->paginate(10);

        if ($jadwal){
            $res['message'] = 'Data jadwal berhasil didapatkan!';
            $res['code'] = 200;
            $res['status'] = "OK";
            $res['result'] = $jadwal;

        }else{
            $res['message'] = 'Tidak ada data';
            $res['code'] = 202;
            $res['status'] = "Failed";
            $res['result'] = [];

        }

        return response()->json($jadwal, $res['code']);
    }
}
