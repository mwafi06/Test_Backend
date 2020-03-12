<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $table = 'transaksi_details';
    protected $primaryKey = 'id';

    protected $fillable = array('transaksi_id', 'layanan_id', 'unit', 'harga', 'qty', 'tagihan');

    public function layanan()
    {
        return $this->belongsTo('App\Layanan');
    }
    
    public function transaksi()
    {
        return $this->belongsTo('App\Transaksi');
    }
}
