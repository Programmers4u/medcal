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
    'sms_self_number' => [
      'format' => 'Cyfry',
      'help'   => 'Twoj identyfikator urządzenia w systemie gatesms',
      'label'  => 'Id urządzenia sms',
    ],
    'sms_message' => [
      'format' => 'Przyk.: Informujemy o zapisie wizyty dla pacjenta %client% w gabinecie %name% o %hour% dnia %day%. Jesli to mozliwe, prosimy o potwierdzenie.',
      'help'   => 'Dodaj wiadomość od %name% .... z parametrami %day%, %hour%',
      'label'  => 'Wiadomość sms',
    ],
    'sms_message1' => [
      'format' => 'Przyk.: Informujemy o jutrzejszej wizycie pacjenta %client% w gabinecie %name% o %hour% dnia %day%. Jesli to mozliwe, prosimy o potwierdzenie.',
      'help'   => 'Dodaj wiadomość od %name% .... z parametrami %day%, %hour%',
      'label'  => 'Wiadomość sms, przypomnienie',
    ],
    'sms_message2' => [
      'format' => 'Przyk.: Informujemy o wizycie kontrolnej pacjenta %client% w gabinecie %name% dnia %day% o godz. %hour%. Jesli to mozliwe, prosimy o potwierdzenie',
      'help'   => 'Dodaj wiadomość od %name% .... z parametrami %day%, %hour%',
      'label'  => 'Wiadomość sms, wysyłane po 6 miesiącach',
    ],
    'sms_message3' => [
      'format' => 'Informujemy ze wizyta pacjenta %client% w dniu %day% %hour% w gabinecie %name% zostala anulowana.',
      'help'   => 'Dodaj wiadomość od %name% .... z parametrami %day%, %hour%',
      'label'  => 'Wiadomość sms, wysyłane w momencie anulowania',
    ],
    'sms_message4' => [
      'format' => 'Informujemy ze wizyta pacjenta %client% w gabinecie %name% zostala zmieniona. Nowy termin to %day% %hour% Jesli to mozliwe, prosimy o potwierdzenie',
      'help'   => 'Dodaj wiadomość od %name% .... z parametrami %day%, %hour%',
      'label'  => 'Wiadomość sms, wysyłane w momencie zmiany spotkania',
    ],      
    'sms_message5' => [
      'format' => 'Potwierdzamy wizyte pacjenta %client% w gabinecie %name% dnia %day% %hour%.',
      'help'   => 'Dodaj wiadomość od %name% .... z parametrami %day%, %hour%',
      'label'  => 'Wiadomość sms, wysyłane po potwierdzeniu spotkania',
    ],      
    'appointment_cancellation_pre_hs' => [
      'format' => 'Liczba godzin',
      'help'   => 'Czas po którym anulowania rezerwacji nie będą przyjmowane.',
      'label'  => 'Anulowanie rezerwacji',
    ],
    'appointment_code_length' => [
      'format' => 'Liczba znaków',
      'help'   => 'Ilość znaków kodu rezerwacji',
      'label'  => 'Długość kodu rezerwacji',
    ],
    'appointment_take_today' => [
      'format' => 'Number of hours',
      'help'   => 'Permit booking on the same day the reservation takes place',
      'label'  => 'Zezwól na rezerwację tego samego dnia',
    ],
    'show_map' => [
      'format' => 'Tak/Nie',
      'help'   => 'Opublikuj lokalizację na mapie (maisto)',
      'label'  => 'Publikacja Mapy',
    ],
    'show_phone' => [
      'format' => 'Tak/Nie',
      'help'   => 'Opublikuj numer telefonu',
      'label'  => 'Opublikuj numer telefonu',
    ],
    'show_postal_address' => [
      'format' => 'Yes/no',
      'help'   => 'Opublikuj pełny adres pocztowy',
      'label'  => 'Opublikuj adres pocztowy',
    ],
    'start_at' => [
      'format' => 'hh:mm:ss',
      'help'   => 'Godzina przyjmowania rezerwacji',
      'label'  => 'Godzina otwarcia',
    ],
    'cancellation_policy_advice' => [
      'format' => 'example: You may annulate this appointment charge-free until %s',
      'help'   => 'Write an advice text your clients will see about your appointment cancellation policy',
      'label'  => 'Tekst porady dotyczącej zasad anulowania',
    ],
    'appointment_flexible_arrival' => [
      'format' => 'Tak/Nie',
      'help'   => 'Let clients arrive anytime during service time',
      'label'  => 'Elastyczne terminy według kolejności przyjazdu',
    ],
    'finish_at' => [
      'format' => 'hh:mm:ss',
      'help'   => 'The time your business closes for receiving appointments',
      'label'  => 'Godzina zamknięcia',
    ],
    'service_default_duration' => [
      'format' => 'przykład: 30',
      'help'   => 'Minimalna długośc wizyty',
      'label'  => 'Podstawowa długośc wizyty (minuty)',
    ],
    'vacancy_edit_advanced_mode' => [
      'format' => 'Tak/Nie',
      'help'   => 'Use advanced mode to publish vacancies',
      'label'  => 'Użyj trybu zaawansowanego, aby publikować dostępne terminy',
    ],
    'time_format' => [
      'format' => 'H:i a',
      'help'   => 'Time format to display time',
      'label'  => 'Format godziny',
    ],
    'date_format' => [
      'format' => 'Y-m-d',
      'help'   => 'Date format to display dates',
      'label'  => 'Format daty',
    ],
    'timeslot_step' => [
      'format' => 'Number',
      'help'   => 'Number of minutes to step for booking availability',
      'label'  => 'Minimalny odstęp czasowy na kalenadrzu (min)',
    ],
    'availability_future_days' => [
      'format' => 'Number',
      'help'   => 'Number of days to show for booking availability',
      'label'  => 'Dostępność w przyszłych dniach',
    ],
    'report_daily_schedule' => [
      'format' => 'Tak/Nie',
      'help'   => 'I want to receive a daily email with active appointments',
      'label'  => 'Włącz codzienny harmonogram e-mail',
    ],
    'vacancy_autopublish' => [
      'format' => 'Tak/Nie',
      'help'   => 'Let timegrid autopublish my vacancies weekly (every sunday)',
      'label'  => 'Włącz autopublikowanie wolnych miejsc pracy',
    ],
    'allow_guest_registration' => [
      'format' => 'Tak/Nie',
      'help'   => 'Let guest users to register on your addressbook through reserving an appointment',
      'label'  => 'Zezwalaj użytkownikom-gościom na rezerwowanie spotkań',
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
