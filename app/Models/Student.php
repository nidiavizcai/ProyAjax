<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//Secrea el nuevo modelo
class Student extends Model
{ //Datos que vamos a manejar
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'address'
    ];
}
