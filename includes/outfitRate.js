$(document).ready(function(){

    //when one of the stars are being clicked in order to rate outfit
    $('.ratings_stars').click(function(event){
        event.preventDefault();

        //how many stars has been voted
        var stars = parseInt($(this).val());

        //gets the number of people and total stars of votings so far to calculate new rate
        var sectionValue = $('#rate_section').prop('title').split(" ");
        var people = parseInt(sectionValue[1]) +1;
        var total = parseInt(sectionValue[2]) + stars;
        var newRate = Math.round(total / people);

        //clear choice if alredy voted
        $(this).nextAll().removeClass('rating_click'); 
        $(this).prevAll().addBack().removeClass('rating_click');

        //set star choice 
        $(this).prevAll().addBack().addClass('rating_click');

        //returns the new rate to the php page
        $.ajax({
            type : 'POST',
            url: 'test.php',
            data: {'star': newRate, 'total': total, 'people': people},
            success: function ( data ,status) {
                $("#total_votes").html(newRate);
            },
            error: function ( xhr, desc, err) {
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    });

    //when hovering over stars changes the img fron full to an empty star
    $('.ratings_stars').hover(
        function() {
            $(this).prevAll().addBack().addClass('ratings_over');
            $(this).nextAll().removeClass('ratings_vote'); 
        },
        function() {
            $(this).prevAll().addBack().removeClass('ratings_over');
        }
    );

});