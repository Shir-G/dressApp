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
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        ctx.rect(0,0,1000,600);
        var isDragging = false;
        var delta = new Object();

        var img1 = document.getElementById("pic1");
        var img2 = document.getElementById("pic2");
        var img3 = document.getElementById("pic4");

        var imgArray = [
            {'x':10, 'y':10, 'src':img1, 'bool':false},
            {'x':200, 'y':10, 'src':img2, 'bool':false},
            {'x':400, 'y':10, 'src':img3, 'bool':false}
        ];

        function redraw(){
            ctx.beginPath();
            for (var i = 0; i< imgArray.length; i++) {
                ctx.drawImage(imgArray[i].src, imgArray[i].x, imgArray[i].y);
            }

        }

        redraw(); //initial draw

        function mousePosition(canvas, evt){
            var rect = canvas.getBoundingClientRect();
            return {
                x: Math.round(evt.clientX - rect.left),
                y: Math.round(evt.clientY - rect.top)
            };
        }

        canvas.addEventListener('mousedown', function(evt){
            isDragging = true;
            var mousePos = mousePosition(canvas, evt);
            
            for (var i = 0; i< imgArray.length; i++) {
                ctx.drawImage(imgArray[i].src, imgArray[i].x, imgArray[i].y);
                //if(ctx.isPointInPath(mousePos.x,mousePos.y)){
                    console.log("POINT IN PATH");
                    imgArray[i].bool = true;
                    delta.x = imgArray[i].x - mousePos.x;
                    delta.y = imgArray[i].y - mousePos.y;
                    break;
                //}
                //else imgArray[i].bool = false;
            }
            ctx.clearRect(0, 0, canvas.width, canvas.height); 
            redraw();
            //imgArray[i].bool = false;
            //console.log("DOWN:   x="+mousePos.x+" y="+mousePos.y);
        }, false);

        canvas.addEventListener('mousemove', function(evt){
            if(isDragging){
                var mousePos = mousePosition(canvas, evt);
                for (var i = 0; i< imgArray.length; i++) {
                    //console.log("MOVE:   bool "+i+"= "+imgArray[i].bool)
                    if (imgArray[i].bool) {
                        ctx.clearRect(0, 0, canvas.width, canvas.height); 
                        X = mousePos.x + delta.x;
                        Y = mousePos.y + delta.y;
                        imgArray[i].x = X;
                        imgArray[i].y = Y;
                        //console.log("MOVE:   x="+imgArray[i].x+" y="+imgArray[i].y);
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