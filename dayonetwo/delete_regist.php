<?php
    require_once '../lib/MyDBControllerMySQL.class.php';
    $my_db = new MyDBControllerMySQL();

    $delete_data = array();
    $two_dim_array = array();

    if (isset($_POST["checkboxval"])) {
        foreach($_POST["checkboxval"] as $val) {
            array_push($delete_data, $val);
            $postal_data_array = explode("/", $val);
            array_push($two_dim_array, $postal_data_array);
        }
    }

    $my_db->connect();
    $table_name = "kadai_jonathan_ziplist";
    $backup_table_name = "kadai_jonathan_ziplist_backup";
    $complete_success = false;

    foreach ($delete_data as $data) {
        $exploded = explode("/", $data);
        $dataRow = $my_db->selectByZip($exploded[0], $exploded[1], $exploded[2], $table_name);

        mysqli_begin_transaction($my_db->db, MYSQLI_TRANS_START_READ_WRITE);
        if ($my_db->delete($exploded[0], $exploded[1], $exploded[2], $table_name)) {
            if ($insertResult = $my_db->insert($backup_table_name, $my_db->mapFieldsToArray($dataRow))) {
                mysqli_commit($my_db->db);
            } else {
                $my_db->console_log($insertResult);
                mysqli_rollback($my_db->db);
            }
        }
    }

    header("Location: index.php");
    exit();

?>