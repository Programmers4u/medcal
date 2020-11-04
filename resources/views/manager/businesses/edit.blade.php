@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
        <div class="panel-heading">
            {{ trans('manager.businesses.edit.title') }}
        </div>

            <div class="panel-body">
                {!! Form::model($business, ['method' => 'put', 'route' => ['manager.business.update', $business], 'id' => 'registration', 'data-toggle' => 'validator']) !!}
                @include('manager.businesses._form', ['submitLabel' => trans('manager.businesses.btn.update')])
                {!! Form::close() !!}
            </div>

        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
        <div class="panel-heading">
             ID: {{$business->id}} Magazyn: {{ $storageSize }}
        </div>

            <div class="panel-body">
                @include('manager.businesses._statistics', compact('business'))
            </div>

        </div>
    </div>

</div>
@endsection


