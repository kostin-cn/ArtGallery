<?php
return [
    'adminEmail' => 'kostin.cn@gmail.com',
    'supportEmail' => 'smtp@otlr.net',
    'user.passwordResetTokenExpire' => 3600,

    'payMethods' => [
        'card' => Yii::t('app', 'Банковской картой'),
        'cash' => Yii::t('app', 'Наличными курьеру'),
    ],

    'languages' => [
        'ru' => 'RUS',
        'en' => 'ENG',
    ],
    'defaultLanguage' => 'ru',
    'cacheTime' => 1,
];
