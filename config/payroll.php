<?php

declare(strict_types=1);

return [
    'working_days' => 30,
    'allowances' => [
        [
            'name' => 'حق مسکن',
            'code' => 'ALW-HOUSING',
            'formula' => '15000000',
        ],
        [
            'name' => 'ایاب و ذهاب',
            'code' => 'ALW-TRANSPORT',
            'formula' => '4500000',
        ],
        [
            'name' => 'حق اولاد',
            'code' => 'ALW-CHILD',
            'formula' => 'daily_rate * work_days * 0.1',
        ],
        [
            'name' => 'پاداش عملکرد',
            'code' => 'ALW-BONUS',
            'formula' => 'base_salary * 0.2',
        ],
    ],
    'deductions' => [
        [
            'name' => 'مالیات حقوق',
            'code' => 'DED-TAX',
            'formula' => '(base_salary + 15000000 + 4500000) * 0.1',
        ],
        [
            'name' => 'بیمه تامین اجتماعی',
            'code' => 'DED-INSURANCE',
            'formula' => 'base_salary * 0.07',
        ],
        [
            'name' => 'بازپرداخت وام',
            'code' => 'DED-LOAN',
            'formula' => '5000000',
        ],
    ],
];
