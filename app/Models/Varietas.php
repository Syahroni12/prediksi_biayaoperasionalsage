<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Varietas extends Model
{
    use HasFactory;
    protected $table = 'varietas';
    protected $fillable = ['varietas'];

    public function prediksi()
    {
        return $this->hasMany(Prediksi::class, 'varietas_id', 'id');
    }
}
