var Statistics = {
    csrf : '',
    businessId : '',
    endPoint : '',
    post : {
        businessId : this.businessId || '',
        hr : '',
        start_at : '',
        csrf : this.csrf || '',
    },
    get : function(success, error) { 
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': this.post.csrf || null
            },            
            url: this.endPoint,
            data: this.post,            
            dataType: "json",
            type: "GET",
            success: function (data) {
                // console.log('successLog: ', data);
                if(success) {
                    success(data);
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                // console.log('errorLog: ' + textStatus);
                if(error) {
                    error(data);
                } else {
                    alert('Błąd: '+textStatus);
                }
            }            
        })   
    },
    set : this.get,
}