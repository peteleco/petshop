<?php

namespace App\Models;

use App\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Peteleco\Notifier\Events\OrderUpdated;
use Peteleco\Notifier\OrderUpdatedMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    use HasUuid;
    protected static function boot(): void
    {
        parent::boot();
        // Dispatch events
        static::created(function (Order $order): void {
            /** @var string $status*/
            $status = $order->load('orderStatus')->getRelation('orderStatus')->getAttribute('title');
            OrderUpdated::dispatch(OrderUpdatedMessage::from([
                'uuid' => $order->getAttribute('uuid'),
                'status' => $status,
                'updated_at' => $order->getAttribute('created_at'),
            ]));
        });

        static::updated(function (Order $order): void {
            if ($order->wasChanged('order_status_id')) {
                $status = $order->load('orderStatus')->getRelation('orderStatus')->getAttribute('title');
                OrderUpdated::dispatch(OrderUpdatedMessage::from([
                    'uuid' => $order->getAttribute('uuid'),
                    'status' => $status,
                    'updated_at' => $order->getAttribute('created_at'),
                ]));
            }
        });
    }

    /**
     * @var array<string, string> $casts
     * @inheritdoc
     */
    protected $casts = [
        'shipped_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\OrderStatus,\App\Models\Order>
     */
    public function orderStatus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Payment, \App\Models\Order>
     */
    public function payment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
