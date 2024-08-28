<?php

namespace Modules\Checkout\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_status',
    ];

    /**
     * Obtener el usuario que realizó el pedido.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
