<?php

/**
 * System administrator related.
 */
return [

    'app' => [
        'name' => env('SYSLOG_APPNAME', 'default.yc'),
        'allow_register' => (bool) env('ALLOW_REGISTER', true),
    ],

    'docs_url' => 
    [
        'en' => env('DOCS_URL_EN', 'http://med.programmers4u.eu/docs/en/user-manual/'),
        'es' => env('DOCS_URL_ES', 'http://med.programmers4u.eu/docs/es/manual-de-usuario/'),
    ],

    'report' => [
        'from_address'       => env('MAIL_FROM_ADDRESS', 'root@localhost'),
        'to_mail'            => env('ROOT_REPORT_MAIL', 'root@localhost'),
        'time'               => env('ROOT_REPORT_TIME', '20:00'),
        'exceptions_subject' => '[ROOT] Exception Report',
    ],

    'vacancy_edit_days' => env('DEFAULT_VACANCY_EDIT_DAYS_QUANTITY', 30),

    'time' => [
        'format' => env('DISPLAY_TIME_FORMAT', 'h:i A'),
    ],
];
