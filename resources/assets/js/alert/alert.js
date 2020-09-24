var alert = function(message,type){
    // console.log('ALERT:',message,type);
    switch(type){
        case 'error' : 
            $('#mc_info_error').text(message);
            $('#mc_info_error').show();
            $('#mc_info_success').hide();
            setTimeout(function(){$('#alertModal button').click();$('#mc_info_error').text('')},1500);
        break;
        case 'success' : 
            $('#mc_info_success').text(message);
            $('#mc_info_success').show();
            $('#mc_info_error').hide();
            setTimeout(function(){$('#alertModal button').click();$('#mc_info_success').text('')},1500);
        break;
        default: 
            $('#mc_info_success').text(message);
            $('#mc_info_success').show();
            $('#mc_info_error').hide();
            setTimeout(function(){$('#alertModal button').click();$('#mc_info_success').text('')},1500);
        break;
    }
    $('#alertModal').modal({
        keyboard: false,
        backdrop: false,
    })    
}
