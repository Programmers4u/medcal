@extends('layouts.app')

@php $title = 'Pacjent: '.$contacts->firstname.' '.$contacts->lastname; @endphp

@section('title',$title)

@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

@push('footer_scripts')
<script type="text/javascript" src="/js/medical/doc.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('#myTabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    })
    $('#myTabs a[href="#home"]').tab('show') // Select tab by name
    $('#myTabs a:first').tab('show') // Select first tab
    $('#myTabs a:last').tab('show') // Select last tab
    $('#myTabs li:eq(2) a').tab('show') // Select third tab (0-indexed)
    getAppoIdFromLink();
   /* $("#input-b6").fileinput({
        showUpload: false,
        dropZoneEnabled: false,
        maxFileCount: 10,
        mainClass: "input-group-lg"
    });*/
        
});

</script>
<script type="text/javascript">
var printHistory = function(){
    var url = "{{ route('medical.history.export.get',[$business,$contacts]) }}";
    webApi(url, {
        csrf : '{{csrf_token()}}',
        success: function(data) {
            alert('Dokument zostanie przesłany na adres e-mail');
        },
    });
}
</script>
<script type="text/javascript">
    var lastReason = '';
    var lastStaff  = ''
    var editReason = '';
    var lastSet = function(indx){
        lastReason = lastStorage[indx].reason;
        lastStaff = lastStorage[indx].staff;
    };
    var note = '';
    var price = '';
    
    var saveHistory = function (){
        if($('#staff_id').val()=='') {
            var txt = '{{ trans('manager.humanresource.alert') }}';
            alert(txt, 'error');
            return -1;
        }
        if($('#diagnosis').val()=='') {
            var txt = 'Wpisz rozpoznanie';
            alert(txt, 'error');
            return -1;
        }
        if($('#procedures').val()=='') {
            var txt = 'Wpisz co zostało wykonane';
            alert(txt, 'error');
            return -1;
        }
        if(appointment_id=='-1') {
            var txt = 'Wybierz wizytę';
            alert(txt, 'error');
            return -1;
        }
        if($('#edit').css('display') != 'none'){
            editReason = prompt('Podaj powód edycji');
            if(null==editReason) {
                return false;
            }
        }

        var post = {
            'business_id':{{$business->id}},
            'contact_id':{{$contacts->id}},
            'appointment_id':appointment_id,
            'history_id' : historyId,
            'staff' : $('#staff_id').val(),
            'json_data':{
                'procedures' : $('#procedures').val(),
                'edit_procedures' : $('#edit_procedures').text(),
                'diagnosis' : $('#diagnosis').val(),
                'edit_diagnosis' : $('#edit_diagnosis').text(),
                'edit_staff' : lastStaff+"\n"+$('#staff_id').val(),
                'edit_reason' : lastReason+"\n"+editReason,
                'files' : filesName,
                'note' : note,
                'price' : price,
            },
        };
        
        var toDay = new Date().getTime();
        var e = $("#appointment :selected").text();
        var saveDay = new Date(e.split(' - ')[0].replace(/ /gi,'T'));
        
        if(toDay < saveDay.getTime()) {
            confirm("UWAGA!\nOpisujesz wizytę której jeszcze nie było.", function(result) {
                if(!result) return false;
                sendSaveHistory(post);            
            });
        } else {
            sendSaveHistory(post);            
        }
    }    
var sendSaveHistory = function(post) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },            
        url: "{{ route('medical.history.update',[$business]) }}",
            data: post,            
            dataType: "json",
            type: "POST",
            success: function (data) {
                alert(data);
                setTimeout(function(){
                    document.location.reload();
                },2100);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                console.log('ERRORS: ' + textStatus);
                alert('Błąd: '+textStatus, 'error');
            }            
    });
}    
</script>

<script type="text/javascript">
var historyUpdateData = function(obj,id){
    //return -1;
    $('#rowphoto').hide();
    $('#appointment').val(id);
    $('#appointment_data').hide();    
    $('#edit').css('display','inline-table');
    historyId = id;
    appointment_id = 0;
    var dateupd = new Date(Date.now());
    var o = obj.parentElement.children;
  //  $(o).css('background-color', '#f1f1f1');
//    $(o).css('border-top', '1px solid grey');
    for(var z=0;z<o.length;z++){
        console.log(z+"=>"+o[z].innerHTML+"\r\n");
        if(z==1){
            $('#edit_diagnosis').show();
            $('#edit_diagnosis').html(o[z].innerHTML.toString().trim()+"\n//-- zmiana: "+dateupd.toLocaleString());
        }
        if(z==2){
            $('#edit_procedures').show();
            $('#edit_procedures').html(o[z].innerHTML.toString().trim()+"\n//-- zmiana: "+dateupd.toLocaleString());
        }    
    };
    if($('#idinfo'+id+' p').length>0){
        $('#note_id').val($('#idinfo'+id+' p')[0].textContent);
        $('#price_id').val($('#idinfo'+id+' p')[1].textContent);
        note = $('#note_id').val();
        price = $('#price_id').val();
    }
    alert('Edycja wpisu z dnia '+o[0].innerHTML.toString().trim());
    return false;
}


