<?php

return  [
  //==================================== Translations ====================================//
  'agenda' => [
    'title'    => 'Agenda',
    'subtitle' => 'List bieżących rezerwacji',
  ],
  'business' => [
    'btn' => [
      'tooltip' => [
        'agenda'         => 'Rezerwacje',
        'contacts'       => 'Lista kontaktowa',
        'humanresources' => 'Lekarze',
        'services'       => 'Zarządzaj usługami',
        'vacancies'      => 'Opublikuj',
      ],
    ],
    'hint' => [
      'out_of_vacancies' => 'Opublikuj swoją dostępność <br> <br> Aby klienci zaczęli przyjmować rezerwacje, musisz opublikować swoją dostępność.',
      'set_services'     => 'Dodaj oferowane usługi',
    ],
    'service' => [
      'msg' => [
        'update' => [
          'success' => 'Usługa zaktualizowana!',
        ],
      ],
    ],
  ],
  'businesses' => [
    'btn' => [
      'store'  => 'Rejestracja',
      'update' => 'Aktualizacja',
    ],
    'check' => [
      'remember_vacancies'  => 'Zapamiętaj te ustawienia jako domyślne',
      'unpublish_vacancies' => 'Zmień moją aktualną dostępność przed publikacją',
    ],
    'contacts' => [
      'btn' => [
        'create' => 'Dodaj kontakt',
        'import' => 'Importuj kontakty',
      ],
    ],
    'create' => [
      'title' => 'Zarejestruj swój biznes',
    ],
    'notifications' => [
      'title' => 'Notifikacje',
      'help' => 'Wszytsko co się wydarzyło',
    ],
    'dashboard' => [
      'alert' => [
        'no_services_set'  => 'Wciąż nie ma dodanej usługi. Dodaj z tego miejsca!',
        'no_vacancies_set' => 'Nie opublikowałeś jeszcze swojej dostępności. Zrób to stąd!',
      ],
      'panel' => [
        'title_appointments_active_tomorrow'    => 'Spotkanie Umówione na Jutro',
        'title_appointments_active'    => 'Spotkanie Umówione Dzisiaj',
        'title_appointments_canceled'  => 'Spotkanie Anulowane',
        'title_appointments_served'    => 'Spotkanie Zapisane',
        'title_appointments_today'     => 'Dzisiaj',
        'title_appointments_tomorrow'  => 'Jutro',
        'title_appointments_total'     => 'Wszytskie Spotkania',
        'title_contacts_subscribed'    => 'Subskrybenci',
        'title_contacts_registered'    => 'Kontakty Zarejestrowane',
        'title_total'                  => 'Razem',
      ],
      'title' => 'Pulpit',
    ],
    'edit' => [
      'title' => 'Edycja profilu biznesu',
    ],
    'form' => [
      'category' => [
        'label' => 'Branża',
      ],
      'description' => [
        'label'       => 'Opisz siebie',
        'placeholder' => 'Opisz swoją firmę i świadczone usługi',
      ],
      'name' => [
        'label'       => 'Nazwa',
        'placeholder' => 'Komercyjna nazwa',
        'validation'  => 'Nazwa jest wymagana',
      ],
      'link' => [
        'label'       => 'Link',
        'placeholder' => 'Link do twojej strony domowej',
        'validation'  => 'Twój link do strony domowej jest niepoprawny',
      ],
      'phone' => [
        'label'       => 'Tel kom.',
        'placeholder' => 'numer twojego telefonu komórkowego',
      ],
      'postal_address' => [
        'label'       => 'Adres',
        'placeholder' => 'nazwa ulicy i numer, obszar, miasto, kraj',
      ],
      'social_facebook' => [
        'label'       => 'Facebook Page',
        'placeholder' => 'https://www.facebook.com/medcal.pl',
      ],
      'timezone' => [
        'label' => 'Timezone',
      ],
      'slug' => [
        'label'       => 'Alias',
        'placeholder' => 'to będzie twój URL',
        'validation'  => 'Alias jest wymagany',
      ],
    ],
    'index' => [
      'help' => 'Stąd możesz zarządzać wszystkimi swoimi firmami',
      'msg'  => [
        'no_appointments' => 'Obecnie nie ma aktywnych spotkań',
      ],
      'register_business_help' => 'Jeśli jesteś usługodawcą i chcesz dokonać rezerwacji online, to jest Twoja szansa!',
      'title'                  => 'Mój biznes',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Usunięto firmę',
      ],
      'index' => [
        'only_one_found' => 'Zarejestrowano tylko jedną firmę. Tutaj twój pulpit.',
      ],
      'preferences' => [
        'success' => 'Pomyślnie zaktualizowano ustawienia!',
      ],
      'register' => 'Wspaniale! Zamierzamy zarejestrować twoją firmę z pomocą: planu planu',
      'store'    => [
        'business_already_exists' => 'Firma jest już zarejestrowana',
        'success'                 => 'Biznes pomyślnie zarejestrowany',
      ],
      'update' => [
        'success' => 'Zaktualizowane dane biznesowe',
      ],
    ],
    'notifications' => [
      'help'  => 'Wszytsko co się wydażyło',
      'title' => 'Notifikacje',
    ],
    'preferences' => [
      'instructions' => 'Tutaj możesz dostosować ustawienia biznesowe do swoich potrzeb.',
      'title'        => 'Preferencje biznesowe',
    ],
    'vacancies' => [
      'btn' => [
        'update' => 'Zaktualizuj dostępność',
      ],
    ],
  ],
  'contacts' => [
    'btn' => [
      'confirm_delete' => 'Jesteś pewnien, że chcesz usunąć kontakt?',
      'delete'         => 'Usuń',
      'edit'           => 'Edytuj',
      'store'          => 'Zapisz',
      'update'         => 'Aktualizuj',
      'close'          => 'Wyjdź',
      'delete_appo'    => 'Usuń Spotkanie',
      'progress' => 'trwa zapis...',          
        
    ],
      
    'search' => 'Wyszukaj kontakty',
      
    'create' => [
      'title' => 'Kontakty',
    ],
    'form' => [
      'birthdate' => [
        'label' => 'Data urodzin',
        'validation' => 'Data urodzin jest wymagana',
      ],
      'description' => [
        'label' => 'Opis',
      ],
      'email' => [
        'label' => 'Email',
      ],
      'firstname' => [
        'label'      => 'Imię',
        'validation' => 'Imię jest wymagane',
      ],
      'gender' => [
        'label' => 'Płeć',
        'validation' => 'Płeć jest wymagana',
        'female' => [
          'label' => 'Kobieta',
        ],
        'male'  => [
          'label' => 'Mężczyzna',
        ],
      ],
      'lastname' => [
        'label'      => 'Nazwisko',
        'validation' => 'Nazwisko jest wymagane',
      ],
      'mobile' => [
        'label' => 'Mobile',
        'validation' => 'Telefon jest wymagany',
      ],
      'nin' => [
        'label' => 'Pesel',
      ],
      'notes' => [
        'label' => 'Notes',
      ],
      'postal_address' => [
        'label'      => 'Adres pocztowy',
        'validation' => 'Adres pocztowy jest wymagany',
      ],
      'prerequisites' => [
        'label' => 'Wymagania wstępne',
      ],
    ],
    'label' => [
      'birthdate'      => 'Data urodzin',
      'email'          => 'Email',
      'member_since'   => 'Zapisany od kiedy',
      'mobile'         => 'Tel kom.',
      'nin'            => 'Pesel',
      'notes'          => 'Notes',
      'postal_address' => 'Adres',
    ],
    'list' => [
      'btn' => [
        'filter' => 'Filter',
      ],
      'header' => [
        'email'     => 'Email',
        'firstname' => 'Imię',
        'lastname'  => 'Nazwisko',
        'mobile'    => 'Tel kom.',
        'username'  => 'Nazwa użytkownika',
      ],
      'msg' => [
        'filter_no_results' => 'Poszukaj, może coś znajdziesz :)',
      ],
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Kontakt usunięty!',
      ],
      'store' => [
        'success'                          => 'Kontakt został pomyślnie zarejestrowany!',
        'warning_showing_existing_contact' => 'Porada: Znaleźliśmy istniejący kontakt',
      ],
      'update' => [
        'success' => 'Aktualizacja udana',
      ],
    ],
    'title' => 'Kontakty',
  ],
  'humanresource' => [
    'btn' => [
      'create' => 'Dodaj',
      'delete' => 'Usuń',
      'store'  => 'Zapisz',
      'update' => 'Aktualizuj',
    ],
    'create' => [
      'title'        => 'Dodaj Specjalistów',
      'subtitle'     => 'Kto będzie świadczył usługi',
      'instructions' => 'Dodaj specjalistę, który zapewni realizację usługi',
    ],
    'edit' => [
      'title'        => 'Edycja',
      'subtitle'     => 'Info',
      'instructions' => 'Edycja informacji o specjaliście',
    ],
    'index' => [
      'title'        => 'Specjaliści',
      'subtitle'     => 'Lista',
      'instructions' => 'Lista specjalistów',
    ],
    'show' => [
      'title'        => 'Specjaliści',
      'subtitle'     => 'Info',
      'instructions' => 'Informacja o specjalistach',
    ],
    'alert' => 'Wybierz specjalistę',
    'form' => [
      'calendar_link' => [
        'label' => 'Link kalendarza',
      ],
      'capacity' => [
        'label' => 'Ilość',
      ],
      'name' => [
        'label' => 'Nazwa',
      ],
    ],
  ],
  'humanresources' => [
    'msg' => [
      'destroy' => [
        'success' => 'Dane specjalisty usunięte',
      ],
      'store' => [
        'success' => 'Dane specjalisty dodane',
      ],
      'update' => [
        'success' => 'Dane zaktualizowane',
      ],
    ],
  ],
  'service' => [
    'btn' => [
      'delete' => 'Usuń',
      'update' => 'Aktualizuj',
    ],
    'form' => [
      'color' => [
        'label' => 'Kolor',
      ],
      'duration' => [
        'label' => 'Okres trwania w minutach',
      ],
      'name' => [
        'label' => 'Nazwa usługi',
      ],
      'servicetype' => [
        'label' => 'Rodzaj usługi',
      ],
    ],
    'msg' => [
      'store' => [
        'success' => 'Usługa zapisana!',
      ],
    ],
  ],
  'services' => [
    'btn' => [
      'create' => 'Dodaj usługę',
      'store'  => 'Zapisz',
    ],
    'create' => [
      'alert' => [
        'go_to_vacancies' => 'Świetnie! Teraz możesz opublikować swoją dostępność.',
      ],
      'btn' => [
        'go_to_vacancies' => 'Ustaw i opublikuj swoją dostępność',
      ],
      'instructions' => 'Podaj nazwę swojej usługi, szeroki opis, aby pomóc klientom zapoznać się z nim. Dodaj wszelkie instrukcje dla swoich klientów, zanim dotrą na spotkanie.',
      'title'        => 'Dodaj usługę',
    ],
    'edit' => [
      'title' => 'Edycja usługi',
    ],
    'index' => [
      'instructions' => 'Dodaj tyle usług ile posiadasz i ustaw dostępność dla każdego z nich.',
      'title'        => 'Usługi',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Usługa usunięta!',
      ],
    ],
  ],
  'vacancies' => [
    'edit' => [
      'instructions' => 'Wpisz ilość dla każdej usługi na każdy dzień. To znaczy, ile spotkań możesz podjąć dla każdej usługi w ciągu jednego dnia?',
      'title'        => 'Dostępność',
    ],
    'msg' => [
      'edit' => [
        'no_services' => 'Brak zarejestrowanych usług. Zarejestruj usługi dla swojej firmy.',
      ],
      'store' => [
        'nothing_changed' => 'Musisz wskazać swoją dostępność co najmniej na jedną datę',
        'success'         => 'Dostępność zarejestrowana pomyślnie!',
      ],
    ],
    'table' => [
      'th' => [
        'date' => 'Data',
      ],
    ],
  ],
  'calendar'=>[
      'modals' => [
          'title'=>'Umów spotkanie',
          'title2' => 'Spotkanie'
          ]
      ],
];
