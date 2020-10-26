@extends('layouts.app')

@section('title', trans('medical.template.create.title'))
@section('subtitle', trans('medical.template.create.subtitle'))

@section('content')
<div class="container-fluid">
    {!! Alert::info(trans('medical.template.create.instructions')) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            {{ trans('medical.template.create.title') }}
        </div>

        <div class="panel-body">
                @include('medical.template._form', ['submitLabel' => trans('manager.humanresource.btn.store'),'template_type'=>$template_type, 'business' => $business])
        </div>
    </div>
</div>
@endsection

@push('footer_scripts')
<script>
    var submit = function() {
        webApi("{{ route('medical.template.store',[$business]) }}", {
            csrf: '{{csrf_token()}}',
            post: {
                name: $('#name').val().replace(/\r\n/gi,' '),
                description: $('#description').val().replace(/\r\n/gi,' '),
                type: $('[name=template_type]').val(),
                id : '',
                businessId: '{{ $business->id }}',
                success: function(data) {
                    document.location.href='{{ route('medical.template.index',[$business]) }}';
                },
            }
        });
    }
    </script>

@endpush