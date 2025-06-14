<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'workshops';
    protected $fillable = ['workshop_type'];
}