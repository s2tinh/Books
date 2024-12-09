<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    
    <!-- Sử dụng Vite để kết nối tài nguyên -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: #384c601f;">
    <!-- Gọi phần header từ file con -->
    @include('admin.header')

    <div class="d-flex container-fluid">
        <!-- Gọi phần sidebar từ file con -->
        @include('admin.sidebar')

        <!-- Content bên phải -->
        <main class="flex-grow-1 p-4 ">
            <div id="content-admin" class=" ms-auto">
            @yield('content') <!-- Nơi chèn nội dung động -->
            </div>
        </main>
    </div>

    <!-- Gọi phần footer từ file con -->
    @include('admin.footer')

    <!-- Các script cần thiết -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <!-- Khởi tạo AOS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({
                offset: 50,
                duration: 1000,
                easing: 'ease-in-out',
                once: true,
            });
        });
    </script>
</body>
</html>
