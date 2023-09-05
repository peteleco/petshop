<?php

namespace App\Models;

use App\Concerns\HasUuid;
use Database\Seeders\OrderStatusSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Peteleco\Notifier\Events\OrderUpdated;
use Peteleco\Notifier\OrderUpdatedMessage;

class Order extends Model
{
    use HasFactory;
    use HasUuid;
    protected static function boot(): void
    {
        parent::boot();
        // Dispatch events
        static::created(function (Order $order) {
            OrderUpdated::dispatch(OrderUpdatedMessage::from([
                'uuid' => $order->getAttribute('uuid'),
                'status' => $order->load('orderStatus')->orderStatus->getAttribute('title'),
                'updated_at' => $order->getAttribute('created_at'),
            ]));
        });

        static::updated(function (Order $order) {
            if($order->wasChanged('order_status_id')) {
                OrderUpdated::dispatch(OrderUpdatedMessage::from([
                    'uuid' => $order->getAttribute('uuid'),
                    'status' =>  $order->load('orderStatus')->orderStatus->getAttribute('title'),
                    'updated_at' => $order->getAttribute('created_at'),
                ]));
            }
        });
    }

    /**
     *
     * @var array<string, string> $casts
     * @inheritdoc
     */
    protected $casts = [
        'shipped_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\OrderStatus>
     */
    public function orderStatus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Payment>
     */
    public function payment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
