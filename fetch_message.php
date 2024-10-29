<?php
include('db.php');

$sql = "SELECT * FROM messages WHERE to_user_id = ? ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$messages = $stmt->fetchAll();

foreach ($messages as $message) {
    $from_user = $pdo->query("SELECT username FROM users WHERE id = " . $message['from_user_id'])->fetchColumn();
    echo "<div class='message-widget'>";
    echo "<h3>From: " . htmlspecialchars($from_user) . "</h3>";
    echo "<p>" . htmlspecialchars($message['message']) . "</p>";
    if ($message['read'] == 0) {
        echo "<div class='new-message-indicator'>New</div>";
    }
    echo "</div>";
}

