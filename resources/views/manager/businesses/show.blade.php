@extends('layouts.app')

@section('title', trans('manager.businesses.dashboard.title'))
@section('subtitle', $business->name)

@section('css')
<link rel="stylesheet" href="{{ asset('css/tour.css') }}">
<style>
    .pd2 {
        padding-top: 2em;        
    }

</style>
@endsection

@section('content')

<div class="container-fluid">

    @if ($business->services()->count() == 0)
    <div class="row">
        <div class="col-md-12">
            {!! Alert::warning(Button::withIcon(Icon::tag())
                ->warning()
                ->asLinkTo( route('manager.business.service.create', $business)) . '&nbsp;' .
                    trans('manager.businesses.dashboard.alert.no_services_set'))
            !!}
        </div>
    </div>
    @endif

    {{-- @if ($business->vacancies()->future()->count() == 0)
    <div class="row">
        <div class="col-md-12">
            {!! Alert::warning(Button::withIcon(Icon::time())
                ->warning()
                ->asLinkTo( route('manager.business.vacancy.create', $business)) . '&nbsp;' .
                    trans('manager.businesses.dashboard.alert.no_vacancies_set'))
            !!}
        </div>
    </div>
    @endif --}}
    
    @foreach ($boxes->chunk(3) as $chunk)
        <div class="row">
            @foreach ($chunk as $box)
                <div class="col-md-4 col-sm-6 col-xs-12">
                    @include('manager.components.info-box', $box)
                </div>
            @endforeach
        </div>
    @endforeach

    <div class="row">
            <div class="col-md-4">
                {!! 
                    Button::success(trans('manager.businesses.dashboard.buttons.import.label'))
                        ->large()
                        ->block()
                        ->asLinkTo('javascript:openImport()') 
                !!}
            </div>
            <div class="col-md-4">
                {!! 
                    Button::success(trans('manager.businesses.dashboard.buttons.calendar.label'))
                        ->large()
                        ->block()
                        ->asLinkTo(route('manager.business.agenda.calendar', $business)) 
                !!}
            </div>
        </div>
    </div>

    <div class="row" style="padding-top:2em;">
        <div class="col-md-1"></div>
            <div class="col-md-11">
          <b>Rozpoznania - choroby</b>
          <div style="position: relative; height:60vh; width:60vw">
            <canvas id="myChart"></canvas>
          </div>
        </div>
    </div>

    <div class="row pt2">
        <div class="col-md-1"></div>
        <div class="col-md-11">
            <b>Rozpoznania - choroby kobiety/męzczyźni</b>
            <div style="position: relative; height:60vh; width:60vw">
              <canvas id="myChart2"></canvas>
            </div>
        </div>  
    </div>

</div>

@include('medical._modal_md_import')
@endsection

@push('footer_scripts')

<script type="text/javascript" src="/js/statistics/statistics.min.js"></script>

<script type="text/javascript">

var Statistics = Object.create(ModelStatistics);
Statistics.csrf = '{{csrf_token()}}';
Statistics.endPoint = '/statistics';
Statistics.post.businessId = '{{ $business->id }}';
Statistics.post.type = Statistics.diagnosisType;


</script>

<script>
  var ctx = document.getElementById('myChart');
  var ctx2 = document.getElementById('myChart2');

Statistics.get(function(data) {
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels : data.statistics[0].labels,
            datasets: [{
                label: 'Rozpoznania',
                data: data.statistics[0].data,
                backgroundColor: data.statistics[0].data.map(item=>{
                    return 'rgba(54, 162, 235, 0.2)';
                }),
                borderColor: data.statistics[0].data.map(item=>{
                    return 'rgba(255, 99, 132, 1)';
                }),
                borderWidth: 1            
            }],
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 100,
                            beginAtZero: true,
                            stepSize: 1,
                        }
                    }]
                }
            }
        }
    });
});

Statistics.post.type = Statistics.diagnosisSexType;
Statistics.get(function(data) {
    var chart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels : data.statistics[0].labels,
            datasets: [{
                label: 'Kobiety',
                data: data.statistics[0].data,
                backgroundColor: data.statistics[0].data.map(item=>{
                    return 'rgba(54, 162, 235, 0.2)';
                }),
                borderColor: data.statistics[0].data.map(item=>{
                    return 'rgba(255, 99, 132, 1)';
                }),
                borderWidth: 1            
            },{
                label: 'Męzczyźni',
                data: data.statistics[1].data,
                backgroundColor: data.statistics[1].data.map(item=>{
                        return 'rgba(255, 159, 64, 0.2)';
                }),
                borderColor: data.statistics[1].data.map(item=>{
                        return 'rgba(255, 159, 64, 0.2)';
                }),
                borderWidth: 1            
            }],
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMin: 50,
                            suggestedMax: 100,
                            beginAtZero: true
                        }
                    }]
                }
            }
        }
    });
});
</script>
@endpush