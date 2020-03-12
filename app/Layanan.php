<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan';
    protected $primaryKey = 'id';

    protected $fillable = ['nama', 'unit', 'harga'];
    
    public function transaksidetail()
    {
        return $this->hasMany('App\TransaksiDetail');
    }
}
