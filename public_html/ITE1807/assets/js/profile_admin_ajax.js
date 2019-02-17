
$('#reset_edit_project').on('click', function(){
    reset_values("edit_project");
});

$('#reset_create_project').on('click', function(){
    reset_values("create_project");
});

$('#reset_create_team').on('click', function(){
    reset_values("create_team");
});

$('#find_employee_admin').on('click', function(){
    findEmployeeByEmail_Admin($('#find_username_admin').val());
});
$('#create_project').on('click', function(){
    createProject($('#project_name').val(), $('#create_project_start').val(), $('#create_project_end').val(),$('#team_select_project').val(), $('#costumer_name').val(), $('#costumer_address').val(), $('#costumer_contactPerson').val(), $('#costumer_email').val());
});

$('#project_manage_select').on('click', function (){
    getSelectedProject($('#project_manage_select').val());
});

$('#update_project').on('click', function(){
    updateProject($('#project_manage_select').val(), $('#project_name_manage').val(), $('#manage_project_start').val(), $('#manage_project_end').val(), $('#project_status').val(), $('#selected_teams').val());
});
$('#delete_project').on('click', function(){
    deleteProject($('#project_manage_select').val());
});
$('#make_team').on('click', function(){
    create_team($('#team_name').val());
});

function reset_values(type){
    switch (type){
        case 'edit_project':
            document.getElementById('project_name_manage').value = "";
            document.getElementById('manage_project_start').value = "";
            document.getElementById('manage_project_end').value = "";
            break;
        case 'create_project':
            document.getElementById('project_name').value = "";
            document.getElementById('create_project_start').value = "";
            document.getElementById('create_project_end').value = "";
            document.getElementById('costumer_name').value = "";
            document.getElementById('costumer_address').value = "";
            document.getElementById('costumer_contactPerson').value = "";
            document.getElementById('costumer_email').value = "";
            break;
        case 'create_team':
            document.getElementById('team_name').value = "";
            break;
    }
}

function dynamicAdding_admin(type, selectorId, value, print) {
    switch(type){
        case 'create_team':
            $(selectorId).append("<option value=\"" + value +"\" id=\"" + value + "\">" + print + "</option>");
            break;
    }
}

function dynamicRemoval_admin(type, selectorId, value) {
    switch(type){
        case 'delete_team':
            $(selectorId + " option[value=" + value + "]").remove();
            break;
    }
}

