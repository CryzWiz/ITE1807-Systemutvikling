/**
 * Created by nor28349 on 18.03.2017.
 */


$('#find_user_admin').on('click', function(){
    findUserByEmail_Admin($('#find_username_admin2').val());
});

$('#changeStatus').on('click', function(){
    changeUserStatus($('#idToAdd').val());
});

$('#changeAccountStatus').on('click', function(){
    changeKontoStatus($('#idToAdd').val());
});

function findUserByEmail_Admin(mail) {
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
                var found = $('#found_user_admin_manageuser');

                if(result!=null && result.UserDTos[0]){ //only one user per email
                    //var value = result.UserDTos[0].fullname + ", " + result.UserDTos[0].email;
                    found.children("span").text(makeFoundItem(result.UserDTos[0].fullname, result.UserDTos[0].email,result.UserDTos[0].isPermanent));
                    $('#emailToAdd').val(result.UserDTos[0].email); //hidden with email to be added to the team
                    $('#idToAdd').val(result.UserDTos[0].id);
                    $('#fullnameToAdd').val(result.UserDTos[0].fullname);
                    $('#permanent').val(result.UserDTos[0].isPermanent);
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

function changeUserStatus(userId){
    //var userId = $('#idToAdd').val();

    var data = [
        { 'name':'type', 'value':'changeStatus'},
        { 'name':'user_id', 'value': userId}
    ];

    $.ajax({
        url: "action_admin_team.php",
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            if(result!=null){
                var ans = $('#alert-user_admin_manageuser');
                if(result.success == "innleid" || result.success == "fast"){ //success
                    if(ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    ans.addClass("alert-info");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert-user_admin_manageuser").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
                else{ // errror
                    if(ans.hasClass("alert-info"))
                        ans.removeClass("alert-info");
                    ans.addClass("alert-danger");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert-user_admin_manageuser").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
            }
        }
    });
}

function dynamicRemoval_user(type, selectorId, value) {
    switch(type){
        case 'changeKontoStatus':
            $(selectorId + " option[value=" + value + "]").remove();
            break;
    }
}

function dynamicAdding_user(type, selectorId, value, print) {
    switch(type){
        case 'changeKontoStatus':
            $(selectorId).append("<option value=\"" + value +"\" id=\"" + value + "\">" + print + "</option>");
            break;
    }

}

function changeKontoStatus(userId){
    //var userId = $('#idToAdd').val();

    var data = [
        { 'name':'type', 'value':'changeKontoStatus'},
        { 'name':'user_id', 'value': userId}
    ];

    var type = 'changeKontoStatus';
    var selectorId = '#inactive_user_select';
    var value = userId;
    var toRemove = '#'+userId;
    var print = 'ny linje';

    $.ajax({
        url: "action_admin_team.php",
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            if(result!=null){
                var ans = $('#alert-user_admin_manageuser');
                if(result.success == "active" || result.success == "inactive"){ //success
                    if(ans.hasClass("alert-danger"))
                        ans.removeClass("alert-danger");
                    ans.addClass("alert-info");
                    ans.text(result.message);
                    ans.show();
                    if(result.success == "active"){
                        dynamicRemoval_user(type, selectorId, value, print);
                    }else {
                        dynamicAdding(type, selectorId, value, print);
                    }
                    window.setTimeout(function() {
                        $("#alert-user_admin_manageuser").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
                else{ // errror
                    if(ans.hasClass("alert-info"))
                        ans.removeClass("alert-info");
                    ans.addClass("alert-danger");
                    ans.text(result.message);
                    ans.show();
                    window.setTimeout(function() {
                        $("#alert-user_admin_manageuser").fadeTo(2000, 500).slideUp(500, function () {
                            $(this).hide();
                        });
                    }, 2000);
                }
            }
        }
    });
}

function deleteInactiveUserById(){
    var userId = $('#inactive_user_select').val();

    if (userId > 0) {

        var data = [
            { 'name':'type', 'value':'delete_inactive_user'},
            { 'name':'user_id', 'value':userId}
        ];
        $.ajax({
            url: "action_admin_team.php",
            cache: false,
            dataType: 'json',
            type: "POST",
            data : data,
            success: function (result, success) {
                var ans = $('#alert-user_admin_manageuser');
                if (result != null) {
                    if (result.success == "true") { //success
                        if (ans.hasClass("alert-danger"))
                            ans.removeClass("alert-danger");
                        ans.addClass("alert-info");
                        ans.text(result.message);
                        ans.show();
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