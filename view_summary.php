<?php 
include('db.php');
include_once('templates/header.php');
?>


   <!-- page content -->
   <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h1>View Summary</h1>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Arus Keuangan</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive">
                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Month</th>
                          <th>Total Expenses</th>
                          <th>Total Incomes</th>
                          <th>Balance</th>
                        </tr>
                      </thead>

            <tbody>
                <?php
                $sql = "SELECT 
                            DATE_FORMAT(date, '%Y-%m') AS month,
                            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS total_expenses,
                            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) AS total_incomes
                        FROM (
                            SELECT date, 'expense' AS type, amount FROM expenses WHERE user_id = ?
                            UNION ALL
                            SELECT date, 'income' AS type, amount FROM incomes WHERE user_id = ?
                        ) AS transactions
                        GROUP BY month
                        ORDER BY month";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$_SESSION['user_id'], $_SESSION['user_id']]);
                $transactions = $stmt->fetchAll();

                foreach ($transactions as $transaction) {
                    echo "<tr>";
                    echo "<td>" . $transaction['month'] . "</td>";
                    echo "<td>" . number_format($transaction['total_expenses'], 2) . "</td>";
                    echo "<td>" . number_format($transaction['total_incomes'], 2) . "</td>";
                    echo "<td>" . number_format($transaction['total_incomes'] - $transaction['total_expenses'], 2) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <hr>
        
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>

<?php
include_once('templates/footer.php');
?>