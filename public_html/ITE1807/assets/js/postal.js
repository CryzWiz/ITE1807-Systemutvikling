/* Created by vicki on 03/03/17.
*/


$('#postcode1').on('keyup', function(){
    search_postal(true);
});
$('#postcode2').on('keyup', function(){
    search_postal(false);
});


function is_int(value){
    if((parseFloat(value) == parseInt(value)) && !isNaN(value)){
        return true;
    } else {
        return false;
    }
}

function search_postal(isPrimary) {
    //
    // Cache
    var code,city;
    if(isPrimary == true){
        code=$("#postcode1");
        city=$("#city1");
    }
    else{
        code=$("#postcode2");
        city=$("#city2");
    }

    // Did they type four integers?
    if ((code.val().length == 4) && (is_int(code.val()))) {
        //http://maps.googleapis.com/maps/api/geocode/json?address=norway,+4608&language=no&sensor=false
        // Call googleapis for information
        //postal_code : code.val(),
        $.ajax({
            url: "http://maps.googleapis.com/maps/api/geocode/json",
            cache: false,
            dataType: "json",
            type: "GET",
            data : {
                sensor  : false,
                address : 'Norge,' + code.val(),
                language: 'no',
                componentRestrictions: {
                    country: 'NO',
                    postalCode: code.val()
                }
            },
            success: function (result, success) {
                //alert(result.results[0].formatted_address);
                city.val(result.results[0].formatted_address);
            }

        });
    }

}

