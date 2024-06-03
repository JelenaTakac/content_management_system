<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
if (isset($_GET['subj'])) {
    $selected_subject = get_subject_by_id($_GET['subj']);
    $selected_page = NULL;
} elseif (isset($_GET['page'])) {
    $selected_subject = NULL;
    $selected_page = get_page_by_id($_GET['page']);
} else {
    $selected_subject = NULL;
    $selected_page = NULL;
}
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
                        if ($selected_subject && $subject["id"] == $selected_subject["id"]) {
                            echo " class=\"selected\"";
                        }
                        echo "><a href=\"content.php?subj=" . urlencode($subject["id"]) .
                            "\">{$subject["menu_name"]}</a></li>";

                        $page_set = get_pages_for_subjects($subject["id"]);
                        if ($page_set->num_rows > 0) {
                            echo "<ul class='pages'>";
                            while ($page = $page_set->fetch_assoc()) {
                                echo "<li";
                                if ($selected_page && $page["id"] == $selected_page["id"]) {
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
            <?php if (!is_null($selected_subject)) { //subject selected 
            ?>
                <h2><?php echo $selected_subject["menu_name"]; ?></h2>
            <?php } elseif (!is_null($selected_page)) { //page selected 
            ?>
                <h2><?php echo $selected_page["menu_name"]; ?></h2>
                <div class="page-content">
                    <?php echo $selected_page["content"]; ?>
                </div>
            <?php } else { // nothing selected 
            ?>
                <h2>Select a subject or page to edit</h2>
            <?php } ?>
        </td>
    </tr>
</table>
<?php require("includes/footer.php"); ?>