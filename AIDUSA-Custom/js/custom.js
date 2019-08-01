const rellax = new Rellax('.parallax-bg', {
  speed: -3,
  center: true,
  wrapper: null,
  round: true,
  vertical: true,
  horizontal: false
});

const slideInterval = 8000
let nextSlide = 1

const slides = jQuery('.wp-block-mcw-blocks-slide')

for( let i = 0; i < slides.length; i++){
  let dot = `<a class="slide-dot" data-count=${i} onclick="chooseSlide(${i})"></a>`
  jQuery('.slider-dots').append(dot)
}

jQuery('.slide-dot[data-count="0"]').addClass('active')

function chooseSlide( slide ){
  clearInterval(slidemover)
  slidemover = window.setInterval( moveToSlide, slideInterval)
  moveToSlide( slide )
}

function moveToSlide( slide ){
  if (slide === undefined){
    slide = nextSlide
  }
  jQuery(".slide-dot").removeClass('active')
  jQuery(".slide-dot[data-count='"+slide+"']").addClass('active')
  slides.css('transform', `translatex(${slide * -100}%)`)
  nextSlide = (slide + 1 >= slides.length) ? 0 : slide + 1
}

let slidemover = window.setInterval( moveToSlide, slideInterval)

const els = document.querySelectorAll("a[href$='#']");

for ( let i = 0; i < els.length; i++){
	els[i].addEventListener('click', e => e.preventDefault() )
}
