<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
if (isset($_GET['subj'])) {
    $selected_subj = $_GET['subj'];
    $selected_page = "";
} elseif (isset($_GET['page'])) {
    $selected_subj = "";
    $selected_page = $_GET['page'];
} else {
    $selected_subj = "";
    $selected_page = "";
}
$selected_subject = get_subject_by_id($selected_subj);
?>
<?php include("includes/header.php"); ?>
<table id="structure">
    <tr>
        <td id="navigation">
            <ul class="subjects">
                <?php
                $subject_set = get_all_subjects();
                if ($subject_set->num_rows > 0) {
                    while ($subject = $subject_set->fetch_assoc()) {
                        echo "<li";
                        if ($subject["id"] == $selected_subj) {
                            echo " class=\"selected\"";
                        }
                        echo "><a href=\"content.php?subj=" . urlencode($subject["id"]) .
                            "\">{$subject["menu_name"]}</a></li>";

                        $page_set = get_pages_for_subjects($subject["id"]);
                        if ($page_set->num_rows > 0) {
                            echo "<ul class='pages'>";
                            while ($page = $page_set->fetch_assoc()) {
                                echo "<li";
                                if ($page["id"] == $selected_page) {
                                    echo " class=\"selected\"";
                                }
                                echo "><a href=\"content.php?page=" . urlencode($page["id"]) . "\">{$page["menu_name"]}</a></li>";
                            }
                            echo "</ul>";
                        }
                    }
                }
                ?>
            </ul>
        </td>
        <td id="page">
            <h2><?php echo $selected_subject["menu_name"]; ?></h2>
            <br>
            <?php echo $selected_page; ?><br>
        </td>
    </tr>
</table>
<?php require("includes/footer.php"); ?>