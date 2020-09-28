@extends('layouts.app')

@section('title', trans('manager.services.index.title'))
@section('subtitle', trans('manager.services.index.instructions'))

@section('content')
<div class="container-fluid">
    <div class="col-md-6 col-md-offset-3">

        <div class="panel panel-default">

            <div class="panel-body">

                @foreach ($business->services as $service)
                <p>
                    <div class="btn-group">

                        {!! Button::danger()->withIcon(Icon::trash())->withAttributes([
                            'type' => 'button',
                            'data-toggle' => 'tooltip',
                            ])->asLinkTo( "javascript:remove()" ) !!}

                        {!! Button::normal()
                            ->withIcon(Icon::edit())
                            ->asLinkTo(route('manager.business.service.edit', [$business, $service->id]) ) !!}

                        @if($service->type)
                        {!! Button::normal($service->type->name) !!}
                        @endif

                        {!! Button::normal($service->name)
                            ->asLinkTo( route('manager.business.service.show', [$business, $service->id]) ) !!}
                    </div>
                </p>
                @endforeach
                
            </div>

            <div class="panel-footer">
                {!! Button::primary(trans('manager.services.btn.create'))
                    ->withIcon(Icon::plus())
                    ->asLinkTo( route('manager.business.service.create', [$business]) )
                    ->block() !!}
                <!--
                {!! Button::primary(trans('servicetype.btn.edit'))
                    ->asLinkTo( route('manager.business.servicetype.edit', [$business]) )
                    ->block() !!}
                -->
            </div>

        </div>
        @if (0==1 && $business->services()->count())
        {!! Alert::success(trans('manager.services.create.alert.go_to_vacancies')) !!}
        {!! Button::success(trans('manager.services.create.btn.go_to_vacancies'))
            ->withIcon(Icon::time())
            ->asLinkTo(route('manager.business.vacancy.create', $business))
            ->large()
            ->block() !!}
        @endif
    </div>
</div>
@endsection

@push('footer_scripts')
<script type="text/javascript" src="/js/service/services.min.js"></script>
<script>
@if(isset($service))
    var remove = () => {
        removeService("{{ trans('manager.service.btn.delete').'?' }}", "{{ route('manager.business.service.destroy', [$service->business, $service]) }}");
    };
@endif
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush