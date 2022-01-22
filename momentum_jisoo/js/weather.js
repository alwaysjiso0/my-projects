const API_KEY = "8df6dd7c4744cc0cd27b8cbcf0f3aeba";

function onGeoOk(position) {
  const lat = position.coords.latitude;
  const lon = position.coords.longitude;
  const url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${API_KEY}&units=metric`;
  fetch(url).then(response => response.json()).then(data => {
    const weather = document.querySelector("#weather");
    const weatherContainer = document.querySelector('#weather span:first-child');
    const city = document.querySelector('#weather span:last-child');
    city.innerHTML = data.name;
    const image = document.createElement("img");
    console.log(image);
    image.src = `http://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png`;
    weather.appendChild(image);
    weatherContainer.innerHTML = `${data.weather[0].main} / ${data.main.temp}℃`;
  }); 
  // 검사 > Network에서 확인

}

function onGeoError() {
  alert("Can't find you.");
}


navigator.geolocation.getCurrentPosition(onGeoOk, onGeoError);