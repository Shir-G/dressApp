$(document).ready(function(){
    $('#addBtn').click(function(event){
        event.preventDefault();
        var btnValue = $(this).val();
        
        /*var clickBtnValue = $(this).val();
        var ajaxurl = 'item.php',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            console.log("action performed successfully");
        });*/

        $.ajax({
            type : 'POST',
            url: 'item.php',
            data: {'action': btnValue},
            success: function ( data ,status) {
         
            },
            error: function ( xhr, desc, err) {
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
        $( "div.success" ).fadeIn( 300 ).delay( 1500 ).fadeOut( 400 );
    }); 
});