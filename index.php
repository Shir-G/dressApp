<?php
    include "fbConfig.php";
    if(!isset($_SESSION)){ 
        session_start(); 
    } 
    if (isset($_SESSION['user_id'])) {
        header("Location: homepage.php");
    }
    
?>
<!DOCTYPE html>
<html>
<head>
    <title>DressApp</title>
    <link href="https://fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/style.css">
</head>
<body id="desktop_body">

<div class="container-fluid">
    <div class="row justify-content-end" id="row1">
        <div class="col-md-6">
            <div id="mobile_pic"></div>
        </div>
        <div class="col-md-6">
            <div class="row">
            
                <div class="col-md-12">
                    <h1>DressApp</h1>
                    <h2>Creating new looks every day</h2>
                    <ul id="desktop_list">
                       <li>Manage your closet</li>
                       <li>Discover new styles</li>
                       <li>Try out different looks</li>
                       <li>Slay!</li> 
                    </ul>
                </div>
                <ul class="list-inline" id="desktop_buttons">
                    <li class="list-inline-item"><a href="register.php">SIGN UP</a></li>
                    <li class="list-inline-item"><a href="login.php">LOG IN</a></li>
                    <li class="list-inline-item"><div><?php echo $fbButton; ?></div></li>  
                </ul>
            </div>
        </div>
    </div>
    <div class="row" id="row2">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <section id="download_links">
                <a href="#" id="appstore"></a>
                <a href="#" id="googleplay"></a>
            </section>
        </div>
    </div>
</div>
    <!-- <main id="desktop_main">
    
        <div id="mobile_pic"></div>
    
        <h1>DressApp</h1>
        <p>Creating new looks every day</p>
    
        <section>
            <ul>
               <li>Manage your closet</li>
               <li>Discover new styles</li>
               <li>Try out new looks</li>
               <li>Slay!</li> 
            </ul>
        </section>
    
        <section id="desktop_buttons">
            <a href="register.php">SIGN UP</a>
            <a href="login.php">LOG IN</a>
            <div><?php echo $fbButton; ?></div>
        </section>
    
        
    </main>
    <section id="download_links">
        <a href="#" id="appstore"></a>
        <a href="#" id="googleplay"></a>
    </section> -->

</body>
</html>