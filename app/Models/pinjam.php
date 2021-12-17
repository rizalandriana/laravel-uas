<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pinjam extends Model
{
    use HasFactory;

    protected $table = "pinjam";

    protected $fillable = ['kode', 'member_id', 'tgl', 'duedate', 'total', 'user_id'];

    public function kembali()
    {
    	return $this->hasOne(kembali::class);
    }

    public function member()
    {
    	return $this->belongsTo(member::class);
    }

    public function users()
    {
    	return $this->hasOne('App\Models\User');
    }

    public function pinjam_detail()
    {
    	return $this->hasMany(pinjam_detail::class);
    }

}