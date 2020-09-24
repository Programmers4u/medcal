@extends('layouts.app')

@section('title', trans('manager.contacts.title'))

@push('footer_scripts')
<script>
var openImport = () => {
    $('#importContactModal').modal({
        keyboard: false,
        backdrop: false,
    }) 
}   

$(document).ready(function(){

    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
    
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">{{ trans('manager.contacts.list.msg.filter_no_results') }}</td></tr>'));
        }
    });
});
</script>

<script>
var showResult = function (str) {

    if (str.length < 2) { 
        document.getElementById("livesearch").innerHTML="";
        document.getElementById("livesearch").style.border="0px";
        $("#livesearch").css('height','auto');        
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
var changeContact = function(id,name){
    document.getElementById("searchfield").value='';
    document.getElementById("livesearch").innerHTML='';
    $("#livesearch").css('height','auto');
    document.location = '/{!!$business->slug!!}/medical/document/'+id;
}
</script>
@endpush

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

@section('content')
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <table width='100%'>
                <tr>
                    <td><h3 class="panel-title">{{ trans('manager.contacts.search') }}</h3></td>
                </tr>
            </table>
        </div>
        <input class="form-control" style="margin:5px;width:98%" id="searchfield" type="text" size="30" onkeyup="showResult(this.value)">
        <div id="livesearch"></div>
    </div>          
    {!! $contacts->render() !!}

    <div class="panel panel-default filterable">
        <div class="panel-heading">
            <h3 class="panel-title">{{ trans('manager.contacts.title') }}</h3>
            <div class="pull-right">
                <button class="btn btn-default btn-xs btn-filter">
                    <span class="glyphicon glyphicon-filter"></span>&nbsp;{{ trans('manager.contacts.list.btn.filter') }}
                </button>
            </div>
        </div>
        <table class="table table-condensed table-hover table-striped">
            <thead>
                <tr class="filters">
                    <th><input type="text" class="form-control" placeholder="{{ trans('manager.contacts.list.header.lastname') }}" disabled></th>
                    <th><input type="text" class="form-control" placeholder="{{ trans('manager.contacts.list.header.firstname') }}" disabled></th>
                    <th><input type="text" class="form-control" placeholder="{{ trans('manager.contacts.list.header.email') }}" disabled></th>
                    <th><input type="text" class="form-control" placeholder="{{ trans('manager.contacts.list.header.mobile') }}" disabled></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($contacts as $contact)
                <tr>
                    <td>{!! str_link( route('manager.addressbook.show', [$business, $contact]), $contact->lastname) !!}</td>
                    <td>{!! str_link( route('manager.addressbook.show', [$business, $contact]), $contact->firstname) !!}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->mobile }}</td>
                    <td>
                        {!! Button::withIcon(Icon::book())->success(trans('medical.btn.history'), [$business,$contact])
                                  ->asLinkTo( route('medical.document', [$business, $contact]) )
                                  ->small()
                                  ->block() !!}
                        
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {!! $contacts->links() !!}
        </div>
    </div>
{!! Button::withIcon(Icon::plus())->primary(trans('manager.businesses.contacts.btn.create'))
                                  ->asLinkTo( route('manager.addressbook.create', $business) )
                                //   ->large()
                                  ->block() !!}

{!! Button::withIcon(Icon::plus())->primary(trans('manager.businesses.contacts.btn.import'))
->asLinkTo("javascript:openImport()")
//   ->large()
->block() !!}
</div>

@include('manager.contacts._modal_contact_import',[$business])
@endsection
