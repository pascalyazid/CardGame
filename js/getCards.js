var cards = [];



/*function addListener() {
  var openButton = document.getElementById("buttonCreate");
  openButton.addEventListener("click", function() {
    //createPack();
  });
}*/
function randomCard(){
  let url = "https://api.scryfall.com/cards/random";

  $.getJSON(url).done(function(data) {

    let imageURL = data.image_uris.normal;
    let card = document.getElementById("card");
    card.style.width = "350px";
    card.style.height = "600px";


    let imageContainer = document.getElementById("frontImage");
    imageContainer.classList.add('image');
    imageContainer.style.width = "350px";
    imageContainer.style.height = "600px";
    let image = document.createElement('img');
    image.style.width = "350px";
    image.style.height = "600px";
    image.srcset = imageURL;
    imageContainer.append(image);
    let backContainer = document.getElementById("backImage");
    backContainer.style.width = "350px";
    backContainer.style.height = "600px";
    backContainer.classList.add('image');
    let backImage = document.createElement('img');
    backImage.style.width = "350px";
    backImage.style.height = "600px";
    backImage.srcset = "https://i.imgur.com/P7qYTcI.png";
    backContainer.append(backImage);
  })

}

function createPack() {
    console.log("cards created");
    console.log(cards.length);
    if(cards.length != 0){
      let packs = document.getElementById('packs');
      while(packs.firstChild) {
        packs.removeChild(packs.firstChild);
      }
    }
    for (var i = 0; i < 3; i++) {
      url = "https://api.scryfall.com/cards/random";
      $.getJSON(url).done(function(data) {
        imageURL = data.image_uris.normal;
        artist = data.artist;
        marketID = data.cardmarket_id;
        details = [imageURL, artist, marketID];
        cards.push(details);

        let card = document.createElement('div');
        card.classList.add('card');

        let cardInner = document.createElement('div');
        cardInner.classList.add('card-inner');

        let imageContainer = document.createElement('div');
        imageContainer.classList.add('card-front');

        let image = document.createElement('img');
        image.style.width = "350px";
        image.style.height = "600px";
        image.srcset = "https://i.imgur.com/P7qYTcI.png";
        imageContainer.append(image);

        let backContainer = document.createElement('div');
        backContainer.classList.add('card-back');

        let backImage = document.createElement('img');
        backImage.style.width = "350px";
        backImage.style.height = "600px";
        backImage.srcset = imageURL;
        backContainer.append(backImage);

        cardInner.append(imageContainer);
        cardInner.append(backContainer);
        card.append(cardInner);
        let packs = document.getElementById('packs');
        packs.append(card);
        card.onclick = function() {
        cardInner.style.transform = "rotateY(180deg)";
        }
      })
  }

}
