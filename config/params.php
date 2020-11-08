<?php

return 
[
    'maskMoneyOptions' => 
    [
        'prefix' => 'R$ ',
        'affixesStay' => true,
        'thousands' => '.',
        'decimal' => ',',
        'precision' => 2, 
        'allowZero' => TRUE,
        'allowNegative' => TRUE,
    ],
    'maskedInputOptions' =>
    [
        'alias' => 'numeric',
        'digits' => 3,
        'groupSeparator' => '.',
        'autoGroup' => false,
        'autoUnmask' => true,
        'unmaskAsNumber' => true,
    ],
    'maintenance' => FALSE,
    'dontSaveLog' => FALSE
];