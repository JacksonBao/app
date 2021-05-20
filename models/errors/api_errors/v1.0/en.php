<?php 

return [
    'authenticate' => [
        'invalid' => 'dfasda'
    ],
    'convert' => [
        'invalid_from' => 'Invalid from currency code.',
        'invalid_to' => 'Invalid to currency code.',
        'invalid_amount' => 'Invalid amount',
        'invalid_currency' => 'Invalid currency code.',
    ],
    'rates' => [
        'invalid_base' => 'Invalid base currency.',
        'invalid_date' => 'Invalid date.',
        'base_unavailable' => 'No base record found for {base} today. Base records will be available in 2 minuites.',
        'invalid_rates' => 'Invalid rate list.',
        'rate_limit' => 'The maximum number of rates allowed is 20 currencies.'
    ],
    'usage' => [
        'invalid_request' => 'Invalid usage request.',
        'invalid_order' => 'Invalid order. Only ASC and DESC allowed.',
        'no_results' => 'Could not find any request for the specified time frame.'
    ]
];