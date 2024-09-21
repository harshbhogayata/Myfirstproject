?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Show records
$stmt = $conn->prepare("SELECT * FROM records WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$records = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['insert'])) {
        $data = $_POST['data'];
        $stmt = $conn->prepare("INSERT INTO records (data, user_id) VALUES (?, ?)");
        $stmt->execute([$data, $_SESSION['user_id']]);
        header('Location: crud.php');
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $data = $_POST['data'];
        $stmt = $conn->prepare("UPDATE records SET data = ? WHERE id = ?");
        $stmt->execute([$data, $id]);
        header('Location: crud.php');
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM records WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: crud.php');
    }
}
?>

<h2>Manage Records</h2>
<ul>
<?php foreach ($records as $record): ?>
    <li><?php echo $record['data']; ?>
        <form method="POST" action="" style="display:inline;">
            <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
            <input type="text" name="data" value="<?php echo $record['data']; ?>">
            <button type="submit" name="update">Update</button>
            <button type="submit" name="delete">Delete</button>
        </form>
    </li>
<?php endforeach; ?>
</ul>

<h2>Add New Record</h2>
<form method="POST" action="">
    <input type="text" name="data" placeholder="New Data">
    <button type="submit" name="insert">Add</button>
</form>
