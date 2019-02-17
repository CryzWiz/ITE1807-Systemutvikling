/**
 * Created by Allan Arnesen on 05.04.2017.
 */
var usage_graph;

$('ul.nav a').on('shown.bs.tab', function (e) {
    usage_graph.redraw();

});
function onload(){
    loadUserHoursGraph($('#userId').val(), $('#projectId').val());
}
function loadUserHoursGraph(user_id, project_id){
    var data = [
        {'name': 'type','value': 'loadUserHoursGraph'},
        {'name': 'user_id','value': user_id},
        {'name': 'project_id','value': project_id}

    ];
    $.ajax({
        url: "action_dashboard_userGraphs.php",
        cache: false,
        dataType: 'json',
        type: "POST",
        data : data,
        success: function (result, success) {
            if (result != null) {
                usage_graph = new Morris.Bar({
                    barSizeRatio : 0.25,
                    element: "user-morris-chart",
                    data: result.hoursPrTask,
                    xkey: "y",
                    ykeys: ["a", "b"],
                    labels: ["Estimerte timer", "Registrerte timer"]
                    });
                usage_graph.redraw();
                $('svg').css({ width: '100%' });

                }
            else {
                /**
                 * TODO:: Return something to show the user if no data is registered ?
                 */
                usage_graph = new Morris.Bar({
                    element: "user-morris-chart",
                    data: [
                        { 'a': 0, 'b': 0 }
                    ],
                    xkey: "y",
                    ykeys: ["a", "b"],
                    labels: ["Estimerte timer", "Registrerte timer"]
                });
            }
            usage_graph.redraw();
        }
    });
}



