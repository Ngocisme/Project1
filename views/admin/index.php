<?php
include_once "./includes/header.php";
include_once "../../models/Database.php";


// Tổng số đơn hàng
$stmt = $conn->prepare("SELECT COUNT(*) as total_orders FROM orders");
$stmt->execute();
$totalOrders = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];

// Tổng doanh thu
$stmt = $conn->prepare("SELECT SUM(totalBill) as total_revenue FROM orders");
$stmt->execute();
$totalRevenue = $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'];

// Số lượng sản phẩm bán ra
$stmt = $conn->prepare("SELECT SUM(qty) as total_products_sold FROM order_details");
$stmt->execute();
$totalProductsSold = $stmt->fetch(PDO::FETCH_ASSOC)['total_products_sold'];

// Doanh thu theo ngày
$stmt = $conn->prepare("
    SELECT DATE(created_at) as order_date, SUM(totalBill) as daily_revenue 
    FROM orders 
    GROUP BY DATE(created_at)
");
$stmt->execute();
$dailyRevenue = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Chuyển dữ liệu thành JSON để sử dụng với Chart.js
$dailyRevenueDates = [];
$dailyRevenueAmounts = [];


foreach ($dailyRevenue as $day) {
    $dailyRevenueDates[] = $day['order_date'];
    $dailyRevenueAmounts[] = $day['daily_revenue'];
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="../../models/ExportExcel_model.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng số đơn hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalOrders ?> Đơn hàng</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tổng doanh thu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= formatCurrencyVND($totalRevenue) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <?php foreach ($dailyRevenue as $day) { ?>
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Doanh thu ngày <?= $day['order_date'] ?>
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?=formatCurrencyVND($day['daily_revenue']) ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tổng sản phẩm được bán
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $totalProductsSold ?> Cái
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content Row -->
    </div>
    <!-- /.container-fluid -->
    <h3>Doanh thu</h3>
        <canvas id="dailyRevenueChart"></canvas>

</div>
<!-- End of Main Content -->

<?php
include_once "./includes/footer.php";
?>