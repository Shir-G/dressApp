$(document).ready(function(){
    
    $('.loadBtn').click(function(event){
        event.preventDefault();
        var btnValue = $(this).val();
        var id = $(this).attr('data-last-id');
        var stylist = $(this).attr('data-stylist-id');
        console.log("limit= "+btnValue);
        console.log("last id= "+id);

        $.ajax({
            type : 'POST',
            url: 'loadMroeOutfits.php',
            dataType: 'json',
            data: {'load': btnValue, 'lastID' : id, 'stylist' : stylist},
            success: function (data) {
                console.log(data);
                $(".loadBtn").val(Number(btnValue));
                if (Array.isArray(data.data)) {
                    data.data.forEach(function(outfit){
                        $('#items').append(outfit);
                    }); 
                }
                else {
                    $('#items').append(data.data);
                }
                $(".loadBtn").attr('data-last-id',data.lastID);
                console.log("success");
                console.log($('.loadBtn').attr('data-last-id'));
            },
            error: function ( xhr, desc, err) {
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    });
});