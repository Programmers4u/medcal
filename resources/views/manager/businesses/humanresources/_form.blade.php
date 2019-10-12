@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

<div class="form-group">
    {!! Form::label( trans('manager.humanresource.form.name.label'), null, ['class' => 'control-label col-sm-3 col-md-3'] ) !!}
    <div class="col-sm-9 col-md-9">
        {!! Form::text('name', null, [
            'required',
            'class' => 'form-control',
            'placeholder' => old('name'),
            ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.humanresource.form.capacity.label'), null, ['class' => 'control-label col-sm-3 col-md-3'] ) !!}
    <div class="col-sm-9 col-md-9">
        {!! Form::text('capacity', null, [
            'required',
            'class' => 'form-control',
            'type' => 'number',
            'step' => '1',
            'placeholder' => old('capacity'),
            ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<br/>

<div class="form-group">
    {!! Form::label( trans('manager.humanresource.form.calendar_link.label'), null, ['class' => 'control-label col-sm-3 col-md-3'] ) !!}
    <div class="col-sm-9 col-md-9">
        {!! Form::text('calendar_link', null, [
            'class' => 'form-control',
            'placeholder' => old('calendar_link'),
            ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="form-group">
    {!! Form::label( trans('manager.service.form.color.label'), null, ['class' => 'control-label col-sm-3 col-md-3'] ) !!}
    <div class="col-sm-6 col-md-2">
        <div class="input-group color-picker">
            {!! Form::text('color', null, [
                'class'=>'form-control',
                'placeholder'=> trans('manager.service.form.color.label')
                ]) !!}
            <span class="input-group-addon"><i></i></span>
        </div>
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="col-xs-12">
    <div class="form-group">
        {!! Button::primary($submitLabel)->large()->block()->submit() !!}
    </div>
</div>
@push('footer_scripts')
<script src="{{ asset('js/forms.js') }}"></script>

<script type="text/javascript">
$(document).ready(function(){

    $('.color-picker').colorpicker({
      colorSelectors: {
        '#BF4D28': '#BF4D28',
        '#E6AC27': '#E6AC27',
        '#F6F7BD': '#F6F7BD',
        '#80BCA3': '#80BCA3',
        '#655643': '#655643',
        '#6C2D58': '#6C2D58',
        '#B2577A': '#B2577A',
        '#B2577A': '#B2577A',
        '#F6B17F': '#F6B17F'
      }
    });

});
</script>
@endpush