/*function startDragging(event) {
    // which object was pressed
    if (!event) {
        var event = window.event;
    }
    if(event.preventDefault) event.preventDefault();

    // explorer uses srcElement
    target = event.target ? event.target : event.srcElement;

    if (target.className != 'draggable') return; //=work only on the object that suppose to move
    
    offsetX = event.clientX;
    offsetY = event.clientY;

    // default values
    if(!target.style.left) target.style.left = '0px';
    if (!target.style.top) target.style.top = '0px';

    coordX = parseInt(target.style.left);
    coordY = parseInt(target.style.top);
    
    drag = true;

    document.onmousemove = dragDiv;
    event.preventDefault();
    return false;  
}

function dragDiv(event) {
    if (!drag) return;
    if (!event) var event = window.event;
    target = event.target ? event.target : event.srcElement;
    
    // move div element
    target.style.left = coordX + event.clientX - offsetX + 'px';
    target.style.top = coordY + event.clientY - offsetY + 'px';
    return false;
}

function stopDrag() {
    drag = false;
}

window.onload = function() {
    document.onmousedown = startDragging;
    document.onmouseup = stopDrag;
}*/

window.onload = function(){
    var canvas = document.getElementById('holder');
    var ctx = canvas.getContext('2d');

    if (ctx){
        canvas.width = 1000;//window.innerWidth;
        canvas.height = 600;//window.innerHeight;
        var rect = canvas.getBoundingClientRect();
        

        /*var img1 = document.getElementById("pic1");
        var img2 = document.getElementById("pic2");
        var img3 = document.getElementById("pic4");

        var imgArray = [
            {'x':10, 'y':10, 'src':img1, 'bool':false},
            {'x':200, 'y':10, 'src':img2, 'bool':false},
            {'x':400, 'y':10, 'src':img3, 'bool':false}
        ];*/

        var images = document.getElementsByClassName("itemImage");
        var imgArray = [];

        function redraw(){
            //ctx.beginPath();
            for (var i = 0; i< imgArray.length; i++) {
                ctx.drawImage(imgArray[i].src, imgArray[i].x, imgArray[i].y,imgArray[i].width, imgArray[i].height);
                console.log(imgArray[i].width+" "+imgArray[i].height);
                
            }
        }

        /*for (var i = 0; i <images.length; i++) {
            //console.log("-------- "+images[i].src);
            images[i].addEventListener("dragstart",function(evt){
                console.log("======"+this.src);
                var img = document.createElement("img");
                img.src = this.src;
                img.style.width = "100px";
                console.log("src= "+img.style.width);
                // console.log("imgSize " + bla.width);    
                evt.dataTransfer.setDragImage(img, img.width/2, img.height/2);
                console.log("w="+img.width+" h="+img.height);
            }, false);
        }*/

        canvas.addEventListener("dragover", function (evt) {
            evt.preventDefault();
        }, false);

        canvas.addEventListener("drop", function (evt) {
            var data = evt.dataTransfer.getData("text");
            for (var i = 0; i < images.length; i++) {
                if (images[i].src == data) {
                    var isInArray = false;
                    for (var j = 0; j < imgArray.length; j++) {
                        if (imgArray[j].src.src == data) {
                            isInArray = true; //if the img is already in canvas turn flag to true
                        }
                    }
                    if (isInArray != true) {
                        var coord = mousePosition(canvas, evt); //drop on mouse position
                        var imgSize = images[i].getBoundingClientRect();
                        imgArray.push({'x':coord.x-imgSize.width/2, 'y':coord.y-imgSize.height/2, 'src':images[i], 'bool':false, 'width':imgSize.width*2, 'height':imgSize.height*2});
                    }
                }
            }
            redraw();
        }, false);

        function UnderElement(element,mouse) {
            var elemPosition = {'top':element.y + element.height , 'left':element.x+ element.width};
            console.log("my="+mouse.y+" mx="+mouse.x);
            console.log("top="+element.y+" height="+element.height+" left="+element.x+" width="+element.width);

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

        canvas.addEventListener('mousedown', function(evt){
            isDragging = true;
            var mousePos = mousePosition(canvas, evt);
            console.log("###"+mousePos.x +","+mousePos.y);
            
            for (var i = 0; i< imgArray.length; i++) {
                //if(ctx.isPointInPath(mousePos.x,mousePos.y)){
                if (UnderElement(imgArray[i],mousePos)) {
                    console.log("POINT IN PATH");
                    imgArray[i].bool = true;
                    delta.x = imgArray[i].x - mousePos.x;
                    delta.y = imgArray[i].y - mousePos.y;
                    break;
                }
                //}
                else {
                    imgArray[i].bool = false;
                    console.log("NOT IN PATH");
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
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            redraw();  
        }, false);

    }
}