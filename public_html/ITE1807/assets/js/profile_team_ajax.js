/* Created by vicki on 03/03/17.
*/
//var alertDeleteButton = '<a href="#" class="close" onclick="removeEmployeeFromTeam($(this))">&times;</a>';

$('#user_teams').on('change', function(){
    findEmployeesByTeamId($('#user_teams').val());
});

$('#c_user_teams').on('change', function(){
    findProjectsByTeamId($('#c_user_teams').val());
});

$('#find_employee').on('click', function(){
    findEmployeeByEmail($('#find_username').val());
});

$('#team_projects').on('change', function(){
    findTasksByTeamAndProject($('#user_teams').val(), $('#team_projects').val())
 //   findEmployeeByEmail($('#find_username').val());
});

$('#team_proj_tasks').on('change', function(){
    getTaskById($('#team_proj_tasks').val());
    //   findEmployeeByEmail($('#find_username').val());
});

$('#form_create_task').submit(function(event){
    // cancels the form submission
    event.preventDefault();
    submitNewTask();

});


function onReportTeamLoad(){
    var t_id = $('#user_teams').val();
    findEmployeesByTeamId(t_id);
    loadTeamTimes();
}

function loadTeamTimes(){
    var uid = $('#logged_uid').val();
    var tm_approve_table = $('#approve_team_hours').DataTable( {
        ajax: {
            url: 'team_time_action.php',
            cache: false,
            dataType: 'json',
            type: "POST",
            data: {
                    'type':'team_time_for_approval',
                    'user_id': uid},
            dataSrc: 'times'

        },
        fixedColumns:   {
            leftColumns: 2
        },
        scrollX:        true,
        scrollCollapse: true,
        responsive: true,
        columns: [
            { data: 'id' },
            { data: 'Fullname' },
            { data: 'Project_name' },
            { data: 'Team_name' },
            { data: 'Task_name' },
            { data: 'Start' },
            { data: 'Stop' },
            { data: 'Place' },
            { data: 'Comment' }
        ],
            "columnDefs": [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                },
                {
                    'targets': [1, 2, 3, 4, 5, 6, 7],
                    'width': "50px"
                },
                {
                    'targets': 8,
                    'width': "100px"
                }
                ],
        'select': {
            'style':    'multi'
            }
    } );


    $('#tm_panelApproveTime').on('show.bs.collapse', function () {
        $(window).resize();
        $(this).resize();
    });
}

function getIdsForApproving(){
    var table = $('#approve_team_hours').DataTable();
    var ids = [];
    var rows_selected = table.column(0).checkboxes.selected();

    // Iterate over all selected checkboxes
    $.each(rows_selected, function(index, rowId){
        ids.push(rowId);
    });
    //alert(JSON.stringify(ids));
    submitIdsForApproval(ids);
}

function getTaskById($taskId){


    if ($taskId > 0) {

        var data = [
            { 'name':'type', 'value':'task_by_id'},
            { 'name':'task_id', 'value': $taskId}
        ];
        $.ajax({
            url: "find.php",
            cache: false,
            dataType: 'json',
            type: "POST",
            data : data,
            success: function (result, success) {


                if(result == null || result.task == null){

                    return;
                }

                $('#tm_task_start_date').val(result.task.start);
                $('#tm_task_end_date').val(result.task.end);
                $('#tm_edit_status_input').val(result.task.statusId)

            }
        });
    }


}

/*function toggleCreateForm() {
    $("#c_task").toggle();
}*/

