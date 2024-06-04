<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php
    if (intval($_GET['subj']) == 0) {
        redirect_to("content.php");
    }

    $id = $_GET['subj'];

    if ($subject = get_subject_by_id($id)) {
        $query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
        $result = $conn->query($query);
        if (mysqli_affected_rows($conn) == 1) {
            // Success Deletion
            redirect_to("content.php");
        } else {
            // Deletion Failed
            echo "<p>Subject deletion failed.</p>";
            echo "<p>" . mysqli_error($conn) . "</p>";
            echo "<a href=\"content.php\">Return to Main Page</a>";
        }
    } else {
        // subject didn't exist in database
        redirect_to("content.php");
    }

?>

<?php if (isset($conn)) {
    $conn->close();
}
?> 