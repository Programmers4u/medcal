var appointment_id = -1;
var historyId = -1;

var popUp = function(obj){
    $('#'+obj).modal({
        keyboard: false,
        backdrop: false,
    });
}

var getAppointmentNote = function(endPoint, post) {
    webApi(endPoint, post);
}

var putAppointmentNote = function(endPoint, post) {
    webApi(endPoint, post);
}
var addNote = function(endPoint, post) {
    var info = prompt('Napisz notatkę');
    if(info===null) return;
    post.note = info;
    webApi(endPoint, post);
}

