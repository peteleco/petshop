<?php

use App\Models\OrderStatus;
use Illuminate\Support\Facades\Event;
use Peteleco\Notifier\Events\OrderUpdated;
use Peteleco\Notifier\Listeners\SendOrderUpdatedNotification;

it('fires order created message event', function () {
    Event::fake([
        OrderUpdated::class
    ]);
    $order = \App\Models\Order::factory()->create();
    $orderStatus = $order->load('orderStatus')->orderStatus;
    Event::assertDispatched(function (OrderUpdated $event) use ($order, $orderStatus) {
        return $event->message->uuid === $order->getAttribute('uuid')
            && $event->message->status === $orderStatus->getAttribute('title');
        ;
    });
    Event::assertListening(
        OrderUpdated::class,
        SendOrderUpdatedNotification::class
    );
});

it('fires order updated message event', function () {
    Event::fake([
        OrderUpdated::class
    ]);
    $order = \App\Models\Order::factory()->create();
    $orderStatusProcessing = OrderStatus::query()->where('title', 'like', '%Processing%')->limit(1)->get()->first();

    $order->setAttribute('order_status_id', $orderStatusProcessing->getKey());
    $order->save();
    Event::assertDispatched(function (OrderUpdated $event) use ($order, $orderStatusProcessing) {
        return $event->message->uuid === $order->getAttribute('uuid')
            && $event->message->status === $orderStatusProcessing->getAttribute('title');
    });
    Event::assertListening(
        OrderUpdated::class,
        SendOrderUpdatedNotification::class
    );
});

it('fires for real order updated message event', function () {
    $order = \App\Models\Order::factory()->create();
    $orderStatusProcessing = OrderStatus::query()->where('title', 'like', '%Processing%')->limit(1)->get()->first();

    $order->setAttribute('order_status_id', $orderStatusProcessing->getKey());
    $order->save();
    expect($order->isClean())->toBeTrue();
});
