var confirm = function(message){
    console.log('CONFIRM:',message);
    $('#confirm_info_success').text(message);
    $('#confirm_info_success').toggle();
    setTimeout(function(){$('#confirm_info_success').toggle(400);$('#confirmModal button').click();},1500);
    $('#confirmModal').modal({
        keyboard: false,
        backdrop: false,
    })    
}
