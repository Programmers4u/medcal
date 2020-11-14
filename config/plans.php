<?php

return [

    /*
   |--------------------------------------------------------------------------
   | User Model Plan Field
   |--------------------------------------------------------------------------
   |
   | Define the field that is used on the User model to define the
   | plan that the user is subscribed to.
   */

    'plan_field' => 'plan',

    /*
   |--------------------------------------------------------------------------
   | Fallback Plan
   |--------------------------------------------------------------------------
   |
   | The fallback plan will be used if one of the requested attributes
   | is not found in the user's subscription plan. If you don't define a
   | default fallback plan, then set this to false.
   */

    'fallback_plan' => 'free',

    /*
    |--------------------------------------------------------------------------
    | Subscription plans
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the plans that you offer, along with the
    | limits for each plan. The default plan will be used if no plan matches
    | the one provided when calling the plan() helper function.
    */

    'plans'      => [

        'free' => [
            'title'       => 'FREE',
            'description' => 'Personal use only',
            'price'       => '0',
            'currency'    => 'PLN',
            'limits'      => [
                'contacts'    => 200,
                'services'    => 3,
                'specialists' => 1,
                'notification' => 200,
            ],
        ],

        'standard' => [
            'title'       => 'STANDARD',
            'description' => 'Partners use only',
            'price'       => '52',
            'currency'    => 'PLN',
            'limits'      => [
                'contacts'    => 10000,
                'services'    => 10,
                'specialists' => 10,
                'notification' => 10000,
            ],
        ],
    ],
];
