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

    if (!$_SESSION["in_progress"]) {
        $_SESSION["in_progress"] = true;
    }

    if ($_SESSION["input_hajimete"] == true) {
        clear_session_fields();
    }

    $my_db = new MyDBControllerMySQL();
    $my_db->connect();
    $comment_table_query = 
      "SHOW FULL COLUMNS FROM kadai_jonathan_ziplist";
    $comment_table_fields = $my_db->query($comment_table_query, "Comment", null, null, null, null);

    $_SESSION["comment_table_fields"] = $comment_table_fields;

    // Get errors from validation class
    $missing_errors = $_SESSION["error_data"][0];
    $format_errors = $_SESSION["error_data"][1];
    
    // Close database connection
    $my_db->close();

    // Set data from session if it exists to display previous values
    $publicGroupCode = $_SESSION["submission_data"][0];
    $zipCodeOld = $_SESSION["submission_data"][1];
    $zipCode = $_SESSION["submission_data"][2];
    $prefectureKana = $_SESSION["submission_data"][3];
    $cityKana = $_SESSION["submission_data"][4];
    $townKana = $_SESSION["submission_data"][5];
    $prefecture = $_SESSION["submission_data"][6];
    $city = $_SESSION["submission_data"][7];
    $town = $_SESSION["submission_data"][8];
    // Set gaitou as default for the 4 fields
    if ($townDoubleZipCode) {
        $townDoubleZipCode = $_SESSION["submission_data"][9];
    } else {
        $townDoubleZipCode = 1;
    }
    if ($townMultiAddress) {
        $townMultiAddress = $_SESSION["submission_data"][10];
    } else {
        $townMultiAddress = 1;
    }
    if ($townAttachDistrict) {
        $townAttachDistrict = $_SESSION["submission_data"][11];
    } else {
        $townAttachDistrict = 1;
    }
    if ($zipCodeMultiTown) {
        $zipCodeMultiTown = $_SESSION["submission_data"][12];
    } else {
        $zipCodeMultiTown = 1;
    }

    $updateCheck = $_SESSION["submission_data"][13];
    $updateReason = $_SESSION["submission_data"][14];

    // define variables and initialize with empty values
    $publicGroupCodeErr = $zipCodeOldErr = $zipCodeErr = "";
    $prefectureKanaErr = $cityKanaErr = $townKanaErr = $prefectureErr = $cityErr = $townErr = "";
    $_SESSION["has_errors"] = false;


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
        <button onclick="history.back();">Back</button></br>
        <h2>入力ページ</h2>
        <!-- Loop through and display errors at the top -->
        <?php
        // Format
        if (count($format_errors) != 0 && $_SESSION["input_hajimete"] == false) {
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
        if (count($missing_errors != 0) && $_SESSION["input_hajimete"] == false) {
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
        <br />
        <form action="confirm.php" method="POST">
            <?php echo $comment_table_fields[0] ?>(数字): <input name="public_group_code" id="public_group_code" value="<?php print htmlspecialchars($publicGroupCode, ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[1] ?>(数字): <input name="zip_code_old" id="zip_code_old" value="<?php print htmlspecialchars($zipCodeOld, ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[2] ?>(数字): <input name="zip_code" id="zip_code" value="<?php print htmlspecialchars($zipCode, ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <!-- Text inputs -->
            <?php echo $comment_table_fields[3] ?>: <input name="prefecture_kana" id="prefecture_kana" value="<?php print htmlspecialchars($prefectureKana, ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[4] ?>: <input name="city_kana" id="city_kana" value="<?php print htmlspecialchars($cityKana, ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[5] ?>: <input name="town_kana" id="town_kana" value="<?php print htmlspecialchars($townKana, ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[6] ?>: <input name="prefecture" id="prefecture" value="<?php print htmlspecialchars($prefecture, ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[7] ?>: <input name="city" id="city" value="<?php print htmlspecialchars($city, ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[8] ?>: <input name="town" id="town" value="<?php print htmlspecialchars($town, ENT_COMPAT, 'utf-8'); ?>">
            <br />
            <?php echo $comment_table_fields[9] ?><select name="town_double_zip_code" id="town_double_zip_code" size="1">
                <option value="1" <?php if($townDoubleZipCode == 1) print 'selected' ?>> 該当</option>
                <option value="0" <?php if($townDoubleZipCode == 0) print 'selected' ?>> 該当せず</option>
            </select><br />
            <?php echo $comment_table_fields[10] ?><select name="town_multi_address" id="town_multi_address" size="1">
                <option value="1" <?php if($townMultiAddress == 1) print 'selected' ?>> 該当</option>
                <option value="0" <?php if($townMultiAddress == 0) print 'selected' ?>> 該当せず</option>
            </select><br />
            <?php echo $comment_table_fields[11] ?><select name="town_attach_district" id="town_attach_district" size="1">
                <option value="1" <?php if($townAttachDistrict == 1) print 'selected' ?>> 該当</option>
                <option value="0" <?php if($townAttachDistrict == 0) print 'selected' ?>> 該当せず</option>
            </select><br />
                <?php echo $comment_table_fields[12] ?><select name="zip_code_multi_town" id="zip_code_multi_town" size="1">
                <option value="1" <?php if($zipCodeMultiTown == 1) print 'selected' ?>> 該当</option>
                <option value="0" <?php if($zipCodeMultiTown == 0) print 'selected' ?>> 該当せず</option>
            </select><br />
            <?php echo $comment_table_fields[13] ?><select name="update_check" id="update_check" size="1">
                <option value="0" <?php if($updateCheck == 0) print 'selected' ?>> 変更なし</option>
                <option value="1" <?php if($updateCheck == 1) print 'selected' ?>> 変更あり</option>
                <option value="2" <?php if($updateCheck == 2) print 'selected' ?>> 廃止(廃止データのみ使用)</option>
            </select><br />
            <?php echo $comment_table_fields[14] ?>
            <select name="update_reason" id="update_reason" size="1">
                <option value="0" <?php if($updateReason == 0) print 'selected' ?>> 変更なし</option>
                <option value="1" <?php if($updateReason == 1) print 'selected' ?>> 市政・区政・町政・分区・政令指定都市施行</option>
                <option value="2" <?php if($updateReason == 2) print 'selected' ?>> 住居表示の実施</option>
                <option value="3" <?php if($updateReason == 3) print 'selected' ?>> 区画整理</option>
                <option value="4" <?php if($updateReason == 4) print 'selected' ?>> 郵便区調整等</option>
                <option value="5" <?php if($updateReason == 5) print 'selected' ?>> 訂正</option>
                <option value="6" <?php if($updateReason == 6) print 'selected' ?>> 廃止(廃止データのみ使用)</option>
            </select><br />
            <!-- Reset and Submit Buttons -->
            <input type="reset" name="reset">
            <input type="submit" name="submit">
        </form>
    </body>
</html>
