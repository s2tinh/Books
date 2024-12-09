<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bookstore')</title>

    <!-- Thêm CSS AOS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Sử dụng Vite để kết nối tài nguyên CSS đã biên dịch -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Header -->
    @include('components.header')

    <!-- Navbar -->
    @include('components.navbar')

    <main>
        @yield('content') <!-- Phần nội dung động sẽ được chèn tại đây -->
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- Các script cần thiết -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    
    <!-- Khởi tạo AOS -->
    <script>
        // Khởi tạo AOS với các tuỳ chọn
        AOS.init({
            offset: 50,  // Độ lệch khi hiệu ứng bắt đầu
            duration: 1000,  // Thời gian hiệu ứng xuất hiện
            easing: 'ease-in-out',  // Hiệu ứng easing
            once: true,  // Chỉ thực hiện hiệu ứng một lần
        });
    </script>
</body>
</html>
