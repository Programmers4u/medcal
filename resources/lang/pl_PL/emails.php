<?php

return [
    'root'    => [
        'report' => [
            'subject' => 'Root Report',
        ],
    ],
    'manager' => [
        'business-report' => [
            'subject'      => 'Schedule report of :date at :businessName',
            'welcome'      => 'Hi :ownerName',
            'button'       => 'View Calendar',
        ],
        'appointment-notification' => [
            'subject'      => 'You have a new appointment',
            'welcome'      => ':ownerName, you have a new appointment',
            'instructions' => 'A new appointment was reserved',
            'title'        => 'Appointment Details',
        ],
    ],
    'user'    => [
        'welcome' => [
            'subject'              => 'Witamy w MedCal.pl',
            'hello-title'          => 'Cześć :userName',
            'hello-paragraph'      => 'MedCal pomaga optymalnie zaplanować czas abyś mógł(a) skupić się na swojej profesji.',
            'quickstart-title'     => 'Jesteś gotowy do pracy?',
            'quickstart-paragraph' => 'Wystarczy wejść do programu w dowolnym momencie i dokonać rezerwacji.',
            'button' => 'Miłej pracy :)',
        ],
        'appointment-notification' => [
            'subject'              => 'Szczegóły Twojego nowego spotkania',
            'hello-title'          => ':userName, umówiłeś się na nowy termin',
            'hello-paragraph'      => 'Twoja rezerwacja spotkania została podjęta.',
            'appointment-title'    => 'Oto szczegóły twojego spotkania',
            'button'               => 'Zobacz moją agendę',
        ],
        'appointment-confirmation' => [
            'subject'              => 'Twoje spotkanie w :businessName zostało potwierdzone.',
            'hello-title'          => 'Cześć :userName,',
            'hello-paragraph'      => 'Twoje spotkanie zostało potwierdzone.',
            'appointment-title'    => 'Oto szczegóły twojego spotkania',
            'button'               => 'Zobacz moją agendę',
        ],
        'appointment-cancellation' => [
            'subject'              => 'Twoje spotkanie w :businessName zostało skasowane',
            'hello-title'          => 'Cześć :userName,',
            'hello-paragraph'      => 'Przepraszamy, twoje spotkanie zostało anulowane.',
            'appointment-title'    => 'Oto szczegóły anulowanage spotkania.',
            'button'               => 'Zobacz moją agendę',
        ],
    ],
    'guest'   => [
        'password' => [
            'subject'      => 'Zresetowanie hasła',
            'hello'        => 'Cześć :userName,',
            'instructions' => 'Wystarczy kliknąć przycisk resetowania hasła i zresetować hasło.',
            'button'       => 'Zresetuj moje hasło.',
        ],
        'appointment-validation' => [
            'subject'            => 'Potwierdź swoją rezerwację',
            'hello-title'        => 'Zatwierdź spotkanie',
            'hello-paragraph'    => 'Dokonałe(a)ś rezerwacji gościa, która wymaga potwierdzenia. Jeśli nie potwierdzisz, wygaśnie automatycznie.',
            'appointment-title'  => 'Szczegóły rezerwacji',
            'button'             => 'Zatwierdź termin',
        ],
    ],
    'text'  => [
        'business'          => 'Business',
        'user'              => 'Użytkownik',
        'date'              => 'Data',
        'time'              => 'Czas',
        'code'              => 'Kod',
        'where'             => 'Gdzie',
        'phone'             => 'Telefon',
        'service'           => 'Usługa',
        'important'         => 'ważne',
        'customer_notes'    => 'Uwagi klienta',
        'there_are'         => 'Tam są',
        'registered'        => 'dotychczas zarejestrowani użytkownicy',
    ],
];
