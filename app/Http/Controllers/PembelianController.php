<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Distributor;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index()
    {
         //menampilkan Pembelian
         $pembelian = Pembelian::all();
         return view('pembelian.index', [
         'pembelian' => $pembelian
         ]);
    }

    public function create()
    {
        return view(
            'pembelian.create',[
            'users' => User::all(),
            'distributor' => Distributor::all()
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
        'nonota_beli'=>'required',
        'tgl_beli' => 'required',
        'total_beli' =>'required',
        'id_distributor' =>'required',
        'id_user' => 'required'

    ]);
    $array = $request->only([
    'nonota_beli', 'tgl_beli', 'total_beli','id_distributor','id_user'
    ]);

Pembelian::create($array);
return redirect()->route('detail_pembelian.create') 
->with('success_message', 'Berhasil menambah pembelian');
}

public function edit($id)
    {
        $pembelian = pembelian::find($id);
        if (!$pembelian) return redirect()->route('pembelian.index')->with('error_message', 'pembelian dengan id = '.$id.' tidak ditemukan');
        return view('pembelian.edit', [
        'pembelian' => $pembelian,
        'users' => User::all(),
        'distributor' => Distributor::all()
        ]);

    
    }

public function update(Request $request, $id)
    {
        $request->validate([
            'nonota_beli' => 'required',
            'tgl_beli' => 'required',
            'total_beli' => 'required',
            'id_distributor' => 'required',
            'id_user'  => 'required',
            ]);
            $pembelian = pembelian::find($id);
            $pembelian->nonota_beli = $request->nonota_beli;
            $pembelian->tgl_beli = $request->tgl_beli;
            $pembelian->total_beli= $request->total_beli;
            $pembelian->id_distributor = $request->id_distributor;
            $pembelian->id_user = $request->id_user;
          
            $pembelian->save();
            return redirect()->route('pembelian.index')->with('success_message', 'Berhasil mengubah pembelian');
    
    }

public function destroy($id)
    {
        $pembelian = pembelian::find($id);

        if ($pembelian) $pembelian->delete();
        return redirect()->route('pembelian.index')->with('success_message', 'Berhasil menghapus pembelian');
    }
}




