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
                $( "div.success" ).fadeIn( 300 ).delay( 1500 ).fadeOut( 400 );
            },
            error: function ( xhr, desc, err) {
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
        
    }); 

    $('#followBtn').click(function(event){
        event.preventDefault();
        var btnValue = $(this).val();

        $.ajax({
            type : 'POST',
            url: 'stylist.php',
            data: {'follow': btnValue},
            success: function ( data ,status) {
                $( "div.success" ).fadeIn( 300 ).delay( 1500 ).fadeOut( 400 );
            },
            error: function ( xhr, desc, err) {
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
        
    });

    /*$('.loadBtn').click(function(event){
        event.preventDefault();
        var btnValue = $(this).val();
        var id = $(this).attr('id');

        $.ajax({
            type : 'POST',
            url: 'loadOutfits.php',
            data: {'limit': btnValue},
            success: function (data) {
                $(".loadBtn").val(Number(btnValue)+6);
                $('#items').append(data);
            },
            error: function ( xhr, desc, err) {
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    });*/

    //for matchingOutfit page and also for likedOutfits page
    $('.outfit').click(function(event) {
        event.preventDefault();
        var outfitId = $(this).attr('id').split("outfit-id-")[1];
        $('#outfitInput').val(outfitId);
        $('#outfitForm').submit();
    });

});

var clickFunc = function(id) {
    event.preventDefault();
    $('#outfitInput').val(id);
    $('#outfitForm').submit();
}