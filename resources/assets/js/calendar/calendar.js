
var dc = 0;
var hix = document.location.pathname.substring(document.location.pathname.lastIndexOf('/')+1);
var humanresources = hix === 'calendar' ? 0 : hix;
var alertText = '';
var contactId = null;

var calendar = function() {
    
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
        aspectRatio: 1.35,
        height: 'auto',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'agendaWeek',
        allDayDefault: false,
        allDaySlot: false,
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
        events: timegrid.events,
        selectable: true,
        selectHelper: true,
        scrollTime: moment().format("HH") + ":00:00",        
        select: function(start, end, jsEvent) {
            if(dc==0) {
                if(0==humanresources){ 
                    var txt = alertText;
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
        dayClick: function(date, jsEvent, view) {
        },
        eventClick: function(calEvent, jsEvent, view) {
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
            contactId = calEvent.contactId;
            $('#app-meeting-client').html("<a onclick='clickLink(this);' href='#'>"+data[0]+"</a>");
            dateEventAppo = calEvent.start;
            var st = dateEventAppo._i.split('T');
            $('#app-meeting-date').html(st[0]+' '+st[1].split('+')[0].slice(0,-3));
            $('#app-meeting-service').html(calEvent.service);
            $('#app-meeting-staff').html(calEvent.staff);
            $('#app-meeting-note').html(calEvent.note?calEvent.note.join(', ') :'');
        },
        eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
            // if(event.allDay === true) {
            //     revertFunc();        
            //     return -1;
            // }

            confirm("Jesteś pewny(a) zmiany?", function(result, revertFunc) {
                if(!result) {
                    revertFunc();
                    return false;
                }

                var sec = dayDelta;
    
                var time, days, hours, minutes = 0;
                days = sec._data.days ? (86400000 * sec._data.days) : 0;
                hours = sec._data.hours ? (3600000 * sec._data.hours) : 0;
                minutes = sec._data.minutes ? (60000 * sec._data.minutes) : 0;
                time = days + hours +  minutes;

                if( !changeAppointmentLock ) return false;
                changeAppointmentLock = false;                

                AppointmentChange.endPoint = '/bookchange';
                AppointmentChange.post = {
                    businessId : businessId,
                    hr : humanresources,
                    id : event.id, 
                    times: time, 
                    type: 'a',                 
                    csrf : csrf,
                };
                // console.log(AppointmentChange);
                AppointmentChange.get(function(data){
                    alert(data.info);
                    changeAppointmentLock = true;  
                    // document.location.reload();              
                });

                return true; 
            },revertFunc)
        },        
        eventResize: function(event, dayDelta, revertFunc) {

            confirm("Jesteś pewny(a) zmiany?", function(result, revertFunc) {                               
                if(!result) {
                    revertFunc();
                    return false;
                }

                var sec = dayDelta;
                
                if( !changeAppointmentLock ) return false;
                changeAppointmentLock = false;                

                AppointmentChange.endPoint = '/bookchange';        
                AppointmentChange.post = {
                    businessId : businessId,
                    hr : humanresources,
                    id : event.id, 
                    times: sec._milliseconds, 
                    type: 'f',                 
                    csrf : csrf,
                };
                // console.log(AppointmentChange);

                AppointmentChange.get(function(data){
                    alert(data.info);
                    changeAppointmentLock = true;   
                    // document.location.reload();
                });
                return true; 
            }, revertFunc);
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
    }
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