@push('footer_scripts')
<script type="text/javascript" src="/js/appointment/appointment.min.js"></script>

<script type="text/javascript">
var csrf = '{{csrf_token()}}';   
var serviceId = '{{ $services[0]->id }}';

Appointment.csrf = '{{csrf_token()}}';
Appointment.businessId = '{{ $business->id }}';
Appointment.endPoint = '{{ route('api.calendar.ajax') }}';
Appointment.post = {
    businessId : '{{ $business->id }}',
    hr : humanresources,
    start_at : start_at,
    csrf : csrf,
    success: function (data) {
        timegrid.events = data;
        $("#calendar").fullCalendar('removeEvents');
        $("#calendar").fullCalendar('addEventSource',timegrid.events);
    }
};

var saveAppointment = function () {
    var endPoint = '/book';
    var post = {
        businessId : '{{ $business->id }}',
        _date : start_date,
        _time : start_date,
        date : start_date,
        _finish_date : finish_date,
        _finish_time : finish_date,
        finish_date : finish_date,
        _timezone : 'Europe/Warsaw',
        contact : contactId,
        contact_id : contactId,
        hr : humanresources,
        service_id : serviceId,
        email : 'x@x.pl',
        note : $('#note_id')[0].value,
        csrf : '{{csrf_token()}}',
        success: function (data) {
            Appointment.get();
            alert(JSON.stringify(data));
            contactId = null;
            document.getElementById('searchfield').value='';
            document.getElementById('livesearch').innerHTML='';
            $('#livesearch').css('height','auto');      
            $('#savebtn').prop('disabled',true);    
            $('#savebtn')[0].innerText='{{ trans('manager.contacts.btn.store') }}';                
            $('.close').click();
        },
        error : function(jqXHR, textStatus, errorThrown){
            alert(textStatus,'error');
            Appointment.get(); 
        }
    }
    $('#savebtn')[0].innerText='{{ trans('manager.contacts.btn.progress') }}';
    webApi(endPoint,post);    
}

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

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ trans('medical.appointments.label.note') }}</h3>
        </div>
        <textarea class="form-control md-textarea" id="note_id" onchange=""></textarea>
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