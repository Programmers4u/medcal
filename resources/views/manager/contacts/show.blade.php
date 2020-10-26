@extends('layouts.app')

@section('title', $contact->fullname)

@section('css')
{{-- <link rel="stylesheet" href="{{ asset('css/forms.css') }}"> --}}
<style>
.user-row {
    margin-bottom: 14px;
}

.user-row:last-child {
    margin-bottom: 0;
}

.dropdown-user {
    margin: 13px 0;
    padding: 5px;
    height: 100%;
}

.dropdown-user:hover {
    cursor: pointer;
}

.table-user-information > tbody > tr:first-child {
    border-top: 0;
}

.table-user-information > tbody > tr > td {
    border-top: 0;
}
.toppad {
    margin-top:20px;
}
</style>
@endsection

@section('content')
<div class="container-fluid">

    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2 toppad" >

        <div class="panel panel-info">

            <div class="panel-heading">
                <h3 class="panel-title">{{ $contact->fullname }}</h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3 " align="center">
                        @if($contact->email)
                            <img alt="{{$contact->fullname}}"
                                 src="{{ Gravatar::get($contact->email) }}"
                                 class="img-circle">
                        @endif
                        <p>&nbsp;</p>
                        <small>{{ trans('app.gender.'.$contact->gender) }} {{ $contact->age or '' }}</small>
                    </div>
                    
                    <div class=" col-md-9 col-lg-9 ">
                        <table class="table table-user-information">
                            <tbody>
                            @if ($contact->email)
                            <tr>
                                <td class="text-right">
                                    <label class="control-label">
                                        {{ trans('manager.contacts.label.email') }}
                                    </label>
                                </td>
                                <td>{{ $contact->email }}</td>
                            </tr>
                            @endif
                            @if ($contact->nin)
                            <tr>
                                <td class="text-right">
                                    <label class="control-label">
                                        {{ trans('manager.contacts.label.nin') }}
                                    </label>
                                </td>
                                <td>{{ $contact->nin }}</td>
                            </tr>
                            @endif
                            @if ($contact->birthdate)
                            <tr>
                                <td class="text-right">
                                    <label class="control-label">
                                        {{ trans('manager.contacts.label.birthdate') }}
                                    </label>
                                </td>
                                <td>{{ $contact->birthdate->formatLocalized('%d %B %Y') }}</td>
                            </tr>
                            @endif
                            @if ($contact->mobile)
                            <tr>
                                <td class="text-right">
                                    <label class="control-label">
                                        {{ trans('manager.contacts.label.mobile') }}
                                    </label>
                                </td>
                                <td>{{ (trim($contact->mobile) != '' && !empty($contact->mobile_country)) ? phone_format($contact->mobile, $contact->mobile_country) : '' }}</td>
                            </tr>
                            @endif
                            @if ($contact->postal_address)
                            <tr>
                                <td class="text-right">
                                    <label class="control-label">
                                        {{ trans('manager.contacts.label.postal_address') }}
                                    </label>
                                </td>
                                <td>{{ $contact->postal_address }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-right">
                                    <label class="control-label">
                                        {{ trans('manager.contacts.label.member_since') }}
                                    </label>
                                    </td>
                                <td>{{ $contact->pivot->created_at->diffForHumans() }}</td>
                            </tr>
                            <tr>
                                <td class="text-right">
                                    <label class="control-label">{{ trans('manager.contacts.label.notes') }}</label>
                                </td>
                                <td>{{ $contact->pivot->notes }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="panel-footer" style="min-height:8em;">
                {!! $contact->quality == 100 ? ProgressBar::success($contact->quality)->animated()->striped()->visible() : ProgressBar::normal($contact->quality)->animated()->striped()->visible() !!}

                {{-- @if ($contact->user) --}}
                {{-- {!! Button::success($contact->user->username)->withIcon(Icon::ok_circle()) !!} --}}
                {{-- @else --}}
                {{-- {!! Button::warning()->withIcon(Icon::remove_circle()) !!} --}}
                {{-- @endif --}}

                <span class="pull-right">
                    @if (!isset($existingContact))
                    {!! Button::withIcon(Icon::ok_circle())->primary(trans('user.contacts.btn.createprofil'), [$business,$contact])
                        ->asLinkTo('javascript:addContactToUser()')
                    !!}
                    @endif
                    {!! Button::withIcon(Icon::book())->primary(trans('medical.btn.history'), [$business,$contact])
                        ->asLinkTo( route('medical.document', [$business, $contact]) )
                        ->withAttributes([
                            'id' => 'medhis-btn',
                            'type' => 'button',
                            'data-for' => 'get',
                            'data-toggle' => 'tooltip',
                            'data-method' => 'GET',
                            'data-original-title' => trans('medical.btn.history'),
                            'data-confirm'=> trans('medical.btn.history')])
                        !!}
                        
                    {!! Button::warning()
                        ->withIcon(Icon::edit())
                        ->asLinkTo( route('manager.addressbook.edit', [$business, $contact]) )
                        ->withAttributes([
                            'data-for' => 'edit',
                            'data-toggle' => 'tooltip',
                            'data-original-title' => trans('manager.contacts.btn.edit')])
                        !!}

                        
                    {!! Button::danger()
                        ->withIcon(Icon::trash())
                        ->asLinkTo( "javascript:remove()" )
                        ->withAttributes([
                            'id' => 'delete-btn',
                            'type' => 'button',
                            'data-for' => 'delete',
                            'data-toggle' => 'tooltip',
                            'data-method' => 'DELETE',
                            'data-original-title' => trans('manager.contacts.btn.delete'),
                            'data-confirm'=> trans('manager.contacts.btn.confirm_delete')])
                        !!}
                        
                </span>
            </div>
        </div>

    @if($contact->hasAppointment())
    <div>
        @include('manager.contacts._appointment', ['appointments' => $contact->appointments()->orderBy('start_at')->ofBusiness($business->id)->Active()->limit(5)->get()] )
    </div>
    @endif

    @if(auth()->user()->isOwnerOf($business->id))
    <!--
    {!! Button::large()->success(trans('user.appointments.btn.book_in_biz_on_behalf_of', ['biz' => $business->name, 'contact' => $contact->fullname()]))
                       ->asLinkTo(route('user.booking.book', ['business' => $business, 'behalfOfId' => $contact->id]))
                       ->withIcon(Icon::calendar())->block() !!}
    -->
    @endif
</div>
@endsection

@push('footer_scripts')
{{-- <script src="{{ asset('js/forms.js') }}"></script> --}}
<script type="text/javascript">
var addContactToUser = function() {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        type      : 'GET',
        url       : '{{ route("manager.addressbook.contact2profil",[$business,$contact])}}',
        //data      : formData,
        //dataType  : 'json',
        encode    : false
    }).done(function(data) {
        console.log(JSON.stringify(data));
        console.log(data.status); 
        alert(data.data);
    }).error(function(data) {
        console.log(JSON.stringify(data));
        console.log('could not be updated '+data.status); 
        alert('could not be updated '+data.data);
    });
}
</script>
<script>
$(document).ready(function() {
    var panels = $('.user-infos');
    var panelsButton = $('.dropdown-user');
    panels.hide();

    //Click dropdown
    panelsButton.click(function() {
        //get data-for attribute
        var dataFor = $(this).data('for');
        var idFor = $(dataFor);

        //current button
        var currentButton = $(this);
        idFor.slideToggle(400, function() {
            //Completed slidetoggle
            if(idFor.is(':visible'))
            {
                currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
            }
            else
            {
                currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
            }
        })
    });

    $('[data-toggle="tooltip"]').tooltip();    
});

var remove = () => {
    removeService("{{ trans('manager.contacts.btn.confirm_delete').'?' }}", "{{ route('manager.addressbook.destroy', [$business, $contact]) }}");
}
</script>
<script type="text/javascript" src="/js/service/services.min.js"></script>
@endpush