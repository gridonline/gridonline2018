<?php
 
  if(!isset($_SESSION)){
      session_start();
      require_once '../../init.php';
      require '../../check.php';
    }

    $PDO = db_connect(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Grid Online</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
      background-color: white;
    }
    
    /* Add a gray background color and some padding to the footer */
    #div-back-image{
        background-image: url("../../img/lotus_evora_gtc/lotus_evora_gtcheader.png");
      }

    .affix {
      top: 0;
      width: 100%;
    }

     .affix + .container-fluid {
      padding-top: 70px;
     }
     #font{
      color:#000000;
      font-family:Roboto, sans-serif;
      line-height:1.5;
    }
    #p1 {
        background-color:yellow;
        vertical-align:middle;
    }
    

  </style>
</head>
<body>

<?php        
    include 'menubackend.php';
    include 'menu.php';
?>

<br>
        <div class="container-fluid bg-3 text-center"> 
          <div><hr></div>   
          <div><h2>GridOnline Lotus Trophy</h2></div>   
        <div><hr></div>  
        </div> 
  
<div class="container">
  <div class="row" align="center">
  <button type="button" class="btn btn-warning btn btn-primary btn-lg" onClick="parent.location='http://18.231.168.55/gridonline/lotusgtc/backend/frminseririnscricao.php'" >Inscreva-se</button>
</div>
</div>
<hr>
        
          <div class="container">
            <div class="row" align="center">
              <img width="30%" height="30%"  src="../../img/lotus_evora_gtc/logolotus.jpg">
            </div>   
          </div>
<hr>

<!--         <div class="embed-responsive embed-responsive-16by9">            
            <iframe class="embed-responsive-item" src="http://gridonline.com.br/category/lotus-trophy/"></iframe>
        </div> -->
       <!--  <img src="http://gridonline.com.br/wp-content/uploads/2018/04/Screenshot_lotus_evora_gtc_lilski_watkins_glen_2-4-118-9-29-47.jpg"> -->

</body>
</html>
