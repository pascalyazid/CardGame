<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: login.php");
      exit;
    }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Cardgame</title>
    <script src="js/getCards.js"></script>
    <link rel="stylesheet" href="css/card.css">
    <link rel="stylesheet" href="/css/style.css">
  </head>
  <body>
    <div class="nav">
      <div class="collection">
        <button type="button" name="collection" class="button-9">
          <a href="inventory.php" class="b-Link">Your Collection</a>
        </button>
      </div>

      <div class="account">
        <button type="button" name="resetPW" class="button-9">
          <a href="reset-password.php" class="b-Link">Reset Your Password</a>
        </button>
        <div class="dropdown">
          <button class="dropbtn">Account</button>
          <div class="dropdown-content">
            <p class="username"><?php echo htmlspecialchars($_SESSION["username"]);?></p>
            <a href="logout.php">Sign out</a>
          </div>
        </div>
      </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
      <div class="open">
        <form method="post">
          <input type="submit" name="createPack" value="Open Pack" class="button-9">
        </form>
      </div>


    <?php
    $servername = "eu-cdbr-west-02.cleardb.net";
    $username = "b3ff51d972250f";
    $password = "bf0598af";
    $dbName = "heroku_2f94a8f46a09c1a";

    $conn = new mysqli($servername, $username, $password, $dbName);

    // Check connection
    if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
    }

    /**
     * Class of the Card Object
     */

     class Card
 {
 public $songURL;
 public $id;
 public $name;
 function __construct()
 {
   $url = "https://api.scryfall.com/cards/random";
   $json = file_get_contents($url);
   $json = json_decode($json);
   $imgURL = $json->image_uris->normal;
   $name = $json->name;
   $id = $json->id;
 }

 function getName() {
   return $this->name;
 }

 function getID() {
   return $this->id;
 }

 function getImage() {
   return $this->imgURL;
 }
 }


     function createPack() {
      $servername = "eu-cdbr-west-02.cleardb.net";
      $username = "b3ff51d972250f";
      $password = "bf0598af";
      $dbName = "heroku_2f94a8f46a09c1a";

      $conn = new mysqli($servername, $username, $password, $dbName);
       for ($i=0; $i < 3; $i++) {
         echo "<script>getCard('" . genCard($conn) . "')</script>";
       }

     }

    function genCard($conn) {
      $url = "https://api.scryfall.com/cards/random";
      $json = file_get_contents($url);
      $json = json_decode($json);
      $cardName = $json->name;
      if(isset($json->image_uris->normal)) {
        saveCards($json->id, $conn, $json->image_uris->normal);
        return $json->uri;
      }
      else{
        genCard($conn);
      }
    }

    if(isset($_POST['createPack'])){
      unset($_POST['createPack']);
      date_default_timezone_set("Europe/Berlin");
      $dateNow = date('Y-m-d H:i:s', time());
      $userID = $_SESSION["id"];
      $lastpackDate = " ";
      $sql = "SELECT lastpack from user where user_id = '" . $userID . "'";

      $result = $conn->query($sql);
      if ($result->num_rows > 0) {

        // output data of each row
        while($row = $result->fetch_assoc()) {
          $lastpackDate = $row["lastpack"];
        }
      }

      if(is_null($lastpackDate)){

        $sql = "UPDATE user SET lastpack = '" . $dateNow . "' where user_id = '" . $userID . "'";
        if ($conn->query($sql) === TRUE) {
          //echo "Record updated successfully";
          createPack();
        }
        else {
          echo "Error updating record: " . $conn->error;
        }

      }

      $dateNow1 = new DateTime($dateNow);
      $lastpackDate1 = new DateTime($lastpackDate);

      $diff = $dateNow1->diff($lastpackDate1);
      $hours = $diff->h;
      $hours = $hours + ($diff->days*24);




        if($hours >= 1) {

          $sql = "UPDATE user SET lastpack = '" . $dateNow . "' where user_id = '" . $userID . "'";
          if ($conn->query($sql) === TRUE) {
            //echo "Record updated successfully";
            createPack();
          } else {
            echo "Error updating record: " . $conn->error;
          }

        }
        if($hours < 1) {
          echo "<div class='message'>";
          echo "<br>You have to wait for another pack...";
          echo "<br>Last Pack: " . $lastpackDate;
          echo "</div>";
        }
        $conn->close();

      }










        //$dateUser = date('Y-m-d H:i:s', time());

      //$dateUser =
      //$sqlUser = "update user set lastpack \'" . $date . "\' where user_id = '" . $id "';";
      //echo $sqlUser;


        //$urls_array =  $urls->find('a');

      function saveCards ($card_id, $conn, $img_url) {

        $sql1 = "INSERT IGNORE INTO card values('" . $card_id . "', 'https://api.scryfall.com/cards/" . $card_id . "', '" . $img_url . "')";
        $sql2 = "INSERT IGNORE INTO card_user(card_id, user_id) VALUES ('" . $card_id . "', '" . $_SESSION["id"] . "')";
        $conn->query($sql1);
        $conn->query($sql2);


  }
    ?>

    <div class="packs" id="packs">
    </div>
  </body>
</html>
