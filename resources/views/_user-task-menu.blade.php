<!-- Tasks: style can be found in dropdown.less -->
<li class="dropdown tasks-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <i class="fa fa-flag-o"></i>
      <span class="label label-danger" id='task_count_s'></span>
    </a>
    <ul class="dropdown-menu">
      <li class="header" id='task_count'>Dzisiejsze spotkania: 0</li>
      <li>
        <!-- inner menu: contains the actual data -->
        <ul class="menu" id='tasks'></ul>
    </li>
    <li class="footer">
      <a href="#"></a>
    </li>
  </ul>
</li>          

@push('footer_scripts')
<script>

var refreshMenuApp = function(){
    var task_count = 0;
    $('#task_count_s').text(task_count);
    $('#task_count').text('Dzisiejsze spotkania: '+task_count);
    let business = {{ $business->id }} ;

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        url: '{{ route('api.get.appointments',$business->id) }}',
        type: 'GET',
        cache: false,
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data, textStatus, jqXHR)
        {
            if(typeof data.error === 'undefined')
            {
                task_count = data.length;
                $('#task_count_s').text(task_count);
                $('#task_count').text('Dzisiejsze spotkania: '+task_count);

                let tasks = '';

                for(let z=0;z<data.length;z++) {
                    let taskName = data[z].start_at+' '+data[z].contact_name+' - '+data[z].staff;
                    var link = "{{ route('medical.document.link',[$business,-1]) }}";
                    link = link.replace('-1','');
                    let task = '<li><!-- Task item --><a href="'+link+data[z].id+'"><h3>'+taskName+'<small class="pull-right"></small></h3></a></li><!-- end task item -->';
                    tasks+=task;
                }
                $('#tasks').html(tasks);
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
};

$(document).ready(function(){
    refreshMenuApp();
});
</script>
@endpush