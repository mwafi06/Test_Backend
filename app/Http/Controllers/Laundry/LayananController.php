<?php

namespace App\Http\Controllers\Laundry;

use App\Http\Controllers\Controller;
use App\Layanan;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LayananController extends Controller
{
    public function create(Request $request)
    {
        try {
            $layanan = Layanan::create([
                'nama' => $request->get('nama'),
                'unit' => $request->get('unit'),
                'harga' => $request->get('harga'),
            ]);
            return response()->json([
                "code" => 200,
                "status" => "Success",
                "data" => Layanan::find($layanan->id)
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                "code" => 400,
                "message" =>  "Gagal Tambah data",
                "data" => null
            ]);
        }
    }
}
