var webApi = function (endPoint, post) {
    var type = post.type || 'POST';
    post.type = undefined;
    var csrf = post.csrf || null;
    post.csrf = undefined;
    var success = post.success || null;
    post.success = undefined;
    var error = post.error || null;
    post.error = undefined;
    var data = post;
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': csrf
        },            
        url: endPoint,
        data: data,            
        dataType: "json",
        type: type,
        success: function (data) {
            if(success) {
                success(data);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // console.log(jqXHR,textStatus,errorThrown);
            if(error) {
                error(jqXHR);
            };
        }            
    })   
}