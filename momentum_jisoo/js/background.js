const images = [
  "pexels-arın-turkay-450038.jpg",
  "pexels-jess-bailey-designs-934011.jpg",
  "pexels-min-an-1353938.jpg",
  "pexels-negative-space-127582.jpg",
  "pexels-pixabay-33622.jpg",
  "pexels-pixabay-164168.jpg",
  "pexels-ray-piedra-1696726.jpg",
  "pexels-valeriia-miller-2642842.jpg"
];

const chosenImage = images[Math.floor(Math.random() * images.length)];

const bgImage = document.createElement("img");
bgImage.src = `img/${chosenImage}`;
document.body.appendChild(bgImage);
bgImage.setAttribute("id", "bgImage");
