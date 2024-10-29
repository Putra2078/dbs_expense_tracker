<?php 
include('db.php');
include_once('templates/header.php');
?>


<!-- page content -->
<div class="right_col" role="main">
				<div class="x_panel">
					<div class="page-title">
						<div class="title_left">
							<h3>Add Income</h3>
						</div>
						<div class="title_right">
							<div class="col-md-5 col-sm-5  form-group pull-right top_search">
								<div class="input-group">
                                    <!-- Pakai untuk table atau page yang menmpilkan data -->
									<!-- <input type="text" class="form-control" placeholder="Search for...">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button">Go!</button>
									</span> -->
								</div>
							</div>
						</div>
					</div>
                    <hr>
<div class="x_content">
        <form action="add_income.php" method="post">
            <div class="mb-3">
                <label for="date" class="form-label">Date:</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Source:</label>
                <select type="text" id="category" name="category" class="form-control" required>
                    <option value="aktiva">Kas</option>
                    <option value="kewajiban">Kewajiban</option>
                    <option value="ekuitas">Ekuitas</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount:</label>
                <input type="number" id="amount" name="amount" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control" id="notes" name="notes"></textarea>
            </div>
            <div class="mb-3">
                <label for="descriptions" class="form-label">Description:</label>
                <select id="descriptions" name="descriptions" class="form-control">
                    <option value="kas">Kas</option>
                    <option value="dividen saham">Dividen Saham</option>
                    <option value="gaji">Gaji</option>
                    <option value="pendapatan tambahan">Pendapatan Tambahan</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Income</button>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $date = $_POST['date'];
            $category = $_POST['category'];
            $notes = $_POST['category'];
            $amount = $_POST['amount'];
            $descriptions = $_POST['descriptions'];

            $sql = "INSERT INTO incomes (user_id, date, category, amount, descriptions, notes) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$_SESSION['user_id'], $date, $category, $notes, $amount, $descriptions])) {
                echo "<div class='alert alert-success mt-3'>Income added successfully!</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>Failed to add income!</div>";
            }
        }
        ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>
    </div>
<?php
include_once('templates/footer.php');
?>