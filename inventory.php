<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/card.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventar</title>
    <style>
        body {
            background-color: black;
        }
        
    </style>
</head>
<body>
    <div class="nav">
        <button type="button" name="resetPW">
            <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        </button>
        <button type="button" name="logout">
            <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        </button>
        <button type="button" name="logout">
            <a href="index.php" class="btn btn-danger ml-3">Home</a>
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
    ?>
    <?php
                $servername = "eu-cdbr-west-02.cleardb.net";
                $username = "b3ff51d972250f";
                $password = "bf0598af";
                $dbName = "heroku_2f94a8f46a09c1a";
            
                $conn = new mysqli($servername, $username, $password, $dbName);
                $query = "SELECT img_url from card where card_id in (select card_id from card_user where user_id='" . $_SESSION["id"] . "')";
                //echo $query;
                $counter = 0;
                if ($result = mysqli_query($conn, $query)) {

                    // Fetch one and one row
                    
                    while ($row = mysqli_fetch_row($result)) {
                        if($counter == 0) {
                            echo "<row class='row'>";
                        }   
                        echo <<<CARD
                                <div class="col-3">
                                    <div id="card" class="card">
                                        <div class="card-inner">
                                            <div class="card-front>
                                                <img style="width: 350px; height: 600px;" srcset="https://i.imgur.com/P7qYTcI.png">
                            CARD;
                    

                        echo <<<CARD

                                            </div
                                            <div class="card-back">
                                                <img style="width: 350px; height: 600px;" srcset="
                            CARD;

                        echo $row[0];

                        echo <<<CARD

                                                "></img>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            CARD;
                            $counter++;
                            if($counter == 4) {
                                echo "</row>";
                                $counter = 0;
                            }
                            

                            
                    }
                }
        ?>         
    </div>

</body>
</html>