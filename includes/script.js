$(document).ready(function(){
    $('#addBtn').click(function(event){
        event.preventDefault();
        
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
            data: {'action': 'follow'},
            success: function ( data ,status) {
                console.log( data );              
            },
            error: function ( xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });

        //disable button
    }); 
});