@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="well">
        <h1>TERMS AND CONDITIONS</h1>
        <p>YOUR TERMS AND CONDITIONS GO HERE</p>
    </div>
</div>

{!! Button::success(trans('wizard.user.terms'))
    ->block()
    ->asLinkTo( route('manager.business.register', ['plan' => 'premium']) )
!!}

@endsection