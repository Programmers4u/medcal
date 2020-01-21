@extends('layouts.app')

@section('css')
@parent
<link rel="stylesheet" href="{{ asset('css/datetime.css') }}">
@endsection

@section('title', 'Kalendarz' )
@section('subtitle', '')

@section('content')

<div>@include('manager.contacts._modalcalendar')</div>
<div>@include('manager.contacts._modal_appocalendar')</div>
<div>@include('manager.contacts._modal_contactadd')</div>
<div>
<div class="modal" id="alertModal" tabindex="-3" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="exampleModalLabel">Alert</h3>
      </div>
      <div class="modal-body">
        <div style="display:none;" id="mc_info_success" class="alert alert-warning"></div>
        <div style="display:none;" id="mc_info_error" class="alert alert-danger"></div>
      </div>
    </div>
  </div>
</div>


<div class="row">
    <div class="col-lg-12" style="border-right:0px solid #afafaf;min-height:100px;position:relative;width:100%;">
        <div class="hr-box" style="display:block;">
            <a class="btn btn-default btn-block" style="display:inline-block;max-width:200px;" onclick="setCookie('');" href="javascript:document.location.reload();">Wszystkie kalendarze</a> 
            @foreach ($humanresources as $hr)
                <a class="btn btn-block" style="display:inline-block;max-width:200px; background-color:{{$hr->color}};color:#FFFFFF;" href="javascript:changeHr({{$hr->id}}, '{{$hr->name}}')">{{$hr->name}}</a>    
            @endforeach
        </div>
        <div id='mini_cal'></div>
    </div>
</div>

<div class="row fullcalendar">
    <div id="calendar"></div>
    <div class="well">{{ $icalURL }}</div>
</div>

@endsection

@push('footer_scripts')
<script src="{{ asset('js/datetime.js') }}"></script>
<script type="text/javascript">
var alert = function(message,type){
    switch(type){
        case 'error' : 
            $('#mc_info_error').text(message);
            $('#mc_info_error').toggle();
            setTimeout(function(){$('#mc_info_error').toggle(400);$('#alertModal button').click();},2000);
        break;
        default: 
            $('#mc_info_success').text(message);
            $('#mc_info_success').toggle();
            setTimeout(function(){$('#mc_info_success').toggle(400);$('#alertModal button').click();},2000);
        break;
    }
    $('#alertModal').modal({
        keyboard: false,
        backdrop: false,
    })    
}
</script>