var openFiles = function(){
    type = (historyId >= 0) ? '{{ $typeHistory }}' : '{{ $typePermission }}';
    if(historyId==='-2') type = '{{ $typePermissionTemplate }}';
    $('div[type]').hide();
    $('div[type='+type+']').show();
    if(historyId > 0){
        $('div[appo]').hide();
        $('div[appo='+historyId+']').show();
    }
    $('#medicalFiles').modal({
        keyboard: false,
        backdrop: false,
    })    
}

var Template = function(obj,t){
    switch(t){
        case '{{$typeTemplateA}}' : $('#diagnosis').val($('#diagnosis').val()+obj+"\n"); break;
        case '{{$typeTemplateQ}}' : $('#procedures').val($('#procedures').val()+obj+"\n"); break;
    }
    $(".close").click();
}

var removeLast = function(obj){
    var p = $("#"+obj).val().split("\n");
    p = p.slice(0,p.length-1);
    $("#"+obj).val(p.join("\n"));
}

var findDoctor = function(obj){
    // Create a formdata object and add the files
    console.log(obj);
    var data = new FormData();
    data.append('businessId','{{ $business->id }}');
    data.append('hr',obj.value);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        url: "/getajaxcalendar",
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
                var output = 'daty<br>';
                for(var z=0;z<data.length;z++){
                    output+=data[z].title+', '.data[z].start;
                }
                $("#listAppointments").html(output);
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

$('#staffapp').on('change',function(){
    linkStr = (!document.location.href.match('link')) ? 'link/' : '';
    var http = document.location.href.substr(0,document.location.href.lastIndexOf('/'))+'/'+linkStr+this.value;
    console.log(http);
    document.location = http;
});

var getAppoIdFromLink = function(){
    
    if(!document.location.href.match('link')) return;
    
    var id = document.location.href.substr(document.location.href.lastIndexOf('/')+1);
    if(id.lastIndexOf('?')>0)
        id = id.substr(0,id.lastIndexOf('?'));
    
    $('#staffapp > option').each(function(){
        if(this.value == id)
            $(this).prop('selected','true');
    })
    
    $('#appointment > option').each(function(){
        console.log(this.value,id)
        if(this.value === id) {
            $(this).prop('selected','true');
            appointment_id = id;
            getAppointmentNote('{{ route('medical.note.get', [$business]) }}', {
                csrf: '{{csrf_token()}}',
                appointmentId: appointment_id,
                success: function(data) { 
                    setTimeout( () => {
                        console.log(data)
                        if(data)
                            $('#note_text')[0].innerText = data.medicalNote.note ? data.medicalNote.note : '';
                    }, 1200, data)
                },
            });
        }
        if($('#staffapp > option[value='+id+']').length > 0){
            var sfid = $('#staffapp > option[value='+id+']')[0].attributes.staff.value;
            $('#staff_id').val(sfid);
        };
    })
}

$('#staff_id').on('change',function(){
    $('#staffapp > option').each(function(){
        if(this.text.match(/Demo/gi))
            $(this).prop('hidden','true');
    })
});
</script>

<script type="text/javascript">
var ePuap = function(){
    window.open('https://pz.gov.pl/dt/login/login','__blank');
}
</script>

<script type="text/javascript">
var urlAppointmentNote = '{{ route('medical.note.put',[$business]) }}';
var putAppointmentNoteCallBack = () => {
    // if(appointment_id < 1) {
    //     alert('Wybierz datę wizyty');
    //     return;
    // }
    return {
        appointmentId : appointment_id,
        note : $('#note')[0].value,
        businessId: '{{ $business->id }}',
        csrf : '{{csrf_token()}}',
        success : function (data) {
            setTimeout( () => {
                console.log(data);
                $('#note_text')[0].innerText += data.medicalNote.note ? data.medicalNote.note + '\n' : '';
                $('#note')[0].value = '';
            },700,data);
        }
    }
};    
</script>
<script>
 getAppointmentNote('{{ route('medical.note.get', [$business]) }}', {
    csrf: '{{csrf_token()}}',
    appointmentId: appointment_id,
    businessId: '{{ $business->id }}',
    contactId: '{{ $contacts->id }}',
    success: function(data) { 
        if(data)
            $('#note_text')[0].innerText = data.medicalNote.note ? data.medicalNote.note : '';
    },
});    
</script>
@endpush

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">{{ trans('medical.document.title') }}</h3>
    </div>

    <div class="panel-body">
        <div>

      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a href="#statistics" aria-controls="statistics" role="tab" data-toggle="tab">{{ trans('medical.document.statistics') }}</a></li>
        <li role="presentation"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">{{ trans('medical.document.client') }}</a></li>
        <li role="presentation" class="active"><a href="#dockmed" aria-controls="dockmed" role="tab" data-toggle="tab">{{ trans('medical.btn.history') }}</a></li>
        <li role="presentation"><a href="#interview" aria-controls="interview" role="tab" data-toggle="tab">{{ trans('medical.document.interview') }}</a></li>
        <li role="presentation"><a href="#permission" aria-controls="permission" role="tab" data-toggle="tab">{{ trans('medical.btn.permission') }}</a></li>
        <li role="presentation"><a href="#photo" aria-controls="photo" role="tab" data-toggle="tab">{{ trans('medical.btn.photo') }}</a></li>
      </ul>

    <!-- Tab panes -->
    <div class="tab-content">

        <div role="tabpanel" class="tab-pane" id="statistics">
            <br>
            <div class="panel" id="statistics">
                <div class="panel-heading">
                    <h3 class="panel-title">Statystyki</h3>
                </div>
  
                <div class="panel-body">
                    @include('medical._statistics',[$contacts,$business] )
                </div>
  
            </div>
  
        </div>
  
        <div role="tabpanel" class="tab-pane" id="home">
          <br>
        {{ trans('medical.document.clients.name') }}: <b>{{ $contacts->firstname }} {{ $contacts->lastname }}</b><br><br>
        {{ trans('medical.document.clients.phone') }}: <b>{{ $contacts->mobile }}</b><br>
        {{ trans('medical.document.clients.email') }}: <b>{{ $contacts->email }}</b><br>
        {{ trans('medical.document.clients.pesel') }}: <b>{{ $contacts->nin }}</b><br>
        {{ trans('medical.document.clients.address') }}: <b>{{ $contacts->postal_address }}</b><br>
        <!--
        {{ trans('medical.document.clients.desc') }}:<br>
        <textarea class="form-control"></textarea><br>
        -->
        {{-- <br>
        Grupy do jakich należy pacjent:<br>
        <b>
        @foreach($group as $gr)
        @if(TRUE==in_array($contacts->id,explode(',',$gr['contacts'])))
        {{ $gr['name'] }},
        @endif
        @endforeach
        </b>
        <hr> --}}
        {!! Button::withIcon(Icon::edit())
            ->primary('edytuj dane')
            ->small()
            ->asLinkTo(route('manager.addressbook.edit',[$business,$contacts->id])) !!}
        
        {!! Button::withIcon(Icon::refresh())
            ->info('Wizyty')
            ->small()
            ->asLinkTo(route('manager.addressbook.show', [$business,$contacts->id])) 
        !!}

      </div>

      <div role="tabpanel" class="tab-pane" id="interview">
          <br>
          <div class="panel" id="interview">
              <div class="panel-heading">
                  <h3 class="panel-title">Wywiad, choroby ogólnoustrojowe</h3>
              </div>

              <div class="panel-body">
                  @include('medical._interview',[$interviewData,$contacts,$business] )
              </div>

          </div>

      </div>

      <div role="tabpanel" class="tab-pane" id="permission">
          <br>
          <div class="panel" id="interview">
              <div class="panel-heading">
                  <h3 class="panel-title">Zgody</h3>
              </div>

              <div class="panel-body">
                  @include('medical._permission',[$permission,$interviewData,$contacts,$business] )
              </div>

          </div>

      </div>

    <div role="tabpanel" class="tab-pane" id="photo">
    <br>
        <div class="panel" id="panel_photo">
            <div class="panel-heading">
                <h3 class="panel-title">Pliki</h3>
            </div>

            <div class="panel-body">
                <div class="container">
                <div class="row">
                
                @foreach($files as $indx=>$file)
                <div class="col-9 col-lg-4">
                <div class="panel panel-default">
                <div class="panel-body">
                    <h4>{{ $file['description'] }}</h4><br>
                    <a href="{{$file['url']}}" target="_blank">
                    <img src="{{$file['url']}}" title="file" width="50%"/>
                    </a>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-primary btn-sm tooltipstered btn-danger fa fa-remove" href="javascript:deleteFile({{$file['id']}})"></a>
                </div>
                </div>
                </div>    
                @endforeach
                </div>
                </div>
            </div>
        </div>
    </div>  

    <div role="tabpanel" class="tab-pane active" id="dockmed">
          <br>
          <div class="panel-default" id="">
              <div class="panel-heading">
                  <h3 class="panel-title">
                      {{ trans('medical.document.history') }} <div style=' cursor: pointer;display:none;text-align: center; width: 93%;' onclick="document.location.reload();" id='edit' class="btn btn-danger">WYJDŹ Z EDYCJI <span class="glyphicon glyphicon-arrow-left"></span></div>
                </h3>
              </div>

              <div class="panel-body">

                  <table class="table table-hover table-striped table-responsive">
                              <tr id='appointment_data' width="25%"> 
                                  <td style="font-weight:bold;">Data wizyty: 
                                  </td>
                                  <td  width="75%">
                                      <select onchange="
                                        appointment_id = $(this).val();
                                        getAppointmentNote('{{ route('medical.note.get', [$business]) }}', {
                                            csrf: '{{csrf_token()}}',
                                            appointmentId: appointment_id,
                                            success: function(data) { 
                                                setTimeout( () => {
                                                    console.log(data)
                                                    if(data)
                                                        $('#note_text')[0].innerText = data.medicalNote.note ? data.medicalNote.note : '';
                                                },1000,data)
                                            },
                                      });" class="form-control mdb-select  colorful-select dropdown-primary" id='appointment'>
                                          <option value="-1" disabled selected>Wybierz datę wizyty</option>
                                          <option value="0">Bez wizyty</option>
                                          @foreach($appointments as $appo)
                                          <option value="{{$appo->id}}">{{\Carbon\Carbon::parse($appo->start_at)->timezone('Europe/Warsaw')}} - {{\Carbon\Carbon::parse($appo->finish_at)->timezone('Europe/Warsaw')}}</option>
                                          @endforeach
                                      </select>
                                  </td>
                              </tr>
                              <tr>
                                  <td style="font-weight:bold;">Rozpoznanie:
                                      <br>
                                        {!! 
                                        Button::withIcon(Icon::search())
                                            ->info('szablon rozpoznanie')
                                            ->small()
                                            ->asLinkTo('javascript:popUp("diagnosisModal")') 
                                        !!}
                                  
                                  </td><td>
                                      <div style="display: none;background-color: white; text-decoration: line-through;font-style: italic;margin-bottom: 5px;padding: 5px;" class="editdoc" id="edit_diagnosis"></div>
                                      <textarea type="text" id="diagnosis" class="form-control md-textarea" rows="3"></textarea></td>
                              </tr>
                              <tr>
                                  <td style="font-weight:bold;">Wykonany zabieg:
                                      <br>
                                        {!! 
                                        Button::withIcon(Icon::search())
                                            ->info('szablon wykonanie')
                                            ->small()
                                            ->asLinkTo('javascript:popUp("proceduresModal")') 
                                        !!}
                                      
                                  </td><td><div style="display: none;background-color: white; text-decoration: line-through;font-style: italic;margin-bottom: 5px;padding: 5px;" class="editdoc" id="edit_procedures"></div><textarea type="text" id="procedures" class="form-control md-textarea" rows="3"></textarea></td>
                              </tr>
                              <tr id='rowphoto'>
                                  <td style="font-weight:bold;">Załącz dokumenty:</td>
                                  <td>
                                    <a class="glyphicon glyphicon-paperclip fa-2x" href="javascript:historyId=0;openFiles();"></a>
                                    <div id='atach_file'></div>
                                  </td>
                              </tr>
                              <tr>
                                  <td style="font-weight:bold;">Wpisu dokonał:</td>
                                  <td>
                                      <select class="form-control" onclick="staff=this.value;" id="staff_id">
                                        <option value="">wybierz lekarza</option>
                                        @foreach($staffs as $staff)
                                        <option value="{{$staff->id}}">{{$staff->name}}</option>
                                        @endforeach
                                      </select>                                      
                                  </td>
                              </tr>
                              <tr>
                                  <td style="font-weight:bold;">{{ trans('medical.appointments.label.note') }}</td>
                                  <td>
                                    <div id="note_text"></div>
                                    <textarea id="note" class="form-control md-textarea"></textarea>
                                    <div style="padding-top:1em;" >
                                      {!! 
                                        Button::withIcon(Icon::save())
                                            ->info('zapisz notatkę')
                                            ->small()
                                            ->asLinkTo("javascript:putAppointmentNote(urlAppointmentNote, putAppointmentNoteCallBack())")
                                        !!}     
                                    </div>                           
                                </td>
                              </tr>
                              <tr>
                                  <td style="font-weight:bold;">przyjęta kwota</td>
                                  <td>
                                    <input style="max-width:6em" class="form-control price" type="text" id="price_id" onchange="price=this.value"/>
                                  </td>
                              </tr>
                      </table>
                  <hr>
                      {!! Button::withIcon(Icon::edit())
                      ->success('zapisz dokumentację')
                      ->asLinkTo("javascript:saveHistory()") !!}
                      
                      {!! Button::withIcon(Icon::print())
                      ->warning('drukuj historię')
                      ->asLinkTo("javascript:printHistory()") !!}

                    {!! Button::withIcon(Icon::folderOpen())
                        ->primary('Połącz z ePuap')
                        ->asLinkTo("javascript:ePuap()") !!}

                    {{-- {!! Button::withIcon(Icon::edit())
                        ->success('importuj dokumentację')
                        ->asLinkTo("javascript:openImport()") !!} --}}

                <hr>
          <table id="history_table" class="table-bordered table table-condensed table-hover table-striped table-responsive table-scrollable">
              @if(count($historyPagin)>0)
              <thead class="text-bold">
                  <tr>
                      <td width="10%">Data wizyty.</td>
                      <!--td width="10%">Data zmiany</td-->
                      <td width="40%">Rozpoznanie</td>
                      <td width="40%">Wykonany zabieg</td>
                      <td width="5%">Pliki</td>
                      <td width="5%">Wykonał</td>
                  </tr>
              </thead>
              @endif
              <tbody>
                  @php $lastStore = []; @endphp
                  @foreach($historyPagin as $i=>$page)
                  @php $es = ""; @endphp
                  @php $json = json_decode($page->json_data); @endphp
                  @if(isset($json->edit_staff))
                  @php array_push($lastStore,["staff" => $json->edit_staff,"reason" => $json->edit_reason]); @endphp
                  @php $es = "lastSet($i);"; @endphp
                  @endif
                  @if(!isset($json->note))
                  @php $json->note = ''; @endphp
                  @endif
                  @if(!isset($json->price))
                  @php $json->price = ''; @endphp
                  @endif
                  <tr style="cursor:pointer;">
                      <td onclick="{!!$es!!}historyUpdateData(this,{{$page->history}})" >{{ \Carbon\Carbon::parse($page->start_at)->timezone($business->timezone) }}</td>
                      <!--td onclick="historyUpdateData(this,'{{$page->appointment_id}}')" >{{ \Carbon\Carbon::parse($page->updated_at)->timezone('Europe/Warsaw') }}</td-->
                      <td onclick="{!!$es!!}historyUpdateData(this,'{{$page->history}}')" >
                          @if(isset($json->edit_diagnosis))
                          <!--div style="text-decoration: line-through;font-style: italic;margin-bottom: 10px;padding: 5px;" class="editdoc" id="update_diagnosis">{{ $json->edit_diagnosis }}</div-->
                          @endif
                          {{ $json->diagnosis }}
                      </td>
                      <td onclick="{!!$es!!}historyUpdateData(this,'{{$page->history}}')" >
                          @if(isset($json->edit_procedures))
                          <!--div style="text-decoration: line-through;font-style: italic;margin-bottom: 10px;padding: 5px;" class="editdoc" id="update_procedures">{{ $json->edit_procedures }}</div-->
                          @endif
                          
                          {{ $json->procedures }}</td>
                      <td><a class="fa fa-file fa-2x" href="javascript:historyId='{{$page->history}}';openFiles();"></a></td>
                      <td>
                          {{$page->name}}<br>
                          @if($json->note!='' || $json->price!='')
                          <i class="fa fa-info-circle fa-1x" onmouseover="$('#idinfo{{$page->history}}').toggle();"></i>
                          <div id='idinfo{{$page->history}}' style='min-width: 200px;padding: 0.9rem;display:none;background-color: #f1f6ff;font-size: 1.2rem;'>
                              ---<br>
                              <p>@php $note = str_replace("\n","<br>",$json->note); @endphp
                                  {!! $note !!}</p><br>
                              <!--
                              ---<br>
                              przyjęta kwota: <p>{{ $json->price }}</p><br>
                              ---<br>
                              -->
                          </div>
                          @endif
                          <i class="fa fa-comment-o fa-1x" onclick="addNote('{{ route('medical.history.note.add',[$business]) }}',{
                            business_id : '{{$business->id}}',
                            contact_id : '{{$contacts->id}}',
                            history_id : historyId,
                            note : '',
                            csrf : '{{csrf_token()}}',
                          });"></i>

                      </td>
                  </tr>
                  @endforeach
              </tbody>
          </table>
                      <script>
                      var lastStorage = {!! json_encode($lastStore) !!};
                      </script>           
          <center>
          {{ $historyPagin->links() }}
          </center>
          <br>                      
              </div>
          </div>
          
      </div>
    </div>

    </div>                
                
    </div>    
