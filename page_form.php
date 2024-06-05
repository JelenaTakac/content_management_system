<?php require_once("includes/session.php"); ?>
<?php confirm_logged_in(); ?>

<?php // this page is included by new_page.php and edit_page.php 
?>
<?php if (!isset($new_page)) { // Corrected usage
    $new_page = false;
} ?>

<?php
// Check if $selected_page is not set or is null, and initialize it with default values for a new page
if (!isset($selected_page) || $selected_page === NULL) {
    $selected_page = [
        'menu_name' => '', // Default value for an empty string
        'position' => '', // Default value for an empty string
        'visible' => '', // Default value for an empty string
        'content' => ''  // Default value for an empty string
    ];
}
?>

<p>Page name: <input type="text" name="menu_name" value="<?php echo $selected_page['menu_name']; ?>" id="menu_name" /></p>

<p>Position:
    <select name="position">
        <?php

        if (!$new_page) {
            $page_set = get_pages_for_subject($selected_page['subject_id']);
            $page_count = mysqli_num_rows($page_set);
        } else {
            $page_set = get_pages_for_subject($selected_subject['id']);
            $page_count = mysqli_num_rows($page_set) + 1;
        }
        for ($count = 1; $count <= $page_count; $count++) {
            echo "<option value=\"{$count}\"";
            if ($selected_page['position'] == $count) {
                echo " selected";
            }
            echo ">{$count}</option>";
        }
        ?>
    </select>
</p>
<p>Visible:
    <input type="radio" name="visible" value="0" <?php if ($selected_page['visible'] == 0) {
                                                        echo " checked";
                                                    }
                                                    ?> /> No
    &nbsp;
    <input type="radio" name="visible" value="1" <?php if ($selected_page['visible'] == 1) {
                                                        echo " checked";
                                                    }
                                                    ?> /> Yes
</p>
<p>Content:<br />
    <textarea name="content" rows="20" cols="80"><?php echo $selected_page['content']; ?></textarea>
</p>