<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class member extends Model
{
    use HasFactory;

    protected $table = "member";

    protected $fillable = ['kode', 'kategori_id', 'nama', 'foto', 'alamat', 'hp', 'email', 'status'];

    public function kategori()
    {
    	return $this->belongsTo(kategori::class);
    }

    public function pinjam()
    {
    	return $this->hasMany(pinjam::class);
    }

}