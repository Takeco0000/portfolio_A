<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable; // 追加

class Item extends Model
{

    /**
     * composer require kyslik/column-sortableのパッケージをインストールする必要あり
     */
    use Sortable;  // 追加



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'type_id',
        'detail',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
        // この商品は一つの種別に属している (逆の関係もTypeモデル内で定義する)
    }
    
    
}
