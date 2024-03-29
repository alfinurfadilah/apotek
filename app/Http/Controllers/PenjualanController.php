<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
        public function index()
    {
        //menampilkan Pembelian
        $penjualan = Penjualan::all();
        return view('penjualan.index', [
        'penjualan' => $penjualan
        ]);
    }

    public function create()
    {
        return view(
            'penjualan.create',[
            'users' => User::all(),
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
        'nonota_jual'=>'required',
        'tgl_jual' => 'required',
        'total_jual' =>'required',
        'id_user' => 'required'

    ]);
    $array = $request->only([
    'nonota_jual', 'tgl_jual', 'total_jual','id_user'
    ]);

Penjualan::create($array);
return redirect()->route('detail_penjualan.create') 
->with('success_message', 'Berhasil menambah penjualan');
}

public function edit($id)
    {
        $penjualan = penjualan::find($id);
        if (!$penjualan) return redirect()->route('penjualan.index')->with('error_message', 'penjualan dengan id = '.$id.' tidak ditemukan');
        return view('penjualan.edit', [
            'penjualan' => $penjualan ,
            'users' => User::all()
        ]);

    
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nonota_jual' => 'required',
            'tgl_jual' => 'required',
            'total_jual' => 'required',
            'id_user'  => 'required',
            ]);
            $penjualan = penjualan::find($id);
            $penjualan->nonota_jual = $request->nonota_jual;
            $penjualan->tgl_jual= $request->tgl_jual;
            $penjualan->total_jual= $request->total_jual;
            $penjualan->id_user = $request->id_user;
          
            $penjualan->save();
            return redirect()->route('penjualan.index')->with('success_message', 'Berhasil mengubah penjualan');
    
    }

    public function destroy($id)
    {
        $penjualan = penjualan::find($id);

        if ($penjualan) $penjualan->delete();
        return redirect()->route('penjualan.index')->with('success_message', 'Berhasil menghapus peenjualan');
    }

}
