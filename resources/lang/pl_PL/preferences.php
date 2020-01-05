<?php

return  [
  'App\\Models\\User' => [
    'timezone' => [
      'label' => 'Strefa czasowa',
    ],
  ],
  'App\\Models\\Business' => [
    'sms_id' => [
      'format' => 'Dowolne znaki',
      'help'   => 'Twój login do systemu sms',
      'label'  => 'Login sms',
    ],
    'sms_secret' => [
      'format' => 'Dowolne znaki',
      'help'   => 'Twoje hasło do systemu sms',
      'label'  => 'Hasło sms',
    ],
    'sms_message' => [
      'format' => 'Przyk.: Informujemy o wizycie pacjenta %client% w gabinecie %name% o %hour% dnia %day%. Jesli to mozliwe, prosimy o potwierdzenie pod nr .....',
      'help'   => 'Dodaj wiadomość od %name% .... z parametrami %day%, %hour%',
      'label'  => 'Wiadomość sms',
    ],
    'sms_message1' => [
      'format' => 'Przyk.: Informujemy o jutrzejszej wizycie pacjenta %client% w gabinecie %name% o %hour% dnia %day%. Jesli to mozliwe, prosimy o potwierdzenie pod nr .....',
      'help'   => 'Dodaj wiadomość od %name% .... z parametrami %day%, %hour%',
      'label'  => 'Wiadomość sms, przypomnienie',
    ],
    'sms_message2' => [
      'format' => 'Przyk.: Informujemy o wizycie kontrolnej pacjenta %client% w gabinecie %name%. Jesli to mozliwe, prosimy o potwierdzenie pod nr .....',
      'help'   => 'Dodaj wiadomość od %name% .... z parametrami %day%, %hour%',
      'label'  => 'Wiadomość sms, wysyłane po 6 miesiącach',
    ],
      
    'appointment_cancellation_pre_hs' => [
      'format' => 'Liczba godzin',
      'help'   => 'Number of hours in advance for which an appointment can be canceled',
      'label'  => 'Appointment Cancellation Anticipation',
    ],
    'appointment_code_length' => [
      'format' => 'Number of characters',
      'help'   => 'Number of characters an appointment code is identified with',
      'label'  => 'Appointment Code Length',
    ],
    'appointment_take_today' => [
      'format' => 'Number of hours',
      'help'   => 'Permit booking on the same day the reservation takes place',
      'label'  => 'Permit booking on same day',
    ],
    'show_map' => [
      'format' => 'Tak/Nie',
      'help'   => 'Publish the map of your location (city level)',
      'label'  => 'Publish Map',
    ],
    'show_phone' => [
      'format' => 'Yes/No',
      'help'   => 'Publish your phone in business profile',
      'label'  => 'Publish Phone',
    ],
    'show_postal_address' => [
      'format' => 'Yes/no',
      'help'   => 'Publish full postal address',
      'label'  => 'Publish Postal Address',
    ],
    'start_at' => [
      'format' => 'hh:mm:ss',
      'help'   => 'The time your business opens for receiving appointments',
      'label'  => 'Opening Hour',
    ],
    'cancellation_policy_advice' => [
      'format' => 'example: You may annulate this appointment charge-free until %s',
      'help'   => 'Write an advice text your clients will see about your appointment cancellation policy',
      'label'  => 'Cancellation Policy Advice Text',
    ],
    'appointment_flexible_arrival' => [
      'format' => 'Yes/No',
      'help'   => 'Let clients arrive anytime during service time',
      'label'  => 'Flexible appointments by arrival time order',
    ],
    'finish_at' => [
      'format' => 'hh:mm:ss',
      'help'   => 'The time your business closes for receiving appointments',
      'label'  => 'Closing Hour',
    ],
    'service_default_duration' => [
      'format' => 'example: 30',
      'help'   => 'The default duration of any service you provide',
      'label'  => 'Default service duration (minutes)',
    ],
    'vacancy_edit_advanced_mode' => [
      'format' => 'Yes/No',
      'help'   => 'Use advanced mode to publish vacancies',
      'label'  => 'Use advanced mode to publish vacancies',
    ],
    'time_format' => [
      'format' => 'H:i a',
      'help'   => 'Time format to display time',
      'label'  => 'Time Format',
    ],
    'date_format' => [
      'format' => 'Y-m-d',
      'help'   => 'Date format to display dates',
      'label'  => 'Date Format',
    ],
    'timeslot_step' => [
      'format' => 'Number',
      'help'   => 'Number of minutes to step for booking availability',
      'label'  => 'Timeslot step',
    ],
    'availability_future_days' => [
      'format' => 'Number',
      'help'   => 'Number of days to show for booking availability',
      'label'  => 'Availability future days',
    ],
    'report_daily_schedule' => [
      'format' => 'Yes/No',
      'help'   => 'I want to receive a daily email with active appointments',
      'label'  => 'Enable Daily Schedule Email',
    ],
    'vacancy_autopublish' => [
      'format' => 'Yes/No',
      'help'   => 'Let timegrid autopublish my vacancies weekly (every sunday)',
      'label'  => 'Enable Vacancy Autopublish',
    ],
    'allow_guest_registration' => [
      'format' => 'Yes/No',
      'help'   => 'Let guest users to register on your addressbook through reserving an appointment',
      'label'  => 'Allow guest users to reserve appointments',
    ],
    'disable_outbound_mailing' => [
      'format' => 'Tak/Nie',
      'help'   => 'Zabezpieczenie przed wysłaniem mail-a i sms-a',
      'label'  => 'Wyłącz wysyłanie wiadomości',
    ],
  ],
  'controls' => [
    'select' => [
      'no'  => 'Nie',
      'yes' => 'Tak',
    ],
  ],
];
