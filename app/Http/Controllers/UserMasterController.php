<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserMaster;
use Spatie\LaravelIgnition\Http\Requests\UpdateConfigRequest;

class UserMasterController extends Controller
{
    //

    public function index(Request $request)
    {
        $user = Auth::user(); // Mendapatkan informasi pengguna yang saat ini masuk
        $userMaster = $user->user_master_id; // Mendapatkan data userMaster yang terkait dengan pengguna

        // Jika userMaster belum ada, buat satu dan arahkan kembali ke halaman utama dengan pesan sukses
        if (!$userMaster) {
            $userMaster = new UserMaster();
            $userMaster->user_id = $user->user_id;
            $userMaster->save();

            // Redirect ke halaman utama dengan pesan sukses jika berhasil
            return redirect('/master')->with('success', 'Akun Anda telah ditingkatkan menjadi UserMaster!');
        }

        // Jika userMaster sudah ada, tampilkan informasi bahwa pengguna telah menjadi UserMaster
        return view('master', compact('userMaster'));
    }

    public function upload(Request $request)
    {
        // Validasi input, pastikan 'gambar' adalah file yang valid
        $request->validate([
            'nama' => 'required',
            'user_id' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Contoh validasi untuk gambar
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Membuat nama file unik

            // Menyimpan gambar ke dalam folder 'public/images' di storage
            $image->storeAs('public/images', $imageName);

            // Simpan nama file gambar ke dalam kolom 'gambar' di tabel 'barang'
            $data = new Barang();
            $data->user_id = $request->input('user_id');
            $data->nama = $request->input('nama');
            $data->gambar = $imageName; // Simpan nama file gambar, bukan path lengkap
            $data->stok = $request->input('stok');
            $data->harga = $request->input('harga');

            if ($data->save()) {
                return redirect('/upload_barang')->with('success', 'Barang ditambahkan');
            } else {
                return redirect('/upload_barang')->with('error', 'Gagal menyimpan barang');
            }
        } else {
            return redirect('/upload_barang')->with('error', 'Gambar tidak ditemukan');
        }
    }
}
