// Import các thư viện CSS và JS cần thiết
import 'bootstrap';

import '@fortawesome/fontawesome-free/css/all.min.css';
import { createPopper } from '@popperjs/core';

import 'bootstrap-icons/font/bootstrap-icons.css';

// Đảm bảo rằng khi người dùng nhấp vào mục, biểu tượng sẽ thay đổi và dropdown sẽ mở/đóng
document.querySelectorAll('.nav-link').forEach(function(link) {
    link.addEventListener('click', function(event) {
        // Lấy phần tử <ul> chứa các mục dropdown
        var dropdown = this.nextElementSibling; // nextElementSibling để lấy <ul> ngay sau <a>
        
        // Kiểm tra nếu phần tử <ul> có class 'collapse' và không phải là mục link không có dropdown
        if (dropdown && dropdown.classList.contains('collapse')) {
            // Nếu dropdown đã mở, đóng nó
            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');  // Đóng dropdown
                
                // Cập nhật lại icon (đổi mũi tên lên thành mũi tên xuống)
                var icon = this.querySelector('.bi-chevron-up');
                if (icon) {
                    icon.classList.remove('bi-chevron-up');
                    icon.classList.add('bi-chevron-down');
                }
            } else {
                // Đóng tất cả các dropdown khác đang mở
                document.querySelectorAll('.collapse.show').forEach(function(openDropdown) {
                    openDropdown.classList.remove('show');  // Tắt lớp 'show' của tất cả các dropdown đang mở

                    // Cập nhật lại icon của các mục đang mở (đổi mũi tên về xuống)
                    var openIcon = openDropdown.previousElementSibling.querySelector('.bi-chevron-up');
                    if (openIcon) {
                        openIcon.classList.remove('bi-chevron-up');
                        openIcon.classList.add('bi-chevron-down');
                    }
                });

                // Mở dropdown hiện tại
                dropdown.classList.add('show');
                
                // Thay đổi biểu tượng mũi tên
                var icon = this.querySelector('.bi-chevron-down, .bi-chevron-up');
                if (icon) {
                    icon.classList.toggle('bi-chevron-down');  // Đổi mũi tên xuống
                    icon.classList.toggle('bi-chevron-up');    // Đổi mũi tên lên
                }
            }
        }
    });
});


if(document.getElementById('toggle-icon')){
    document.getElementById('toggle-icon').addEventListener('click', function () {
        // Lấy phần tử có id="sidebar-content", "sidebar-hr", "sidebar-dashboard", "content-admin"
        const sidebarContent = document.getElementById('sidebar-content');
        const contentAdmin = document.getElementById('content-admin');  // Lấy phần tử content-admin
        const icon = document.getElementById('toggle-icon');
        const sidebar = document.querySelector('.sidebar');  // Lấy toàn bộ sidebar
        // Thêm hoặc bỏ lớp để ẩn/hiện nội dung của sidebar
        sidebarContent.classList.toggle('sidebar-content-hidden');
        // Ẩn/hiện phần tử có id="sidebar-hr"


        // Thay đổi icon từ 3 gạch ngang thành mũi tên hoặc ngược lại
        if (sidebarContent.classList.contains('sidebar-content-hidden')) {

            document.getElementById('sidebarx').style.display='none';
            // Thêm lớp "content-a" và thay đổi độ rộng của content-admin khi sidebar đóng
            contentAdmin.classList.add('content-a');
            contentAdmin.style.width = '100%'; // Đặt độ rộng là 500px
        } else {
            icon.classList.remove('fa-chevron-right');
            icon.classList.add('fa-bars');  // Đổi lại thành 3 gạch ngang
            sidebar.classList.remove('sidebar-hidden');  // Mở rộng sidebar

            // Gỡ lớp "content-a" và thay đổi độ rộng của content-admin khi sidebar mở
            contentAdmin.classList.remove('content-a');
            contentAdmin.style.width = '100%'; // Đặt độ rộng lại là 700px
             document.getElementById('sidebarx').style.display='block';
        }
    });
}


document.getElementById('search1').addEventListener('input', function() {
    var searchValue = this.value;
    document.getElementById('search2').value = searchValue;
});



