$(document).ready(function(){
	$('.item').click(function(event) {
        event.preventDefault();
        var itemId = $(this).attr('id').split("item-id-")[1];
        $('#itemInput').val(itemId);
        $('#itemForm').submit();
    });

    $('.removeFromCloset').click(function(event) {
    	var itemToRemove = $(this).attr('id').split('-')[1];
        console.log("lalala");
    	$.ajax({
            type : 'POST',
            url: 'closet.php',
            data: {'removeItem': itemToRemove},
            success: function ( data ,status) {
                var elem = document.getElementById("div-item-"+itemToRemove);
                elem.parentNode.removeChild(elem);
                $( "div.success" ).fadeIn( 300 ).delay( 1500 ).fadeOut( 400 );
            },
            error: function ( xhr, desc, err) {
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    });
});