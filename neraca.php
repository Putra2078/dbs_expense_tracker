<?php
include('db.php');
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
                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive">
                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Aktiva</th>
                          <th>Kewajiban</th>
                          <th>Ekuitas</th>
                        </tr>
                      </thead>

                      <tbody>
                      <?php
                      $aktiva_incomes = "SELECT SUM(amount) FROM incomes where descriptions = 'kas'";
                      echo  "<tr>";
                      echo "<td> Kas </td>";
                      ?>
                      </tbody>
<?php
include_once('templates/footer.php');
?>