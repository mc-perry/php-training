<?php
    require_once '../lib/MyDBControllerMySQL.class.php';

    // Start the session
    session_start();

    function clear_session_fields()
    {
        $_SESSION["submission_data"][0] = null;
        $_SESSION["submission_data"][1] = null;
        $_SESSION["submission_data"][2] = null;
        $_SESSION["submission_data"][3] = null;
        $_SESSION["submission_data"][4] = null;
        $_SESSION["submission_data"][5] = null;
        $_SESSION["submission_data"][6] = null;
        $_SESSION["submission_data"][7] = null;
        $_SESSION["submission_data"][8] = null;
        $_SESSION["submission_data"][9] = null;
        $_SESSION["submission_data"][10] = null;
        $_SESSION["submission_data"][11] = null;
        $_SESSION["submission_data"][12] = null;
        $_SESSION["submission_data"][13] = null;
        $_SESSION["submission_data"][14] = null;
    }

    //declare arrays for saving properties
    $all_property = array();
    $title_array = array();
    $search_data = array();
    $column_data = array();

    // Get search string if it exists
    $search_category = $_POST['search_category'];
    $search_string = $_POST['catsearch'];
    
    // Set input bool to not display errors at first
    $_SESSION["input_hajimete"] = true;
    $_SESSION["update_hajimete"] = true;

    if ($_SESSION["in_progress"] == true) {
        clear_session_fields();
        $_SESSION["in_progress"] = false;
    }

    // number of rows/cols
    $num_rows = null;
    $num_cols = 15;

    $my_db = new MyDBControllerMySQL();
    // Connect again after insert if it occurred
    $my_db->connect();

    // Text to display regarding query
    $blue_success_text = '';
    $red_error_text = '';

    // Set if coming from submission
    if ($_SESSION["submitted"] == true) {
        if ($_SESSION["submit_success"] == true) {
            $blue_success_text = "1行登録完了しました";
        } else {
            $red_error_text = "登録失敗しました(SQLerror文)";
        }
        $_SESSION["submitted"] = false;
    }

    // Set if coming from submission
    if ($_SESSION["updated"] == true) {
        if ($_SESSION["update_success"] == true) {
            $blue_success_text = "1行更新完了しました";
        } else {
            $red_error_text = "更新失敗しました(SQLerror文)";
        }
        $_SESSION["updated"] = false;
    }
  

    $comment_table_query = "SHOW FULL COLUMNS FROM kadai_jonathan_ziplist";
    /* Query for the rows data */
    $row_data_query = "SELECT * FROM kadai_jonathan_ziplist";
    $comment_table_fields = $my_db->query($comment_table_query, "Comment");
    $postal_data = $my_db->query($row_data_query, null);
    // Set data to render in the view
    $column_data = setData($postal_data, $num_cols, $my_db);

    if (strlen($search_string) > 0) {
        $search_data = $my_db->select($row_data_query, $search_category, $search_string);
        $search_data = setData($search_data, $num_cols, $my_db);
    }

    // Reset the string back to a safe value after the literal value is searched for
    $search_string = htmlentities($_POST['catsearch']);

    // Close database connection
    $my_db->close();

    function setData($postal_data, $num_cols, $my_db) : array
    {
      $column_data = array();
      $num_rows = count($postal_data);
      //showing all data
      for ($x = 0; $x < $num_rows; $x++) {
        for ($y = 0; $y < $num_cols; $y++) {
          if ($y == 9 || $y == 10 || $y == 11 || $y == 12) {
            if ($postal_data[$x][$my_db->column_names[$y]] == 0) {
              array_push($column_data, "該当");
            } elseif ($postal_data[$x][$my_db->column_names[$y]] == 1) {
              array_push($column_data, "該当せず");
            } else {
              array_push($column_data, "不明");
            }
          } elseif ($y == 13) {
            if ($postal_data[$x][$my_db->column_names[$y]] == 0) {
              array_push($column_data, "変更なし");
            } elseif ($postal_data[$x][$my_db->column_names[$y]] == 1) {
              array_push($column_data, "変更あり");
            } elseif ($postal_data[$x][$my_db->column_names[$y]] == 2) {
              array_push($column_data, "廃止(廃止データのみ使用)");
            } else {
              array_push($column_data, "不明");
            }
          } elseif ($y == 14) {
            if ($postal_data[$x][$my_db->column_names[$y]] == 0) {
              array_push($column_data, "変更なし");
            } elseif ($postal_data[$x][$my_db->column_names[$y]] == 1) {
              array_push($column_data, "市政・区政・町政・分区・政令指定都市施行");
            } elseif ($postal_data[$x][$my_db->column_names[$y]] == 2) {
              array_push($column_data, "住居表示の実施");
            } elseif ($postal_data[$x][$my_db->column_names[$y]] == 3) {
              array_push($column_data, "区画整理");
            } elseif ($postal_data[$x][$my_db->column_names[$y]] == 4) {
              array_push($column_data, "郵便区調整等");
            } elseif ($postal_data[$x][$my_db->column_names[$y]] == 5) {
              array_push($column_data, "訂正");
            } elseif ($postal_data[$x][$my_db->column_names[$y]] == 6) {
              array_push($column_data, "廃止(廃止データのみ使用)");
            } else {
              array_push($column_data, "不明");
            }
          } else {
            // Just display value from database
            array_push($column_data, htmlspecialchars($postal_data[$x][$my_db->column_names[$y]]));
          }
        }
      }
      return $column_data;
    }

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>テストページ</title>
        <style>
            .blue-success-text {
                color: blue;
            }
            .red-error-text {
                color:red;
            }
        </style>
    </head>
    <body>
        <h2>課題4_5へようこそ</h2>
        <?php if(strlen($blue_success_text) > 0) {
        print "<p class='blue-success-text'>" . $blue_success_text . "</p>";
        } elseif(strlen($red_error_text) > 0) {
        print "<p class='red-error-text'>" . $red_error_text . "</p>";
        }
        ?>
        <form action="index.php" method="POST">
        <label for="catsearch">カテゴリで検索:</label>
        <select name="search_category" id="search_category" size="1">
            <?php for($x = 0; $x < sizeof($comment_table_fields); $x++) { ?>
            <option value="<?php print $x ?>"
                <?php print $search_category == $x ? "selected" : "" ?>>
                <?php print $comment_table_fields[$x] ?>
            </option>
            <?php } ?>
        </select>
        <input type="search" name="catsearch" value="<?php print $search_string ?>">
        <input type="submit">
        </form>
        <?php if(strlen($search_string) > 0): ?>
            <h3>検索結果</h3>
            <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                <?php
                    foreach($comment_table_fields as $title_text) {
                    print "<th>" . $title_text . "</th>" . "\n";
                    }
                ?>
                </tr>
                <br />
                <?php
                $count = count($search_data);
                for ($x = 0; $x < $count; $x++) {
                    if ($x % $num_cols == 0) {
                    print "<tr>" . "\n";
                    }
                    print "<td>" . $search_data[$x] . "</td>" . "\n";
                    if ($x % $num_cols == ($my_db->num_rows-1)) {
                    print "</tr>" . "\n";
                    }
                }
            ?>
            </table>
            <?php if(count($search_data) == 0): ?>
                    <p>このクエリに一致する結果はありません</p>
            <?php endif; ?>
        <?php endif; ?>

        <h3>全体リスト</h3>
        <form name="selectform" action="delete_regist.php" method="POST" onsubmit="return confirm('選択したエントリを削除しますか?');">
            <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th>削除/一斉チェック<input type='checkbox' id="select-all"></th>
                    <?php
                        foreach($comment_table_fields as $title_text) {
                            print "<th>" . $title_text . "</th>" . "\n";
                        }
                    ?>
                </tr>
                <br />
                <?php
                    for ($x = 0; $x < count($column_data); $x++) {
                        if ($x % $num_cols == 0) {
                            print "<tr>" . "\n";
                            print "<td><input type='checkbox' name='checkboxval[]' value='{$column_data[$x]}/{$column_data[$x+1]}/{$column_data[$x+2]}'></td>";
                        }
                        if ($x % $num_cols == 2) {
                            print "<td><a href='update.php?public_group_code={$column_data[$x-2]}&zip_code_old={$column_data[$x-1]}&zip_code={$column_data[$x]}'>" . $column_data[$x] . "</a></td>" . "\n";
                        }
                        else {
                            print "<td>" . $column_data[$x] . "</td>" . "\n";
                        }
                        if ($x % $num_cols == ($my_db->num_rows-1)) {
                            print "</tr>" . "\n";
                        }
                    }
                ?>
            </table>
            <input type="submit" name="submitdelete" value="削除">
        </form>
        <form action="input.php" method="GET">
            <input type="submit" name="submit" value="入力へ">
        </form>
        <script type="text/javascript">
            document.getElementById('select-all').onclick = function() {
                var checkboxes = document.getElementsByName('checkboxval[]');
                for (var checkbox of checkboxes) {
                    checkbox.checked = this.checked;
                }
            }
        </script>
    </body>
</html>