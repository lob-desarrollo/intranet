<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeCategory extends Model {
    use HasFactory;
    protected $fillable = ['categoria', 'imagen', 'color', 'estatus'];
}