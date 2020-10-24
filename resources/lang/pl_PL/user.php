<?php

return  [
  //============================== New strings to translate ==============================//
  'booking' => [
    'msg' => [
      'validate' => [
        'error' => [
          'bad-code'                              => 'Sorry, invalid appointment code',
          'no-appointment-was-found'              => 'Sorry, no appointments were found with that code',
        ],
        'success' => [
          'your-appointment-is-already-confirmed' => 'Cool, your appointment is already confirmed',
          'your-appointment-was-confirmed'        => 'You confirmed your appointment successfully',
        ],
      ],
      'store' => [
        'error'            => 'Sorry, there is no longer availability for the attempted reservation.',
        'not-registered'   => 'You need to be listed on the contractor\'s addressbook in order to make a guest reservation.',
        'sorry_duplicated' => 'Sorry, your appointment is duplicated with :code reserved before',
        'success'          => 'Success! Your appointment was registered with code :code',
      ],
      'you_are_not_subscribed_to_business' => 'To be able to do a reservation you must subscribe the business first',
    ],
  ],
  //==================================== Translations ====================================//
  'appointments' => [
    'alert' => [
      'book_in_biz_on_behalf_of' => 'Book appointment for :contact at :biz',
      'empty_list'               => 'You have no ongoing reservations.',
      'no_vacancies'             => 'Sorry, the business cannot take any reservations now.',
    ],
    'btn' => [
      'book'                     => 'Book appointment',
      'book_in_biz'              => 'Book appointment for :biz',
      'book_in_biz_on_behalf_of' => 'Book appointment for :contact at :biz',
      'calendar'                 => 'Zobacz Kalendarz',
      'confirm_booking'          => 'Potwierdź rezerwację spotkania',
      'more_dates'               => 'Sprawdź więcej dat',
    ],
    'form' => [
      'btn' => [
        'submit' => 'Potwierdź',
      ],
      'comments' => [
        'label' => 'Would you like to leave any comments for the provider?',
      ],
      'date' => [
        'label' => 'Data',
      ],
      'email' => [
        'label' => 'Twój email',
      ],
      'service' => [
        'label' => 'Usługa',
      ],
      'time' => [
        'label' => 'What time would you like to book?',
      ],
      'timetable' => [
        'instructions' => 'Select a service to reserve',
        'msg'          => [
          'no_vacancies' => 'There is no availability for this date',
        ],
        'title' => 'Reserve appointment at :business',
      ],
    ],
    'index' => [
      'th' => [
        'business'    => 'Biznes',
        'calendar'    => 'Data',
        'code'        => 'Kod',
        'contact'     => 'Pacjent',
        'duration'    => 'Okres',
        'finish_time' => 'koniec',
        'remaining'   => 'Długość',
        'service'     => 'Usługa',
        'start_time'  => 'Początek',
        'status'      => 'Status',
      ],
      'title' => 'Spotkania',
    ],
  ],
  'business' => [
    'btn' => [
      'subscribe_to' => 'Subscribe to :business',
    ],
  ],
  'businesses' => [
    'index' => [
      'btn' => [
        'create'       => 'Register business',
        'manage'       => 'My businesses',
        'power_create' => 'Register now',
      ],
      'title' => 'Available businesses',
    ],
    'list' => [
      'no_businesses' => 'No businesses available.',
    ],
    'subscriptions' => [
      'none_found' => 'No subscriptions available.',
      'title'      => 'Subscriptions',
    ],
  ],
  'profile' => [
    'button' => 'Profil',
  ],
  'contacts' => [
    'btn' => [
      'store'  => 'Save',
      'update' => 'Update',
      'createprofil' => 'Utwórz profil publiczny',
    ],
    'create' => [
      'help'  => 'Well done! You are about to go. Fill your contact profile for the first time so your reservation is handled accordingly. You will be able to change this info per business if you want to.',
      'title' => 'My profile',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Deleted successfully',
      ],
      'store' => [
        'associated_existing_contact' => 'Your profile was attached to an existing one',
        'success'                     => 'Successfully saved',
        'warning'                     => [
          'already_registered' => 'This profile was already registered',
        ],
      ],
      'update' => [
        'success' => 'Updated successfully',
      ],
    ],
  ],
  'dashboard' => [
    'card' => [
      'agenda' => [
        'button'      => 'See Agenda',
        'description' => 'Check out your current reservation.|[2,Inf] Check out your current reservations.',
        'title'       => 'One appointment|[2,Inf] Your appointments',
      ],
      'directory' => [
        'button'      => 'Browse Directory',
        'description' => 'Browse the directory and book your service.',
        'title'       => 'Directory',
      ],
      'subscriptions' => [
        'button'      => 'See Subscriptions',
        'description' => 'Manage your subscriptions to businesses.',
        'title'       => 'Subscriptions',
      ],
    ],
  ],
  'msg' => [
    'preferences' => [
      'success' => 'Twoje ustawienia zostały zapisane.',
    ],
  ],
  'preferences' => [
    'title' => 'Moje Ustawienia',
  ],
  'go_to_business_dashboard' => 'Idź do :business\'s dashboard',
];
