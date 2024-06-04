<?php

// This file is the place to store all basic functons

function redirect_to($location = NULL)
{
    if ($location != NULL) {
        header("Location: $location");
        exit;
    }
}

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

function find_selected_page()
{
    global $selected_subject;
    global $selected_page;
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
}

function navigation($selected_subject, $selected_page)
{
    $output = "<ul class=\"subjects\">";
    $subject_set = get_all_subjects();
    if ($subject_set->num_rows > 0) {
        while ($subject = $subject_set->fetch_assoc()) {
            $output .= "<li";
            if ($selected_subject && $subject["id"] == $selected_subject["id"]) {
                $output .= " class=\"selected\"";
            }
            $output .= "><a href=\"edit_subject.php?subj=" . urlencode($subject["id"]) .
                "\">{$subject["menu_name"]}</a></li>";

            $page_set = get_pages_for_subjects($subject["id"]);
            if ($page_set->num_rows > 0) {
                $output .= "<ul class='pages'>";
                while ($page = $page_set->fetch_assoc()) {
                    $output .= "<li";
                    if ($selected_page && $page["id"] == $selected_page["id"]) {
                        $output .= " class=\"selected\"";
                    }
                    $output .= "><a href=\"content.php?page=" . urlencode($page["id"]) . "\">{$page["menu_name"]}</a></li>";
                }
                $output .= "</ul>";
            }
        }
    }
    $output .= "</ul>";
    return $output;
}
