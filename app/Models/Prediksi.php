<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediksi extends Model
{
    use HasFactory;
    protected $table = 'prediksi';
    protected $guarded = ['id'];

    public function varietas()
    {
        return $this->belongsTo(Varietas::class, 'varietas_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
