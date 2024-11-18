  document.addEventListener('DOMContentLoaded', function () {
        const carousel = document.getElementById('bannerCarousel');
        const carouselInstance = bootstrap.Carousel.getOrCreateInstance(carousel);

        // Reset animation for all elements
        function resetAnimation() {
            document.querySelectorAll('[id^="book"], [id^="heading"], [id^="text"]').forEach(el => {
                el.style.animation = '';
            });
        }

        // Apply animation for active slide
        function applyAnimation(index) {
            if (index === 0) {
                document.getElementById('book1').style.animation = 'slideInFromLeft 3s forwards';
                document.getElementById('heading1').style.animation = 'slideInFromTop 3s forwards';
                document.getElementById('text1').style.animation = 'slideInFromBottom 3s forwards';
            } else if (index === 1) {
                document.getElementById('book2').style.animation = 'slideInFromLeft 3s forwards';
                document.getElementById('heading2').style.animation = 'slideInFromTop 3s forwards';
                document.getElementById('text2').style.animation = 'slideInFromBottom 3s forwards';
            }
        }

        // Handle carousel events
        carousel.addEventListener('slide.bs.carousel', function () {
            resetAnimation();
        });

        carousel.addEventListener('slid.bs.carousel', function (event) {
            applyAnimation(event.to); // Apply animation for the current active slide
        });

        // Initialize animations for the first slide
        applyAnimation(0);
    });



document.addEventListener('DOMContentLoaded', function () {
    // Lấy phần tử carousel
    var myCarousel = document.getElementById('bannerCarousel');
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 5000, // Đặt thời gian chuyển động giữa các banner (5 giây)
        ride: 'carousel', // Tự động bắt đầu carousel khi trang được tải
    });
});


