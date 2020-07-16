<?php
    require_once '../lib/MyDBControllerMySQL.class.php';
    require_once '../lib/validation.class.php';
    // Start the session
    session_start();

    // Array for data to loop through
    $submission_data = array();

    $my_db = new MyDBControllerMySQL();
    $my_db->connect();
    $column_names = $my_db->column_names;
    $my_db->close();

    // Set value for input first time
    $_SESSION["input_hajimete"] = false;
    // Error boolean
    $hasErrors = false;

    // Define variables for completed values
    array_push($submission_data, $_POST['public_group_code']);
    array_push($submission_data, $_POST['zip_code_old']);
    array_push($submission_data, $_POST['zip_code']);
    array_push($submission_data, $_POST['prefecture_kana']);
    array_push($submission_data, $_POST['city_kana']);
    array_push($submission_data, $_POST['town_kana']);
    array_push($submission_data, $_POST['prefecture']);
    array_push($submission_data, $_POST['city']);
    array_push($submission_data, $_POST['town']);
    array_push($submission_data, $_POST['town_double_zip_code']);
    array_push($submission_data, $_POST['town_multi_address']);
    array_push($submission_data, $_POST['town_attach_district']);
    array_push($submission_data, $_POST['zip_code_multi_town']);
    array_push($submission_data, $_POST['update_check']);
    array_push($submission_data, $_POST['update_reason']);
    $_SESSION["submission_data"] = $submission_data;
    $comment_table_fields = $_SESSION["comment_table_fields"];
    $_SESSION["submitting"] = true;

    $validation = new Validation();
    $return_object = $validation->checkForErrors($submission_data, $comment_table_fields);
    $_SESSION["error_data"] = $return_object;
    if (count($return_object[0]) > 0 || count($return_object[1]) > 0) {
        $hasErrors = true;
    }

    if ($hasErrors == true) {
        // Direct user to confirm page
        header("Location: input.php");
        exit();
    }

    ?>

    <!DOCTYPE html>
    <html lang="ja">
    <head>
        <title>テストページ</title>
    </head>
        <body>
            <h3>情報確認</h3>
            <button onclick="history.back();">Back</button></br>
            <form action="regist.php" method="POST">
                <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
                <?php
                    for($x = 0; $x < sizeof($comment_table_fields); $x++) {
                ?>
                <tr>
                    <input type="hidden" name="<?php echo "{$column_names[$x]}" ?>" value="<?php echo htmlentities($submission_data[$x]); ?>" readonly />
                    <?php
                    print "<td width='200'>" . htmlspecialchars($comment_table_fields[$x], ENT_COMPAT, 'utf-8') . "</td>";
                    if ($x < 9) {
                        print "<td width='400'>" . htmlspecialchars($submission_data[$x], ENT_COMPAT, 'utf-8') . "</td>";
                    } elseif ($x >= 9 && $x <= 12) {
                        print "<td width='400'>" . ($submission_data[$x] == 0 ? '該当' : '該当せず') . "</td>";
                    } elseif ($x == 13) {
                        if ($submission_data[$x] == 0) {
                            print "<td width='400'>変更なし</td>";
                        } elseif ($submission_data[$x] == 1) {
                            print "<td width='400'>変更あり</td>";
                        } elseif ($submission_data[$x] == 2) {
                            print "<td width='400'>廃止(廃止データのみ使用)</td>";
                        }
                    } elseif ($x == 14) {
                        if ($submission_data[$x] == 0) {
                            print "<td width='400'>変更なし</td>";
                        } elseif ($submission_data[$x] == 1) {
                            print "<td width='400'>市政・区政・町政・分区・政令指定都市施行</td>";
                        } elseif ($submission_data[$x] == 2) {
                            print "<td width='400'>住居表示の実施</td>";
                        } elseif ($submission_data[$x] == 3) {
                            print "<td width='400'>区画整理</td>";
                        } elseif ($submission_data[$x] == 4) {
                            print "<td width='400'>郵便区調整等</td>";
                        } elseif ($submission_data[$x] == 5) {
                            print "<td width='400'>訂正</td>";
                        } elseif ($submission_data[$x] == 6) {
                            print "<td width='400'>廃止(廃止データのみ使用)</td>";
                        }
                    }
                    ?>
                </tr>
                    <?php } ?>
                </table>
                <p>この内容で宜しいですか？
                <input type="submit" name="submit" class="button" value="はい" /> 
            </form>
        </body>
    </html>