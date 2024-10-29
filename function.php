<?php
require_once 'db.php';


function query($query) {
    global $connection;
    $result = mysqli_query($connection, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// function ubah user
function ubah_user($data) {
    global $connection;

    $kode = htmlspecialchars($data["id"]);
    $username = htmlspecialchars($data["username"]);

    $query = "UPDATE users SET
    username    = '$username',
    WHERE id = '$kode'";

    mysqli_query($connection, $query);

    return mysqli_affected_rows($connection);
}

// function upload gambar
function uploadImage($file, $uploadDir = 'uploads/') {
    $targetFile = $uploadDir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return "File is not an image.";
    }

    // Check file size (5MB maximum)
    if ($file["size"] > 5000000) {
        return "Sorry, your file is too large.";
    }

    // Allow certain file formats
    $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedFormats)) {
        return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        return "Sorry, file already exists.";
    }

    // Attempt to upload file
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return "The file " . htmlspecialchars(basename($file["name"])) . " has been uploaded.";
    } else {
        return "Sorry, there was an error uploading your file.";
    }
}

// function ubah username
function editUsername($userId, $newUsername, $connection) {
    $stmt = $connection->prepare("UPDATE users SET username = ? WHERE id = ?");
    $stmt->bind_param("si", $newUsername, $userId);

    if ($stmt->execute()) {
        return "Username updated successfully.";
    } else {
        return "Error updating username: " . $stmt->error;
    }
}

// function ubah password
function changePassword($userId, $newPassword, $connection) {
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    $stmt = $connection->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashedPassword, $userId);

    if ($stmt->execute()) {
        return "Password changed successfully.";
    } else {
        return "Error changing password: " . $stmt->error;
    }
}


?>