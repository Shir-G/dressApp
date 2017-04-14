<?php
    // $check = $_POST['shirt'];
    // echo $check;
if(!empty($_POST['shirt'])) {
    foreach($_POST['shirt'] as $check) {
            echo $check; //echoes the value set in the HTML form for each checked checkbox.
                         //so, if I were to check 1, 3, and 5 it would echo value 1, value 3, value 5.
                         //in your case, it would echo whatever $row['Report ID'] is equivalent to.
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <script src="includes/editor.js"></script>
    <link rel="stylesheet" href="includes/style.css">
    <title></title>
</head>
<body>
    <!-- <div id="holder">
        <img id="pic1" class="draggable" src="images/1.png" >
        <img id="pic2" class="draggable" src="images/2.png">
        <img id="pic4" class="draggable" src="images/4.png">
    </div> -->
    <canvas id="holder">
        <img id="pic1" class="draggable" src="images/1.png" >
        <img id="pic2" class="draggable" src="images/2.png">
        <img id="pic4" class="draggable" src="images/4.png">
    </canvas>
    <section id="selectedItems">
        
    </section>
</body>
</html>