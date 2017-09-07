$(document).ready(function(){
    
    $('.loadBtn').click(function(event){
        event.preventDefault();
        var limit = $(this).val();
        var offset = $(this).attr('data-offset');
        var category = $(this).attr('data-cat');
        var thisBtn = $(this);
        console.log("category= "+category);

        $.ajax({
            type : 'POST',
            url: 'loadMoreItems.php',
            //dataType: 'json',
            data: {'limit': limit, 'offset' : offset, 'category' : category},
            success: function (data) {
                console.log("offset= "+offset);
                console.log("limit= "+limit);
                console.log("category= "+category);
                $(thisBtn).attr("data-offset",Number(offset)+Number(limit));
                var str = category.replace(/ +/g, '');
                str = str.replace(/&+/g, '');
                console.log("str= "+str);
                $('.cat_'+str).append(data);
/*                $(".loadBtn").val(Number(btnValue));
                if (Array.isArray(data.data)) {
                    data.data.forEach(function(outfit){
                        $('#loadmoreoutfits').append(outfit);
                    }); 
                }
                else $('#loadmoreoutfits').append(data.data);
                $(".loadBtn").attr('data-last-id',data.lastID);*/
                console.log("success");
            },
            error: function ( xhr, desc, err) {
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    });

    $(document.body).on('click', '.cb_item', function(event){
        var category = $(this).parent().attr('data-cat');
        var numItems = $('#tab_'+category).children("span").text();
        $(this).is(':checked') ? numItems++ : numItems--;
        if (numItems != 0) $('#tab_'+category).children("span").show();
        else $('#tab_'+category).children("span").hide()
        $('#tab_'+category).children("span").text(numItems);

    });

});