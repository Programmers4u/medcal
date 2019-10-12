<?php

return  [
  //==================================== Translations ====================================//
  'agenda' => [
    'title'    => 'Agenda',
    'subtitle' => 'List of the standing reservations',
  ],
  'business' => [
    'btn' => [
      'tooltip' => [
        'agenda'         => 'Reservations schedule',
        'contacts'       => 'Contact list',
        'humanresources' => 'Staff',
        'services'       => 'Manage services',
        'vacancies'      => 'Publish availability',
      ],
    ],
    'hint' => [
      'out_of_vacancies' => 'Publish your availability<br><br>For clients to begin taking reservations you need to publish your availability.',
      'set_services'     => 'Add the services you provide',
    ],
    'service' => [
      'msg' => [
        'update' => [
          'success' => 'Service updated!',
        ],
      ],
    ],
  ],
  'businesses' => [
    'btn' => [
      'store'  => 'Register',
      'update' => 'Update',
    ],
    'check' => [
      'remember_vacancies'  => 'Remember these vacancies as default',
      'unpublish_vacancies' => 'Reset my current availability before publishing',
    ],
    'contacts' => [
      'btn' => [
        'create' => 'Add a contact',
      ],
    ],
    'create' => [
      'title' => 'Register your business',
    ],
    'notifications' => [
      'title' => 'Notifications',
      'help' => 'All what happened recently',
    ],
    'dashboard' => [
      'alert' => [
        'no_services_set'  => 'There are still no services added. Add them from here!',
        'no_vacancies_set' => 'You haven\'t yet published your availability. Do it from here!',
      ],
      'panel' => [
        'title_appointments_active'    => 'Appointments Active',
        'title_appointments_canceled'  => 'Appointments Canceled',
        'title_appointments_served'    => 'Appointments Served',
        'title_appointments_today'     => 'Today',
        'title_appointments_tomorrow'  => 'Tomorrow',
        'title_appointments_total'     => 'Total Appointments',
        'title_contacts_subscribed'    => 'Contacts Subscribed',
        'title_contacts_registered'    => 'Contacts Registered',
        'title_total'                  => 'Total',
      ],
      'title' => 'Dashboard',
    ],
    'edit' => [
      'title' => 'Business profile edit',
    ],
    'form' => [
      'category' => [
        'label' => 'Industry',
      ],
      'description' => [
        'label'       => 'Describe yourself',
        'placeholder' => 'Describe your business and the services you provide',
      ],
      'name' => [
        'label'       => 'Name',
        'placeholder' => 'Commercial name',
        'validation'  => 'A name is required',
      ],
      'link' => [
        'label'       => 'Link',
        'placeholder' => 'Your timegrid homepage link',
        'validation'  => 'Your homepage link is invalid',
      ],
      'phone' => [
        'label'       => 'Mobile',
        'placeholder' => 'your mobile number',
      ],
      'postal_address' => [
        'label'       => 'Postal address',
        'placeholder' => 'street name and number, area, city, country',
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
        'placeholder' => 'this will be your timegrid URL',
        'validation'  => 'An alias is required',
      ],
    ],
    'index' => [
      'help' => 'From here you can manage all your businesses',
      'msg'  => [
        'no_appointments' => 'There are no active appointments right now',
      ],
      'register_business_help' => 'If you are a service provider and you wish to give online reservations, this is your chance!',
      'title'                  => 'My businesses',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Business removed',
      ],
      'index' => [
        'only_one_found' => 'You only have one business registered. Here your dashboard.',
      ],
      'preferences' => [
        'success' => 'Successfully updated preferences!',
      ],
      'register' => 'Great! We are going to register your business with :plan plan',
      'store'    => [
        'business_already_exists' => 'The business is already registered',
        'success'                 => 'Business successfully registered',
      ],
      'update' => [
        'success' => 'Updated business data',
      ],
    ],
    'notifications' => [
      'help'  => 'All what happened recently',
      'title' => 'Notifications',
    ],
    'preferences' => [
      'instructions' => 'Here you can customize the business settings to your needs.',
      'title'        => 'Business preferences',
    ],
    'vacancies' => [
      'btn' => [
        'update' => 'Update availability',
      ],
    ],
  ],
  'contacts' => [
    'btn' => [
      'confirm_delete' => 'Sure to delete contact?',
      'delete'         => 'Delete',
      'edit'           => 'Edit',
      'store'          => 'Save',
      'update'         => 'Update',
    ],
    'create' => [
      'title' => 'Contacts',
    ],
    'form' => [
      'birthdate' => [
        'label' => 'Birthdate',
      ],
      'description' => [
        'label' => 'Description',
      ],
      'email' => [
        'label' => 'Email',
      ],
      'firstname' => [
        'label'      => 'Name',
        'validation' => 'Name is required',
      ],
      'gender' => [
        'female' => [
          'label' => 'Female',
        ],
        'label' => 'Gender',
        'male'  => [
          'label' => 'Male',
        ],
      ],
      'lastname' => [
        'label'      => 'Last name',
        'validation' => 'Last name is required',
      ],
      'mobile' => [
        'label' => 'Mobile',
      ],
      'nin' => [
        'label' => 'ID',
      ],
      'notes' => [
        'label' => 'Notes',
      ],
      'postal_address' => [
        'label'      => 'Postal address',
        'validation' => 'Postal address is required',
      ],
      'prerequisites' => [
        'label' => 'Prerequisites',
      ],
    ],
    'label' => [
      'birthdate'      => 'Birthdate',
      'email'          => 'Email',
      'member_since'   => 'Subscribed since',
      'mobile'         => 'Mobile',
      'nin'            => 'ID',
      'notes'          => 'Notes',
      'postal_address' => 'Postal Address',
    ],
    'list' => [
      'btn' => [
        'filter' => 'Filter',
      ],
      'header' => [
        'email'     => 'Email',
        'firstname' => 'Name',
        'lastname'  => 'Lastname',
        'mobile'    => 'Mobile',
        'username'  => 'Username',
      ],
      'msg' => [
        'filter_no_results' => 'Nothing here',
      ],
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Contact deleted!',
      ],
      'store' => [
        'success'                          => 'Contact registered successfully!',
        'warning_showing_existing_contact' => 'Advice: We found this existing contact',
      ],
      'update' => [
        'success' => 'Updated successfully',
      ],
    ],
    'title' => 'My customers',
  ],
  'humanresource' => [
    'btn' => [
      'create' => 'Add',
      'delete' => 'Remove',
      'store'  => 'Save',
      'update' => 'Update',
    ],
    'create' => [
      'title'        => 'Add Staff Members',
      'subtitle'     => 'Who will provide the services',
      'instructions' => 'Add staff member who will provide the services',
    ],
    'edit' => [
      'title'        => 'Edit Staff Member',
      'subtitle'     => 'Info',
      'instructions' => 'Edit staff member info',
    ],
    'index' => [
      'title'        => 'Staff Members',
      'subtitle'     => 'List',
      'instructions' => 'Staff members list',
    ],
    'show' => [
      'title'        => 'Staff Member',
      'subtitle'     => 'Info',
      'instructions' => 'staff member info',
    ],
    'form' => [
      'calendar_link' => [
        'label' => 'Calendar link',
      ],
      'capacity' => [
        'label' => 'Capacity',
      ],
      'name' => [
        'label' => 'Name',
      ],
    ],
  ],
  'humanresources' => [
    'msg' => [
      'destroy' => [
        'success' => 'Staff member removed',
      ],
      'store' => [
        'success' => 'Staff member added',
      ],
      'update' => [
        'success' => 'Staff member updated',
      ],
    ],
  ],
  'service' => [
    'btn' => [
      'delete' => 'Delete',
      'update' => 'Update',
    ],
    'form' => [
      'color' => [
        'label' => 'Color',
      ],
      'duration' => [
        'label' => 'Duration in minutes',
      ],
      'name' => [
        'label' => 'Service name',
      ],
      'servicetype' => [
        'label' => 'Service Type',
      ],
    ],
    'msg' => [
      'store' => [
        'success' => 'Service stored successfully!',
      ],
    ],
  ],
  'services' => [
    'btn' => [
      'create' => 'Add a service',
      'store'  => 'Save',
    ],
    'create' => [
      'alert' => [
        'go_to_vacancies' => 'Well done! Now you can publish your availability.',
      ],
      'btn' => [
        'go_to_vacancies' => 'Set and publish my availability',
      ],
      'instructions' => 'Give a name to your service, a wide description to help your customers be familiar with it.Add any instructions for your customers before they get to the appointment.',
      'title'        => 'Add a service',
    ],
    'edit' => [
      'title' => 'Edit service',
    ],
    'index' => [
      'instructions' => 'Add as many services as you provide to configure availability for each of them.',
      'title'        => 'Services',
    ],
    'msg' => [
      'destroy' => [
        'success' => 'Service deleted!',
      ],
    ],
  ],
  'vacancies' => [
    'edit' => [
      'instructions' => 'Enter the appointments capacity for each service on each day day. This is, how may appointments can you handle per service per day?',
      'title'        => 'Availability',
    ],
    'msg' => [
      'edit' => [
        'no_services' => 'No services registered. Please register services for your business.',
      ],
      'store' => [
        'nothing_changed' => 'You must indicate your availability at least for one date',
        'success'         => 'Availability registered successfully!',
      ],
    ],
    'table' => [
      'th' => [
        'date' => 'Date',
      ],
    ],
  ],
];
