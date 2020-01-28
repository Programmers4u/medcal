@push('footer_scripts')
<script>
$(document).ready(function(){

});
</script>
<script>
    var dateAppo = null;
    var dateEventAppo = null;
    var finish_date = null;
    var start_date = null;
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
    
    var saveAppointment = function (){
        
        var post = {
            'businessId':bussinesId,
            '_date':start_date,
            '_time':start_date,
            'date':start_date,
            '_finish_date':finish_date,
            '_finish_time':finish_date,
            'finish_date':finish_date,
            '_timezone': 'Europe/Warsaw',
            'contact':contactId,
            'contact_id':contactId,
            'hr':humanresources,
            'service_id':serviceId,
            'email':'x@x.pl',
        };
        
        $('#savebtn')[0].innerText="{{ trans('manager.contacts.btn.progress') }}";
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },            
            url: "/book",
            data: post,            
            dataType: "json",
            type: "POST",
            success: function (data) {
                getAppointment();
                alert(JSON.stringify(data));
                contactId = null;
                document.getElementById("searchfield").value='';
                document.getElementById("livesearch").innerHTML='';
                $("#livesearch").css('height','auto');      
                $('#savebtn').prop('disabled',true);    
                $('#savebtn')[0].innerText="{{ trans('manager.contacts.btn.store') }}";                
                $('.close').click();
            },
            error : function(jqXHR, textStatus, errorThrown){
                alert(textStatus,'error');
                getAppointment(); 
            }
        });
    }
</script>

<script>
var ajaxBlockClient = 0;                    
var showResult = function (str) {
    if (str.length < 2) { 
        document.getElementById("livesearch").innerHTML="";
        document.getElementById("livesearch").style.border="0px";
        $("#livesearch").css('height','auto');        
        return;
    }

    if(ajaxBlockClient == 1) return true;
    ajaxBlockClient = 1;

    // Create a formdata object and add the files
    var data = new FormData();
    data.append('business_id','{{ $business->id }}');
    data.append('query',str);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        url: "{{ route('api.contact.ajax.get') }}",
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data, textStatus, jqXHR)
        {
            if(typeof data.error === 'undefined')
            {
                // Success so call function to process the form
                //submitForm(event, data);
                //alert(JSON.stringify(data));
                ajaxBlockClient = 0;
                
                var result='<table class="table table-condensed table-hover table-striped table-responsive table-scrollable"><tbody>';
                data.forEach(function(item,index){
                    result+="<tr><td>";
                    result+="<div onclick='changeContact("+item['id']+",\""+item['name']+"\")' id='"+item['id']+"' style='cursor:pointer'>"+item['name']+', '+item['group']+"</div>";
                    result+="</td></tr>";
                });
                result+="</tbody></table>";
                $("#livesearch").css('height',(data.length*35)+'px');
                $("#livesearch").css('overflow','scroll');
                document.getElementById("livesearch").innerHTML=result;
                document.getElementById("livesearch").style.border="1px solid #A5ACB2";
            }
            else
            {
                // Handle errors here
                ajaxBlockClient = 0;
                console.log('ERRORS: ' + data.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            ajaxBlockClient = 0;
            console.log('ERRORS: ' + textStatus);
            // STOP LOADING SPINNER
        }
    });        
}
</script>
<script>
var contactId = null;    
var changeContact = function(id,name){
    contactId = id;
    document.getElementById("searchfield").value=name;
    document.getElementById("livesearch").innerHTML='';
    $("#livesearch").css('height','auto');      
    $('#savebtn').prop('disabled',false);    
}
</script>

<script>
var showResultService = function (str) {

    if (str.length < 3) { 
        document.getElementById("livesearchservice").innerHTML="";
        document.getElementById("livesearchservice").style.border="0px";
        $("#livesearchservice").css('height','auto');        
        return;
    }
    // Create a formdata object and add the files
    var data = new FormData();
    data.append('business_id','{{ $business->id }}');
    data.append('query',str);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        url: "{{ route('api.service.ajax.get') }}",
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data, textStatus, jqXHR)
        {
            if(typeof data.error === 'undefined')
            {
                // Success so call function to process the form
                //submitForm(event, data);
                //alert(JSON.stringify(data));
                var result='<table class="table table-condensed table-hover table-striped table-responsive table-scrollable"><tbody>';
                data.forEach(function(item,index){
                    result+="<tr><td>";
                    result+="<div onclick='changeService("+item['id']+",\""+item['name']+"\")' id='"+item['id']+"' style='cursor:pointer'>"+item['name']+"</div>";
                    result+="</td></tr>";
                });
                result+="</tbody></table>";
                $("#livesearchservice").css('height','100px');
                $("#livesearchservice").css('overflow','scroll');
                document.getElementById("livesearchservice").innerHTML=result;
                document.getElementById("livesearchservice").style.border="1px solid #A5ACB2";
            }
            else
            {
                // Handle errors here
                console.log('ERRORS: ' + data.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
            // STOP LOADING SPINNER
        }
    });        
}
</script>
<script>
var serviceId = {{ $services[0]->id }};    
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
</script>