function toggleUpdateTask(reset){

    $("#tm_btnEditTask").toggle();
    $("#tm_btnSaveTask").toggle();
    $("#tm_btnResetTask").toggle();
    $("#tm_btnDeleteTask").toggle();
    $("#team_proj_tasks_input").toggle();
    $("#team_proj_tasks").toggle();
    $("#tm_select_project").toggle();



    if($("#tm_btnEditTask").css('display') != 'none'){

        if(reset){
            $("#tm_task_end_date").val($("#tm_task_end_date_old").val());
            $("#tm_task_start_date").val($("#tm_task_start_date_old").val());
            $("#tm_edit_status_input").val($("#tm_edit_status_input_old").val());
            $("#tm_task_hours").val($("#tm_task_hours_old").val());

        }

        $("#tm_task_end_date").attr('readonly', true);
        $("#tm_task_start_date").attr('readonly', true);
       // $("#tm_edit_status_input option:selected").val();
        $("#tm_edit_status_input").prop('disabled', true);
        $("#tm_task_hours").prop('disabled', true);


    }
    else
    {
        $("#tm_task_end_date_old").val($("#tm_task_end_date").val());
        $("#tm_task_end_date").attr('readonly', false);
        $("#tm_task_start_date_old").val($("#tm_task_start_date").val());
        $("#tm_task_start_date").attr('readonly', false);
        $("#tm_edit_status_input_old").val($("#tm_edit_status_input option:selected").val());
        $("#tm_edit_status_input").prop('disabled', false);
        $("#tm_task_hours_old").val($("#tm_task_hours").val());
        $("#tm_task_hours").prop('disabled', false);

        var str = $("#team_proj_tasks  option:selected").text().trim();
        var index  = str.indexOf(" :: ");
        if(index != -1)
        str = str.substring(0, index+1);
        $("#team_proj_tasks_input").val(str);
    }

}

function findEmployeesByTeamId(teamid, prj_selected) {
        //alert("success2");
        // check teamid
        if (teamid > 0) {

            var data = [
                { 'name':'type', 'value':'team_changed'},
                { 'name':'team_id', 'value': teamid}
            ];
            $.ajax({
                url: "find.php",
                cache: false,
                dataType: 'json',
                type: "POST",
                data : data,
                success: function (result, success) {

                    //alert(result);
                    if(result == null){
                        return;
                    }

                    var values = '';
                    for (var i in result.users)
                    {
                        values += makeListGroupItem(result.users[i].fullname
                                                    ,result.users[i].email
                                                    ,result.users[i].id
                                                    ,result.users[i].isTeamleader
                                                    );
                    }
                    $('#team_members').html(values);

                    var p_values = '';
                    for (var i in result.projects)
                    {
                        p_values += makeSelectOptionItem(result.projects[i].id
                                                    ,result.projects[i].name
                                                    ,result.projects[i].start
                                                    ,result.projects[i].end
                                                    ,result.projects[i].status
                                                    , (i == prj_selected)
                                                    );
                    }

                    $('#team_projects').html(p_values);
                }
            });
        }
}

function findProjectsByTeamId(teamid, sel_id) {

    // check teamid
    if (teamid > 0) {

        var data = [
            { 'name':'type', 'value':'team_changed'},
            { 'name':'team_id', 'value': teamid}
        ];
        $.ajax({
            url: "find.php",
            cache: false,
            dataType: 'json',
            type: "POST",
            data : data,
            success: function (result, success) {

                //alert(result);
                if(result == null){

                    return;
                }

                var p_values = '';
                for (var i in result.projects)
                {
                    //<option> for <select>
                    p_values += makeSelectOptionItem(result.projects[i].id
                        ,result.projects[i].name
                        ,result.projects[i].start
                        ,result.projects[i].end
                        ,result.projects[i].status
                        , (sel_id == i)
                    );
                }


                $('#c_team_projects').html(p_values);
            }
        });
    }
}

