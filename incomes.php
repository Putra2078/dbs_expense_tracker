<?php
include_once('db.php');
include_once('templates/header.php');
?>

     <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h1>Incomes</h1>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Your Incomes</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <!-- Form pencarian berdasarkan tanggal -->
                      <form method="GET" class="mb-4">
                          <div class="row">
                              <div class="col-md-3">
                                  <label>Tanggal Awal:</label>
                                  <input type="date" name="start_date" class="form-control" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                              </div>
                              <div class="col-md-3">
                                  <label>Tanggal Akhir:</label>
                                  <input type="date" name="end_date" class="form-control" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
                              </div>
                              <div class="col-md-2">
                                  <label>&nbsp;</label><br>
                                  <button type="submit" class="btn btn-primary">Cari</button>
                                  <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary">Reset</a>
                              </div>
                          </div>
                      </form>

                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive">
                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Tanggal</th>
                          <th>Category</th>
                          <th>Notes</th>
                          <th>Description</th>
                          <th>Amount</th>
                        </tr>
                      </thead>

                      <tbody>
                      <?php
                // Query dasar
                $sql = "SELECT * FROM incomes WHERE user_id = ?";
                $params = [$_SESSION['user_id']];

                // Jika ada filter tanggal
                if (isset($_GET['start_date']) && isset($_GET['end_date']) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
                    $sql .= " AND date BETWEEN ? AND ?";
                    $params[] = $_GET['start_date'];
                    $params[] = $_GET['end_date'];
                }

                $sql .= " ORDER BY date DESC";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
                $incomes = $stmt->fetchAll();

                foreach ($incomes as $income) {
                    $tanggal = date('d M Y', strtotime($income['date']));

                    echo "<tr>";
                    echo "<td>" . $tanggal . "</td>";
                    echo "<td>" . $income['category'] . "</td>";
                    echo "<td>" . $income['notes'] . "</td>";
                    echo "<td>" . $income['descriptions'] . "</td>";
                    echo "<td>" . number_format($income['amount'], 2) . "</td>";
                    echo "</tr>";
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
        <!-- /page content -->

<?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $date = $_POST['date'];
            $source = $_POST['source'];
            $amount = $_POST['amount'];
            $description = $_POST['description'];

            $sql = "INSERT INTO incomes (user_id, date, source, amount, description) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$_SESSION['user_id'], $date, $source, $amount, $description])) {
                echo "<div class='alert alert-success mt-3'>Income added successfully!</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>Failed to add income!</div>";
            }
        }
?>

  </body>

<?php
include_once('templates/footer.php');
?>