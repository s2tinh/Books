// Import các thư viện CSS và JS cần thiết
import 'bootstrap';

import '@fortawesome/fontawesome-free/css/all.min.css';
import { createPopper } from '@popperjs/core';

import './app/home.js'; // Đường dẫn từ app.js tới home.js
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



window.onload = function () {
    function handleMainImageChange(input) {
        const mainImagePreview = document.getElementById('main-image-preview');
        const additionalImagesContainer = document.getElementById('additional-images-container');

        // Xóa nội dung hiện tại
        mainImagePreview.innerHTML = '';

        if (input.files.length > 0) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                // Tạo container chứa ảnh
                const imgContainer = document.createElement('div');
                imgContainer.className = 'position-relative d-inline-block';

                // Tạo DOM hiển thị ảnh
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Hình ảnh chính';
                img.style.maxWidth = '250px';
                img.className = 'rounded';

                // Tạo chữ X để xóa ảnh chính
                const removeText = document.createElement('span');
                removeText.textContent = '×'; // Ký tự 'X' (không phải button)
                removeText.className = 'remove-btn'; // Sử dụng lớp CSS đã định nghĩa cho chữ X

                removeText.onclick = function () {
                    input.value = ''; // Reset input
                    mainImagePreview.innerHTML = ''; // Xóa preview
                    additionalImagesContainer.style.display = 'none'; // Ẩn ảnh phụ
                };

                // Thêm ảnh và chữ X vào container
                imgContainer.appendChild(img);
                imgContainer.appendChild(removeText);

                // Hiển thị container
                mainImagePreview.appendChild(imgContainer);

                // Hiển thị phần ảnh phụ
                additionalImagesContainer.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }
    }

    function handleExtraImages() {
        const input = document.getElementById('extra-images-input');
        const fileList = input.files;
        const extraImagesList = document.getElementById('extra-images-list');

        // Clear the previous list
        extraImagesList.innerHTML = '';

        Array.from(fileList).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                // Create the container
                const container = document.createElement('div');
                container.classList.add('extra-image-item');

                // Create the image
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = `Hình ảnh phụ ${index + 1}`;

                // Create the description input
                const descriptionInput = document.createElement('input');
                descriptionInput.type = 'text';
                descriptionInput.placeholder = `Mô tả cho ảnh ${index + 1}`;
                descriptionInput.name = `extra_images_description[]`;
                descriptionInput.classList.add('form-control', 'rounded-0', 'shadow-none');

                // Create the remove button
                const removeBtn = document.createElement('span');
                removeBtn.classList.add('remove-btn');
                removeBtn.innerHTML = '&times;';
                removeBtn.onclick = function () {
                    container.remove();
                };

                // Append elements to the container
                container.appendChild(img);
                container.appendChild(descriptionInput);
                container.appendChild(removeBtn);

                // Add the container to the list
                extraImagesList.appendChild(container);
            };

            reader.readAsDataURL(file);
        });
    }

    // Đặt các hàm này vào global scope để dùng trong HTML
    window.handleMainImageChange = handleMainImageChange;
    window.handleExtraImages = handleExtraImages;
};



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