function createProject(project_name, startdate, enddate, teamId, customerName, customerAddress, customerContactPerson, customerEmail){
    var data = [
        {'name': 'type','value': 'create_project'},
        {'name': 'project_name','value': project_name},
        {'name':'create_project_start','value': startdate},
        {'name':'create_project_end','value': enddate},
        {'name':'teamId','value': teamId},
        {'name':'customerName','value': customerName},
        {'name':'customerAddress','value': customerAddress},
        {'name':'customerContactPerson','value': customerContactPerson},
        {'name':'customerEmail','value': customerEmail}
    ];

    $.ajax({
        url: "action_admin_project.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            var ans = $('#alert_admin_make_projekt');
            if (result != null) {
                if (result.success == "true") { //success
                    if (ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    ans.addClass("alert-info");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_admin_make_projekt").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
                else { // error
                    if (ans.hasClass("alert-info"))
                        ans.removeClass("alert-info");
                    ans.addClass("alert-danger");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_admin_make_projekt").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }

            }
        }
    });
}

function updateProject(project_select, project_name_manage, manage_project_start, manage_project_end, project_status, selected_teams){

    var data = [
        {'name': 'type','value': 'update_project'},
        {'name':'project_select','value': project_select},
        {'name': 'project_name_manage','value': project_name_manage},
        {'name': 'manage_project_start','value': manage_project_start},
        {'name': 'manage_project_end','value': manage_project_end},
        {'name':'project_status','value': project_status},
        {'name': 'selected_teams', 'value': selected_teams}
    ];

    $.ajax({
        url: "action_admin_project.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            var ans = $('#alert_admin_edit_projekt');
            if (result != null) {
                if (result.success == "true") { //success
                    if (ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    ans.addClass("alert-info");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_admin_edit_projekt").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
                else { // error
                    if (ans.hasClass("alert-info"))
                        ans.removeClass("alert-info");
                    ans.addClass("alert-danger");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_admin_edit_projekt").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }

            }

        }
    });
}

function deleteProject(project_name_delete){
    var data = [
        {'name': 'type','value': 'delete_project'},
        {'name':'project_name_delete','value': project_name_delete}
    ];

    $.ajax({
        url: "action_admin_project.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            var ans = $('#alert_admin_edit_projekt');
            if (result != null) {
                if (result.success == "true") { //success
                    if (ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    ans.addClass("alert-info");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_admin_edit_projekt").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
                else { // error
                    if (ans.hasClass("alert-info"))
                        ans.removeClass("alert-info");
                    ans.addClass("alert-danger");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_admin_edit_projekt").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }

            }

        }
    });
}

function findEmployeeByEmail_Admin(mail) {
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
                var found = $('#found_user_admin_manageteam');

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

function addFoundEmployeeToTeam_AsLeader() {

    var id = $('#idToAdd').val();
    var teamId = $('#team_select_teamleader').val();

    var data = [
        { 'name':'type', 'value':'add_teamleader'},
        { 'name':'team_id', 'value':teamId},
        { 'name':'user_id', 'value': id}
        ]

    $.ajax({
        url: "action_admin_team.php",
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            if(result!=null){
                var ans = $('#alert-user_admin_manageteam');
                if(result.success == "true"){ //success
                    if(ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    ans.addClass("alert-info");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert-user_admin_manageteam").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
                else if (result.success == "false"){ // leader finnes
                    if(ans.hasClass("alert-info"))
                        ans.removeClass("alert-info");
                    ans.addClass("alert-danger");

                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert-user_admin_manageteam").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
            }
        }
    });

}

function deleteTeamById(){
    var teamId = $('#team_select_delete').val();
    // check teamid
    if (teamId > 0) {

        var data = [
            { 'name':'type', 'value':'delete_team'},
            { 'name':'team_id', 'value':teamId}
        ];

        var type = 'delete_team';
        var selectorId = '#team_select_delete';
        var value = teamId;
        var toRemove = '#'+teamId;
        var print = 'ny linje';

        $.ajax({
            url: "action_admin_team.php",
            cache: false,
            dataType: 'json',
            type: "POST",
            data : data,
            success: function (result, success) {
                var ans = $('#alert_admin_make_team');
                if (result != null) {
                    if (result.success == "true") { //success
                        if (ans.hasClass("alert-danger"))
                            ans.removeClass("alert-danger");
                        ans.addClass("alert-info");
                        ans.text(result.message);
                        ans.show();
                        dynamicRemoval_admin(type, selectorId, value, print);
                        window.setTimeout(function() {
                            $("#alert_admin_make_team").fadeTo(2000, 500).slideUp(500, function () {
                                $(this).hide();
                            });
                        }, 2000);
                    }
                    else { // error
                        if (ans.hasClass("alert-info"))
                            ans.removeClass("alert-info");
                        ans.addClass("alert-danger");
                        ans.text(result.message);
                        ans.show();
                        window.setTimeout(function() {
                            $("#alert_admin_make_team").fadeTo(2000, 500).slideUp(500, function () {
                                $(this).hide();
                            });
                        }, 2000);
                    }

                }
            }
        });
    }

}

function create_team(team_name) {
    var data = [
        {'name': 'type','value': 'create_team'},
        {'name':'team_name','value': team_name}
    ];

    var type = 'create_team';
    var selectorId = '#team_select_delete';
    var value;
    var print = ''+ team_name;

    $.ajax({
        url: "action_admin_team.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            var ans = $('#alert_admin_make_team');
            if (result != null) {
                if (result.success == "true") { //success
                    if (ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    ans.addClass("alert-info");
                    ans.text(result.message);
                    value = result.teamId;
                    ans.show();
                    dynamicAdding_admin(type, selectorId, value, print);
                    window.setTimeout(function() {
                        $("#alert_admin_make_team").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
                else { // error
                    if (ans.hasClass("alert-info"))
                        ans.removeClass("alert-info");
                    ans.addClass("alert-danger");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_admin_make_team").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }

            }

        }
    });
}

function getSelectedProject(selected_project){
    var data = [
        {'name': 'type','value': 'get_project_details'},
        {'name':'selected_project','value': selected_project}
    ];

    $.ajax({
        url: "action_admin_project.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            var ans = $('#alert_admin_edit_projekt');
            if (result != null) {
                if (result.success == "true") { //success
                    var list = document.getElementById('selected_teams');
                    list.options.length = 0;

                    var allok_team_group = document.getElementById('allokerte_team');
                    var ikke_allok_team_group = document.getElementById('ikke_allokerte_team');
                    var array_selected =[];
                    for (var i in result.selectedTeams){
                        var option = document.createElement("option");
                        option.value = result.selectedTeams[i].id;
                        array_selected[i] = option.value;
                        option.text = result.selectedTeams[i].name;
                        allok_team_group.appendChild(option);

                    }
                    $('.selected-teams').selectpicker('val', array_selected);

                    for (var i in result.freeTeams){
                        var option = document.createElement("option");
                        option.value = result.freeTeams[i].id;
                        option.text = result.freeTeams[i].name;
                        ikke_allok_team_group.appendChild(option);
                    }

                    document.getElementById('project_name_manage').value = result.projects[0].name;
                    document.getElementById('project_status').value = result.projects[0].status;
                    document.getElementById('manage_project_start').value = result.projects[0].start;
                    document.getElementById('manage_project_end').value = result.projects[0].end;

                    $('.selected-teams').selectpicker('refresh');
                }

                else { // error
                    if (ans.hasClass("alert-info"))
                        ans.removeClass("alert-info");
                    ans.addClass("alert-danger");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert_admin_edit_projekt").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }

            }

        }
    });

}




