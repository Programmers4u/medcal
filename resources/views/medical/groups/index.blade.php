@extends('layouts.app')

@section('title', trans('medical.groups.index.title'))
@section('subtitle', trans('medical.groups.index.subtitle'))

@section('content')
<div class="container-fluid">
    <div class="col-md-6 col-md-offset-3">

        {!! Alert::info(trans('medical.groups.index.instructions')) !!}

        <div class="panel panel-default">

            <div class="panel-heading">{{ trans('medical.groups.index.title') }}</div>

            <div class="panel-body">

                @foreach ($groups as $gr)
                <p>
                    <div class="btn-group">
                        {!! Button::normal()
                            ->withIcon(Icon::edit())
                            ->asLinkTo(route('medical.group.edit', [$business,$gr->id]) ) !!}

                        {!! Button::normal($gr->name)
                             !!}
                    </div>
                </p>
                @endforeach
                
            </div>

            <div class="panel-footer">
                {!! Button::success(trans('manager.humanresource.btn.create'))
                    ->withIcon(Icon::plus())
                    ->asLinkTo( route('medical.group.create', [$business]) )
                    ->block() !!}
            </div>

        </div>

    </div>
</div>
@endsection
