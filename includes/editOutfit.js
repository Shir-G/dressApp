var imgArray = new Array();
var createCanvas = function(outfit, items){
    window.onload = function(){
        var canvas = document.createElement('canvas');
        // canvas.id = "editCanvas";
        var ctx = canvas.getContext('2d');
        canvas.width = 1000;
        canvas.height = 600;
        canvas.style.border = '1px solid #000';

        var numOfItems = outfit.src.length;
        for (var i=0; i<numOfItems; i++) {
            var img = new Image();
            img.setAttribute('crossOrigin', 'anonymous');
            img.src = outfit.src[i];
            img.dataAid= i;
            img.onload = function() {
                var i = this.dataAid;
                ctx.drawImage(this, outfit.x[i], outfit.y[i], outfit.width[i], outfit.height[i]);
                imgArray.push({'x':outfit.x[i], 'y':outfit.y[i], 'src':this, 'bool':false, 'width':outfit.width[i], 'height':outfit.height[i], 'imgSrc':outfit.src[i]});
            }
        }

        function UnderElement(element,mouse) {
            var elemPosition = {'top':Number(element.y) + Number(element.height) , 'left':Number(element.x) + Number(element.width)};
            return ((mouse.x > Number(element.x) && mouse.x < elemPosition.left) && (mouse.y > Number(element.y) && mouse.y < elemPosition.top))
        }

        function mousePosition(canvas, event){
            return {
                x: event.clientX - rect.left,
                y: event.clientY - rect.top
            };
        }

        var oldCanvas = document.getElementById("holder");
        canvas.setAttribute('data-outfit-id', oldCanvas.getAttribute('data-outfit-id'));
        document.body.replaceChild(canvas, oldCanvas);
        var rect = canvas.getBoundingClientRect();

        function redraw(){
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (var i = 0; i< imgArray.length; i++) {
                ctx.drawImage(imgArray[i].src, imgArray[i].x, imgArray[i].y,imgArray[i].width, imgArray[i].height);
                if (imgArray[i].imgSrc == selected) {
                    ctx.strokeStyle = '#D3D3D3';  // some color/style
                    ctx.lineWidth = 1;
                    ctx.strokeRect(imgArray[i].x, imgArray[i].y, imgArray[i].width, imgArray[i].height);
                }
            }
        }

        var delta = new Object();
        var isDragging = false;
        var selected;
        var lastDownTarget;

        canvas.addEventListener('mousedown', function(evt){
            isDragging = true;
            var mousePos = mousePosition(canvas, evt);
            
            for (var i = 0; i< imgArray.length; i++) {
                if (UnderElement(imgArray[i],mousePos)) {
                    selected = imgArray[i].imgSrc;
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
            redraw();  
        }, false);
    
        document.addEventListener('mousedown', function(evt){
            if (event.clientX > rect.left+rect.width || event.clientY >rect.top+rect.height ) {
                selected = false;
            }
            
            redraw();  
        }, false);

        document.addEventListener('keydown', function(evt){
            if (selected) {
                if (lastDownTarget == canvas) {
                    if (evt.keyCode == 38) { //down arrow key
                        evt.preventDefault();
                        for (var i = 0; i< imgArray.length; i++) {
                            if (imgArray[i].imgSrc == selected) {
                                console.log("up-before | w= "+imgArray[i].width+" h= "+imgArray[i].height);
                                imgArray[i].width = parseInt(imgArray[i].width) *1.05;
                                imgArray[i].height = parseInt(imgArray[i].height) *1.05;
                                console.log("up-after | w= "+imgArray[i].width+" h= "+imgArray[i].height);
                            }
                        } 
                        redraw();
                    }
                    if (evt.keyCode == 40) { //down arrow key
                        evt.preventDefault();
                        for (var i = 0; i< imgArray.length; i++) {
                            if (imgArray[i].imgSrc == selected) {
                                console.log("down-before | w= "+imgArray[i].width+" h= "+imgArray[i].height);
                                imgArray[i].width = parseInt(imgArray[i].width) *0.95;
                                imgArray[i].height = parseInt(imgArray[i].height) *0.95;
                                console.log("down-before | w= "+imgArray[i].width+" h= "+imgArray[i].height);
                            }
                        } 
                        redraw();
                    }
                }
            }
        },false);

        document.getElementById('editForm').addEventListener('submit', function(e) {         
            e.preventDefault();

            /*for (var i = 0; i< imgArray.length; i++){
                var timestamp = new Date().getTime();
                imgArray[i].src.setAttribute('crossOrigin', 'anonymous');
                imgArray[i].src.src = imgArray[i].src.src + '?' + timestamp;
            }*/
            //canvas.border = "4px solid red";
            /*var img = new Image();
            img.setAttribute('crossOrigin', 'anonymous');
            img.src = canvas.toDataURL('image/jpg');*/
            // var canvas = document.getElementById('editCanvas');
            var outfitId = canvas.getAttribute("data-outfit-id");
            var newImg = canvas.toDataURL('image/png');
            console.log("image!!!!!!!");
            console.log(newImg);
            var category = document.getElementById("category").value;
            sumbitFunc(imgArray, category, outfitId, newImg);
            
        });

        //enabling bootstrap popovers for tips
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    };
};

var sumbitFunc = null;

$(document).ready(function() {
    sumbitFunc = function (arr, cat, id, outfitImg) {
        $.ajax({
            type : 'POST',
            url: 'editOutfit.php',
            data: {outfits:JSON.stringify(arr), category:cat, outfitId:id, image:outfitImg}
            ,
            success: function ( data ,status) {
                console.log("cat= " + cat);
                console.log("id= "+id);
                console.log("success");
                //console.log(data);
                // window.location.reload();
            },
            error: function ( xhr, desc, err) {
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    }
});