var removeService = function (ask, route) {
    confirm(ask, function(result) {
        if(!result)
            return false;
        
        var form =
            $('<form>', {
                'method': 'POST',
                'action': route
            });
 
            var token =
            $('<input>', {
                'type': 'hidden',
                'name': '_token',
                    'value': '{{ csrf_token() }}'
                });
 
            var hiddenInput =
            $('<input>', {
                'name': '_method',
                'type': 'hidden',
                'value': 'DELETE'
            });
 
            form.append(token, hiddenInput).appendTo('body');  
            form.submit();
            return true;
    });
}