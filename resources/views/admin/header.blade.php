<div class="container-fluid">
    <div class="container">
        <div class="row align-items-center py-2">
            <!-- Header: Đăng nhập/Đăng ký hoặc Tên người dùng -->
            <div class="col-md-12 d-flex justify-content-end align-items-center">
                @auth
                    <!-- Hiển thị tên người dùng và icon đăng xuất -->
                    <div class="me-3 text-dark d-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tên người dùng">
                        <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        <!-- Đăng xuất -->
                        <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 text-dark" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Đăng xuất">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Đăng nhập -->
                    <div class="me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Đăng nhập">
                        <a href="/login" class="text-dark">
                            <i class="fas fa-sign-in-alt"></i>
                        </a>
                    </div>

                    <!-- Đăng ký -->
                    <div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Đăng ký">
                        <a href="/register" class="text-dark">
                            <i class="fas fa-user-plus"></i>
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
