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
      'help'   => 'Twój login do systemu sms u dostawcy GateSms',
      'label'  => 'Login sms',
    ],
    'sms_secret' => [
      'format' => 'Dowolne znaki',
      'help'   => 'Twoje hasło do systemu sms u dostawcy GateSms',
      'label'  => 'Hasło sms',
    ],
    'sms_self_number' => [
      'format' => 'Cyfry',
      'help'   => 'Twoj identyfikator urządzenia w systemie GateSms',
      'label'  => 'Id urządzenia sms',
    ],
    'sms_message' => [
      'format' => 'Informujemy o zapisie wizyty dla pacjenta %client% w gabinecie %name% o %hour% dnia %day%. Jesli to mozliwe, prosimy o potwierdzenie.',
      'help'   => 'Dodaj wiadomość wysyłaną w momencie rezerwacji od %name% .... z parametrami %day%, %hour%',
      'label'  => 'Wiadomość sms',
    ],
    'sms_message1' => [
      'format' => 'Informujemy o jutrzejszej wizycie pacjenta %client% w gabinecie %name% o %hour% dnia %day%. Jesli to mozliwe, prosimy o potwierdzenie.',
      'help'   => 'Dodaj wiadomość - przypomnienie wysyłaną dzień przed wizytą, od %name% .... z parametrami %day%, %hour%',
      'label'  => 'Wiadomość sms, przypomnienie',
    ],
    'sms_message2' => [
      'format' => 'Informujemy o wizycie kontrolnej pacjenta %client% w gabinecie %name% dnia %day% o godz. %hour%. Jesli to mozliwe, prosimy o potwierdzenie',
      'help'   => 'Dodaj wiadomość - przypomnienie wysyłane po 6 miesiącach od ostatniej wizyty: od %name% .... z parametrami %day%, %hour%',
      'label'  => 'Wiadomość sms, wysyłane po 6 miesiącach',
    ],
    'sms_message3' => [
      'format' => 'Informujemy ze wizyta pacjenta %client% w dniu %day% %hour% w gabinecie %name% zostala anulowana.',
      'help'   => 'Dodaj wiadomość wysyłaną w momencie anulowania wizyty: od %name% .... z parametrami %day%, %hour%',
      'label'  => 'Wiadomość sms, wysyłane w momencie anulowania',
    ],
    'sms_message4' => [
      'format' => 'Informujemy ze wizyta pacjenta %client% w gabinecie %name% zostala zmieniona. Nowy termin to %day% %hour% Jesli to mozliwe, prosimy o potwierdzenie',
      'help'   => 'Dodaj wiadomość wysyłaną w momencie zmiany daty wizyty: od %name% .... z parametrami %day%, %hour%',
      'label'  => 'Wiadomość sms, wysyłane w momencie zmiany spotkania',
    ],      
    'sms_message5' => [
      'format' => 'Potwierdzamy wizyte pacjenta %client% w gabinecie %name% dnia %day% %hour%.',
      'help'   => 'Dodaj wiadomość wysyłaną w momemncie potwierdzenia wizyty od %name% .... z parametrami %day%, %hour%',
      'label'  => 'Wiadomość sms, wysyłane po potwierdzeniu spotkania',
    ],      
    'appointment_cancellation_pre_hs' => [
      'format' => 'Liczba godzin',
      'help'   => 'Czas po którym anulowanie rezerwacji nie będą przyjmowane.',
      'label'  => 'Anulowanie rezerwacji',
    ],
    'appointment_code_length' => [
      'format' => 'Liczba znaków',
      'help'   => 'Ilość znaków kodu rezerwacji',
      'label'  => 'Długość kodu rezerwacji',
    ],
    'appointment_take_today' => [
      'format' => 'Number of hours',
      'help'   => 'Zezwolenie na rezerwację tego samego dnia, w którym następuje rezerwacja',
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
      'format' => 'przykład: Możesz anulować to spotkanie bez opłat do% s',
      'help'   => 'Napisz tekst z poradą, którą zobaczą Twoi klienci na temat polityki odwoływania wizyt',
      'label'  => 'Tekst porady dotyczącej zasad anulowania',
    ],
    'appointment_flexible_arrival' => [
      'format' => 'Tak/Nie',
      'help'   => 'Pozwól klientom dotrzeć w dowolnym momencie w czasie obsługi.',
      'label'  => 'Elastyczne terminy według kolejności przyjazdu',
    ],
    'finish_at' => [
      'format' => 'hh:mm:ss',
      'help'   => 'Godzina zamknięcia przyjmowania wizyt',
      'label'  => 'Godzina zamknięcia',
    ],
    'service_default_duration' => [
      'format' => 'przykład: 30',
      'help'   => 'Minimalna długośc wizyty',
      'label'  => 'Podstawowa długośc wizyty (minuty)',
    ],
    'vacancy_edit_advanced_mode' => [
      'format' => 'Tak/Nie',
      'help'   => 'Użyj trybu zaawansowanego, aby publikować oferty pracy',
      'label'  => 'Użyj trybu zaawansowanego, aby publikować dostępne terminy',
    ],
    'time_format' => [
      'format' => 'H:i a',
      'help'   => 'Format czasu do wyświetlania godziny',
      'label'  => 'Format godziny',
    ],
    'date_format' => [
      'format' => 'Y-m-d',
      'help'   => 'Format daty do wyświetlania dat',
      'label'  => 'Format daty',
    ],
    'timeslot_step' => [
      'format' => 'Number',
      'help'   => 'Liczba minut przerwy pomiędzy rezerwacjami',
      'label'  => 'Minimalny odstęp czasowy na kalenadrzu (min)',
    ],
    'availability_future_days' => [
      'format' => 'Number',
      'help'   => 'Liczba dni dostępności',
      'label'  => 'Dostępność w przyszłych dniach',
    ],
    'report_daily_schedule' => [
      'format' => 'Tak/Nie',
      'help'   => 'Chcę codziennie otrzymywać e-maile z umówionymi wizytami',
      'label'  => 'Włącz codzienny harmonogram e-mail',
    ],
    'vacancy_autopublish' => [
      'format' => 'Tak/Nie',
      'help'   => 'Pozwól autopublikować wolne terminy co tydzień (w każdą niedzielę)',
      'label'  => 'Włącz autopublikowanie wolnych terminów',
    ],
    'allow_guest_registration' => [
      'format' => 'Tak/Nie',
      'help'   => 'Pozwól użytkownikom - gościom zarejestrować się w Twojej książce adresowej poprzez rezerwację terminu',
      'label'  => 'Zezwalaj użytkownikom - gościom na rezerwowanie spotkań',
    ],
    'disable_outbound_mailing' => [
      'format' => 'Tak/Nie',
      'help'   => 'Wyłącz lub włącz zabezpieczenie przed wysłaniem wiadomości mail i sms',
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
