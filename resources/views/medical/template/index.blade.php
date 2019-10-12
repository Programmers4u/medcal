@extends('layouts.app')

@section('title', trans('medical.template.index.title'))
@section('subtitle', trans('medical.template.index.subtitle'))

@section('content')
<div class="container-fluid">
    <div class="col-md-6 col-md-offset-3">

        {!! Alert::info(trans('medical.template.index.instructions')) !!}
                {!! Button::primary(trans('manager.humanresource.btn.create'))
                    ->withIcon(Icon::plus())
                    ->asLinkTo( route('medical.template.create', [$business]) )
                    ->block() !!}
                    <br>

        <div class="panel panel-default">

            <div class="panel-heading">{{ trans('medical.template.index.title') }}</div>

            <div class="panel-body">

                @foreach ($template as $gr)
                <p>
                    <div class="btn-group">
                        {!! Button::normal()
                            ->withIcon(Icon::edit())
                            ->asLinkTo(route('medical.template.edit', [$business,$gr->id]) ) !!}
                            <a class="btn btn-danger tooltipstered" href="javascript:destroy({{$gr->id}})"><span class="glyphicon glyphicon-trash"></span></a>
                            <br><br>
                            <b>Nazwa:</b> {{$gr->name}}
                            <b>Typ:</b> {{$template_type[$gr->type]}}
                            <br><br>
                            <b>Opis:</b>
                            <br>{{substr($gr->desc,0,120)}} 
                            <br><br>
                            <hr>
                    </div>
                </p>
                @endforeach
                
            </div>

        </div>

    </div>
</div>
@endsection
@push('footer_scripts')

<script>

var destroy  = function(id) {
    
    var r = confirm("Czy chcesz usunąć wpis?");
    if (r === true) {
        var url = "{!! route('medical.template.delete', [$business,'0']) !!}";
        url = url.replace('0',id);
        document.location = url;
    }
}

</script>

@endpush
