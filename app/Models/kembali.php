<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kembali extends Model
{
    use HasFactory;

    protected $table = "kembali";

    protected $fillable = ['pinjam_id', 'tgl', 'denda', 'bayar', 'user_id'];

    public function pinjam()
    {
    	return $this->belongsTo(pinjam::class);
    }

    public function User()
    {
    	return $this->hasOne('App\Models\User');
    }

}
