/**
 * Created by Allan Arnesen on 28.03.2017.
 */

$('#team_select').on('click', function(){
    onTeamSelect($('#team_select').val());
});
$('#team_select').on('change', function(){
    onProjectSelect($('#team_select').val(), $('#project_select').val());
});
$('#project_select').on('click', function(){
    onProjectSelect($('#team_select').val(), $('#project_select').val());
});
$('#user_register_tid').on('click', function() {
    registerTime($('#fra').html(), $('#til').html(), $('#sted').html(), $('#predef_task').html(), $('#kommentar').html(),$('#oppgave_select').val(), $('#team_select').val(), $('#user_id').val());
});

function onTeamSelect(team_id, currentSelector) {

    if(currentSelector == 1) {
        var selector="project_select_timer";
        var selectorKey=$('#project_select_timer');
        var selectorTeam=$('#team_select_timer');
    } else {
        var selector="project_select";
        var selectorKey=$('#project_select');
        var selectorTeam=$('#team_select');
    }


    var data = [
        {'name': 'type','value': 'findProject'},
        {'name': 'team_id','value': team_id}
    ];
    $.ajax({
        url: "action_user_register_time.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            if (result != null) {
                if (result.success == "true") { //success
                    document.getElementById(selector).options.length = 0;
                    for (var i in result.projects){
                        var x = document.getElementById(selector);
                        var option = document.createElement("option");
                        option.value = result.projects[i].id;
                        option.text = result.projects[i].name;
                        x.add(option);
                    }
                }
                else { // error
                    document.getElementById(selector).options.length = 0;
                    var x = document.getElementById(selector);
                    var option = document.createElement("option");
                    option.text = 'Ingen prosjekt funnet';
                    x.add(option);

                }

            }
            onProjectSelect(selectorTeam.val(), selectorKey.val());
        }
    });
}

function onProjectSelect(team_id, project_id, currentSelector) {

    if(currentSelector == 1) {
        var selector="oppgave_select_timer";
    } else {
        var selector="oppgave_select";
    }

    var data = [
        {'name': 'type','value': 'findTasks'},
        {'name': 'team_id','value': team_id},
        {'name': 'project_id','value': project_id}
    ];
    $.ajax({
        url: "action_user_register_time.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            if (result != null) {
                if (result.success == "true") { //success
                    document.getElementById(selector).options.length = 0;
                    for (var i in result.tasks){
                        var x = document.getElementById(selector);
                        var option = document.createElement("option");
                        option.value = result.tasks[i].id;
                        option.text = result.tasks[i].name;
                        x.add(option);
                    }
                }
                else { // error
                    document.getElementById(selector).options.length = 0;
                    var x = document.getElementById(selector);
                    var option = document.createElement("option");
                    option.text = 'Ingen oppgaver funnet';
                    x.add(option);
                }

            }
        }
    });
}

function loadHours(user_id){
    var data = [
        {'name': 'type','value': 'loadHours'},
        {'name': 'user_id','value': user_id}
    ];

    $.ajax({
        url: "action_user_register_time.php",
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            if(result!=null){
                if(result.success == "true"){ //success
                    // print out the updated content

                    var x = 1;
                    /*if (document.getElementById("user_all_hours").rows.length > 1){
                        clearRowTable("user_all_hours");
                    }*/

                    var arrayLength= result.hours.length;
                    for (i = 0; i < arrayLength; i++){
                        var table = document.getElementById("user_all_hours");
                        var row = table.insertRow(x);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        var cell5 = row.insertCell(4);
                        var cell6 = row.insertCell(5);
                        var cell7 = row.insertCell(6);
                        var cell8 = row.insertCell(7);
                        var cell9 = row.insertCell(8);
                        cell1.innerHTML = result.hours[i].id;
                        cell2.innerHTML = result.hours[i].Start;
                        cell3.innerHTML = result.hours[i].Stop;
                        cell4.innerHTML = result.hours[i].Place;
                        cell5.innerHTML = result.hours[i].PredefinedTask;
                        cell6.innerHTML = result.hours[i].Team_id;
                        cell7.innerHTML = result.hours[i].Task_id;
                        cell8.innerHTML = result.hours[i].Comment;
                        cell9.innerHTML = '<a href="#" onclick="changeTimeStatus(this.id)" name="reg_id" id="' +result.hours[i].id +'">'+ result.hours[i].Active + '</a>';
                        //table.add(row);
                        x++;

                    }
                }
                else{ // errror
                    var table = document.getElementById("user_all_hours");
                    var row = table.insertRow(1);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    var cell4 = row.insertCell(3);
                    var cell5 = row.insertCell(4);
                    var cell6 = row.insertCell(5);
                    var cell7 = row.insertCell(6);
                    var cell8 = row.insertCell(7);
                    var cell9 = row.insertCell(8);
                    cell1.innerHTML = 'N/A';
                    cell2.innerHTML = 'N/A';
                    cell3.innerHTML = 'N/A';
                    cell4.innerHTML = 'N/A';
                    cell5.innerHTML = 'N/A';
                    cell6.innerHTML = 'N/A';
                    cell7.innerHTML = 'N/A';
                    cell8.innerHTML = 'Ingen timeregistreringer funnet!';
                    cell9.innerHTML = 'N/A';
                    table.add(row);

                }
            }
        }
    });
}

