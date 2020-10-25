@extends('layouts.app')

@section('title', trans('medical.template.index.title'))
@section('subtitle', trans('medical.template.index.subtitle'))

@section('content')
<div class="container-fluid">
    {!! Alert::info(trans('medical.template.index.instructions')) !!}
    @include('medical.template.table', compact('templates', 'business', 'template_type'))
</div>

@endsection
@push('footer_scripts')
<script>
var destroy  = function(id) {
    
    var r = confirm("Czy chcesz usunąć wpis?", function(result){
        if(!result) return false;
        var url = "{!! route('medical.template.delete', [$business,'0']) !!}";
        url = url.replace('0',id);
        document.location = url;
        return true;
    });
}
</script>
@endpush
