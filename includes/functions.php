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

function get_all_subjects($public = true)
{
    global $conn;
    $query = "SELECT * 
            FROM subjects ";
    if ($public) {
        $query .= "WHERE visible = 1 ";
    }
    $query .= "ORDER BY position ASC";
           
    $subject_set = $conn->query($query);
    confirm_query($subject_set);

    return $subject_set;
}

function get_pages_for_subject($subject_id, $public = true)
{
    global $conn;
    $query = "SELECT * 
            FROM pages ";
    $query .= "WHERE subject_id = {$subject_id} "; 
    if ($public) {
        $query .= "AND visible = 1 ";
    }
    $query .= "ORDER BY position ASC";

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

function get_default_page($subject_id) {
    // Get all visible pages
    $page_set = get_pages_for_subject($subject_id, true);
    if ($first_page = mysqli_fetch_array($page_set)) {
        return $first_page;
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
        $selected_page = get_default_page($selected_subject['id']);
    } elseif (isset($_GET['page'])) {
        $selected_subject = NULL;
        $selected_page = get_page_by_id($_GET['page']);
    } else {
        $selected_subject = NULL;
        $selected_page = NULL;
    }
}

function navigation($selected_subject, $selected_page, $public = false)
{
    $output = "<ul class=\"subjects\">";
    $subject_set = get_all_subjects($public = false);
    if ($subject_set->num_rows > 0) {
        while ($subject = $subject_set->fetch_assoc()) {
            $output .= "<li";
            if ($selected_subject && $subject["id"] == $selected_subject["id"]) {
                $output .= " class=\"selected\"";
            }
            $output .= "><a href=\"edit_subject.php?subj=" . urlencode($subject["id"]) .
                "\">{$subject["menu_name"]}</a></li>";

            $page_set = get_pages_for_subject($subject["id"], $public = false);
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

function public_navigation($selected_subject, $selected_page, $public = true)
{
    $output = "<ul class=\"subjects\">";
    $subject_set = get_all_subjects($public);
    if ($subject_set->num_rows > 0) {
        while ($subject = $subject_set->fetch_assoc()) {
            $output .= "<li";
            if ($selected_subject && $subject["id"] == $selected_subject["id"]) {
                $output .= " class=\"selected\"";
            }
            $output .= "><a href=\"index.php?subj=" . urlencode($subject["id"]) .
                "\">{$subject["menu_name"]}</a></li>";

            if ($selected_subject && $subject["id"] == $selected_subject["id"]) {
                $page_set = get_pages_for_subject($subject["id"], $public = true);
                if ($page_set->num_rows > 0) {
                    $output .= "<ul class='pages'>";
                    while ($page = $page_set->fetch_assoc()) {
                        $output .= "<li";
                        if ($selected_page && $page["id"] == $selected_page["id"]) {
                            $output .= " class=\"selected\"";
                        }
                        $output .= "><a href=\"index.php?page=" . urlencode($page["id"]) . "\">{$page["menu_name"]}</a></li>";
                    }
                    $output .= "</ul>";
                }
            }
        }
    }
    $output .= "</ul>";
    return $output;
}
