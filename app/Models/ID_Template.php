<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ID_Template extends Model
{
    use HasFactory;

    protected $fillable = ['back','front','status'];
}