function loadTeams(userId){
    var data = [
        {'name': 'type','value': 'loadTeams'},
        {'name': 'user_id','value': userId}
    ];
    $.ajax({
        url: "action_user_register_time.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            var ans = $('#team_select');
            if (result != null) {
                if (result.success == "true") { //success
                    document.getElementById('team_select').options.length = 0;
                    for (var i in result.projects){
                        var x = document.getElementById("team_select");
                        var option = document.createElement("option");
                        option.value = result.projects[i].id;
                        option.text = result.projects[i].name;
                        x.add(option);
                    }
                }
                else { // error
                    document.getElementById('team_select').options.length = 0;
                    var x = document.getElementById("team_select");
                    var option = document.createElement("option");
                    option.text = 'Ingen team funnet';
                    x.add(option);

                }

            }
        }
    });
}

function registerTime(from, until, place, predefTask, comment, taskId, teamId, userId, setting){
    if(setting == 1){
        var infoElement=$('#info_user_register_time_timer');
    } else {
        var infoElement=$('#info_user_register_time');
    }

    var data = [
        {'name': 'type','value': 'register_time'},
        {'name': 'from','value': from},
        {'name': 'until','value': until},
        {'name': 'place','value': place},
        {'name': 'predefTask','value': predefTask},
        {'name': 'comment','value': comment},
        {'name': 'user_id', 'value': userId},
        {'name': 'team_id', 'value': teamId},
        {'name': 'task_id', 'value': taskId},
        ];
    $.ajax({
        url: "action_user_register_time.php",
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            if(result!=null){
                var ans = infoElement;
                if(result.success == "true"){ //success
                    if(ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    ans.addClass("alert-info");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        infoElement.fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                    clearRowTable("user_all_hours");
                    loadHours($('#user_id').val());
                }
                else{ // errror
                    if(ans.hasClass("alert-info"))
                        ans.removeClass("alert-info");
                    ans.addClass("alert-danger");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        infoElement.fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
            }
        }
    });

}

function clearRowTable(table_name){
    var rows = document.getElementById(table_name).rows;
    var i = rows.length;
    while (--i) {
        rows[i].parentNode.removeChild(rows[i]);
    }
}

function changeTimeStatus(reg_id){

    var data = [
        {'name': 'type','value': 'ToggleTimeStatus'},
        {'name': 'reg_id', 'value': reg_id}
    ];
    $.ajax({
        url: "action_user_register_time.php",
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            if(result!=null){
                var ans = $('#info_user_register_time2');
                if(result.success == "true"){ //success
                    if(ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    ans.addClass("alert-info");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#info_user_register_time2").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                    clearRowTable("user_all_hours");
                    loadHours($('#user_id').val());
                }
                else{ // errror
                    if(ans.hasClass("alert-info"))
                        ans.removeClass("alert-info");
                    ans.addClass("alert-danger");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#info_user_register_time2").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
            }
        }
    });
}


function onload(){
    loadTeams($('#user_id').val());
    loadHours($('#user_id').val());
}