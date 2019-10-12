@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

<div class="form-group">
    {!! Form::label( trans('medical.template.name.label'), null, ['class' => 'control-label col-sm-3 col-md-3'] ) !!}
    <div class="col-sm-9 col-md-9">
        {!! Form::text('name', null, [
            'required',
            'id' => 'name',
            'class' => 'form-control',
            'placeholder' => old('name'),
            ]) !!}
        <div class="help-block with-errors"></div>
    </div>

    {!! Form::label( trans('medical.template.desc.label'), null, ['class' => 'control-label col-sm-3 col-md-3'] ) !!}
    <div class="col-sm-9 col-md-9">
        {!! Form::textarea('template', null, [
            'required',
            'id' => 'template',
            'class' => 'form-control',
            'placeholder' => old('name'),
            ]) !!}
        <div class="help-block with-errors"></div>
    </div>

    {!! Form::label( trans('medical.template.type.label'), null, ['class' => 'control-label col-sm-3 col-md-3'] ) !!}
    <div class="col-sm-9 col-md-9">
        {!! Form::select('template_type', $template_type, [
            'required',
            'id' => 'template_type',
            'class' => 'form-control',
            'placeholder' => old('name'),
            ]) !!}
        <div class="help-block with-errors"></div>
    </div>
</div>

<div class="col-xs-12">
    <div class="form-group">
        {!! Button::primary($submitLabel)->large()->block()->asLinkTo('javascript:submit()') !!}
    </div>
</div>