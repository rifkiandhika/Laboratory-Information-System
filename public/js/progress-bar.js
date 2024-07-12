const one = document.querySelector('.one');
const two = document.querySelector('.two');
const three = document.querySelector('.three');
const four = document.querySelector('.four');
const five = document.querySelector('.five');
const six = document.querySelector('.six');

one.onclick = function(){
    one.classList.add('aktif');
    two.classList.remove('aktif');
    three.classList.remove('aktif');
    four.classList.remove('aktif');
    five.classList.remove('aktif');
    six.classList.remove('aktif');
}
two.onclick = function(){
    one.classList.add('aktif');
    two.classList.add('aktif');
    three.classList.remove('aktif');
    four.classList.remove('aktif');
    five.classList.remove('aktif');
    six.classList.remove('aktif');
}
three.onclick = function(){
    one.classList.add('aktif');
    two.classList.add('aktif');
    three.classList.add('aktif');
    four.classList.remove('aktif');
    five.classList.remove('aktif');
    six.classList.remove('aktif');
}
four.onclick = function(){
    one.classList.add('aktif');
    two.classList.add('aktif');
    three.classList.add('aktif');
    four.classList.add('aktif');
    five.classList.remove('aktif');
    six.classList.remove('aktif');
}
five.onclick = function(){
    one.classList.add('aktif');
    two.classList.add('aktif');
    three.classList.add('aktif');
    four.classList.add('aktif');
    five.classList.add('aktif');
    six.classList.remove('aktif');
}
six.onclick = function(){
    one.classList.add('aktif');
    two.classList.add('aktif');
    three.classList.add('aktif');
    four.classList.add('aktif');
    five.classList.add('aktif');
    six.classList.add('aktif');
}
