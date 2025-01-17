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


document.querySelectorAll('.book-container').forEach(container => {
    let isMouseDown = false;
    let startX;
    let scrollLeft;
    let momentum = false;
    let startTime;  // Khai báo biến startTime
    let speed = 0;

    container.addEventListener('mousedown', (e) => {
        isMouseDown = true;
        startX = e.pageX - container.offsetLeft;
        scrollLeft = container.scrollLeft;
        startTime = Date.now(); // Khởi tạo startTime khi bắt đầu kéo
        container.style.cursor = 'grabbing'; // Đổi con trỏ khi kéo
        momentum = false; // Dừng quán tính khi bắt đầu kéo
    });

    container.addEventListener('mouseleave', () => {
        isMouseDown = false;
        container.style.cursor = 'grab';
    });

    container.addEventListener('mouseup', () => {
        isMouseDown = false;
        container.style.cursor = 'grab';
        momentum = true;
        // Tính toán tốc độ quán tính dựa trên khoảng cách và thời gian kéo
        const distance = container.scrollLeft - scrollLeft;
        const time = Date.now() - startTime; // Tính thời gian kéo
        speed = distance / time; // Tính tốc độ
        requestAnimationFrame(applyMomentum);
    });

    container.addEventListener('mousemove', (e) => {
        if (!isMouseDown) return;
        e.preventDefault(); // Ngừng hành vi mặc định
        const x = e.pageX - container.offsetLeft;
        const walk = (x - startX) * 2; // Điều chỉnh tốc độ cuộn
        container.scrollLeft = scrollLeft - walk;
    });

    // Hàm áp dụng quán tính
    function applyMomentum() {
        if (!momentum) return;
        container.scrollLeft += speed;
        speed *= 1; // Giảm tốc độ theo thời gian
        if (Math.abs(speed) > 0.5) {
            requestAnimationFrame(applyMomentum);
        } else {
            momentum = false;
        }
    }
});
