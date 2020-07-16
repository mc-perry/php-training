<?php
    require_once '../lib/MyDBControllerMySQL.class.php';
    require_once '../lib/validation.class.php';

    // Start the session
    session_start();

    function clear_session_fields()
    {
        $_SESSION["public_group_code"] = null;
        $_SESSION["zip_code_old"] = null;
        $_SESSION["zip_code"] = null;
        $_SESSION["prefecture_kana"] = null;
        $_SESSION["city_kana"] = null;
        $_SESSION["town_kana"] = null;
        $_SESSION["prefecture"] = null;
        $_SESSION["city"] = null;
        $_SESSION["town"] = null;
        $_SESSION["town_double_zip_code"] = null;
        $_SESSION["town_multi_address"] = null;
        $_SESSION["town_attach_district"] = null;
        $_SESSION["zip_code_multi_town"] = null;
        $_SESSION["update_check"] = null;
        $_SESSION["update_reason"] = null;    
    }

    $submission_data = array();
    array_push($submission_data, $_POST["public_group_code"]);
    array_push($submission_data, $_POST["zip_code_old"]);
    array_push($submission_data, $_POST["zip_code"]);
    array_push($submission_data, $_POST["prefecture_kana"]);
    array_push($submission_data, $_POST["city_kana"]);
    array_push($submission_data, $_POST["town_kana"]);
    array_push($submission_data, $_POST["prefecture"]);
    array_push($submission_data, $_POST["city"]);
    array_push($submission_data, $_POST["town"]);
    array_push($submission_data, $_POST["town_double_zip_code"]);
    array_push($submission_data, $_POST["town_multi_address"]);
    array_push($submission_data, $_POST["town_attach_district"]);
    array_push($submission_data, $_POST["zip_code_multi_town"]);
    array_push($submission_data, $_POST["update_check"]);
    array_push($submission_data, $_POST["update_reason"]);
    $oldPublicGroupCode = $_POST['old_public_group_code'];
    $oldZipCodeOld = $_POST['old_zip_code_old'];
    $oldZipArray = array($oldPublicGroupCode, $oldZipCodeOld);

    // Check for the submission data to set blue success text
    if ($_SESSION["updating"] == true) {
        $my_db = new MyDBControllerMySQL();
        $my_db->console_log($oldPublicGroupCode);
        // Connect again after insert if it occurred
        $my_db->connect();

        $table_name = "kadai_jonathan_ziplist";
        $comment_table_fields = $_SESSION["comment_table_fields"];

        $validation = new Validation();
        $return_object = $validation->checkForErrors($submission_data, $comment_table_fields);
        $my_db->console_log("The return object is : " . $return_object);
        if (count($return_object[0]) > 0 || count($return_object[1]) > 0) {
            header("Location: input.php");
            exit();
        }

        // Submit the data
        $data_updated = $my_db->update($table_name, $submission_data, $oldZipArray);
        $my_db->console_log($data_updated);
        if ($data_updated == true) {
            $_SESSION["update_success"] = true;
        } else {
            $_SESSION["update_success"] = false;
        }
        $_SESSION["submission_data"] = null;
        $_SESSION["updating"] = false;
        clear_session_fields();
        // Set submitted value to use in index page
        $_SESSION["updated"] = true;
        // Set input bool to not display errors at first
        $_SESSION["input_hajimete"] = true;
        // Redirect to the list page
        header("Location: index.php");
        exit();
    }
?>