</div>
<div>
@include('medical._modal_files',[$business])
</div>
<!-- MODAL DIAGNOSIS-->
<div>
<div class="modal draggable fade" id="diagnosisModal" tabindex="-2" role="dialog" aria-labelledby="diagnosisModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="exampleModalLabel">Rozpoznanie</h3>
      </div>
      <div class="modal-body">
                                        {!! 
                                        Button::withIcon(Icon::arrow_left())
                                            ->danger('usuń pozycję')
                                            ->small()
                                            ->asLinkTo('javascript:removeLast("diagnosis")') 
                                        !!}
                                        
                                        <br><br>
          
                                        <select style="height:300px" multiple="" class="form-control" onclick="Template($(this).val(),'A')" id="tempalate_whatdo">
                                        @foreach($template as $temp)
                                        @if($temp->type == 'A')
                                        <option value="{{$temp->description}}">{{$temp->name}}</option>
                                        @endif
                                        @endforeach
                                      </select>          
                                        <br>
          
        <div style="display:none;" id="md_info_success" class="alert alert-warning"></div>
        <div style="display:none;" id="md_info_error" class="alert alert-danger"></div>
      </div>
    </div>
  </div>
</div>
</div>


<!-- MODAL PROCEDURES-->
<div>
<div class="modal draggable fade" id="proceduresModal" tabindex="-4" role="dialog" aria-labelledby="proceduresModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="proceduresModalLabel">Zabieg</h3>
      </div>
      <div class="modal-body">
                                        {!! 
                                        Button::withIcon(Icon::arrow_left())
                                            ->danger('usuń pozycję')
                                            ->small()
                                            ->asLinkTo('javascript:removeLast("procedures")') 
                                        !!}
                                        <br><br>
          
                                        <select style="height:300px"  multiple="" class="form-control" onclick="Template($(this).val(),'Q')" id="tempalate_doing">
                                        @foreach($template as $temp)
                                        @if($temp->type == 'Q')
                                        <option value="{{$temp->description}}">{{$temp->name}}</option>
                                        @endif
                                        @endforeach
                                      </select>   
                                        <br>
          
        <div style="display:none;" id="md_info_success" class="alert alert-warning"></div>
        <div style="display:none;" id="md_info_error" class="alert alert-danger"></div>
      </div>
    </div>
  </div>
</div>
</div>



<!-- MODAL LIST APPOINTMENTS-->
<div>
<div class="modal draggable fade" id="appointmentsModal" tabindex="-5" role="dialog" aria-labelledby="appointmentsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="appointmentsModalLabel">Wizyty</h3>
      </div>
      <div class="modal-body">
            <select class="form-control" onclick="findDoctor(this);" id="staff_id">
                <option value="">wybierz lekarza</option>
                @foreach($staffs as $staff)
                    <option value="{{$staff->id}}">{{$staff->name}}</option>
                @endforeach
          </select>                             
          <div id='listAppointments'></div>

        <div style="display:none;" id="md_info_success" class="alert alert-warning"></div>
        <div style="display:none;" id="md_info_error" class="alert alert-danger"></div>
      </div>
    </div>
  </div>
</div>
</div>

@endsection

@section('css')
@parent
<style>
    .editdoc {
        text-decoration: line-through;
        font-style: italic;
    }
</style>
@endsection


