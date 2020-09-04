var alert = function(message,type){
    switch(type){
        case 'error' : 
            $('#mc_info_error').text(message);
            $('#mc_info_error').toggle();
            setTimeout(function(){$('#mc_info_error').toggle(400);$('#alertModal button').click();},1500);
        break;
        default: 
            $('#mc_info_success').text(message);
            $('#mc_info_success').toggle();
            setTimeout(function(){$('#mc_info_success').toggle(400);$('#alertModal button').click();},1500);
        break;
    }
    $('#alertModal').modal({
        keyboard: false,
        backdrop: false,
    })    
}
