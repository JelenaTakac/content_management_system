<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>
<table id="structure">
    <tr>
        <td id="navigation">
            <?php
            // 3. Performe database query
            $sql = "SELECT * FROM subjects";
            $result = $conn->query($sql);

            // 4. Use returned data
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<br>" . $row["menu_name"] . " " . $row["position"];
                }
            } else {
                echo "0 results";
            }
            ?>
        </td>
        <td id="page">
            <h2>Content Area</h2>
        </td>
    </tr>
</table>
<?php require("includes/footer.php"); ?>