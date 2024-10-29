<?php
include('db.php');
include_once('templates/header.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set default date range (1 bulan terakhir)
$end_date = date('Y-m-d');
$start_date = date('Y-m-d', strtotime('-1 month'));

// Jika ada filter tanggal
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
}

// Query untuk mengambil data berdasarkan rentang tanggal
$sql = "SELECT 
            date,
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS total_expenses,
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) AS total_incomes
        FROM (
            SELECT date, 'expense' AS type, amount FROM expenses WHERE user_id = ? AND date BETWEEN ? AND ?
            UNION ALL
            SELECT date, 'income' AS type, amount FROM incomes WHERE user_id = ? AND date BETWEEN ? AND ?
        ) AS transactions
        GROUP BY date
        ORDER BY date";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id'], $start_date, $end_date, $_SESSION['user_id'], $start_date, $end_date]);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Siapkan data untuk grafik
$dates = [];
$expenses = [];
$incomes = [];

foreach ($transactions as $transaction) {
    $dates[] = $transaction['date'];
    $expenses[] = $transaction['total_expenses'];
    $incomes[] = $transaction['total_incomes'];
}
?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h1>Financial Chart</h1>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Financial Analysis</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!-- Date Range Filter -->
                        <form method="GET" class="form-inline mb-4">
                            <div class="form-group mx-2">
                                <label for="start_date" class="mr-2">Start Date:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                       value="<?php echo $start_date; ?>">
                            </div>
                            <div class="form-group mx-2">
                                <label for="end_date" class="mr-2">End Date:</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                       value="<?php echo $end_date; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Apply Filter</button>
                        </form>

                        <!-- Chart Container -->
                        <div class="chart-container" style="position: relative; height:60vh; width:80vw">
                            <canvas id="financialChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('financialChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dates); ?>,
            datasets: [{
                label: 'Expenses',
                data: <?php echo json_encode($expenses); ?>,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.1
            },
            {
                label: 'Incomes',
                data: <?php echo json_encode($incomes); ?>,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Financial Overview'
                },
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
});
</script>

<?php include_once('templates/footer.php'); ?>