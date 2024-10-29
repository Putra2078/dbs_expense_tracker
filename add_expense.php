<?php 
include('db.php'); 
include_once('templates/header.php');
?>

<!-- page content -->
<div class="right_col" role="main">
				<div class="x_panel">
					<div class="page-title">
						<div class="title_left">
							<h3>Add Expense</h3>
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
        <form action="add_expense.php" method="post">
            <div class="mb-3">
                <label for="date" class="form-label">Date:</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category:</label>
                <select id="category" name="category" class="form-control" required>
                    <option value="aktiva">Aktiva</option>
                    <option value="kewajiban">Kewajiban</option>
                    <option value="ekuitas">Ekuitas</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount:</label>
                <input type="number" id="amount" name="amount" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <select id="description" name="description" class="form-control">
                    <option value="beban rumah tangga">Beban Rumah Tangga</option>
                    <option value="beban hobi">Beban Hobi</option>
                    <option value="beban sosial">Beban Sosial</option>
                    <option value="beban tak terduga">Beban tak terduga</option>
                    <option value="beban pajak">Beban Pajak</option>
                    <option value="beban liburan">Beban Liburan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea id="notes" name="notes" class="form-control"
                required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Expense</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $date = $_POST['date'];
            $category = $_POST['category'];
            $amount = $_POST['amount'];
            $description = $_POST['description'];
            $notes = $_POST['notes'];

            $sql = "INSERT INTO expenses (user_id, date, category, amount, description, notes) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$_SESSION['user_id'], $date, $category, $amount, $description, $notes])) {
                echo "<div class='alert alert-success mt-3'>Expense added successfully!</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>Failed to add expense!</div>";
            }
        }
        ?>
    </div>
    <script src="https://code.jquery.com /jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>

<?php
include_once('templates/footer.php');
?>