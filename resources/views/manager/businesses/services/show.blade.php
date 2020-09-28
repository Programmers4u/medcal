@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $service->name }}</h3>
                </div>

                <ul class="list-group">
                    @if($service->type)
                    <li class="list-group-item">
                        {{ $service->type->name }}
                    </li>
                    @endif
                    <li class="list-group-item">
                        <span class='glyphicon glyphicon-tag'></span>&nbsp;{{ $service->slug }}&nbsp;
                        &nbsp;&nbsp;
                        <span class='glyphicon glyphicon-hourglass'></span>&nbsp;{{ $service->duration }}&prime;
                    </li>
                </ul>

                <div class="panel-body">
                    <p>{{ $service->description }}</p>
                </div>

                @include('manager.businesses.services._availability', ['service' => $service])

                <div class="panel-footer">
                    {!! Button::danger()->withIcon(Icon::trash())->withAttributes([
                        'type' => 'button',
                        'data-toggle' => 'tooltip',
                    ])->asLinkTo( "javascript:remove()") !!}

                    {!! Button::normal()
                        ->withIcon(Icon::edit())
                        ->asLinkTo(route('manager.business.service.edit', [$service->business, $service->id]) ) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer_scripts')
<script type="text/javascript" src="/js/service/services.min.js"></script>
<script>
var remove = () => {
    removeService("{{ trans('manager.service.btn.delete').'?' }}", "{{ route('manager.business.service.destroy', [$service->business, $service]) }}");
}

$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();

    var laravel = {
        initialize: function() {
            this.methodLinks = $('a[data-method]');
 
            this.registerEvents();
        },
 
        registerEvents: function() {
            this.methodLinks.on('click', this.handleMethod);
        },
 
        handleMethod: function(e) {
            var link = $(this);
            var httpMethod = link.data('method').toUpperCase();
            var form;
 
            // If the data-method attribute is not PUT or DELETE,
            // then we don't know what to do. Just ignore.
            if ( $.inArray(httpMethod, ['PUT', 'DELETE']) === - 1 ) {
                return;
            }
 
            // Allow user to optionally provide data-confirm="Are you sure?"
            if ( link.data('confirm') ) {
                if ( ! laravel.verifyConfirm(link) ) {
                    return false;
                }
            }
 
            form = laravel.createForm(link);
            form.submit();
 
            e.preventDefault();
        },
 
        verifyConfirm: function(link) {
            return window.confirm(link.data('confirm'));
        },
 
        createForm: function(link) {
            var form =
            $('<form>', {
                'method': 'POST',
                'action': link.attr('href')
            });
 
            var token =
            $('<input>', {
                'type': 'hidden',
                'name': '_token',
                    'value': '{{ csrf_token() }}'
                });
 
            var hiddenInput =
            $('<input>', {
                'name': '_method',
                'type': 'hidden',
                'value': link.data('method')
            });
 
            return form.append(token, hiddenInput)
                                 .appendTo('body');
        }
    };
 
    laravel.initialize();
 
});
</script>
@endpush