if(document.getElementById('category')){
    document.addEventListener("DOMContentLoaded", function () {
        const toggleButton = document.getElementById('toggle-category');
        const categoryDiv = document.getElementById('category');
        const categoryIcon = document.getElementById('category-icon');

        if (toggleButton && categoryDiv && categoryIcon) {
            toggleButton.onclick = function () {
                if (categoryDiv.classList.contains('show')) {
                    categoryDiv.classList.remove('show');
                    categoryIcon.classList.remove('fa-chevron-up');
                    categoryIcon.classList.add('fa-chevron-down');
                } else {
                    categoryDiv.classList.add('show');
                    categoryIcon.classList.remove('fa-chevron-down');
                    categoryIcon.classList.add('fa-chevron-up');
                }
            };
        } else {
            console.error("Các phần tử cần thiết không tồn tại trên trang.");
        }
    });

}


// Hàm để lấy tham số từ URL
function getUrlParameter(name) {
    var url = new URL(window.location.href);
    var params = new URLSearchParams(url.search);
    return params.get(name);
}

// Lấy giá trị của price-min và price-max từ URL (nếu có)
var priceMinFromUrl = getUrlParameter('price-min');
var priceMaxFromUrl = getUrlParameter('price-max');

// Kiểm tra và thiết lập giá trị mặc định nếu không có tham số trong URL
var priceMin = priceMinFromUrl ? parseInt(priceMinFromUrl) : 0;
var priceMax = priceMaxFromUrl ? parseInt(priceMaxFromUrl) : 0;

// Tạo thanh trượt
var priceSlider = document.getElementById('price-slider');
var priceMinInput = document.getElementById('price-min');
var priceMaxInput = document.getElementById('price-max');

noUiSlider.create(priceSlider, {
    start: [priceMin, priceMax], // Sử dụng giá trị từ URL hoặc giá trị mặc định
    connect: true, // Liên kết giữa 2 chấm kéo
    range: {
        'min': 0,
        'max': 1000000
    },
    step: 1000, // Bước giá trị
    tooltips: [false, false], // Không hiển thị tooltip
    format: {
        to: function (value) {
            return Math.round(value); // Làm tròn giá trị
        },
        from: function (value) {
            return value;
        }
    }
});

// Cập nhật giá trị trên thanh trượt khi người dùng thay đổi ô nhập liệu
priceMinInput.addEventListener('change', function () {
    priceSlider.noUiSlider.set([priceMinInput.value, null]);
});

priceMaxInput.addEventListener('change', function () {
    priceSlider.noUiSlider.set([null, priceMaxInput.value]);
});

// Cập nhật giá trị các ô nhập liệu khi thanh trượt thay đổi
priceSlider.noUiSlider.on('update', function (values, handle) {
    if (handle === 0) {
        priceMinInput.value = values[0]; // Cập nhật giá trị của ô input min
    } else {
        priceMaxInput.value = values[1]; // Cập nhật giá trị của ô input max
    }
});



document.addEventListener('DOMContentLoaded', function () {
    // Khi trang đã được tải, ẩn các phần tử
    var checkboxContent = document.getElementById('checkbox-content');
    var arrowIcon = document.getElementById('arrow-icon');
    var publisherDiv = document.getElementById('div-publisher');
    checkboxContent.style.display = 'none';
    publisherDiv.style.height = '37px'; // Đặt chiều cao khi ẩn checkbox
    arrowIcon.classList.add('open'); // Đổi icon thành đóng

    var checkboxContentAuthor = document.getElementById('checkbox-content-author');
    var arrowIconAuthor = document.getElementById('arrow-icon-author');
    var authorDiv = document.getElementById('div-author');
    checkboxContentAuthor.style.display = 'none';
    authorDiv.style.height = '37px';
    arrowIconAuthor.classList.add('open');

    var priceContent = document.getElementById('price-content');
    var arrowIconPrice = document.getElementById('arrow-icon-price');
    var priceContainer = document.getElementById('price-container');
    priceContent.style.display = 'none';
    priceContainer.style.height = '37px';
    arrowIconPrice.classList.add('open');

    var categoryContent = document.getElementById('category-content');
    var arrowIconCategory = document.getElementById('arrow-icon-category');
    var categoryContainer = document.getElementById('category-container');
    categoryContent.style.display = 'none';
    categoryContainer.style.height = '37px';
    arrowIconCategory.classList.add('open');

    var targetAudienceContent = document.getElementById('target-audience-content');
    var arrowIconTargetAudience = document.getElementById('arrow-icon-target-audience');
    var targetAudienceContainer = document.getElementById('target-audience-container');
    targetAudienceContent.style.display = 'none';
    targetAudienceContainer.style.height = '37px';
    arrowIconTargetAudience.classList.add('open');
});

