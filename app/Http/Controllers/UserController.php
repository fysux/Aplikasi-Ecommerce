<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Riwayat;
use App\Models\Saldo;
use App\Models\User;

class UserController extends Controller
{
    //

    public function index()
    {
        // Mengecek apakah sudah melakukan login terlebih dahulu
        if (auth()->check()) {
            $name = auth()->user();

            $barang = Barang::paginate(5);

            return view('welcome', compact('name', 'barang'));
        } else {
            return redirect('/login');
        }
    }

    public function beli(Request $request)
    {
        // ambil data user yang sedang login
        $user = auth()->user();
        if ($user) {
            return view('beli', compact('user'));
        }
    }

    public function beli_barang(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'barang_id' => 'required',
            'harga' => 'required',
            'qty' => 'required',
        ]);

        $harga_barang = $request->input('harga');
        $jumlah_dipilih = $request->input('qty');

        // lakukan pengecekan saldo pembeli, apakah cukup.
        // jika cukup maka lanjutkan transaksi
        // jika tidak, tampilkan pesan kesalahan
        // lakukan transaksi
        $user = Saldo::find($request->input('user_id'));
        if ($user && $user->saldo >= $harga_barang * $jumlah_dipilih) {
            $data = new Transaksi();
            $data->user_id = $request->input('user_id');
            $data->barang_id = $request->input('barang_id');
            $data->qty = $jumlah_dipilih;
            $data->total_harga = $harga_barang * $jumlah_dipilih;

            if ($data->save()) {
                $new_data = new Riwayat();
                $new_data->user_id = $request->input('user_id');
                $new_data->transaksi_id = $data->transaksi_id;
                $new_data->total_harga = $data->total_harga;

                if ($new_data->save()) {
                    // update data barang pada penjual karena sudah dibeli
                    $barang = Barang::find($request->input('barang_id'));
                    $barang->stok = $barang->stok - $jumlah_dipilih;
                    $barang->save();

                    // update data saldo pada pembeli karena sudah dibeli
                    $user->saldo = $user->saldo - $data->total_harga;
                    $user->save();

                    return redirect('/')->with('success', 'Barang Berhasil dibeli');
                } else {
                    return redirect('/')->with('error', 'Gagal menambahkan data');
                }
            }
        } else {
            return redirect('/')->with('error', 'Saldo tidak mencukupi');
        }
    }


    public function tambah_uang(Request $request)
    {
        $saldo = Saldo::all();

        return view('tambah_saldo', compact('saldo'));
    }
    public function tambah_saldo(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'saldo' => 'required',
        ]);

        try {
            // Lakukan cek data saldo user
            $cek_data = Saldo::where('user_id', $request->input('user_id'))->first();

            if ($cek_data) {
                // Jika data saldo ditemukan, update saldo
                $update_saldo = $cek_data->saldo + $request->input('saldo');

                $cek_data->saldo = $update_saldo;
                $cek_data->save();
            } else {
                // Jika data saldo tidak ditemukan, buat data baru
                $data = new Saldo();
                $data->user_id = $request->input('user_id');
                $data->saldo = $request->input('saldo');
                $data->save();
            }

            return redirect('/tambahsaldo')->with('success', 'Transaksi Berhasil');
        } catch (\Exception $e) {
            return redirect('/tambahsaldo')->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }


    public function riwayat(Request $request)
    {
        $riwayat = Riwayat::where('user_id', $request->input('user_id'))->get();
        
        return view('riwayat_transaksi', compact('riwayat'));
    }
}