<script type="text/javascript">
function setCookie(cvalue) {
    var d = new Date();
    d.setTime(d.getTime() + (1*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = "medcallaststaff=" + encodeURIComponent(cvalue) + ";" + expires + ";path=/";
};
function getCookie() {
    var name = "medcallaststaff=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
};

$(document).ready(function(){
    var cookie = getCookie().split(',');
    if(cookie[0]!='')
    changeHr(cookie[0],cookie[1]);
});
</script>
<script type="text/javascript">
var bussinesId = {{ $business->id }};
var hix = document.location.pathname.substring(document.location.pathname.lastIndexOf('/')+1);
var humanresources = hix=='calendar' ? 0 : hix;

var changeHr = function (id,name) {
    setCookie(id+','+name);
    humanresources = id;
    url = document.location.protocol+'\/\/'+document.location.host+document.location.pathname.substring(0,document.location.pathname.lastIndexOf('/'));
    is = url.lastIndexOf('calendar')
    url = (is == -1) ? url+'/calendar/'+humanresources : url+'/'+humanresources;
    getAppointment();
    $('h1').html('<b>Kalendarz dla: '+name+'</b>');
}    
    
$(document).ready(function(){
    calendar();
    var whos = getAsystaCook();
    if(whos){
        whos = whos.split('^');
        for(var i=0;i<whos.length-1;i++){
            who = whos[i].split(',');
            asysta(who[0],who[1]);
            //console.log(who);
        };
    }
});

var getAsystaCook = function(){
    var name = "asysta=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return '';
}

var asysta = function(who, date){
    var obj = {
        title : who,
        allDay : true,
        stick : false,
        start: date,
        editable: true,
        overlap: false,
        backgroundColor: '#f1f1f1',
        textColor: '#000000',
    };
//    $('#calendar').fullCalendar('renderEvent', obj);
    timegrid.events.push(obj);
    $("#calendar").fullCalendar('removeEvents');
    $("#calendar").fullCalendar('addEventSource',timegrid.events);
    
}
var asystaAdd = function(who, date) {
    var d = new Date();
    d.setTime(d.getTime() + (1*24*60*60*24000));
    var expires = "expires="+ d.toUTCString();
    var ac = getAsystaCook();
    document.cookie = "asysta=" + encodeURIComponent(ac+who+','+date+'^') + ";" + expires + ";path=/";
}
var asystaRemove = function(whois, date) {
    var asysta = '';
    var whos = getAsystaCook();
    if(whos){
        whos = whos.split('^');
        for(var i=0;i<whos.length-1;i++){
            who = whos[i].split(',');
            //console.log(whois+','+date);
            if(who[0]!=whois || who[1]!=date) {
                asysta+=who[0]+','+who[1]+'^'
            };
        };
    }
    //console.log(asysta);
    
    var d = new Date();
    d.setTime(d.getTime() + (1*24*60*60*24000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = "asysta=" + encodeURIComponent(asysta) + ";" + expires + ";path=/";
}

var dc = 0;
var calendar = function(){
    
    /*$('#mini_cal').datepicker({
        language: timegrid.lang,
        clearButton: false,
        todayButton: false,        
    });
    */
    $('#calendar').fullCalendar({
        defaultDate: moment(),
        locale: timegrid.lang,
        editable: true,
        aspectRatio: 1.8,
        height: '600',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'agendaWeek',
        allDayDefault: false,
        allDaySlot: true,
        allDayText: 'Asysta',
        businessHours: {
            start: timegrid.minTime,
            end: timegrid.maxTime,
            dow: [ 1, 2, 3, 4, 5, 6 ]
        },
        views: {
            agendaWeek: {
                minTime: timegrid.minTime,
                maxTime: timegrid.maxTime,
                slotDuration: timegrid.slotDuration,
                slotLabelInterval: ['01:00'],
                slotLabelFormat: [
                    'H:mm', // top level of text
                ],
            }
        },

        dayClick: function(date, jsEvent, view) {
            if(!date._i) {
                //console.log('dayClick');
                dc = 1;
                if(who = prompt('Napisz kto będzie asystował w dniu dzisiejszym')) {
                    asystaAdd(who,date.format());
                    asysta(who,date.format());
                }
                setTimeout(function(){dc = 0;},500);
            }
        },
        
        events: timegrid.events,
        selectable: true,
        selectHelper: true,
        scrollTime: moment().format("HH") + ":00:00",        
        select: function(start, end, jsEvent) {
            if(dc==0) {

            if(0==humanresources){ 
                var txt = 'Wybierz kalendarz pracownika';
                alert(txt,'error');
                $('#calendar').fullCalendar('unselect');
                return -1;
            }            
            var eventData;
            eventData = {
                title: 'Spotkanie',
                start: start,
                end: end
            };
            //$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
            $('#exampleModal').modal({
                keyboard: false,
                backdrop: false,
            });
            $('#searchfield').val('');
            $('#searchfield').focus(); 
            if($('#exampleModal').css('block')) $('#calendar').fullCalendar('unselect');

            dateAppo = eventData.start; 
            changeDateAppo(start,end);
        }
        },        
        /*dayClick: function(date, allDay, jsEvent, view) {
            if(0==humanresources){ 
                var txt = 'Wybierz kalendarz pracownika';
                alert(txt,'error');
                return -1;
            }

            $('#exampleModal').modal({
                keyboard: false,
                backdrop: false,
            })
            $('#searchfield').val('');
            $('#searchfield').focus();
            dateAppo = date;    
            changeDateAppo();

            if (allDay) {
                //alert('Clicked on the entire day: ' + date);
            }else{
                //alert('Clicked on the slot: ' + date);
            }
        },*/
        eventClick: function(calEvent, jsEvent, view) {
            //console.log(calEvent);
            if(calEvent.allDay == true) {
                $('#calendar').fullCalendar( 'removeEvents', calEvent._id );
                asystaRemove(calEvent.title,calEvent.start._i);
                return -1;
            }
            
            $('#_modal_appocalendar').modal({
                keyboard: false,
                backdrop: false,
            })
            var data = calEvent.title.split('/');
            app_meeting_Id = calEvent.id
            $('#app-meeting-client').html("<a onclick='clickLink(this);' href='#'>"+data[0]+"</a>");
            dateEventAppo = calEvent.start;
            var st = dateEventAppo._i.split('T');
            $('#app-meeting-date').html(st[0]+' '+st[1].split('+')[0].slice(0,-3));
            $('#app-meeting-service').html(calEvent.service);
            $('#app-meeting-staff').html(calEvent.staff);
        },
        eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
            /*alert(
                event.title + " was moved " +
                dayDelta + " days and " +
                minuteDelta + " minutes."
            );*/
        
            if(event.allDay == true) {
                //$('#calendar').fullCalendar( 'removeEvents', calEvent._id );
                return -1;
            }

            if (!confirm("Jesteś pewny(a) zmiany?")) {
                revertFunc();
            }
            changeAppointment(event.id,dayDelta.toString(), revertFunc);
        },        
        eventResize: function(event, dayDelta, revertFunc) {
            if (!confirm("Jesteś pewny(a) zmiany?")) {
              revertFunc();
            }
            changeAppointment(event.id,dayDelta.toString(), revertFunc,'f');
        },
        eventRender: function(event, element) {
            if(event.icon){          
                element.find(".fc-title").prepend("&nbsp;<i style='color:white;' class='fa fa-"+event.icon+" fa-1x' aria-hidden='true'></i>&nbsp;");
            }
            if(event.icon2){          
                element.find(".fc-title").prepend("&nbsp;<i style='color:white;' class='fa fa-"+event.icon2+" fa-1x' aria-hidden='true'></i>&nbsp;");
            }
            if(event.icon3){          
                element.find(".fc-title").prepend("&nbsp;<i style='color:white;' class='fa fa-"+event.icon3+" fa-1x' aria-hidden='true'></i>&nbsp;");
            }
            if(event.icon4){          
                element.find(".fc-title").prepend("&nbsp;<i style='color:white;' class='fa fa-"+event.icon4+" fa-1x' aria-hidden='true'></i>&nbsp;");
            }
        },    
    });

    
};

var clickLink = function(obj){
  var link = "{{ route('medical.document.link',[$business,0]) }}";
  link = link.replace('0','');
  link+=app_meeting_Id;
  document.location = link;
  return false;
};

var start_at = null;
var getAppointment = function(){
    
    try{
        start_at = $('#calendar').fullCalendar('getDate').format();
    }catch(e){
        //alert(e);
    }

    if(humanresources==0){
        var txt = 'Wybierz kalendarz pracownika';
        alert(txt,'error');
        return -1;
    }
    
    var post = {
        'businessId':bussinesId,
        'hr':humanresources,
        'start_at':start_at,
    }
        
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },            
        url: "/getaxajcallendar",
        data: post,            
        dataType: "json",
        type: "POST",
        success: function (data) {
            var whos = getAsystaCook();
            //console.log(whos);
            if(whos){
                whos = whos.split('^');
                for(var i=0;i<whos.length-1;i++){
                    who = whos[i].split(',');
                    var obj = {
                        title : who[0],
                        allDay : true,
                        stick : true,
                        start: who[1],
                        editable: true,
                        overlap: true,
                        backgroundColor: '#f1f1f1',
                        textColor: '#000000',
                    };
                    data.push(obj);
                };
            };
            timegrid.events = data;
            $("#calendar").fullCalendar('removeEvents');
            $("#calendar").fullCalendar('addEventSource',timegrid.events);
        },
    });
}

