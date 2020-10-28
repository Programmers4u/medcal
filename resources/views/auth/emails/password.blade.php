{{ trans('auth.reset.text') }}: {{ url('/password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}
