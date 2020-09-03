
var dc = 0;
var hix = document.location.pathname.substring(document.location.pathname.lastIndexOf('/')+1);
var humanresources = hix === 'calendar' ? 0 : hix;

var calendar = function(Appointment) {
    
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

        dayClick: function(date, jsEvent, view) {
            /*
            if(!date._i) {
                //console.log('dayClick');
                dc = 1;
                if(who = prompt('Napisz kto będzie asystował w dniu dzisiejszym')) {
                    asystaAdd(who,date.format());
                    asysta(who,date.format());
                }
                setTimeout(function(){dc = 0;},500);
            }
            */
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
            $('#app-meeting-note').html(calEvent.icon4.note?calEvent.icon4.note:'');
        },
        eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
            var sec = dayDelta;

            Appointment.endPoint = '/bookchange';

            if(event.allDay === true) {
                //$('#calendar').fullCalendar( 'removeEvents', calEvent._id );
                return -1;
            }

            if (!confirm("Jesteś pewny(a) zmiany?")) {
                revertFunc();
            }

            var post = {
                businessId : businessId,
                id : event.id, 
                times: sec, 
                type: 'f',                 
                csrf : csrf,
            }

            Appointment.post = post;
            // Appointment.set(function(data) {
            //     console.log(data);
            //     // changeAppointmentLock=-1;
            // },function(data) {
            //     console.log(data);
            //     // changeAppointmentLock=-1;
            // });
            console.log(Appointment);
            // Appointment.get();
        },        
        eventResize: function(event, dayDelta, revertFunc) {

            if (!confirm("Jesteś pewny(a) zmiany?")) {
              revertFunc();
            }

            var sec = dayDelta;
            var post = {
                businessId : businessId,
                csrf : csrf,
                success: function (data) {
                    alert(data.info,data.type);
                    // getAppointment();
                    changeAppointmentLock=-1;
                },
                error: function (xhr, desc, err) {
                    if(xhr.status === 403) document.location.reload();
                },
            }        
            changeAppointment(event.id, sec, 'f', post);
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