var confirm = function(message, resultFunc) {
    // console.log('CONFIRM:',message);
    $('#confirm_info_success').text(message);
    $('#confirm_info_success').show();
    $('#confirmModal').modal({
        keyboard: false,
        backdrop: false,
    });
    $("#confirmYes").on("click", function () {
        $('#confirmModal button').click(); 
        if(resultFunc) {
            resultFunc(true);
        }
        $('#confirm_info_success').text('');
        return true;
    });    
    $("#confirmNo").on("click", function () {
        $('#confirmModal button').click(); 
        if(resultFunc) {
            resultFunc(false);
        }
        $('#confirm_info_success').text('');        
        return false;
    });    
}
