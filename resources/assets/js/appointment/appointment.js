var dateAppo = null;
var dateEventAppo = null;
var finish_date = null;
var start_date = null;
var start_at = null;
var ca_revertFunc = null;
var changeAppointmentLock = -1;
var contactId = null;    
var ajaxBlockClient = 0;                    

var Appointment = {
    csrf : '',
    businessId : '',
    endPoint : '',
    post : {
        businessId : '',
        hr : '',
        start_at : '',
        csrf : '',
    },
    get : function(success, error) { 
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': this.post.csrf || null
            },            
            url: this.endPoint,
            data: this.post,            
            dataType: "json",
            type: "POST",
            success: function (data) {
                // console.log('successLog: ', data);
                if(success) {
                    success(data);
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                // console.log('errorLog: ' + textStatus);
                // Handle errors here
                if(error) {
                    error(data);
                } else {
                    alert('Błąd: '+textStatus);
                }
            }            
        })   
    },
    set : this.get,
}

var changeDateAppo = function(dateStart, dateStop){
    //dateAppo = date;
    //var t = new Date(dateAppo);
    //alert(t);
    start_date = dateStart.toISOString();//dateAppo.toISOString();
    stop_date = dateStop.toISOString();//dateAppo.toISOString();
    var st = start_date.split('T');
    $('#meeting-date-from').html(st[0]+' ');
    $('#meeting-date-to').html(st[0]+' ');
    hour = st[1].split(':');
//        console.log(hour[1]);
    $('#time_from_h').val(parseInt(hour[0]));
    $('#time_from_m').val(parseInt(hour[1]));
    
    var stf = stop_date.split('T');
    hour = stf[1].split(':');
    finish_at_m = parseInt(hour[1]);
    finish_at_h = parseInt(hour[0]);
    /*if((timegrid.serviceDuration+finish_at_m)>=60) {
        finish_at_h++;  
        finish_at_m = finish_at_m;
    }*/
    $('#time_to_h').val(finish_at_h);
    $('#time_to_m').val(finish_at_m);
    finish_at_m_s = (finish_at_m < 10) ? '0'+finish_at_m : finish_at_m;
    finish_at_h_s = (finish_at_h < 10) ? '0'+finish_at_h : finish_at_h;
    finish_date = st[0]+'T'+finish_at_h_s+':'+finish_at_m_s+':00';
    
}

var changeFinishTime = function(time,type){
    finish_at_m = $('#time_to_m').val();
    finish_at_h = $('#time_to_h').val();
    switch(type){
        case 'tm' : 
            finish_at_m = time;
            break;
        case 'th' : 
            finish_at_h = time;
            break;
    }
    
    finish_at_m_s = (finish_at_m < 10) ? '0'+finish_at_m : finish_at_m;
    finish_at_h_s = (finish_at_h < 10) ? '0'+finish_at_h : finish_at_h;
    finish_date = $('#meeting-date-to').text().trim()+'T'+finish_at_h_s+':'+finish_at_m_s+':00';
}

var changeStartTime = function(time,type){
    start_at_m = $('#time_from_m').val();
    start_at_h = $('#time_from_h').val();
    switch(type){
        case 'tm' : 
            start_at_m = time;
            break;
        case 'th' : 
            start_at_h = time;
            break;
    }
    
    start_at_m_s = (start_at_m < 10) ? '0'+start_at_m : start_at_m;
    start_at_h_s = (start_at_h < 10) ? '0'+start_at_h : start_at_h;
    start_date = $('#meeting-date-to').text().trim()+'T'+start_at_h_s+':'+start_at_m_s+':00';
}

var changeContact = function(id,name){
    contactId = id;
    document.getElementById("searchfield").value=name;
    document.getElementById("livesearch").innerHTML='';
    $("#livesearch").css('height','auto');      
    $('#savebtn').prop('disabled',false);    
}

var changeService = function(id,name){
    serviceId = id;
    document.getElementById("searchfieldservice").value=name;
    document.getElementById("livesearchservice").innerHTML='';
    $("#livesearchservice").css('height','auto');    
}

var openAddContact = function(){
    $('#firstname').val('');
    $('#lastname').val('');
    $('#lastname').val($('#searchfield').val());
    $('#lastname').keydown();
    $('#mobile-input').val('');
    $('#addContactModal').modal({
        keyboard: false,
        backdrop: false,
    })     
}

var saveNote = function() {
    
}

var app_meeting_Id = 0;
var deleteAppointment = function(){
    if(!confirm('Jesteś zdecydowany anulować spotkanie?')) return;
    var post = {
        'business' : bussinesId,
        'appointment' : app_meeting_Id,
        'action' : 'cancel',
        'widget' : 'row',
    }
    if(humanresources==0){
        var txt = 'Wybierz kalendarz pracownika';
        alert(txt,'error');
        return -1;
    }

    // $.ajax({
    //     headers: {
    //         'X-CSRF-TOKEN': '{{csrf_token()}}'
    //     },            
    //     url: "/booking",
    //     data: post,            
    //     dataType: "json",
    //     type: "POST",
    //     success: function (data) {
    //         getAppointment();
    //         $('#_modal_appocalendar [data-dismiss=modal]').click();
    //     },
    // });
}

var changeAppointment = function(post) {
    //if(changeAppointmentLock!=-1) return;
    changeAppointmentLock=1;
    //console.log('times: '+times);  
    console.log(post);  
    webApi('/bookchange', post);    
}
