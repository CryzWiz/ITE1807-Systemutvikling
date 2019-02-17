$(function(){

    $.fn.editable.defaults.mode = 'popup';

    $('#kommentar').editable({
        validate: function(value) {
           if($.trim(value) == '') return 'This field is required';
        }
    });
    $('#kommentar_timer').editable({
        validate: function(value) {
            if($.trim(value) == '') return 'This field is required';
        }
    });
    $('#sted_timer').editable({
        prepend: "Ikke valgt",
        source: [
            {value: 1, text: 'Kontor'},
            {value: 2, text: 'Site Norge'},
            {value: 3, text: 'Site Utland'},
            {value: 4, text: 'Offshore'}
        ],
    });
    $('#predef_task_timer').editable({
        prepend: "Ikke valgt",
        source: [
            {value: 1, text: 'Selvstudie'},
            {value: 2, text: 'Kurs'},
            {value: 3, text: 'Møte'}
        ],
    });
    $('#fra').editable({
        placement: 'right',
        combodate: {
            firstItem: 'name',
            locale: 'no'
        }
    });

    $('#til').editable({
        placement: 'right',
        combodate: {
            firstItem: 'name',
            locale: 'no'
        }
    });

    $('#sted').editable({
        prepend: "Ikke valgt",
        source: [
            {value: 1, text: 'Kontor'},
            {value: 2, text: 'Site Norge'},
            {value: 3, text: 'Site Utland'},
            {value: 4, text: 'Offshore'}
        ],

    });

    $('#predef_task').editable({
        prepend: "Ikke valgt",
        source: [
            {value: 1, text: 'Selvstudie'},
            {value: 2, text: 'Kurs'},
            {value: 3, text: 'Møte'}
        ],

    });

    $('#status').editable({
        pk: 1,
        limit: 1,
        source: [
            {value: 1, text: 'Aktiv'},
        ]
    });


    $('#user .editable').on('hidden', function(e, reason){
        if(reason === 'save' || reason === 'nochange') {
            var $next = $(this).closest('tr').next().find('.editable');
            if($('#autoopen').is(':checked')) {
                setTimeout(function() {
                    $next.editable('show');
                }, 300); 
            } else {
                $next.focus();
            } 
        }
   });

});