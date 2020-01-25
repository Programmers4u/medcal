@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">

            <div class="panel-heading">{{ trans('user.contacts.create.title') }}</div>

            <div class="panel-body">
                {!! Form::model($contact, ['method' => 'put', 'route' => ['user.business.profile.edit', $business, $contact->id ]]) !!}
                @include('user.profile._form', ['submitLabel' => trans('user.contacts.btn.update')])
                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>
@endsection
