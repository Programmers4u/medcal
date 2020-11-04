var ModelStatistics = {
    csrf : '',
    businessId : '',
    endPoint : '',
    businessPriceType: 'business_price',
    types : [this.businessPriceType],
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
                if(success) {
                    success(data);
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                if(error) {
                    error(textStatus);
                } else {
                    alert(errorThrown);
                }
            }            
        })   
    },
    set : this.get,
}