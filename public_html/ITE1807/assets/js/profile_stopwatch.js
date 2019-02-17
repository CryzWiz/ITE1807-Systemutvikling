$('#start_timer').on('click', function(){
    timerStart();
});

$('#stop_timer').on('click', function(){
    timerStop();
});


$('#team_select_timer').on('click', function(){
    onTeamSelect($('#team_select_timer').val(),1);
});
$('#team_select_timer').on('change', function(){
    onProjectSelect($('#team_select_timer').val(), $('#project_select_timer').val(),1);
});
$('#project_select_timer').on('click', function(){
    onProjectSelect($('#team_select_timer').val(), $('#project_select_timer').val(),1);
});
$('#user_register_tid_timer').on('click', function() {
    registerTime($('#start_timer').html(),$('#stop_timer').html(), $('#sted_timer').html(), $('#predef_task_timer').html(), $('#kommentar_timer').html(),$('#oppgave_select_timer').val(), $('#team_select_timer').val(), $('#user_id_timer').val(),1);
});


var timerStarted = 0;
var timerStopped = 0;
var timerRunning = 0;

if((timerStarted = checkTimerCookie()) != null){
    var cookietime = new Date(parseInt(timerStarted)).getTime();
    document.getElementById("start_timer").removeAttribute("class");
    document.getElementById("start_timer").innerHTML = moment(cookietime).format("YYYY-MM-d HH:mm");
    timerRunning = 1;
    timerUpdatePresentation();
}

function checkTimerCookie() {
    var cookie = decodeURIComponent(document.cookie);
    var cookiearray = cookie.split(";")
    for(c in cookiearray) {
        while(cookiearray[c].charAt(0)==" ") {
            cookiearray[c]=cookiearray[c].substr(1);
        }
        if(cookiearray[c].indexOf("timer_started") == 0) {
            var mycookie = JSON.parse(cookiearray[c].split('=')[1]);
            if( mycookie[0] == $('#user_id').val()) {
                var started = mycookie[1];
                var cookietime = new Date(parseInt(started)).getTime();
                alert("En timeregistrering pågår. Startet: " + moment(cookietime).format("YYYY-MM-d HH:mm"));
                return started;
            }
        }
    }
    return null;
}

function timerStart(){
    if(timerRunning == 0) {
        timerRunning = 1;
        timerStarted = (new Date()).getTime();
        var endOfDay = (new Date());
        endOfDay.setHours(23,59,59,999);
        document.getElementById("start_timer").removeAttribute("class");
        document.getElementById("start_timer").innerHTML = moment(timerStarted).format("YYYY-MM-d HH:mm");
        var cookiearray = [$('#user_id').val(),timerStarted];
        document.cookie = "timer_started=" + JSON.stringify(cookiearray) + "; expires=" + endOfDay;
        timerUpdatePresentation();
    }
}

function timerStop(){
    if(timerRunning != 0) {
        timerStopped = (new Date()).getTime();
        timerRunning = 0;
        document.getElementById("stop_timer").removeAttribute("class");
        document.getElementById("stop_timer").innerHTML = moment(timerStopped).format("YYYY-MM-d HH:mm");
        document.cookie = "timer_started=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
    }
}

function timerUpdatePresentation(){
    if(timerRunning == 1) {
        setTimeout(function () {
            var timerCurrent = ((new Date()).getTime() - timerStarted);

            document.getElementById("timer-seconds").innerHTML = timerSeconds(timerCurrent);
            document.getElementById("timer-minutes").innerHTML = timerMinutes(timerCurrent);
            document.getElementById("timer-hours").innerHTML = timerHours(timerCurrent);
            timerUpdatePresentation();
        }, 1000);
    }
}

function timerSeconds(inputTime){
    var seconds = Math.floor(inputTime / 1000) % 60;
    return seconds;
}

function timerMinutes(inputTime) {
    var minutes = Math.floor(inputTime / 60000) % 60;
    return minutes;
}

function timerHours(inputTime) {
    var hours = Math.floor(inputTime / 3600000);
    return hours;
}
