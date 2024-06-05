<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php find_selected_page(); ?>
<?php include("includes/header.php"); ?>

<table id="structure">
    <tr>
        <td id="navigation">
            <?php echo public_navigation($selected_subject, $selected_page); ?>
        </td>
        <td id="page">
            <?php if ($selected_page) { ?>
                <h2><?php echo htmlentities($selected_page['menu_name']); ?></h2>
                <div class="page-content">
                    <?php echo strip_tags(nl2br($selected_page['content']), "<b><br>,<p>, <a>"); ?>
                </div>
            <?php } else { ?>
                <h2>Welcome to Widget Corp</h2>
            <?php } ?>
        </td>
    </tr>
</table>
<?php require("includes/footer.php"); ?>