<?php

return [
    'hooks' => [
        'orders' => [
            'updated' => env('NOTIFIER_HOOKS_ORDERS_UPDATED', 'https://webhook.site/bb7586cd-24cb-4336-b648-ceb4fd9c6609'),
            'queue' => env('NOTIFIER_HOOKS_ORDERS_queue', 'default'),
        ],
    ],
];
