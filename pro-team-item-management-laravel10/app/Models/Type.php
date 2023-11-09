<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $table = 'types'; // テーブル名を指定
    protected $fillable = ['user_id', 'name', 'type', 'detail']; // フィールドの許可
}
