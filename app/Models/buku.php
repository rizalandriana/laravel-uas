<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buku extends Model
{
    use HasFactory;

    protected $table = "buku";

    protected $fillable = ['kode', 'judul_buku', 'harga_sewa', 'stok', 'gambar', 'pengarang', 'penerbit', 'tahun', 'tempat', 'status'];

    public function pinjam_cart()
    {
    	return $this->hasMany(pinjam_cart::class);
    }

    public function pinjam_detail()
    {
    	return $this->hasMany(pinjam_detail::class);
    }
}