// JavaScript cho Publisher
document.getElementById('toggle-header').addEventListener('click', function () {
    var checkboxContent = document.getElementById('checkbox-content');
    var arrowIcon = document.getElementById('arrow-icon');
    var publisherDiv = document.getElementById('div-publisher'); 

    // Kiểm tra trạng thái hiện tại và thay đổi
    if (checkboxContent.style.display === 'none') {
        checkboxContent.style.display = 'block';
        arrowIcon.classList.remove('open');
        publisherDiv.style.height = '200px';
    } else {
        checkboxContent.style.display = 'none';
        arrowIcon.classList.add('open');
        publisherDiv.style.height = '37px';
    }
});

// JavaScript cho Author
document.getElementById('toggle-header-author').addEventListener('click', function () {
    var checkboxContentAuthor = document.getElementById('checkbox-content-author');
    var arrowIconAuthor = document.getElementById('arrow-icon-author');
    var authorDiv = document.getElementById('div-author'); 

    // Kiểm tra trạng thái hiện tại và thay đổi
    if (checkboxContentAuthor.style.display === 'none') {
        checkboxContentAuthor.style.display = 'block';
        arrowIconAuthor.classList.remove('open');
        authorDiv.style.height = '200px';
    } else {
        checkboxContentAuthor.style.display = 'none';
        arrowIconAuthor.classList.add('open');
        authorDiv.style.height = '37px';
    }
});

// JavaScript cho Price
document.getElementById('toggle-price').addEventListener('click', function () {
    var priceContent = document.getElementById('price-content');
    var arrowIconPrice = document.getElementById('arrow-icon-price');
    var priceContainer = document.getElementById('price-container'); 

    if (priceContent.style.display === 'none' || priceContent.style.display === '') {
        priceContent.style.display = 'block';
        arrowIconPrice.classList.remove('open');
        priceContainer.style.height = '130px';
    } else {
        priceContent.style.display = 'none';
        arrowIconPrice.classList.add('open');
        priceContainer.style.height = '37px';
    }
});

// JavaScript cho Thể loại sách
document.getElementById('toggle-category').addEventListener('click', function () {
    var categoryContent = document.getElementById('category-content');
    var arrowIconCategory = document.getElementById('arrow-icon-category');
    var categoryContainer = document.getElementById('category-container'); 

    if (categoryContent.style.display === 'none' || categoryContent.style.display === '') {
        categoryContent.style.display = 'block';
        arrowIconCategory.classList.remove('open');
        categoryContainer.style.height = '200px';
    } else {
        categoryContent.style.display = 'none';
        arrowIconCategory.classList.add('open');
        categoryContainer.style.height = '37px';
    }
});

// JavaScript cho Đối tượng
document.getElementById('toggle-target-audience').addEventListener('click', function () {
    var targetAudienceContent = document.getElementById('target-audience-content');
    var arrowIconTargetAudience = document.getElementById('arrow-icon-target-audience');
    var targetAudienceContainer = document.getElementById('target-audience-container'); 

    if (targetAudienceContent.style.display === 'none' || targetAudienceContent.style.display === '') {
        targetAudienceContent.style.display = 'block';
        arrowIconTargetAudience.classList.remove('open');
        targetAudienceContainer.style.height = '200px';
    } else {
        targetAudienceContent.style.display = 'none';
        arrowIconTargetAudience.classList.add('open');
        targetAudienceContainer.style.height = '37px';
    }
});

