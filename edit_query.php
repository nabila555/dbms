<?php
session_start();

$dbc = mysqli_connect("localhost", "root", "", "admin") or die("Unable to connect to database");

if (!isset($_SESSION['Aname'])) {
    echo "Unauthorized Access";
    return;
}

$id = $_GET['id'];
$query = "SELECT * FROM `query` WHERE id = $id";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $des = $_POST['des'];
    $user_id = $_POST['user_id'];

    $updateQuery = "UPDATE `query` SET title = '$title', des = '$des', user_id = $user_id WHERE id = $id";
    $updateResult = mysqli_query($dbc, $updateQuery);

    if ($updateResult) {
        header('Location: query_list.php');
    } else {
        $error = "Failed to update the query.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('./templates/header.php'); ?>
</head>
<body>
    <div class="sidebar">
        <?php include_once('./templates/sidebar.php'); ?>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Dashboard</span>
            </div>
        </nav>
        <div class="container">
            <h2 style="padding-top: 50px; margin-left: 20px">Edit Query</h2>
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php } ?>
            <form method="post" style="margin-left: 20px">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title" value="<?php echo $row['title']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="des" required><?php echo $row['des']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>User ID</label>
                    <input type="number" class="form-control" name="user_id" value="<?php echo $row['user_id']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Query</button>
            </form>
        </div>
    </section>
    <?php
                        include_once('./templates/footer.php');
                        ?>
</body>
</html>