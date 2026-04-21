<?php

return [
    'merchant_name' => env('DONATION_MERCHANT_NAME', 'OF "Eurasian Public Foundation INDUSTRY OF SOCIAL DEVELOPMENT"'),
    'merchant_inn' => env('DONATION_MERCHANT_INN', '12345678901234'),
    'bank_name' => env('DONATION_BANK_NAME', 'OJSC Demo Bank Kyrgyzstan'),
    'bank_bic' => env('DONATION_BANK_BIC', 'DEMOKG22'),
    'account_kgs' => env('DONATION_ACCOUNT_KGS', 'KG12DEMO1234567890123456'),
    'payment_purpose' => env('DONATION_PAYMENT_PURPOSE', 'Charity donation / Благотворительный взнос'),
    'minimum_amount' => (int) env('DONATION_MINIMUM_AMOUNT', 100),
    'webhook_secret' => env('DONATION_WEBHOOK_SECRET', 'demo-webhook-secret'),
];
