<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php
$menu_name = $_POST['menu_name'];
$position = $_POST['position'];
$visible = $_POST['visible'];
?>


<?php
// $query = "INSERT INTO subjects (menu_name, position, visible) VALUES (?, ?, ?);";

$stmt = $conn->prepare("INSERT INTO subjects (menu_name, position, visible) VALUES (?, ?, ?);");
$stmt->bind_param("ssi", $menu_name, $position, $visible);
// $query = "INSERT INTO subjects (menu_name, position, visible) VALUES ('{$menu_name}', {$position}, {$visible});";
// '$menu_name' is the string in database so, we need to put SINGLE QUOTES!

if ($stmt->execute()) {
    // Success!
    header("Location: content.php");
    exit;
} else {
    // Display error message
    echo "<p>Subject creation failed.</p>";
    echo "<p>" . mysqli_error($conn) . "</p>";
}
?>

<?php if (isset($conn)) {
    $conn->close();
}
?> 