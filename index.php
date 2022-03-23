<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Cardgame</title>
    <style>
        body {
            background-image: url('http://localhost/CardGame/images/1141048.jpg');
        }
        
    </style>
    <script src="js/getCards.js"></script>
    <link rel="stylesheet" href="css/card.css">
  </head>
  <body>

    <div class="data">
    <div class="menue">
    <button type="button" name="resetPW">
      <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
    </button>
    <button type="button" name="logout">
      <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </button>
    <button type="button" name="logout">
      <a href="inventory.php" class="btn btn-danger ml-3">Your Collection</a>
    </button>
    </div>



    <?php
    require_once "config.php";
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: login.php");
      exit;
    }
    echo "You are now logged in as " . htmlspecialchars($_SESSION["username"]);



    // Check connection
    if ($link->connect_error) {
     die("Connection failed: " . $link->connect_error);
    }

     function createPack($link) {
      $servername = "eu-cdbr-west-02.cleardb.net";
      $username = "b3ff51d972250f";
      $password = "bf0598af";
      $dbName = "heroku_2f94a8f46a09c1a";
  
       for ($i=0; $i < 3; $i++) {
         echo "<script>getCard('" . genCard($link) . "')</script>";
       }

     }
     
    function genCard($link) {
      $url = "https://api.scryfall.com/cards/random";
      $json = file_get_contents($url);
      $json = json_decode($json);
      $cardName = $json->name;
      if(isset($json->image_uris->border_crop)) {
        saveCards($json->id, $json->image_uris->border_crop, $link);
        return $json->uri;
      }
      else{
        genCard();
      }
    }

    if(isset($_POST['createPack'])){
      unset($_POST['createPack']);
      date_default_timezone_set("Europe/Berlin");
      $dateNow = date('Y-m-d H:i:s', time());
      $userID = $_SESSION["id"];
      $lastpackDate = " ";
      $sql = "SELECT lastpack from user where user_id = '" . $userID . "'";

      $result = $link->query($sql);
      if ($result->num_rows > 0) {

        // output data of each row
        while($row = $result->fetch_assoc()) {
          $lastpackDate = $row["lastpack"];
        }
      }

      if(is_null($lastpackDate)){

        $sql = "UPDATE user SET lastpack = '" . $dateNow . "' where user_id = '" . $userID . "'";
        if ($link->query($sql) === TRUE) {
          //echo "Record updated successfully";
          createPack($link);
        }
        else {
          echo "Error updating record: " . $link->error;
        }

      }

      $dateNow1 = new DateTime($dateNow);
      $lastpackDate1 = new DateTime($lastpackDate);

      $diff = $dateNow1->diff($lastpackDate1);
      $hours = $diff->h;
      $hours = $hours + ($diff->days*24);


  
     
        if($hours >= 0) {

          $sql = "UPDATE user SET lastpack = '" . $dateNow . "' where user_id = '" . $userID . "'";
          if ($link->query($sql) === TRUE) {
            //echo "Record updated successfully";
            createPack($link);
          } else {
            echo "Error updating record: " . $link->error;
          }
  
        }
        if($hours < 1) {
          echo "<br>You have to wait for another pack...";
          echo "<br>Last Pack: " . $lastpackDate;
        }
        $link->close();

      }
    
      function saveCards ($card_id, $img_url, $link) {
        
        $sql1 = "INSERT IGNORE INTO card values('" . $card_id . "', 'https://api.scryfall.com/cards/" . $card_id . "', '" . $img_url . "')";
        $sql2 = "INSERT IGNORE INTO card_user(card_id, user_id) VALUES ('" . $card_id . "', '" . $_SESSION["id"] . "')";
        $link->query($sql1);
        $link->query($sql2);
        
          
      }
    ?>
    <form method="post">
      <input type="submit" name="createPack" value="Open Pack">
    </form>
    <div class="packs" id="packs">
    </div>
  </body>
    </div>

</html>
