<?php // this page is included by new_page.php and edit_page.php 
?>
<?php if (!isset($new_page)) {
    $new_page = false;
} ?>

<p>Page name: <input type="text" name="menu_name" value="" id="menu_name" /></p>

<p>Position:
    <select name="position">
        <?php

        if (!$new_page) {
            $page_set = get_pages_for_subjects($selected_page['subject_id']);
            $page_count = mysqli_num_rows($page_set);
        } else {
            $page_set = get_pages_for_subjects($selected_subject['id']);
            $page_count = mysqli_num_rows($page_set) + 1;
        }
        for ($count = 1; $count <= $page_count; $count++) {
            echo "<option value=\"{$count}\"";
            echo ">{$count}</option>";
        }
        ?>
    </select>
</p>
<p>Visible:
    <input type="radio" name="visible" value="0" /> No
    &nbsp;
    <input type="radio" name="visible" value="1" /> Yes
</p>
<p>Content:<br />
    <textarea name="content" rows="20" cols="80"></textarea>
</p>