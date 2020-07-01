<?php
    require_once '../lib/MyDBControllerMySQL.class.php';

    // Start the session
    session_start();

    $table_name = "kadai_jonathan_ziplist";
    
    // Run the DB query if coming from index
    $run_select_query = false;

    // The data will be in either the GET request or the session
    if ($_GET['public_group_code']) {
        $publicGroupCode = $_GET['public_group_code'];
        // Setting these values here isn't the best but works for now
        $_SESSION["error_data"] == null;
        $run_select_query = true;
    }
    if ($_GET['zip_code_old']) {
        $zipCodeOld = $_GET['zip_code_old'];
    }
    if ($_GET['zip_code']) {
        $zipCode = $_GET['zip_code'];
    }

    // Set data from session if it exists to display previous values
    if ($_SESSION["submission_data"][0]) {
        $publicGroupCode = $_SESSION["submission_data"][0];
    }
    if ($_SESSION["submission_data"][1]) {
        $zipCodeOld = $_SESSION["submission_data"][1];
    }
    if ($_SESSION["submission_data"][2]) {
        $zipCode = $_SESSION["submission_data"][2];
    }
    

    $my_db = new MyDBControllerMySQL();
    // Connect again after insert if it occurred
    $my_db->connect();

    $table_name = "kadai_jonathan_ziplist";
    $comment_table_query = "SHOW FULL COLUMNS FROM $table_name";
    /* Query for the rows data */
    $row_data_query = "SELECT * FROM $table_name";
    $comment_table_fields = $my_db->query($comment_table_query, "Comment");

    // If coming from a GET request
    if ($run_select_query) {
        $postal_row_data = $my_db->selectByZip($publicGroupCode, $zipCodeOld, $zipCode, $table_name);
        $postal_row = $postal_row_data[0];
        $my_db->console_log($postal_row);
        // Close database connection
        $my_db->close();
    } else {
        // Set the data from the previous entered values
        $postal_row["prefecture_kana"] = $_SESSION["submission_data"][3];
        $postal_row["city_kana"] = $_SESSION["submission_data"][4];
        $postal_row["town_kana"] = $_SESSION["submission_data"][5];
        $postal_row["prefecture"] = $_SESSION["submission_data"][6];
        $postal_row["city"] = $_SESSION["submission_data"][7];
        $postal_row["town"] = $_SESSION["submission_data"][8];
        $postal_row["town_double_zip_code"] = $_SESSION["submission_data"][9];
        $postal_row["town_multi_address"] = $_SESSION["submission_data"][10];
        $postal_row["town_attach_district"] = $_SESSION["submission_data"][11];
        $postal_row["zip_code_multi_town"] = $_SESSION["submission_data"][12];
        $postal_row["update_check"] = $_SESSION["submission_data"][13];
        $postal_row["update_reason"] = $_SESSION["submission_data"][14];
    }
    
    // Declare error variable objects
    $format_errors;
    $missing_errors;

    // define variables and initialize with empty values
    $publicGroupCodeErr = $zipCodeOldErr = $zipCodeErr = "";
    $prefectureKanaErr = $cityKanaErr = $townKanaErr = $prefectureErr = $cityErr = $townErr = "";
    $_SESSION["has_errors"] = false;
    if ($_SESSION["error_data"] != null) {
        $missing_errors = $_SESSION["error_data"][0];
        $format_errors = $_SESSION["error_data"][1];
        $my_db->console_log($missing_errors);
    }
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>テストページ</title>
    <style>
        .error {
            color: red;
        }
    </style>
    </head>
    <body>
        <h3>上書きページ</h3>
        <button onclick="history.back();">Back</button></br>
        <!-- Loop through and display errors at the top -->
        <?php
        // Format
        if (count($format_errors) != 0 && $_SESSION["update_hajimete"] == false) {
            print "<span class='error'>";
            $count = count($format_errors);
            for ($x=0; $x < $count; $x++) {
                // If it's not the last iteration
                if ($x != count($format_errors)-1) {
                    echo $format_errors[$x] . ", ";
                } else {
                    echo $format_errors[$x] . "の型が不正です。";
                }
            }
            print "</span><br />";
        }
        // Missing errors
        if (count($missing_errors != 0) && $_SESSION["update_hajimete"] == false) {
            print "<span class='error'>";
            $count = count($missing_errors);
            for ($x=0; $x < $count; $x++) {
                // If it's not the last iteration
                if ($x != count($missing_errors)-1) {
                    echo $missing_errors[$x] . ", ";
                } else {
                    echo $missing_errors[$x] . "が未入力です。";
                }
            }
            print "</span><br />";
        }
        ?>

        <form action="update_confirm.php" method="POST">
            <input type="hidden" name="old_public_group_code" value="<?php print htmlspecialchars($publicGroupCode, ENT_COMPAT, 'utf-8'); ?>">
            <input type="hidden" name="old_zip_code_old" value="<?php print htmlspecialchars($zipCodeOld, ENT_COMPAT, 'utf-8'); ?>">
            <?php echo $comment_table_fields[0] ?>(数字): <input name="public_group_code" id="public_group_code" value="<?php print htmlspecialchars($publicGroupCode, ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[1] ?>(数字): <input name="zip_code_old" id="zip_code_old" value="<?php print htmlspecialchars($zipCodeOld, ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[2] ?>(数字): <input name="zip_code" id="zip_code" value="<?php print htmlspecialchars($zipCode, ENT_COMPAT, 'utf-8'); ?>" readonly>
            <br />
            <!-- Text inputs -->
            <?php echo $comment_table_fields[3] ?>: <input name="prefecture_kana" id="prefecture_kana" value="<?php print htmlspecialchars($postal_row["prefecture_kana"], ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[4] ?>: <input name="city_kana" id="city_kana" value="<?php print htmlspecialchars($postal_row["city_kana"], ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[5] ?>: <input name="town_kana" id="town_kana" value="<?php print htmlspecialchars($postal_row["town_kana"], ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[6] ?>: <input name="prefecture" id="prefecture" value="<?php print htmlspecialchars($postal_row["prefecture"], ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[7] ?>: <input name="city" id="city" value="<?php print htmlspecialchars($postal_row["city"], ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[8] ?>: <input name="town" id="town" value="<?php print htmlspecialchars($postal_row["town"], ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[9] ?><select name="town_double_zip_code" id="town_double_zip_code" size="1">
                <option value="0" <?php if($postal_row["town_double_zip_code"] == 0) print 'selected' ?>> 該当</option>
                <option value="1" <?php if($postal_row["town_double_zip_code"] == 1) print 'selected' ?>> 該当せず</option>
            </select><br />
            <?php echo $comment_table_fields[10] ?><select name="town_multi_address" id="town_multi_address" size="1">
                <option value="0" <?php if($postal_row["town_multi_address"] == 0) print 'selected' ?>> 該当</option>
                <option value="1" <?php if($postal_row["town_multi_address"] == 1) print 'selected' ?>> 該当せず</option>
            </select><br />
            <?php echo $comment_table_fields[11] ?><select name="town_attach_district" id="town_attach_district" size="1">
                <option value="0" <?php if($postal_row["town_attach_district"] == 0) print 'selected' ?>> 該当</option>
                <option value="1" <?php if($postal_row["town_attach_district"] == 1) print 'selected' ?>> 該当せず</option>
            </select><br />
                <?php echo $comment_table_fields[12] ?><select name="zip_code_multi_town" id="zip_code_multi_town" size="1">
                <option value="0" <?php if($postal_row["zip_code_multi_town"] == 0) print 'selected' ?>> 該当</option>
                <option value="1" <?php if($postal_row["zip_code_multi_town"] == 1) print 'selected' ?>> 該当せず</option>
            </select><br />
            <?php echo $comment_table_fields[13] ?><select name="update_check" id="update_check" size="1">
                <option value="0" <?php if($postal_row["update_check"] == 0) print 'selected' ?>> 変更なし</option>
                <option value="1" <?php if($postal_row["update_check"] == 1) print 'selected' ?>> 変更あり</option>
                <option value="2" <?php if($postal_row["update_check"] == 2) print 'selected' ?>> 廃止(廃止データのみ使用)</option>
            </select><br />
            <?php echo $comment_table_fields[14] ?>
            <select name="update_reason" id="update_reason" size="1">
                <option value="0" <?php if($postal_row["update_reason"] == 0) print 'selected' ?>> 変更なし</option>
                <option value="1" <?php if($postal_row["update_reason"] == 1) print 'selected' ?>> 市政・区政・町政・分区・政令指定都市施行</option>
                <option value="2" <?php if($postal_row["update_reason"] == 2) print 'selected' ?>> 住居表示の実施</option>
                <option value="3" <?php if($postal_row["update_reason"] == 3) print 'selected' ?>> 区画整理</option>
                <option value="4" <?php if($postal_row["update_reason"] == 4) print 'selected' ?>> 郵便区調整等</option>
                <option value="5" <?php if($postal_row["update_reason"] == 5) print 'selected' ?>> 訂正</option>
                <option value="6" <?php if($postal_row["update_reason"] == 6) print 'selected' ?>> 廃止(廃止データのみ使用)</option>
            </select><br />
            <!-- Submit Button -->
            <input type="submit" name="submit">
        </form>
    </body>
</html>