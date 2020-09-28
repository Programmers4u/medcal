@extends('layouts.app')

@section('title', trans('manager.humanresource.show.title'))
@section('subtitle', trans('manager.humanresource.show.subtitle'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title" style="color:{{$humanresource->color}}">{{ $humanresource->name }}</h3>
                </div>

                <ul class="list-group">
                    <li class="list-group-item">
                        {{ $humanresource->slug }}
                    </li>
                </ul>

                <div class="panel-body">
                    <p>{{ $humanresource->calendar_link }}</p>
                </div>

                <div class="panel-footer">
                    {!! Button::normal()
                        ->withIcon(Icon::edit())
                        ->asLinkTo(route('manager.business.humanresource.edit', [$humanresource->business, $humanresource->id]) ) !!}

                        {!! Button::danger()->withIcon(Icon::trash())->withAttributes([
                            'type' => 'button',
                            'data-toggle' => 'tooltip',
                        ])->asLinkTo( "javascript:remove()" ) !!}
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
    removeService("{{ trans('manager.humanresource.btn.delete').'?' }}", "{{ route('manager.business.humanresource.destroy', [$humanresource->business, $humanresource]) }}");
}
</script>
@endpush