function findTasksByTeamAndProject(tid, pid) {

    // check teamid
    if (tid > 0 && pid > 0) {

        var data = [
            { 'name':'type', 'value':'tasks_by_team_and_project'},
            { 'name':'team_id', 'value': tid},
            { 'name':'project_id', 'value': pid}
        ];
        $.ajax({
            url: "find.php",
            cache: false,
            dataType: 'json',
            type: "POST",
            data : data,
            success: function (result, success) {

                //alert(result);
                if(result == null){
                    return;
                }
                else alert("not null");

                var task_selected;
                var values = '';
                for (var i in result.tasks)
                {

                    values += makeSelectOptionItem(
                            result.tasks[i].id
                            ,result.tasks[i].name
                            ,result.tasks[i].start
                            ,result.tasks[i].end
                            ,result.tasks[i].statusId
                            ,false

                    );
                }

                if(result.tasks.length > 0 ){
                    task_selected = result.tasks[0];

                }
                $('#team_proj_tasks').html(values);
                //$('#tm_task_start_date').val(task_selected.);
            }
        });
    }
}

function findEmployeeByEmail(mail) {
    //alert("success");
    // check teamid
    if (mail.length > 0) {

        var data = [
            { 'name':'type', 'value':'user_by_email'},
            { 'name':'email', 'value': mail}
        ];
        $.ajax({
            url: "find.php",
            cache: false,
            dataType: 'json',
            type: "POST",
            data : data,
            success: function (result, success) {
                var found = $('#found_user-div');

                if(result!=null && result.UserDTos[0]){ //only one user per email
                    //var value = result.UserDTos[0].fullname + ", " + result.UserDTos[0].email;
                    found.children("span").text(makeFoundItem(result.UserDTos[0].fullname, result.UserDTos[0].email));
                    $('#emailToAdd').val(result.UserDTos[0].email); //hidden with email to be added to the team
                    $('#idToAdd').val(result.UserDTos[0].id);
                    $('#fullnameToAdd').val(result.UserDTos[0].fullname);
                    found.show();

                    //alert($('#emailToAdd').val());
                    //$('#found_user').html(el);
                }
                else{
                    found.children("span").text('');
                    $('#emailToAdd').val('');
                    $('#idToAdd').val('');
                    $('#fullnameToAdd').val('');
                    found.hide();
                }

            }
        });
    }
}

///////===== helpers ===========

function checkTaskDates(oncreate){
    var message = '';
    var error = false;

    var start_ctrl = null;
    var end_ctrl = null;

    if(oncreate){
        start_ctrl = $("#tm_create_task_start_date");
        end_ctrl = $("#tm_create_task_end_date");
    }
    else{
        start_ctrl = $("#tm_task_start_date");
        end_ctrl = $("#tm_task_end_date");
    }


    var startdate = start_ctrl.val();  //.data("DateTimePicker").date();
    if(startdate.length==0){
        message += 'Start date is not supplied. ';
        error = true;
    }


    var enddate = end_ctrl.val(); //.data("DateTimePicker").date();
    if(enddate.length==0){
        message += 'End date is not supplied. ';
        error = true;
    }

    var start_ts = moment(startdate, "DD/MM/YYYY", true); //Date.parse(startdate);
    var end_ts = moment(enddate, "DD/MM/YYYY", true); //Date.parse(enddate);

    var start;
    var end;

    if (!start_ts.isValid()){
        message += 'Invalid start date. ';
        error = true;
    }

    if (!end_ts.isValid()){
        message += 'Invalid end date. ';
        error = true;
    }

    if(!error && start_ts >= end_ts){
        message += 'Start date must be less then end date. ';
        error = true;
    }

    return message;
}

function makeListGroupItem(fullname, email, id, isleader){
    var el = '<li class="list-group-item" value="' + id +'" ><strong>' + fullname + '</strong>, '+ email;
    if(!isleader){
        el+='<a href="#" class="close" onclick="removeEmployeeFromTeam($(this))">&times;</a>';
        el+='<a href="#" class="btn btn-xs btn-primary pull-left" onclick="changeTeamLeader(' + id + ')">make a leader</a>';
    }

    el+='</li>';
    return el;
}

function makeSelectOptionItem(id, name, start, end, status, isselected){
    var selected = (isselected)? ' selected ' : '';
    var el = '<option  value="' + id  +'"' + selected + '>' + name
        + '  :: ' +  status + '</option>';

    return el;
}

