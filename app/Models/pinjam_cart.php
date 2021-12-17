<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pinjam_cart extends Model
{
    use HasFactory;

    protected $table = "pinjam_cart";

    protected $fillable = ['user_id', 'buku_id', 'qty'];

    public function buku()
    {
    	return $this->belongsTo(buku::class);
    }

    public function User()
    {
    	return $this->belongsTo(User::class);
    }
}