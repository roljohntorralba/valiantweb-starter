const navMenu = document.querySelector("#site-header > .container");
const offsetDetect = document.querySelector('#wpadminbar') ? -(300 + 32) : -300;

let lastKnownScrollPosition = 0;
let ticking = false;
let scrollPosFlag = false;

function doScroll(scrollPos) {
  // If body reaches a certain scroll position
  if(document.body.getBoundingClientRect().top <= offsetDetect) {
    scrollPosFlag = true;
  } else {
    scrollPosFlag = false;
  }
  if(scrollPosFlag) {
    navMenu.classList.remove('py-4');
    navMenu.classList.add('py-1');
  } else {
    navMenu.classList.add('py-4');
    navMenu.classList.remove('py-1');
  }
}

/*
document.addEventListener("scroll", function (e) {
  lastKnownScrollPosition = window.scrollY;

  if (!ticking) {
    window.requestAnimationFrame(function () {
      doScroll(lastKnownScrollPosition);
      ticking = false;
    });

    ticking = true;
  }
});
*/