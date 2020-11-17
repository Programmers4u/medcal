const alert = function(message, type) {
    // console.log('ALERT:',message,type);
    const delay = 2000;
    switch(type) {
        case 'error' : 
            $('#mc_info_error').text(message);
            $('#mc_info_error').show();
            $('#mc_info_success').hide();
            setTimeout(function(){$('#alertModal button').click();$('#mc_info_error').text('')},delay);
        break;
        case 'success' : 
            $('#mc_info_success').text(message);
            $('#mc_info_success').show();
            $('#mc_info_error').hide();
            setTimeout(function(){$('#alertModal button').click();$('#mc_info_success').text('')},delay);
        break;
        default: 
            $('#mc_info_success').text(message);
            $('#mc_info_success').show();
            $('#mc_info_error').hide();
            setTimeout(function(){$('#alertModal button').click();$('#mc_info_success').text('')},delay);
        break;
    }
    $('#alertModal').modal({
        keyboard: false,
        backdrop: false,
    })    
}
