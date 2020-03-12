<?php

namespace App\Http\Controllers\Laundry;

use App\Http\Controllers\Controller;
use App\Layanan;
use App\Transaksi;
use App\TransaksiDetail;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function create(Request $request)
    {

        $allPost = (object)$request->all();

        $total_qty = 0;
        $total_tagihan= 0;
        $returnDetail = array();

        $rules = array(
            'pelanggan' => 'required',
            'unit' => 'required',
            'transaksi' => 'required'
        );

        $validator = validator($request->all(), $rules);

        if ($validator->fails())
        {
            return response()->json([
                "code" => 400,
                "status" => "Failed",
                "message" =>  $validator->errors()->first(),
                "data" => null
            ]);
        }

        if (count($allPost->transaksi) == 0) {
           
            return response()->json([
                "code" => 400,
                "status" => "Failed",
                "message" =>  'Data transaksi tidak boleh kosong!',
                "data" => null
            ]);
        }

        $transaksi = new Transaksi();
        $transaksi->pelanggan = $allPost->pelanggan;
        $transaksi->unit = $allPost->unit;
        $transaksi->total_qty = $total_qty;
        $transaksi->total_tagihan = $total_tagihan;
        $transaksi->save();


        foreach ($allPost->transaksi as $key => $value) {

            $data = (object) $value;
           
            $layanan = Layanan::where('id',$data->layanan_id)->first();

            if(!is_null($layanan))
            {
                $total = $layanan->harga*$data->qty;

                $transaksiDetail = new TransaksiDetail();
                $transaksiDetail->transaksi_id = $transaksi->id;
                $transaksiDetail->layanan_id = $layanan->id;
                $transaksiDetail->unit = $allPost->unit;
                $transaksiDetail->harga = $layanan->harga;
                $transaksiDetail->qty = $data->qty;
                $transaksiDetail->tagihan = $total;
                $transaksiDetail->save();

                $total_qty+= $data->qty;
                $total_tagihan+=$total;

                $returnDetail['id'] = $transaksiDetail->id;
                $returnDetail['qty'] = $data->qty;
                $returnDetail['layanan']['id'] = $layanan->id;
                $returnDetail['layanan']['nama'] = $layanan->nama;
                $returnDetail['layanan']['unit'] = $layanan->unit;
                $returnDetail['layanan']['harga'] = $layanan->harga;
            }
        }
  
        $transaksi = Transaksi::find($transaksi->id);
        $transaksi->total_qty = $total_qty;
        $transaksi->total_tagihan = $total_tagihan;
        $transaksi->save();

        $returnTransaksi['id'] = $transaksi->id;
        $returnTransaksi['pelanggan'] = $transaksi->pelanggan;
        $returnTransaksi['unit'] = $transaksi->unit;
        $returnTransaksi['tagihan'] = $transaksi->total_tagihan;
        $returnTransaksi['detail'] = $returnDetail;

        return response()->json([
            "code" => 200,
            "status" => "success",
            "data" => $returnTransaksi
        ]);
    }
}