@endpush

<!-- Modal -->
<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="exampleModalLabel">{{trans('manager.calendar.modals.title')}}</h3>
      </div>
      <div class="modal-body">

      <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Data spotkania</h3>
            </div>

            <div class="panel-body">
                od: <b><span id='meeting-date-from'></span></b> 
                <select class="form-control" style="display:inline-block;width: 70px" id='time_from_h' onchange="changeStartTime(this.value,'th')">
                    @for($z=0;$z<24;$z++)
                    @if(strlen($z)==1)
                    <option value="{{$z}}">0{{$z}}</option>
                    @else
                    <option value="{{$z}}">{{$z}}</option>
                    @endif
                    @endfor
                </select>
                : 
                <select class="form-control" style="display:inline-block;width: 70px" id='time_from_m' onchange="changeStartTime(this.value,'tm')">
                    <option value="0">00</option>
                    @for($z=15;$z<60;$z+=15)
                    <option value="{{$z}}">{{$z}}</option>
                    @endfor
                </select>
                
                do: <b><span id='meeting-date-to'></span></b> 
                <select class="form-control" style="display:inline-block;width: 70px"  id='time_to_h' onchange="changeFinishTime(this.value,'th')">
                    @for($z=0;$z<24;$z++)
                    @if(strlen($z)==1)
                    <option value="{{$z}}">0{{$z}}</option>
                    @else
                    <option value="{{$z}}">{{$z}}</option>
                    @endif
                    @endfor
                </select>
                : 
                <select class="form-control" style="display:inline-block;width: 70px"  id='time_to_m' onchange="changeFinishTime(this.value,'tm')">
                    <option value="0">00</option>
                    @for($z=15;$z<60;$z+=15)
                    <option value="{{$z}}">{{$z}}</option>
                    @endfor
                </select>
                <br>
                
                
                
            </div>    
        </div>
          
          
    <div class="panel panel-default">
        <div class="panel-heading">
            <table width='100%'>
                <tr>
                    <td><h3 class="panel-title">{{ trans('manager.contacts.title') }}</h3></td>
                    <td align='right'><a onclick="openAddContact()" target="_blank" class="btn btn-primary btn-sm tooltipstered btn-success fa fa-plus"></a></td>
                </tr>
            </table>
        </div>
        <input class="form-control" style="margin:5px;width:98%" id="searchfield" type="text" size="30" onkeyup="showResult(this.value)">
        <div id="livesearch" style="overflow: hidden;"></div>
    </div>          

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ trans('manager.business.btn.tooltip.services') }}</h3>
        </div>

        <input class="form-control" style="margin:5px;width:98%" value="{{ $services[0]->name }}" id="searchfieldservice" type="text" size="30" onkeyup="showResultService(this.value)">
        <div id="livesearchservice"></div>

    </div>
                  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('manager.contacts.btn.close') }}</button>
        <button type="button" class="btn btn-primary" disabled="yes" id="savebtn" onclick="saveAppointment()">{{ trans('manager.contacts.btn.store') }}</button>
      </div>
    </div>
  </div>
</div>

@section('css')
@parent
<style>
.filterable {
    margin-top: 15px;
}
.filterable .panel-heading .pull-right {
    margin-top: -20px;
}
.filterable .filters input[disabled] {
    background-color: transparent;
    border: none;
    cursor: auto;
    box-shadow: none;
    padding: 0;
    height: auto;
}
.filterable .filters input[disabled]::-webkit-input-placeholder {
    color: #333;
}
.filterable .filters input[disabled]::-moz-placeholder {
    color: #333;
}
.filterable .filters input[disabled]:-ms-input-placeholder {
    color: #333;
}
</style>
@endsection