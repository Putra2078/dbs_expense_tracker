<?php
// Include necessary files
include_once('db.php');
include_once('templates/header.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fungsi untuk format mata uang
function formatRupiah($amount) {
    return number_format($amount, 2, ',', '.');
}

// Fungsi untuk format tanggal
function formatTanggal($date) {
    return date('d M Y', strtotime($date));
}

// Persiapkan parameter query
$sql = "SELECT * FROM expenses WHERE user_id = ?";
$params = [$_SESSION['user_id']];

// Filter tanggal jika ada
if (isset($_GET['start_date']) && isset($_GET['end_date']) && 
    !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
    $sql .= " AND date BETWEEN ? AND ?";
    $params[] = $_GET['start_date'];
    $params[] = $_GET['end_date'];
}

$sql .= " ORDER BY date DESC";
?>

<!-- Page Content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h1>Expenses</h1>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Your Expenses</h2>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="x_content">
                        <!-- Form Pencarian Berdasarkan Tanggal -->
                        <form method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Tanggal Awal:</label>
                                    <input type="date" name="start_date" class="form-control" 
                                           value="<?php echo htmlspecialchars($_GET['start_date'] ?? ''); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label>Tanggal Akhir:</label>
                                    <input type="date" name="end_date" class="form-control" 
                                           value="<?php echo htmlspecialchars($_GET['end_date'] ?? ''); ?>">
                                </div>
                                <div class="col-md-2">
                                    <label>&nbsp;</label><br>
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Category</th>
                                                <th>Notes</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            try {
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->execute($params);
                                                $expenses = $stmt->fetchAll();

                                                $no = 1;
                                                foreach ($expenses as $expense) {
                                                    echo "<tr>";
                                                    echo "<td>" . $no++ . "</td>";
                                                    echo "<td>" . htmlspecialchars(formatTanggal($expense['date'])) . "</td>";
                                                    echo "<td>" . htmlspecialchars($expense['category']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($expense['notes']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($expense['description']) . "</td>";
                                                    echo "<td>" . formatRupiah($expense['amount']) . "</td>";
                                                    echo "</tr>";
                                                }
                                            } catch (PDOException $e) {
                                                // Tangani error
                                                echo "<tr><td colspan='6'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer
include_once('templates/footer.php');
?>

