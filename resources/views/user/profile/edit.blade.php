@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">

            <div class="panel-heading">{{ trans('user.contacts.create.title') }}</div>

            <div class="panel-body">
                {!! Form::model($contact, ['enctype' => 'multipart/form-data', 'method' => 'put', 'route' => ['user.business.profile.update', $business, $contact->id ]]) !!}
                @include('user.profile._form', ['submitLabel' => trans('user.contacts.btn.update')])
                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>
@endsection
