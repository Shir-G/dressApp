var imgArray = new Array();
var createCanvas = function(outfit, items){

	var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');
    canvas.width = 1000;
    canvas.height = 600;
    canvas.style.border = '1px solid #000';
    var rect = canvas.getBoundingClientRect();

    var numOfItems = outfit.src.length;
    for (var i=0; i<numOfItems; i++) {
    	var img = new Image();
    	img.src = outfit.src[i];
    	img.dataAid= i;
    	img.onload = function() {
    		var i = this.dataAid;
    		context.drawImage(this, outfit.x[i], outfit.y[i], outfit.width[i], outfit.height[i]);
    		imgArray.push({'x':outfit.x[i], 'y':outfit.y[i], 'src':this, 'bool':false, 'width':outfit.width[i], 'height':outfit.height[i], 'imgSrc':outfit.src[i]});
    	}
    }

    function UnderElement(element,mouse) {
        var elemPosition = {'top':Number(element.y) + Number(element.height) , 'left':Number(element.x) + Number(element.width)};

        return ((mouse.x > Number(element.x) && mouse.x < elemPosition.left) && (mouse.y > Number(element.y) && mouse.y < elemPosition.top))
    }

    function mousePosition(canvas, event){
        return {
            x: Math.round(event.clientX - rect.left),
            y: Math.round(event.clientY - rect.top)
        };
    }

    window.onload = function(){
    	var oldCanvas = document.getElementById("holder");
    	document.body.replaceChild(canvas, oldCanvas);

        canvas.addEventListener("mousemove", function(event) {
            var mousePos = mousePosition(this, event);
            for(var i=0; i<numOfItems; i++) {
                if(UnderElement(imgArray[i], mousePos)){
                    this.style.cursor = "pointer";
                    break;
                }
                else this.style.cursor = "default";
            }
        });

        canvas.addEventListener("mousedown", function(event) {
            var mousePos = mousePosition(this, event);
            var infoSection = document.getElementById("info");
            var newInfo = document.createElement("div");
            newInfo.id = "info";
            for(var i=0; i<numOfItems; i++) {
                if (UnderElement(imgArray[i], mousePos)) {
                    var html = "";
                    items.forEach(function(item) {
                        if (item.image == imgArray[i].imgSrc) {
                            for (key in item) {
                                if (isNaN(key)) {
                                    if (key == "item_id" || key == "image" || key == "qr_code") continue;
                                    if (key == "item_type") html += "<a class='item' id='item-id-" + item.item_id + "' href='' onclick='clickFunc(" + item.item_id + ")'><strong>" + item.item_type + "</strong></a><br>";
                                    else html += key + " = " + item[key] + "<br>";
                                }
                            }
                            return false;
                        }
                    });
                    newInfo.innerHTML = html;
                    infoSection.parentNode.replaceChild(newInfo, infoSection);
                }
            }
        });
	};
    
};

var clickFunc = function(id) {
    event.preventDefault();
    $('#itemInput').val(id);
    $('#itemForm').submit();
}

$(document).ready(function(){
	$('.item').click(function(event) {
        event.preventDefault();
        var itemId = $(this).attr('id').split("item-id-")[1];
        $('#itemInput').val(itemId);
        $('#itemForm').submit();
    });

    $('#likeOutfit').click(function(event) {       
        var id = $(this).val();
        likeOutfitFunc(id);
    });

    $('#dislikeOutfit').click(function(event) {
        var id = $(this).val();
        dislikeOutfitFunc(id);
    });

});

var dislikeOutfitFunc = function(id) {
    event.preventDefault();
    
    $.ajax({
            type : 'POST',
            url: 'outfit.php',
            data: {'dislikedOutfit': id},
        
            success: function (data) {
                var likeBtn = document.createElement("button");
                likeBtn.id = "likeOutfit";
                likeBtn.value = id;
                likeBtn.innerHTML = "Like Outfit";
                likeBtn.setAttribute("onClick", "likeOutfitFunc("+id+");");

                var elem = document.getElementById('dislikeOutfit');
                elem.parentNode.replaceChild(likeBtn, elem);

                // $( "div.success" ).fadeIn( 300 ).delay( 1500 ).fadeOut( 400 );
            },
            error: function ( xhr, desc, err) {
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
}

var likeOutfitFunc = function(id) {
    event.preventDefault();
    
    $.ajax({
        type : 'POST',
        url: 'outfit.php',
        data: {'likedOutfit': id},
        success: function (data) {
            var dislikeBtn = document.createElement("button");
            dislikeBtn.id = "dislikeOutfit";
            dislikeBtn.value = id;
            dislikeBtn.innerHTML = "Dislike Outfit";
            dislikeBtn.setAttribute("onClick", "dislikeOutfitFunc("+id+");");

            var elem = document.getElementById('likeOutfit');
            elem.parentNode.replaceChild(dislikeBtn, elem);

            $( "div.success" ).fadeIn( 300 ).delay( 1500 ).fadeOut( 400 );
        },
        error: function ( xhr, desc, err) {
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
}