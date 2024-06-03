<?php

// This file is the place to store all basic functons

function confirm_query($result_set)
{
    global $conn;
    if (!$result_set) {
        die("Database query failed: " . mysqli_error($conn));
    }
}

function get_all_subjects()
{
    global $conn;
    $query = "SELECT * 
            FROM subjects 
            ORDER BY position ASC";
    $subject_set = $conn->query($query);
    confirm_query($subject_set);

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

    confirm_query($page_set);
    return $page_set;
}

function get_subject_by_id($subject_id)
{
    global $conn;
    $query = "SELECT * ";
    $query .= "FROM subjects ";
    $query .= "WHERE id=" . $subject_id . " ";
    $query .= "LIMIT 1";
    $result_set = $conn->query($query);
    confirm_query($result_set);
    // REMEMBER:
    // if no rows are returned, fetch_array will return false
    if ($subject = $result_set->fetch_assoc()) {
        return $subject;
    } else {
        return NULL;
    }
}

function get_page_by_id($page_id)
{
    global $conn;
    $query = "SELECT * ";
    $query .= "FROM pages ";
    $query .= "WHERE id=" . $page_id . " ";
    $query .= "LIMIT 1";
    $result_set = $conn->query($query);
    confirm_query($result_set);
    // REMEMBER:
    // if no rows are returned, fetch_array will return false
    if ($page = $result_set->fetch_assoc()) {
        return $page;
    } else {
        return NULL;
    }
}