function makeFoundItem(fullname, email){
    var el = fullname + ", "+ email;
    return el;
}

function getTeamUserIds(){

    var ids = new Array();
    $('#team_members li').each(function(){
        ids.push($(this).attr("value"));
    });

    return ids;
}

///////===== Team opps =========

function submitTeamMembers(){

    var team_id = $('#user_teams').val();
    var ids = getTeamUserIds();
    //var jsonar = JSON.stringify(ids);
    var data = [
        { 'name':'team_id', 'value':team_id},
        { 'name':'ids', 'value': ids}
    ];
    if(ids.length > 0) {
        $.ajax({
            url: "update_teamusers_action.php", //"http://localhost/ITE1807/controller/update_teamusers_action.php",
            cache: false,
            dataType: 'json',
            type: "POST",
            data : data,
            success: function (result, success) {
                if(result!=null){
                    var ans = $('#team-users-alert');
                    if(result.success == "true"){ //success
                        if(ans.hasClass("alert-danger"))
                            ans.removeClass("alert-danger");
                        if(!ans.hasClass("alert-danger"))
                            ans.addClass("alert-info");
                        ans.children("span").text(result.message);
                        ans.show();
                    }
                    else{ // errror
                        if(ans.hasClass("alert-iinfo"))
                            ans.removeClass("alert-info");
                        if(!ans.hasClass("alert-danger"))
                            ans.addClass("alert-danger");
                        ans.children("span").text(result.message);
                        ans.show();
                    }
                }
            }
        });
    }
}

function addFoundEmployeeToTeam() {

    var list = $('#team_members');
    var email = $('#emailToAdd').val();
    var id = $('#idToAdd').val();
    var fullname= $('#fullnameToAdd').val();

    var found=false;
    $('#team_members li').each(function(){
        if(id==$(this).attr("value")){
            found = true;
            return true;
        }
    });

    if(found){
        alert("this person is already in the team.")
    }
    else{
        list.append(makeListGroupItem(fullname, email, id));
    }
}

function removeEmployeeFromTeam(el){
    id = el.parent().val();
    el.parent().remove();
}

function changeTeamLeader(id){
    var ans = $('#team-users-alert');
    var uid = $('#logged_uid').val();
    var taskId = $('#team_proj_tasks').val();
    var data = [
        { 'name':'type', 'value': 'change_team_leader'},
        { 'name':'team_id', 'value': taskId },
        { 'name':'user_id', 'value': id },
        { 'name':'logged_uid', 'value': uid }
    ];

    $.ajax({
        url: "team_action.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {

            if(result == null){
                //alert("null");
                return;
            }

            if(result.success == true){ //success

                if(ans.hasClass("alert-danger"))
                    ans.removeClass("alert-danger");
                if(!ans.hasClass("alert-info"))
                    ans.addClass("alert-info");
                ans.children('span').text(result.message);
                ans.show();

                location.reload(true);
            }
            else{ // errror


                if(ans.hasClass("alert-info"))
                    ans.removeClass("alert-info");
                if(!ans.hasClass("alert-danger"))
                    ans.addClass("alert-danger");
                ans.children('span').text(result.message);
                ans.show();

            }

        },
        error: function(result){
            if(ans.hasClass("alert-info"))
                ans.removeClass("alert-info");
            if(!ans.hasClass("alert-danger"))
                ans.addClass("alert-danger");
            ans.children('span').text(result);
            ans.show();
        }
    });
}

///////===== Task CRUD =========

