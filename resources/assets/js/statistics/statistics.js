var ModelStatistics = {
    csrf : '',
    businessId : '',
    endPoint : '',
    businessPriceType: 'business_price',
    diagnosisType: 'diagnosis',
    diagnosisSexType: 'diagnosis_sex',
    types : [this.businessPriceType,this.diagnosisType,this.diagnosisSexType],
    post : {
        businessId : this.businessId || '',
        hr : '',
        start_at : '',
    },
    init : function () {
        return this.csrf;
    }, 
    get : function(success, error) { 
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': this.csrf || null
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