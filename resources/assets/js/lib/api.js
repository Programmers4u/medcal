var webApi = function (endPoint, post) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': post.csrf || null
        },            
        url: endPoint,
        data: post,            
        dataType: "json",
        type: "POST",
        success: function (data) {
            if(post.success) {
                post.success(data);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            if(post.error) {
                post.error(data);
            } else {
                alert('Błąd: '+textStatus);
            }
            console.log('ERRORS: ' + textStatus);
        }            
    })   
}