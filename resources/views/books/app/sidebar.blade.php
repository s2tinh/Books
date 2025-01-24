<div class="border sidebar bg-white p-1">
  <div class="mt-3 dashboard-block">
    <div style="display: flex; align-items: center;">
        <p id="sidebar-dashboard" class="h6" style="margin-right: 10px;">
            Search  <i class="fas fa-sync text-primary"></i> <!-- Icon khác -->
        </p>
        <i id="toggle-icon" class="fas fa-bars ms-auto toggle-icon border p-2" style="font-size: 17px;"></i> <!-- Icon 3 gạch ngang -->
    </div>
    <hr id="sidebar-hr" style="width: 80%; margin-top: 10px; border: 1px solid #000;">
</div>

    <div class="nav flex-column" id="sidebar-content">
<div class="container bg-light">
    <h6 class="m-1 mb-3"><i class="fas fa-coins"></i>Giá</h6>
    <form>
        <!-- Mục Giá -->
        <div class="mb-4">
            <div class="row g-2">
                <!-- Input giá thấp -->
                <div class="col-6">
                    <input type="number" id="price-min" class="form-control" placeholder="Giá tối thiểu" value="10000" min="0" max="1000000">
                </div>
                <!-- Input giá cao -->
                <div class="col-6">
                    <input type="number" id="price-max" class="form-control" placeholder="Giá tối đa" value="150000" min="0" max="1000000">
                </div>
            </div>
        </div>

        <div id="price-slider"></div>
    </form>
</div>


    </div>
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.js"></script>


<style>
    #price-slider {
        width: 100%;
        height: 8px; /* Chiều cao của thanh trượt */
        margin: 20px 0;
    }

    .noUi-connect {
        background: #007bff; /* Màu xanh cho phần kết nối */
    }

    .noUi-handle {
        width: 4px; /* Đường kính chấm tròn nhỏ lại */
        height: 4px; /* Chiều cao chấm tròn nhỏ lại */
        border-radius: 50%;
        background: #007bff; /* Màu xanh cho chấm tròn */
        border: none;
        cursor: pointer;
    }

    .noUi-tooltip {
        background: #007bff;
        color: #fff;
        border-radius: 5px;
        padding: 5px;
    }
</style>
