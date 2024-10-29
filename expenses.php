<?php
include_once('db.php');
include_once('templates/header.php');
?>

     <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h1>Expenses</h1>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Your Expenses</h2>
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
                $sql = "SELECT * FROM expenses WHERE user_id = ?";
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
                $expenses = $stmt->fetchAll();

                foreach ($expenses as $expense) {
                    $tanggal = date('d M Y', strtotime($expense['date']));

                    echo "<tr>";
                    echo "<td>" . $tanggal . "</td>";
                    echo "<td>" . $expense['category'] . "</td>";
                    echo "<td>" . $expense['notes'] . "</td>";
                    echo "<td>" . $expense['description'] . "</td>";
                    echo "<td>" . number_format($expense['amount'], 2) . "</td>";
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
        </div>
          <input type="date" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" id="date" name="date" required class="form-control">
        </div>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
        </div>
          <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="source" id="source" required>
        </div>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
        </div>
          <textarea type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="description" id="description">
            </textarea>
        </div>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
        </div>
          <input type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="amount" id="amount">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
        
  </body>

  <?php
  include_once('templates/footer.php');
  ?>
</html>