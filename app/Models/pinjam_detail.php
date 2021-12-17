<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pinjam_detail extends Model
{
    use HasFactory;

    protected $table = "pinjam_detail";

    protected $fillable = ['pinjam_id', 'buku_id', 'harga_sewa', 'qty'];

    public function pinjam(){
    	return $this->belongsTo(pinjam::class);
    }

    public function buku(){
    	return $this->belongsTo(buku::class);
    }

}