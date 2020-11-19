@extends('layouts.bare')

@section('css')
@parent
<style>
    /* @import url(http://fonts.googleapis.com/css?family=Lato); */
    body{
        background-color: #f0f0f0;
        font-size: 1.5em;
    }
    .flat .plan {
        border-radius: 6px;
        list-style: none;
        padding: 0 0 20px;
        margin: 0 0 15px;
        background: #fff;
        text-align: center;
    }
    .flat .plan li {
        padding: 10px 15px;
        color: #888;
        border-top: 1px solid #f5f5f5;
        -webkit-transition: 300ms;
        transition: 300ms;
    }

	.flat .plan li.noZoom {
		 -o-transition-property: none !important;
		 -moz-transition-property: none !important;
		 -ms-transition-property: none !important;
		 -webkit-transition-property: none !important;
		 transition-property: none !important;

		 /*CSS transforms*/
		 -o-transform: none !important;
		 -moz-transform: none !important;
		 -ms-transform: none !important;
		 -webkit-transform: none !important;
		 transform: none !important;

		 /*CSS animations*/
		 -webkit-animation: none !important;
		 -moz-animation: none !important;
		 -o-animation: none !important;
		 -ms-animation: none !important;
		 animation: none !important;
	}
    
    .flat .plan li.plan-price {
        /* font-family: 'Lato', sans-serif; */
        font-size: 2em;
        border-top: 0;
    }
    .flat .plan li.plan-hint {
        /* font-family: 'Lato', sans-serif; */
        font-size: 1em;
        border-top: 0;
        color: #9a9a9a;
        background-color: #fafafa;
        border: 0;
        border-top: 1px dashed #9a9a9a;
        border-bottom: 1px dashed #9a9a9a;
    }
    .flat .plan li.plan-name {
        /* font-family: 'Lato', sans-serif; */
        border-radius: 6px 6px 0 0;
        padding: 15px;
        font-size: 24px;
        line-height: 24px;
        color: #fff;
        background: #367FA9;
        margin-bottom: 30px;
        border-top: 0;
    }
    .flat .plan li > strong {
        color: #e74c3c;
    }
    .flat .plan li.plan-action {
        margin-top: 10px;
        border-top: 0;
    }
    .flat .plan.featured :hover {
        -webkit-transform: scale(1.05);
        -ms-transform: scale(1.05);
        transform: scale(1.05);
    }

    .flat .plan.featured :hover {
        -webkit-transform: scale(1.05);
        -ms-transform: scale(1.05);
        transform: scale(1.05);
    }

    .plan-action .btn {
        /* font-family: 'Lato', sans-serif; */
        font-size: 1.5em;
        border: 0px;
        -webkit-transition: 300ms;
        transition: 300ms;
    }
    .plan-action .btn:hover {
        background-color: #5CB85C;
    }
    .flat .plan.featured li.plan-name {
        background: #367FA9;
    }
    .flat .plan.featured:hover li.plan-name {
        background: #5CB85C;
    }
    .flat .plan:hover li.plan-name {
        background: #EEE232;
    }
    #footer {
        margin-top: 100px;
        padding-bottom: 30px;
    }
    .info {
        padding: 1em;
        background-color: white;
        margin-bottom: 1em;
        border-radius: 10px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <div class="row flat">

    <h4 style='cursor:pointer;' onclick="$('.info').fadeToggle(800)">{{ trans('pricing.information.label') }}</h4>
        <div class="info">
            <p>{{ trans('pricing.information.paragraf_1') }}</p>
            <p>{{ trans('pricing.information.paragraf_2') }}</p>
            <p>{{ trans('pricing.information.paragraf_3') }}</p>
            <p>{{ trans('pricing.information.paragraf_4') }}</p>
            <p>{{ trans('pricing.information.paragraf_5') }}</p>
        </div>

        <div class="">

            <div class="col-lg-6 col-md-6">
                <ul class="plan plan2 featured" id="plan2">
                    <li class="plan-name">
                        {{config('plans.plans.standard.title')}}
                    </li>
                    <li class="plan-hint noZoom">
                        {{trans('pricing.plan.standard.hint')}}
                    </li>
                    <li class="plan-price">
                        {{-- Important to use unescaped for currency as might have html entities --}}
                        <strong>{!! config('plans.plans.standard.price') !!} {!! config('plans.plans.standard.currency') !!}</strong> / {{ trans('pricing.month') }}
                    </li>
                    <li id="p2_appointments">
                        {!! trans('pricing.feature.unlimited_appointments') !!}
                    </li>
                    <li id="p2_contacts">
                        {!! trans('pricing.feature.up_to_contacts', ['limit' => config('plans.plans.standard.limits.contacts')]) !!}
                    </li>
                    <li id="p2_services">
                        {!! trans('pricing.feature.up_to_services', ['limit' => config('plans.plans.standard.limits.services')]) !!}
                    </li>
                    <li id="p2_specialists">
                        {!! trans('pricing.feature.up_to_specialists', ['limit' => config('plans.plans.standard.limits.specialists')]) !!}
                    </li>
                    <li id="p2_sms">
                        {!! trans('pricing.feature.up_to_sms', ['limit' => config('plans.plans.standard.limits.notification')]) !!}
                    </li>
                    <li>
                        {{ trans('pricing.feature.customized_support') }}
                    </li>
                    <li class="plan-action">
                        {{-- <a href="{{ route('manager.business.register', ['plan' => 'premium']) }}" class="btn btn-danger btn-lg">{!! Icon::cloud_upload() !!}&nbsp;{{ trans('pricing.plan.premium.submit') }}</a> --}}
                        <a href="{{ route('wizard.terms', ['plan' => 'standard']) }}" class="btn btn-danger btn-lg">{!! Icon::cloud_upload() !!}&nbsp;{{ trans('pricing.plan.standard.submit') }}</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-6 col-md-5">
                <ul class="plan plan1 featured" id="plan1">
                    <li class="plan-name noZoom">
                        {{trans('pricing.plan.free.name')}}
                    </li>
                    <li class="plan-hint noZoom">
                        {{trans('pricing.plan.free.hint')}}
                    </li>
                    <li class="plan-price">
                        <span class="label label-success"><strong>{{trans('pricing.free')}}</strong></span>
                    </li>
                    <li id="p1_appointments">
                        {!! trans('pricing.feature.unlimited_appointments') !!}
                    </li>
                    <li id="p1_contacts">
                        {!! trans('pricing.feature.up_to_contacts', ['limit' => config('plans.plans.free.limits.contacts')]) !!}
                    </li>
                    <li id="p1_services">
                        {!! trans('pricing.feature.up_to_services', ['limit' => config('plans.plans.free.limits.services')]) !!}
                    </li>
                    <li id="p1_specialists">
                        {!! trans('pricing.feature.one_specialist') !!}
                    </li>
                    <li id="p1_sms">
                        {!! trans('pricing.feature.up_to_sms', ['limit' => config('plans.plans.free.limits.notification')]) !!}
                    </li>
                    <li class="noZoom">
						<strike>{{ trans('pricing.feature.customized_support') }}</strike>
                    </li>
                    <li class="plan-action">
                        <a href="{{ route('wizard.terms', ['plan' => 'free'])  }}" class="btn btn-danger btn-lg">{!! Icon::cloud_upload() !!}&nbsp;{{ trans('pricing.plan.free.submit') }}</a>
                    </li>
                </ul>
            </div>

        </div> <!-- /offset -->
    </div> <!-- /flat -->

</div> <!-- /container -->
@endsection

@push('footer_scripts')
<script>
let steps = [
    {
        element: "#plan1",
        title: "{{ trans('tour.pricing.step0.title') }}",
        content: "{{ trans('tour.pricing.step0.content') }}",
        placement: "left"
    },
    {
        element: "#p1_appointments",
        title: "{{ trans('tour.pricing.step1.title') }}",
        content: "{{ trans('tour.pricing.step1.content') }}"
    },
    {
        element: "#p1_contacts",
        title: "{{ trans('tour.pricing.step2.title') }}",
        content: "{{ trans('tour.pricing.step2.content') }}"
    },
    {
        element: "#p1_services",
        title: "{{ trans('tour.pricing.step3.title') }}",
        content: "{{ trans('tour.pricing.step3.content') }}"
    },
    {
        element: "#plan2",
        title: "{{ trans('tour.pricing.step4.title') }}",
        content: "{{ trans('tour.pricing.step4.content') }}"
    }
];

$(document).ready(function() {

    setTimeout( () => {
        $('.info').fadeOut(800);

        var tour = new Tour({
            name: 'pricing',
            duration: 6500,
            delay: 1000,
            template: "@include('tour._template')",
            steps: steps
        }).init().start();

    }, 30000);

});

</script>
@endpush
