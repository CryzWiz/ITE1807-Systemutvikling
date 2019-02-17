/**
 * Created by nor28349 on 24.04.2017.
 */

function loadDataSource(user_id, project_id){
    var data = [
        {'name': 'type','value': 'loadCalendar'},
        {'name': 'project_id','value': project_id},
        {'name': 'user_id','value': user_id}

    ];
    $.ajax({
        url: "action_dashboard_project.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            if (result != null) {
                var myData = [];

                for (var i = 0; i < result.dataSource.length; i++) {
                    myData.push({
                        id: result.dataSource[i].id,
                        userId : result.dataSource[i].userId,
                        projectId : result.dataSource[i].projectId,
                        name: result.dataSource[i].name,
                        location:  result.dataSource[i].location,
                        regards:  result.dataSource[i].regards,
                        startDate: new Date(result.dataSource[i].startDate),
                        endDate: new Date(result.dataSource[i].endDate),
                        type : result.dataSource[i].type
                    });
                }
                $('#calendar').data('calendar').setDataSource(myData);
            }
            else {

                alert('Error loading calendar');
            }
        }
    });
}

function saveToDB(typeEvent, event){
    switch (typeEvent){
        case 'event':
            var data = [
                {'name': 'type','value': 'saveEventToDB'},
                {'name': 'typeEvent','value': typeEvent},
                {'name': 'event','value': JSON.stringify(event)}

            ];
            $.ajax({
                url: "action_dashboard_project.php",
                cache: false,
                dataType: 'json',
                type: "POST",
                data : data,
                success: function(output) {
                    alert('event is created');
                }
            });
    }
}

function loadContextMenuItem(user_id, teamleader_id, events){

    var data = [
        {'name': 'type','value': 'loadContextMenuItem'},
        {'name': 'user_id','value': user_id},
        {'name': 'teamleader_id','value': teamleader_id},
        {'name': 'events','value': events}

    ];
    $.ajax({
        url: "action_dashboard_project.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            if (result != null) {
                var myContextData = [];

                for (var i = 0; i < result.contextMenuItems.length; i++) {
                    myContextData.push({
                        text: result.contextMenuItems[i].name,
                        click: window[result.contextMenuItems[i].click]
                    });
                }
                $('#calendar').data('calendar').setContextMenuItems(myContextData);

            }
            else {
                /**
                 *
                 */
                alert('Error loading context menu items');

            }
        }
    });
}

function editEvent(event) {
    $('#event-modal input[name="event-index"]').val(event ? event.id : '');
    $('#event-modal input[name="event-name"]').val(event ? event.name : '');
    $('#event-modal input[name="event-regards"]').val(event ? event.regards : '');
    $('#event-modal input[name="event-projectId"]').val(event ? event.projectId : '');
    $('#event-modal input[name="event-userId"]').val(event ? event.userId : '');
    $('#event-modal input[name="event-location"]').val(event ? event.location : '');
    $('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '');
    $('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '');
    $('#event-modal input[name="type"]').val(event ? event.type : '');
    $('#event-modal').modal();
}

function deleteEvent(event) {
    var dataSource = $('#calendar').data('calendar').getDataSource();

    for(var i in dataSource) {
        if(dataSource[i].id == event.id) {
            dataSource.splice(i, 1);
            break;
        }
    }

    $('#calendar').data('calendar').setDataSource(dataSource);
}

function saveEvent() {
    var event = {
        id: $('#event-modal input[name="event-index"]').val(),
        userId : $('#event-modal input[name="event-userId"]').val(),
        projectId : $('#event-modal input[name="event-projectId"]').val(),
        name: $('#event-modal input[name="event-name"]').val(),
        regards: $('#event-modal input[name="event-regards"]').val(),
        location: $('#event-modal input[name="event-location"]').val(),
        startDate: $('#event-modal input[name="event-start-date"]').datepicker('getDate'),
        endDate: $('#event-modal input[name="event-end-date"]').datepicker('getDate'),
        type: $('#event-modal input[name="eventType"]').val()
    }

    var dataSource = $('#calendar').data('calendar').getDataSource();

    if(event.id) { // edit existing event
        for(var i in dataSource) {
            if(dataSource[i].id == event.id) {
                dataSource[i].name = event.name;
                dataSource[i].userId = event.userId;
                dataSource[i].projectId = event.projectId;
                dataSource[i].regards = event.regards;
                dataSource[i].location = event.location;
                dataSource[i].startDate = event.startDate;
                dataSource[i].endDate = event.endDate;
                dataSource[i].eventType = event.type;
            }
        }
        //update event in database
        saveToDB('event', event);
    }
    else // create new event
    {
        var newId = 1;
        for(var i in dataSource) {
            if(dataSource[i].id > newId) {
                newId = dataSource[i].id;
            }
        }

        newId++;
        event.id = newId;
        event.projectId = $('#projectId').val();
        event.userId = $('#userId').val();

        dataSource.push(event);
        // save event to database
        saveToDB('event', event);
    }

    $('#calendar').data('calendar').setDataSource(dataSource);

    $('#event-modal').modal('hide');
}

$(function() {

    $('#calendar').calendar({
        enableContextMenu: true,
        enableRangeSelection: true,
        displayWeekNumber: true,

        selectRange: function(e) {
            editEvent({ startDate: e.startDate, endDate: e.endDate });
        },
        mouseOnDay: function(e) {
            if(e.events.length > 0) {
                var content = '';

                for(var i in e.events) {
                    content += '<div class="event-tooltip-content">'
                        + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                        + '<div class="event-regards">' + 'Gjelder: ' + e.events[i].regards + '</div>'
                        + '<div class="event-location">' + 'Lokasjon: ' +e.events[i].location + '</div>'
                        + '</div>';
                }

                $(e.element).popover({
                    trigger: 'manual',
                    container: 'body',
                    html:true,
                    content: content
                });

                $(e.element).popover('show');
            }
        },
        mouseOutDay: function(e) {
            if(e.events.length > 0) {
                $(e.element).popover('hide');
            }
        },
        dayContextMenu: function(e) {
            $(e.element).popover('hide')
            //alert(JSON.stringify(e.events))
        },
        dataSource : loadDataSource($('#userId').val(), $('#projectId').val()),
        contextMenuItems: loadContextMenuItem($('#userId').val(), $('#teamleaderId').val())


});

    $('#save-event').click(function() {
        saveEvent();
    });

});
