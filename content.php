<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>
<table id="structure">
    <tr>
        <td id="navigation">
            <ul class="subjects">
                <?php
                $subject_set = get_all_subjects();
                if ($subject_set->num_rows > 0) {
                    while ($subject = $subject_set->fetch_assoc()) {
                        echo "<li>{$subject["menu_name"]}</li>";

                        $page_set = get_pages_for_subjects($subject["id"]);
                        if ($page_set->num_rows > 0) {
                            echo "<ul class='pages'>";
                            while ($page = $page_set->fetch_assoc()) {
                                echo "<li>{$page["menu_name"]}</li>";
                            }
                            echo "</ul>";
                        }
                    }
                }
                ?>
            </ul>
        </td>
        <td id="page">
            <h2>Content Area</h2>
        </td>
    </tr>
</table>
<?php require("includes/footer.php"); ?>