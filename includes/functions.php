<?php

// This file is the place to store all basic functons

function confirm_query($result_set, $connection)
{
    if (!$result_set) {
        die("Database query failed: " . mysqli_error($connection));
    }
}

function get_all_subjects()
{
    global $conn;
    $query = "SELECT * 
            FROM subjects 
            ORDER BY position ASC";
    $subject_set = $conn->query($query);
    confirm_query($subject_set, $conn);

    return $subject_set;
}

function get_pages_for_subjects($subject_id)
{
    global $conn;
    $query = "SELECT * 
            FROM pages 
            WHERE subject_id = {$subject_id} 
            ORDER BY position ASC";
    $page_set = $conn->query($query);

    confirm_query($page_set, $conn);
    return $page_set;
}
