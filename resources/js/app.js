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
        const sidebarHr = document.getElementById('sidebar-hr');
        const sidebarDb = document.getElementById('sidebar-dashboard');
        const contentAdmin = document.getElementById('content-admin');  // Lấy phần tử content-admin
        const icon = document.getElementById('toggle-icon');
        const sidebar = document.querySelector('.sidebar');  // Lấy toàn bộ sidebar

        // Thêm hoặc bỏ lớp để ẩn/hiện nội dung của sidebar
        sidebarContent.classList.toggle('sidebar-content-hidden');
        
        // Ẩn/hiện phần tử có id="sidebar-hr"
        sidebarHr.classList.toggle('sidebar-content-hidden');
        sidebarDb.classList.toggle('sidebar-content-hidden');

        // Thay đổi icon từ 3 gạch ngang thành mũi tên hoặc ngược lại
        if (sidebarContent.classList.contains('sidebar-content-hidden')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-chevron-right');  // Đổi thành mũi tên
            sidebar.classList.add('sidebar-hidden');  // Thu nhỏ sidebar

            // Thêm lớp "content-a" và thay đổi độ rộng của content-admin khi sidebar đóng
            contentAdmin.classList.add('content-a');
            contentAdmin.style.width = '96%'; // Đặt độ rộng là 500px
        } else {
            icon.classList.remove('fa-chevron-right');
            icon.classList.add('fa-bars');  // Đổi lại thành 3 gạch ngang
            sidebar.classList.remove('sidebar-hidden');  // Mở rộng sidebar

            // Gỡ lớp "content-a" và thay đổi độ rộng của content-admin khi sidebar mở
            contentAdmin.classList.remove('content-a');
            contentAdmin.style.width = '80%'; // Đặt độ rộng lại là 700px
        }
    });
}





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


  // Tạo thanh trượt
    var priceSlider = document.getElementById('price-slider');
    var priceMinInput = document.getElementById('price-min');
    var priceMaxInput = document.getElementById('price-max');

    noUiSlider.create(priceSlider, {
        start: [10000, 150000], // Giá trị ban đầu
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


window.addEventListener("wheel", function(event) {
    const sidebar = document.querySelector('.sidebar'); // Lấy sidebar
    const currentScrollTop = document.documentElement.scrollTop || document.body.scrollTop; // Vị trí cuộn hiện tại

    if (currentScrollTop >= 100) {
        sidebar.style.top = '85px'; // Khi cuộn xuống 100px, sidebar sẽ ở vị trí top 85px
    } else if (currentScrollTop <= 20) {
        sidebar.style.top = '151px'; // Khi cuộn lên top, sidebar sẽ ở vị trí top 200px
    }
});

