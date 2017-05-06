var imgArray = new Array();
var createCanvas = function(outfit){

	var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');
    canvas.width = 1000;
    canvas.height = 600;
    canvas.style.border = '1px solid #000';


    var numOfItems = outfit.src.length;
    for (var i=0; i<numOfItems; i++) {
    	var img = new Image();
    	img.src = outfit.src[i];
    	img.dataAid= i;
    	img.onload = function() {
    		var i = this.dataAid;
    		context.drawImage(this, outfit.x[i], outfit.y[i], outfit.width[i], outfit.height[i]);
    		imgArray.push({'x':outfit.x[i], 'y':outfit.y[i], 'src':this, 'bool':false, 'width':outfit.width[i], 'height':outfit.height[i], 'imgSrc':outfit.src});
    	}
    }

    window.onload = function(){
    	var oldCanvas = document.getElementById("holder");
    	document.body.replaceChild(canvas, oldCanvas);
	};
    
};

$(document).ready(function(){
	$('.item').click(function(event) {
        event.preventDefault();
        var itemId = $(this).attr('id').split("item-id-")[1];
        $('#itemInput').val(itemId);
        $('#itemForm').submit();
    });
});

// window.onload = function(){
// 		var rect = canvas.getBoundingClientRect();

//         var images = document.getElementsByClassName("itemImage");
//         // var imgArray = [];

//         function redraw(){
//             ctx.clearRect(0, 0, canvas.width, canvas.height);
//             for (var i = 0; i< imgArray.length; i++) {
//                 imgArray[i].src.style.opacity = 0.2; //fades out images the are alredy dragged
//                 ctx.drawImage(imgArray[i].src, imgArray[i].x, imgArray[i].y,imgArray[i].width, imgArray[i].height);
//                 if (imgArray[i]==selected) {
//                     ctx.strokeStyle = '#D3D3D3';  // some color/style
//                     ctx.lineWidth = 1;
//                     ctx.strokeRect(imgArray[i].x, imgArray[i].y, imgArray[i].width, imgArray[i].height);
//                 }
//             }
//         }

//         canvas.addEventListener("dragover", function (evt) {
//             evt.preventDefault();
//         }, false);

//         var items = document.getElementsByClassName("itemImage");
//         for (var i = 0; i < items.length ; i++) {
//             items[i].addEventListener("dragstart", function(e) {
//                 var itemId = this.className.split("item-id-")[1];
//                 e.dataTransfer.setData("itemId", itemId); 
//             });
//         }

//         canvas.addEventListener("drop", function (evt) {
//             var data = evt.dataTransfer.getData("text");
//             var itemId = evt.dataTransfer.getData("itemId");
//             for (var i = 0; i < images.length; i++) {
//                 if (images[i].src == data) {
//                     var isInArray = false;
//                     for (var j = 0; j < imgArray.length; j++) {
//                         if (imgArray[j].src.src == data) {
//                             isInArray = true; //if the img is already in canvas turn flag to true
//                         }
//                     }
//                     if (!isInArray) {
//                         var coord = mousePosition(canvas, evt); //drop on mouse position
//                         var imgSize = images[i].getBoundingClientRect();
//                         imgArray.push({'x':coord.x-imgSize.width/2, 'y':coord.y-imgSize.height/2, 'src':images[i], 'bool':false, 'width':imgSize.width*2, 'height':imgSize.height*2, 'imgSrc':images[i].src, 'id':itemId});
//                     }
//                 }
//             }
//             redraw();
//         }, false);

//         function UnderElement(element,mouse) {
//             var elemPosition = {'top':element.y + element.height , 'left':element.x+ element.width};

//             return ((mouse.x > element.x && mouse.x < elemPosition.left) && (mouse.y > element.y && mouse.y < elemPosition.top))
//         }

//         function mousePosition(canvas, evt){
//             return {
//                 x: Math.round(evt.clientX - rect.left),
//                 y: Math.round(evt.clientY - rect.top)
//             };
//         }

//         var delta = new Object();
//         var isDragging = false;
//         var selected;
//         var lastDownTarget;

//         /*function addResizeBorder(item){
//             item.src.classList.add("resize_border");
//             console.log("resize_border= "+item.src.className);
//             for (var i = 0; i < imgArray.length; i++) {
//                 if (imgArray[i] != item) {
//                     item.src.classList.remove("resize_border");
//                 }
//             }
//         }*/

//         document.addEventListener('keydown', function(evt){
            
//             if (selected) {
//                 if (lastDownTarget == canvas) {
//                     if (evt.keyCode == 40) { //down arrow key
//                         evt.preventDefault();
//                         console.log("last = "+evt.keyCode);
//                         //var imgSize = selected.getBoundingClientRect();
//                         selected.width -= 10;
//                         selected.height -= 10;
//                         redraw();
//                     }
//                     if (evt.keyCode == 38) { //down arrow key
//                         evt.preventDefault();
//                         console.log("last = "+evt.keyCode);
//                         //var imgSize = selected.getBoundingClientRect();
//                         selected.width += 10;
//                         selected.height += 10;
//                         redraw();
//                     }
//                 }
//             }
//         },false);

//         canvas.addEventListener('mousedown', function(evt){
//             isDragging = true;
//             var mousePos = mousePosition(canvas, evt);
            
//             for (var i = 0; i< imgArray.length; i++) {
//                 if (UnderElement(imgArray[i],mousePos)) {
//                     selected = imgArray[i];
//                     console.log("selected="+selected.src.src);
//                     lastDownTarget = event.target;
//                     //addResizeBorder(selected);
//                     imgArray[i].bool = true;
//                     delta.x = imgArray[i].x - mousePos.x;
//                     delta.y = imgArray[i].y - mousePos.y;
//                     break;
//                 }
//                 else {
//                     imgArray[i].bool = false;
//                     selected = false;
//                 }
//             }
//             ctx.clearRect(0, 0, canvas.width, canvas.height); 
//             redraw();
//         }, false);

//         canvas.addEventListener('mousemove', function(evt){
//             if(isDragging){
//                 var mousePos = mousePosition(canvas, evt);
//                 for (var i = 0; i< imgArray.length; i++) {
//                     if (imgArray[i].bool) {
//                         ctx.clearRect(0, 0, canvas.width, canvas.height); 
//                         X = mousePos.x + delta.x;
//                         Y = mousePos.y + delta.y;
//                         imgArray[i].x = X;
//                         imgArray[i].y = Y;
//                         break;
//                     }
//                 }
//                 redraw();
//             }
//         }, false);

//         canvas.addEventListener('mouseup', function(evt) {
//             isDragging = false;
//             for (var i = 0; i< imgArray.length; i++) {
//                 imgArray[i].bool = false;
//             }
//             ctx.clearRect(0, 0, canvas.width, canvas.height);
//             redraw();   
//         }, false);

//         canvas.addEventListener('mouseout', function(evt){
//             isDragging = false;
//             for (var i = 0; i< imgArray.length; i++) {
//                 imgArray[i].bool = false;
//             }
//             //ctx.clearRect(0, 0, canvas.width, canvas.height);
//             redraw();  
//         }, false);
    
//         document.addEventListener('mousedown', function(evt){
//             if (event.clientX > rect.left+rect.width || event.clientY >rect.top+rect.height ) {
//                 selected = false;
//             }
            
//             redraw();  
//         }, false);

// }