function submitNewTask(){

    var ans = $('#tm_create-task-alert');
    var message = '';
    var error = false;
    var team_id =$('#c_user_teams').val();

    var project_id =$('#c_team_projects').val();

    var taskname = $('#c_task_name').val().trim();

    var taskhours = $('#tm_create_task_hours').val();

    alert($('#tm_create_task_hours').val());
    taskhours = (isNaN(taskhours) || taskhours <  0) ? 0 : taskhours;


    if(taskname.length==0){
        message += 'Name of task is not supplied. ';
        error = true;
    }

    message += checkTaskDates(true);
    if(message !== ''){
        error = true;
    }


    if(error){

        if(ans.hasClass("alert-info"))
            ans.removeClass("alert-info");
        ans.addClass("alert-danger");
        ans.children('span').text(result.message);
        ans.show();
        return;
    }
    startdate=$("#tm_create_task_start_date").val(); //.split('/').join('-');
    enddate=$("#tm_create_task_end_date").val(); //.split('/').join('-');

    var data = [
        { 'name':'type', 'value': 'create_task'},
        { 'name':'team_id', 'value': team_id},
        { 'name':'project_id', 'value': project_id},
        { 'name':'task_name', 'value': taskname },
        { 'name':'task_hours', 'value': taskhours },
        { 'name':'task_start', 'value': startdate },
        { 'name':'task_end', 'value':  enddate }
        ];


    $.ajax({
        url: "task_action.php", //"http://localhost/ITE1807/controller/update_teamusers_action.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            if(result!=null){

                if(result.success == true){ //success
                    if(ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    if(!ans.hasClass("alert-info"))
                        ans.addClass("alert-info");
                    ans.children('span').text(result.message);
                    ans.show();
                    window.location=window.location + '?active_tab=team';
                }
                else{ // errror
                    if(ans.hasClass("alert-info"))
                        ans.removeClass("alert-info");
                    if(!ans.hasClass("alert-danger"))
                        ans.addClass("alert-danger");
                    ans.children('span').text(result.message);
                    ans.show();
                }
            }
        },
        error: function(result){
            if(ans.hasClass("alert-info"))
                ans.removeClass("alert-info");
            if(!ans.hasClass("alert-danger"))
                ans.addClass("alert-danger");
            ans.children('span').text(result.message);
            ans.show();
        }
    });
}

