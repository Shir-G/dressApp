$(document).ready(function(){
	$('.item').click(function(event) {
        event.preventDefault();
        var itemId = $(this).attr('id').split("item-id-")[1];
        $('#itemInput').val(itemId);
        $('#itemForm').submit();
    });
});