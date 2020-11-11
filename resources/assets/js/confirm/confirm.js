var confirm = function(message, resultFunc, otherFunc) {
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
            resultFunc(true, otherFunc);
        }
        $('#confirm_info_success').text('');
        return true;
    });    
    $("#confirmNo").on("click", function () {
        $('#confirmModal button').click(); 
        if(resultFunc) {
            resultFunc(false, otherFunc);
        }
        $('#confirm_info_success').text('');        
        return false;
    });    
}