function updateTask(){

    var ans = $('#tm_edit_task_alert');
    var message = checkTaskDates(false);

    var error = (message != '');
    var taskId = $('#team_proj_tasks').val();

    if (taskId > 0 && error==false) {
        var name = $('#team_proj_tasks_input').val();
        var statusId = $('#tm_edit_status_input').val();
        var start = $('#tm_task_start_date').val();
        var end = $('#tm_task_end_date').val();
        var taskhours = $('#tm_task_hours').val();
        alert(""+taskhours);
        taskhours = (isNaN(taskhours) || parseInt(taskhours) < 0) ? 0 : parseInt(taskhours);

        //startdate=$("#tm_create_task_start_date").val().split('/').join('-');
        //enddate=$("#tm_create_task_end_date").val().split('/').join('-');


        var data = [
            { 'name':'type', 'value': 'update_task'},
            { 'name':'task_name', 'value': name },
            { 'name':'task_hours', 'value': taskhours },
            { 'name':'task_id', 'value': taskId },
            { 'name':'task_start', 'value': start },
            { 'name':'task_end', 'value': end },
            { 'name':'statusId', 'value':  statusId }
        ];

        $.ajax({
            url: "task_action.php",
            cache: false,
            dataType: 'json',
            type: "POST",
            data : data,
            success: function (result, success) {

                if(result == null){
                    //alert("null");
                    return;
                }

                if(result.success == true){ //success
                    /* $('#team_proj_tasks_input').val(result.task.name);
                     $('#tm_edit_status_input').val(result.task.statusId);
                     $('#tm_task_start_date').val(result.task.start);
                     $('#tm_task_end_date').val(result.task.end);*/

                    if(ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    if(!ans.hasClass("alert-info"))
                        ans.addClass("alert-info");
                    ans.children('span').text(result.message);
                    ans.show();

                    //getTaskById(result.task.id);
                   // location.reload(true);
                    window.location=window.location + '?active_tab=team';
                }
                else{ // errror


                    if(ans.hasClass("alert-info"))
                        ans.removeClass("alert-info");
                    if(!ans.hasClass("alert-danger"))
                        ans.addClass("alert-danger");
                    ans.children('span').text(result.message);
                    ans.show();

                }

            },
            error: function(result){
                if(ans.hasClass("alert-info"))
                    ans.removeClass("alert-info");
                if(!ans.hasClass("alert-danger"))
                    ans.addClass("alert-danger");
                ans.children('span').text(result);
                ans.show();
            }
        });
    }
    else{
        if(ans.hasClass("alert-info"))
            ans.removeClass("alert-info");
        if(!ans.hasClass("alert-danger"))
            ans.addClass("alert-danger");
        ans.children('span').text(message);
        ans.show();
    }

}

function deleteTask(){
    var ans = $('#tm_edit_task_alert');
    var message = checkTaskDates(false);

    var error = (message != '');
    var taskId = $('#team_proj_tasks').val();
    var statusId = $('#tm_edit_status_input').val();
    if(statusId != 'ONHOLD'){
        error = true;
        message += 'Cannot delete task which has been already started/finished. '
    }

    //alert(message);

    //alert(taskId);
    if (taskId > 0 && error==false) {
        var uid = $('#logged_uid').val();



        var data = [
            { 'name':'type', 'value': 'delete_task'},
            { 'name':'task_id', 'value': taskId },
            { 'name':'user_id', 'value':  uid } //TODO: check permissions on server-side, not implemented yet.
        ];

        $.ajax({
            url: "task_action.php",
            cache: false,
            dataType: 'json',
            type: "POST",
            data : data,
            success: function (result, success) {

                if(result == null){
                    //alert("null");
                    return;
                }



                if(result.success == true){ //success

                    if(ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    if(!ans.hasClass("alert-info"))
                        ans.addClass("alert-info");
                    ans.children('span').text(result.message);
                    ans.show();

                    location.reload(true);
                }
                else{ // errror


                    if(ans.hasClass("alert-info"))
                        ans.removeClass("alert-info");
                    if(!ans.hasClass("alert-danger"))
                        ans.addClass("alert-danger");
                    ans.children('span').text(result.message);
                    ans.show();

                }

            },
            error: function(result){
                if(ans.hasClass("alert-info"))
                    ans.removeClass("alert-info");
                if(!ans.hasClass("alert-danger"))
                    ans.addClass("alert-danger");
                ans.children('span').text(result);
                ans.show();
            }
        });
    }
    else{
        if(ans.hasClass("alert-info"))
            ans.removeClass("alert-info");
        if(!ans.hasClass("alert-danger"))
            ans.addClass("alert-danger");
        ans.children('span').text(message);
        ans.show();
    }
}

/////====== Team Time Approving /////////

function submitIdsForApproval(ids){

    if(ids == null){
        alert("Nothing to approve.");
        return;
    }


    var ans = $('#tm_approve_time_alert');
    var data = [
        { 'name':'type', 'value': 'approve_time'},
        { 'name':'ids', 'value': ids }
    ];

    $.ajax({
        url: "team_time_action.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {

            if(result == null){
                //alert("null");
                return;
            }

            if(result.success == true){ //success

                if(ans.hasClass("alert-danger"))
                    ans.removeClass("alert-danger");
                if(!ans.hasClass("alert-info"))
                    ans.addClass("alert-info");
                ans.children('span').text(result.message);
                ans.show();

               $('#approve_team_hours').DataTable().ajax.reload();

            }
            else{ // errror

                if(ans.hasClass("alert-info"))
                    ans.removeClass("alert-info");
                if(!ans.hasClass("alert-danger"))
                    ans.addClass("alert-danger");
                ans.children('span').text(result.message);
                ans.show();

            }

        },
        error: function(result){
            if(ans.hasClass("alert-info"))
                ans.removeClass("alert-info");
            if(!ans.hasClass("alert-danger"))
                ans.addClass("alert-danger");
            ans.children('span').text(result);
            ans.show();
        }
    });

}





