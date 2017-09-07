window.onload = function(){
    var canvas = document.getElementById('holder');
    var ctx = canvas.getContext('2d');
    var imgArray = [];

    if (ctx){
        canvas.width = 1000;//window.innerWidth;
        canvas.height = 600;//window.innerHeight;
        var rect = canvas.getBoundingClientRect();

        var images = document.getElementsByClassName("itemImage");
        // var imgArray = [];

        function redraw(){
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (var i = 0; i< imgArray.length; i++) {
                ctx.drawImage(imgArray[i].src, imgArray[i].x, imgArray[i].y,imgArray[i].width, imgArray[i].height);
                if (imgArray[i]==selected) {
                    ctx.strokeStyle = '#D3D3D3';  // some color/style
                    ctx.lineWidth = 1;
                    ctx.strokeRect(imgArray[i].x, imgArray[i].y, imgArray[i].width, imgArray[i].height);
                }
            }
        }

        canvas.addEventListener("dragover", function (evt) {
            evt.preventDefault();
        }, false);

        var items = document.getElementsByClassName("itemImage");
        for (var i = 0; i < items.length ; i++) {
            items[i].addEventListener("dragstart", function(e) {
                var itemId = this.className.split("item-id-")[1];
                e.dataTransfer.setData("itemId", itemId); 
            });
        }

        canvas.addEventListener("drop", function (evt) {
            var data = evt.dataTransfer.getData("text");
            var itemId = evt.dataTransfer.getData("itemId");
            for (var i = 0; i < images.length; i++) {
                if (images[i].src == data) {
                    images[i].style.opacity = 0.2; //fades out images that have alredy been dragged in
                    var isInArray = false;
                    for (var j = 0; j < imgArray.length; j++) {
                        if (imgArray[j].src.src == data) {
                            isInArray = true; //if the img is already in canvas turn flag to true
                        }
                    }
                    if (!isInArray) {
                        var coord = mousePosition(canvas, evt); //drop on mouse position
                        var imgSize = images[i].getBoundingClientRect();
                        var img = new Image();
                        img.setAttribute('crossOrigin', 'anonymous');
                        img.src = images[i].src;
                        img.onload = function() {
                            imgArray.push({'x':coord.x-imgSize.width/2, 'y':coord.y-imgSize.height/2, 'src':img, 'bool':false, 'width':imgSize.width*2, 'height':imgSize.height*2, 'imgSrc':img.src, 'id':itemId});
                            redraw();
                            console.log("redraw");
                        }
                    }
                }
            }
            //redraw();
        }, false);

        function UnderElement(element,mouse) {
            var elemPosition = {'top':element.y + element.height , 'left':element.x+ element.width};

            return ((mouse.x > element.x && mouse.x < elemPosition.left) && (mouse.y > element.y && mouse.y < elemPosition.top))
        }

        function mousePosition(canvas, evt){
            return {
                x: Math.round(evt.clientX - rect.left),
                y: Math.round(evt.clientY - rect.top)
            };
        }

        var delta = new Object();
        var isDragging = false;
        var selected;
        var lastDownTarget;

        document.addEventListener('keydown', function(evt){
            
            if (selected) {
                if (lastDownTarget == canvas) {
                    if (evt.keyCode == 38) { //up arrow key
                        evt.preventDefault();
                        if (selected.width <= 1500 && selected.height <= 1500) {
                            selected.width *= 1.05;
                            selected.height *= 1.05;
                        }
                        redraw();
                    }
                    if (evt.keyCode == 40) { //down arrow key
                        evt.preventDefault();
                        if (selected.width >=100 && selected.height>=100) {
                            selected.width *= 0.95;
                        selected.height *= 0.95;
                        }
                        redraw();
                    }
                }
            }
        },false);

        canvas.addEventListener('mousedown', function(evt){
            isDragging = true;
            var mousePos = mousePosition(canvas, evt);
            
            for (var i = 0; i< imgArray.length; i++) {
                if (UnderElement(imgArray[i],mousePos)) {
                    selected = imgArray[i];
                    lastDownTarget = event.target;
                    imgArray[i].bool = true;
                    delta.x = imgArray[i].x - mousePos.x;
                    delta.y = imgArray[i].y - mousePos.y;
                    break;
                }
                else {
                    imgArray[i].bool = false;
                    selected = false;
                }
            }
            ctx.clearRect(0, 0, canvas.width, canvas.height); 
            redraw();
        }, false);

        canvas.addEventListener('mousemove', function(evt){
            if(isDragging){
                var mousePos = mousePosition(canvas, evt);
                for (var i = 0; i< imgArray.length; i++) {
                    if (imgArray[i].bool) {
                        ctx.clearRect(0, 0, canvas.width, canvas.height); 
                        X = mousePos.x + delta.x;
                        Y = mousePos.y + delta.y;
                        imgArray[i].x = X;
                        imgArray[i].y = Y;
                        break;
                    }
                }
                redraw();
            }
        }, false);

        canvas.addEventListener('mouseup', function(evt) {
            isDragging = false;
            for (var i = 0; i< imgArray.length; i++) {
                imgArray[i].bool = false;
            }
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            redraw();   
        }, false);

        canvas.addEventListener('mouseout', function(evt){
            isDragging = false;
            for (var i = 0; i< imgArray.length; i++) {
                imgArray[i].bool = false;
            }
            //ctx.clearRect(0, 0, canvas.width, canvas.height);
            redraw();  
        }, false);
    
        document.addEventListener('mousedown', function(evt){
            if (event.clientX > rect.left+rect.width || event.clientY >rect.top+rect.height ) {
                selected = false;
            }
            
            redraw();  
        }, false);


        document.getElementById('canvasForm').addEventListener('submit', function(e) {         
            
            e.preventDefault();

            var canvas = document.getElementById('holder');
            var img = canvas.toDataURL('image/png');
            var category = document.getElementById("category").value;
            sumbitFunc(imgArray, category ,img);
            
        });

        

    }

    //enabling bootstrap popovers for tips
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
}

var sumbitFunc = null;

$(document).ready(function() {
    sumbitFunc = function (dodo, cat, img) {
        $.ajax({
            type : 'POST',
            url: 'createOutfit.php',
            data: {outfits:JSON.stringify(dodo), category:cat, image: img},
            success: function ( data ,status) {
                console.log(data);
                window.location.replace("homepage.php");
                //$.post("outfit.php",{outfit:data});
            },
            error: function ( xhr, desc, err) {
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    }
});