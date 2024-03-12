

  document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll('.hero-section .slide');
    let currentSlide = 0;

    function showSlide(index) {
      slides.forEach((slide, i) => {
        if (i === index) {
          slide.style.display = 'block';
        } else {
          slide.style.display = 'none';
        }
      });
    }

    function nextSlide() {
      currentSlide = (currentSlide + 1) % slides.length;
      showSlide(currentSlide);
    }

    // Set interval for auto-sliding, adjust the time (in milliseconds) as needed
    setInterval(nextSlide, 5000);
  });
