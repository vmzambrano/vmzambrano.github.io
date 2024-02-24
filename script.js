const slider = document.querySelector('.slider');
let counter = 1;

setInterval(() => {
  slider.style.transition = 'transform 0.5s ease-in-out';
  slider.style.transform = 'translateX(' + (-350 * counter) + 'px)';
  counter++;

  if (counter === slider.children.length) {
    counter = 0;
    setTimeout(() => {
      slider.style.transition = 'none';
      slider.style.transform = 'translateX(0)';
    }, 500);
  }
}, 3000);
