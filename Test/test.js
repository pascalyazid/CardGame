var cards = [];
$(document).ready(function() {
  //  createPack();
});

function getTest(){
  var test = document.getElementById('test');
  console.log(test);
}

function setCard(data) {
  id = data.id;
  imageURL = data.image_uris.normal;
  artist = data.artist;
  marketID = data.cardmarket_id;
  details = [imageURL, artist, marketID];

  let card = document.createElement('div');
  card.classList.add('card');
    card.setAttribute('id', 'card');
  let cardInner = document.createElement('div');
  cardInner.classList.add('card-inner');

  let cardURL = document.createElement('p');
  cardURL.innerHTML = "https://api.scryfall.com/cards/" + id;
  cardURL.setAttribute('id', 'cardURL');
  card.appendChild(cardURL);

  let imageContainer = document.createElement('div');
  imageContainer.classList.add('card-front');

  let image = document.createElement('img');
  image.style.width = "350px";
  image.style.height = "600px";
  image.srcset = "https://i.imgur.com/P7qYTcI.png";
  imageContainer.append(image);

  let backContainer = document.createElement('div');
  backContainer.classList.add('card-back');
  let test = document.createElement('p');
  test.setAttribute('id', 'test');
  test.innerHTML = "Gaggi";
  test.hidden = true;
  backContainer.append(test);

  let backImage = document.createElement('img');
  backImage.style.width = "350px";
  backImage.style.height = "600px";
  backImage.srcset = imageURL;
  backContainer.append(backImage);

  cardInner.append(imageContainer);
  cardInner.append(backContainer);
  card.append(cardInner);
  card.onclick = function() {
  cardInner.style.transform = "rotateY(180deg)";
  }
  let packs = document.getElementById('packs');
  packs.append(card);
}

function getCard() {
  url = "https://api.scryfall.com/cards/random";

  $.getJSON(url).done(function(data) {
    if(data.image_uris === undefined) {
      console.log("Image is undefined");
      getCard();
    }
    else {
      setCard(data);
    }

  });
}




function createPack() {
      while(packs.firstChild) {
        packs.removeChild(packs.firstChild);
      }
    for (var i = 0; i < 3; i++) {
      getCard();

  }

}
