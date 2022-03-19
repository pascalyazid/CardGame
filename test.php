<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="Test/test.js" charset="utf-8"></script>
    <link rel="stylesheet" href="css/card.css">
    <title></title>
  </head>
  <body>

    <div class="packs" id="packs">

    </div>
  </body>
</html>

<?php



function getCard() {
  $url = "https://api.scryfall.com/cards/random";
  if(isset($json->image_uris)){
    getCard();
  }
  else {
    $json = file_get_contents($url);
    $json = json_decode($json);
    $card_uri = $json->uri;
    $card_name = $json->name;
    $card_image = $json->image_uris->normal;
    $data = array(
      0 => $card_uri,
      1 => $card_name,
      2 => $card_image,
    );
  }

  return $data;
}

function setCard() {
  $doc = new DOMDocument();
  $doc->validateOnParse = true;
  $doc->loadHTMLFile("test.php");

  $packs = $doc->getElementById('packs');

  $card = $doc->createElement('div');
  $card->setAttribute('class', 'card');
  $card->setAttribute('id', 'card');

  $cardInner = $doc->createElement('div');
  $cardInner->setAttribute('class', 'card-inner');
  $doc->appendChild($card);
  $packs->appendChild($card);
}
setCard();
 ?>
