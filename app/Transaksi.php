<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id';

    protected $fillable = array('pelanggan', 'unit', 'total_qty', 'total_tagihan');

    public function transaksidetail()
    {
        return $this->hasMany('App\TransaksiDetail');
    }
}


