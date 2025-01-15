let currentIndex = 0;

function showNextSlide() {
    const slides = document.querySelectorAll('.carousel-item');
    const totalSlides = slides.length;
    const slidesToShow = 3; // 一次顯示三張圖片

    slides.forEach((slide, index) => {
        slide.style.transform = `translateX(-${currentIndex * (100 / slidesToShow)}%)`;
    });

    currentIndex = (currentIndex + slidesToShow) % totalSlides;
}

setInterval(showNextSlide, 2000); // 每2秒切換一次