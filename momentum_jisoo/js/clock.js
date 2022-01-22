const clock = document.querySelector('h2#clock');

function getClock() {
  const date = new Date();
  const hoursLong = String(date.getHours()).padStart(2, "0");
  const hoursShort = String(date.getHours()%12).padStart(2, "0");
  const minutes = String(date.getMinutes()).padStart(2, "0");
  const seconds = String(date.getSeconds()).padStart(2, "0");
  const ampm = hoursLong >= 12 ? 'PM' : 'AM';

  clock.innerText = `${hoursShort}:${minutes} ${ampm}`;
}

getClock();
setInterval(getClock, 1000);