var ca_revertFunc = null;
var changeAppointment = function(id, times, revertFunc, type='a'){
    ca_revertFunc = revertFunc;
    if(humanresources==0){
        var txt = 'Wybierz kalendarz pracownika';
        alert(txt,'error');
        revertFunc();
        return -1;
    }
    
    var post = {
        'businessId':bussinesId,
        'hr':humanresources,
        'id':id,
        'time':times,
        'app':type,
    }
    
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },            
        url: "/bookchange",
        data: post,            
        dataType: "json",
        type: "POST",
        success: function (data) {
            alert(data);
            getAppointment();
        },
    });
}
</script>

<script src="{{ asset('js/tour.js') }}"></script>
<script type="text/javascript">
// Instance the tour
var tour = new Tour({
  duration: 10000,
  delay: 100,
  template: "@include('tour._template')",
  onEnd: function(tourDashboard){

    $('#btnVacancies').tooltipster({
          animation: 'fade',
          delay: 200,
          theme: 'tooltipster-timegrid',
          touchDevices: true,
          content: $('<strong>{!! trans('manager.business.hint.set_services') !!}</strong>')
    }).tooltipster('show');

  },
  steps: [
  {
    element: "#activecal",
    title: "{{ trans('tour.dashboard.panel.title') }}",
    content: "{{ trans('tour.dashboard.panel.content') }}",
    duration: 18000,
    placement: "top",
  },
]});
$(document).ready(function(){

// Initialize the tour
tour.init();

// Start the tour
tour.start();

$('.fc-prev-button.fc-button.fc-state-default.fc-corner-left').click(function(){
    try{
        getAppointment();
    }catch(e){
        alert(e);
    }
});

$('.fc-next-button.fc-button.fc-state-default.fc-corner-right').click(function(){
    try{
        getAppointment();
    }catch(e){
        alert(e);
    };
});

$('.fc-today-button.fc-button.fc-state-default.fc-corner-left.fc-corner-right').click(function(){
    try{
        getAppointment();
    }catch(e){
        alert(e);
    };
});
    
});
</script>

@endpush