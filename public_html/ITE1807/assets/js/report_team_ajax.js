/* Created by vicki on 03/03/17.
*/

function onReportTeamLoad(){
    var t_id = 4;
    loadTeamStatistics();

    // Order by the grouping

}

function loadTeamStatistics(){
    var uid = 4;
    var table = $('#report_team').DataTable( {
        ajax: {
            url: 'report_team_action.php',
            cache: false,
            dataType: 'json',
            type: "POST",
            data: {
                    'type':'report_team_general_info',
                    'user_id': uid},
            dataSrc: 'times'

        },
        "order": [[ 3, 'asc' ]],
        "stateSave": false,
        responsive: true,
        columns: [
            { data: null },
            { data: 'Team_id' },
            { data: 'User_id' },
            { data: 'Task_id' },
            { data: 'Team_name' },
            { data: 'Fullname' },
            { data: 'Project_name' },
            { data: 'Task_name' },
            { data: 'Start' },
            { data: 'Stop' },
            { data: 'Duration' }
        ],
            "columnDefs": [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                },
                {
                    'targets': [ 1, 2, 3, 4],
                    'visible': false
                },
                {
                    'targets': [5, 6, 7, 9],
                    'width': "50px"
                },
                {
                    'targets': 8,
                    'width': "100px"
                },
                {
                    'targets': 10,
                    render: $.fn.dataTable.render.moment('X', '', 'en', true)
                }
                ],
        'select': {
            'style':    'single'
            },
        'rowGroup': {
                dataSrc: 2
            },
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
                var total = [];
                var totalTitle = 'Duration';
                var durationColumnIndex = 10;
                total[totalTitle]= [];
                var groupid = -1;
                var subTotal = [];

                api.column(4, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="7">'+group+'</td></tr>'
                        );

                        last = group;
                    }


                    val = api.row(api.row($(rows).eq( i )).index()).data();      //current order index
                    $.each(val,function(colIdx,colVal){
                        if(colIdx === durationColumnIndex){

                            if (typeof subTotal[groupid] =='undefined'){
                                subTotal[groupid] = [];
                            }
                            if (typeof subTotal[groupid][colIdx] =='undefined'){
                                subTotal[groupid][colIdx] = 0;
                            }
                            if (typeof total[totalTitle][colIdx] =='undefined'){ total[totalTitle][colIdx] = 0; }

                            curVal = Number(colVal.replace('€',"").replace('.',"").replace(',',"."));
                            subTotal[groupid][colIdx] += curVal;
                            total[totalTitle][colIdx] += 100; //curVal;

                        }

                    });
                } );

                ////

                $('tbody').find('.group').each(function (i,v) {
                    var rowCount = $(this).nextUntil('.group').length;
                    $(this).find('td:first').append($('<span />', { 'class': 'rowCount-grid' }).append($('<b />', { 'text': ' ('+rowCount+')' })));
                    var subtd = '';
                    //for (var a=2;a<column;a++)
                    //{
                        subtd += '<td>'+subTotal[i][durationColumnIndex]+' OUT OF '+total[totalTitle][durationColumnIndex]+ ' ('+ Math.round(subTotal[i][durationColumnIndex]*durationColumnIndex/total[totalTitle][durationColumnIndex],2) +'%) '+'</td>';
                    //}
                    $(this).append(subtd);
                });

                ////

            }

    }
    /*
     "drawCallback": function ( settings ) {
     var api = this.api();
     var rows = api.rows( {page:'current'} ).nodes();
     var last=null;

     api.column(0, {page:'current'} ).data().each( function ( group, i ) {
     if ( last !== group ) {
     $(rows).eq( i ).before(
     '<tr class="group"><td colspan="8">'+group+'</td></tr>'
     );

     last = group;
     }
     } );
     }


    @/
     */
            /*,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows({page: 'current'}).nodes();
            var last = null;
            var colonne = api.row(0).data().length;
            var totale = new Array();
            totale['Totale'] = new Array();
            var groupid = -1;
            var subtotale = new Array();
        }*/
     );

    $('#report_team tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === 0 && currentOrder[1] === 'asc' ) {
            table.order( [ 0, 'desc' ] ).draw();
        }
        else {
            table.order( [ 0, 'asc' ] ).draw();
        }
    });

}

function getSelectedIds(){
    var table = $('#report_team').DataTable();
    var ids = [];
    var rows_selected = table.column(0).checkboxes.selected();

    // Iterate over all selected checkboxes
    $.each(rows_selected, function(index, rowId){
        ids.push(rowId);
    });
    //alert(JSON.stringify(ids));
    submitIdsForApproval(ids);
}



