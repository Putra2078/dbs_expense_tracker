<?php 
include('db.php');
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");

    // cek apakah ada username
    if(mysqli_num_rows($result) > 0) {

        // cke apakah passwordnya benar
        $row = mysqli_fetch_assoc($result);

        if(password_verify($password, $row['password'])) {
            // set session
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;

            // login berhasil
            header("location: view_summary.php");
            exit;
        } 
    } 

    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <section>
        <form action="login.php" method="post" >
                <h1>Login</h1>
                <div class="inputbox">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="username" required id="username" name="username">
                    <label for="username">Username</label>
                </div>
                <div class="inputbox">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" id="password" name="password" required>
                    <label for="password">Password</label>
                </div>
                <div class="forget">
                    <label for=""><input type="checkbox">Remember Me</label>
                  <a href="#">Forget Password</a>
                </div>
                <button>Login</button>
                <div class="register">
                    <p>Don't have a account <a href="register.php">Register</a></p>
                </div>
            </form>
        </section>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: view_summary.php');
                exit;
            } else {
                echo "<div class='alert alert-danger mt-3'>Invalid username or password!</div>";
            }
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>
</html>