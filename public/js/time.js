const time = document.getElementById('waktu');
  const timeformat = document.getElementById('timeformat');

  document.addEventListener('DOMContentLoaded', () => {
  setInterval(showTime, 1000);

  });

  const showTime = () => {
  let date = new Date();

  let hr = date.getHours();
  let min = date.getMinutes();
  let sec = date.getSeconds();

  hr = hr<10 ? `0${hr}` : hr;
  min = min<10 ? `0${min}` : min;
  sec = sec<10 ? `0${sec}` : sec;


  waktu.innerHTML = `${hr} : ${min} : ${sec}`;

  timeformat.innerHTML = hr>12? "PM" : "AM";
  }
