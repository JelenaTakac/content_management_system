<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php
$errors = array();

// Form Validation
// Way - 1
// if (!isset($_POST['menu_name']) || empty($_POST['menu_name'])) {
//     // $errors[] - this means in the end of an array
//     $errors[] = 'menu_name';
// }
// if (!isset($_POST['position']) || empty($_POST['position'])) {
//     // $errors[] - this means in the end of an array
//     $errors[] = 'position';
// }

// Way 2
$required_fields = array('menu_name', 'position', 'visible');
foreach ($required_fields as $fieldname) {
    if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
        $errors[] = $fieldname;
    }
}

if (!empty($errors)) {
    // go back to the form if there are some errors
    redirect_to("new_Subject.php");
}
?>

<?php
$menu_name = $_POST['menu_name'];
$position = $_POST['position'];
$visible = $_POST['visible'];
?>


<?php

$stmt = $conn->prepare("INSERT INTO subjects (menu_name, position, visible) VALUES (?, ?, ?);");
$stmt->bind_param("ssi", $menu_name, $position, $visible);

if ($stmt->execute()) {
    // Success!
    redirect_to("content.php");
} else {
    // Display error message
    echo "<p>Subject creation failed.</p>";
    echo "<p>" . mysqli_error($conn) . "</p>";
}

$stmt->close();

?>


<?php if (isset($conn)) {
    $conn->close();
}
?> 