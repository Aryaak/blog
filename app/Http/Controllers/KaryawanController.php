<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\karyawan;
use App\departemen;
use App\jabatan;

class KaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function karyawan(Request $request)
    {
        $request->user();
        
        $karyawan = Karyawan::all();
        $departemen = Departemen::all();
        $jabatan = Jabatan::all();

        return view('karyawan', compact('karyawan', 'departemen', 'jabatan'));
    }

    public function tambah_karyawan(Request $request)
    {
        DB::beginTransaction();
        try {
            $karyawan = new Karyawan();
            $karyawan->nama = $request->nama;
            $karyawan->username = $request->username;
            $karyawan->password = $request->password;
            $karyawan->departemen_id_departemen = $request->departemen;
            $karyawan->jabatan_id_jabatan= $request->jabatan;
            $karyawan->alamat = $request->alamat;
            $karyawan->no_hp = $request->no_hp;
            $karyawan->gaji_pokok = $request->gaji_pokok;
            if ($request->status) {
                $karyawan->status_karyawan = 'Aktif';
            } else {
                $karyawan->status_karyawan = 'Nonaktif';
            }

            $karyawan->hash = 'DEFAULT_HASH';
            $karyawan->save();

            DB::commit();
            return back()->with('success', 'Data karyawan baru telah berhasil ditambahakan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }


    }
    public function get_ubah_karyawan($id_karyawan)
    {
        // $karyawan = Karyawan::Where('id_karyawan','=', $id_karyawan)->get();   
        $karyawan = Karyawan::find($id_karyawan);   
        
        $arr = json_decode($karyawan,true);

        $departemen = Departemen::all();
        $arr['departemen'] = $departemen;

        $jabatan = Jabatan::all();
        $arr['jabatan'] = $jabatan;

        echo json_encode($arr);

        exit;
    }
    public function ubah_karyawan(Request $request)
    {
        // dd($request);   
        
        DB::beginTransaction();
        try {
            // $tables = DB::select('SHOW karyawan'); 

            // $karyawan = Schema::getColumnListing("karyawan");
            // $dbname = DB::connection()->getDatabaseName();
            // $karyawan = Karyawan::where('id_karyawan', $request->id_karyawan); 
            $karyawan = Karyawan::find($request->id_karyawan);

            // dd($karyawan);


            $karyawan->nama = $request->nama_ubah;
            $karyawan->username = $request->username_ubah;
            $karyawan->password = $request->password_ubah;
            $karyawan->departemen_id_departemen = $request->departemen_ubah;
            $karyawan->jabatan_id_jabatan= $request->jabatan_ubah;

            $karyawan->alamat = $request->alamat_ubah;
            $karyawan->no_hp = $request->no_hp_ubah;
            $karyawan->gaji_pokok = $request->gaji_pokok_ubah;
            if ($request->status_ubah) {
                $karyawan->status_karyawan = 'Aktif';
            } else {
                $karyawan->status_karyawan = 'Nonaktif';
            }
            $karyawan->save();

            DB::commit();
            return back()->with('success', 'Data karyawan telah berhasil diubah');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
       
     }
    public function hapus_karyawan($id_karyawan)
    {
        DB::beginTransaction();
        try {
            Karyawan::find($id_karyawan)->delete();
            
            DB::commit();
            return back()->with('success', 'Karyawan telah berhasil dihapus'); 
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Oops Sepertinya ada masalah pada sistem\n\nPesan error: '.$e);
        }
    }
}