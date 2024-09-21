?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<h1>Welcome, <?php echo $user['email']; ?></h1>
<a href="change_password.php">Change Password</a>
<a href="crud.php">Manage Records</a>
<a href="logout.php">Logout</a>
