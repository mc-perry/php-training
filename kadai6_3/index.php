<?php
require_once '../lib/MyDBControllerMySQL.class.php';
require_once '../lib/pager.class.php';
// Start the session
session_start();

function console_log($data)
{
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ')';
    echo '</script>';
}

$my_db = new MyDBControllerMySQL();
// Connect again after insert if it occurred
$my_db->connect();

$table_name = "kadai_jonathan_ziplist";
$town_code_mst_table_name = "kadai_jonathan_town_code_mst";
$update_check_code_mst_table_name = "kadai_jonathan_update_check_code_mst";
$update_reason_code_mst_table_name = "kadai_jonathan_update_reason_code_mst";
$total_pages_sql = "SELECT COUNT(*) FROM $table_name";
$allDataArray = $my_db->query($total_pages_sql, null, null, null, null, null);
$total_count = $allDataArray[0]["COUNT(*)"];

if ($_GET["pageno"] != null) {
    $pageno = $_GET["pageno"];
} else if ($_COOKIE["pageno"] != null) {
    $pageno = number_format($_COOKIE["pageno"]);
} else {
    $pageno = 0;
}

// Create the pager class
$pager = new Pager($pageno, $total_count);

$num_pages = $pager->num_pages;
$can_go_back = $pager->can_go_back;
$can_go_forward = $pager->can_go_forward;
$pager_html = $pager->generate_pager_html();

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

// Set if coming from download
if ($_SESSION["no_files_selected_error"] !== null) {
    $my_db->console_log($_SESSION["no_files_selected_error"]);
    if ($_SESSION["no_files_selected_error"] == true) {
        $red_error_text = "ダウンロードするファイルを少なくとも1つ選択する必要があります。";
    }
    $_SESSION["no_files_selected_error"] = null;
}

$my_db->console_log($_SESSION["upload_success"]);

// Upload stuff
if ($_SESSION["upload_success"] !== null) {
    if ($_SESSION["upload_success"] == true) {
        $blue_success_text = "アップロードが正常に終了しました。";
    } else if ($_SESSION["upload_success"] == false) {
        if (count($_SESSION["duplicate_entries"]) > 0) {
            $lastDuplicates = $_SESSION["duplicate_entries"];
            $red_error_text = $lastDuplicates . "件の重複したエントリがありました";
            $_SESSION["duplicate_entries"] = 0;
        } else {
            $red_error_text = $_SESSION["upload_error"];
        }
    }
    $_SESSION["upload_success"] = null;
    // Set duplicate entries back to 0
    $_SESSION["duplicate_entries"] = null;
}

$join1 = " LEFT JOIN $town_code_mst_table_name AS mst_table1 ON $table_name.town_double_zip_code = mst_table1.code_key_index ";
$join2 = " LEFT JOIN $town_code_mst_table_name AS mst_table2 ON $table_name.town_multi_address = mst_table2.code_key_index ";
$join3 = " LEFT JOIN $town_code_mst_table_name AS mst_table3 ON $table_name.town_attach_district = mst_table3.code_key_index ";
$join4 = " LEFT JOIN $town_code_mst_table_name AS mst_table4 ON $table_name.zip_code_multi_town = mst_table4.code_key_index ";
$join5 = " LEFT JOIN $update_check_code_mst_table_name AS mst_table5 ON $table_name.update_check = mst_table5.code_key_index ";
$join6 = " LEFT JOIN $update_reason_code_mst_table_name AS mst_table6 ON $table_name.update_reason = mst_table6.code_key_index ";
$joinArray = array($join1, $join2, $join3, $join4, $join5, $join6);

$orderingClause = null;
// Add an order by clause to SQL statement if
if ($_COOKIE["ascending"] == true) {
    $orderingClause .= " ORDER BY $table_name.{$_COOKIE['sort_field']} ASC";
} else if ($_COOKIE["descending"] == true) {
    $orderingClause .= " ORDER BY $table_name.{$_COOKIE['sort_field']} DESC";
}

$comment_table_query = "SHOW FULL COLUMNS FROM $table_name";
/* Query for the rows data */
$row_data_query = "SELECT * FROM $table_name";
$comment_table_fields = $my_db->query($comment_table_query, "Comment", null, null, null, null);
$postal_data = $my_db->query($row_data_query, null, $joinArray, $orderingClause, $pager->items_per_page, $pager->items_per_page * $pageno);

// Set data to render in the view
if (strlen($search_string) > 0) {
    $search_data = $my_db->select($row_data_query, $search_category, $search_string, $joinArray);
}

// Reset the string back to a safe value after the literal value is searched for
$search_string = htmlentities($_POST['catsearch']);

// Close database connection
$my_db->close();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <title>テストページ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .blue-success-text {
            color: blue;
        }

        .red-error-text {
            color: red;
        }

        .pagination-parent {
            text-align: center;
            width: 100%;
        }

        .pagination {
            display: inline-block;
        }

        .pagination a {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <h2>課題6_3へようこそ</h2>
    <?php if (strlen($blue_success_text) > 0) {
        print "<p class='blue-success-text'>" . $blue_success_text . "</p>";
    } elseif (strlen($red_error_text) > 0) {
        print "<p class='red-error-text'>" . $red_error_text . "</p>";
    }
    ?>
    <form action="index.php" method="POST">
        <label for="catsearch">カテゴリで検索:</label>
        <select name="search_category" id="search_category" size="1">
            <?php for ($x = 0; $x < sizeof($comment_table_fields); $x++) { ?>
                <option value="<?php print $x ?>" <?php print $search_category == $x ? "selected" : "" ?>>
                    <?php print $comment_table_fields[$x] ?>
                </option>
            <?php } ?>
        </select>
        <input type="search" name="catsearch" value="<?php print $search_string ?>">
        <input type="submit">
    </form>
    <?php if (strlen($search_string) > 0) : ?>
        <h3>検索結果</h3>
        <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
            <tr>
                <?php
                foreach ($comment_table_fields as $title_text) {
                    print "<th>" . $title_text . "</th>" . "\n";
                }
                ?>
            </tr>
            <br />
            <?php
            foreach ($search_data as $search) {
                $count = count($search_data);
                for ($x = 0; $x < $num_cols; $x++) {
                    if ($x % $num_cols == 0) {
                        print "<tr>" . "\n";
                    }
                    print "<td>" . htmlspecialchars($search[$my_db->column_names[$x]], ENT_COMPAT, 'utf-8') . "</td>" . "\n";
                    if ($x % $num_cols == ($my_db->num_rows - 1)) {
                        print "</tr>" . "\n";
                    }
                }
            }
            ?>
        </table>
        <?php if (count($search_data) == 0) : ?>
            <p>このクエリに一致する結果はありません</p>
        <?php endif; ?>
    <?php endif; ?>
    <form id="downloadForm" action="download.php" method="POST">
        <input type="submit" form='downloadForm' id="download-button" class="btn" value="ダウンロード" />
    </form>
    <label for="download-all">全件チェック</label>
    <input type='checkbox' id="download-all" name="downloadingAll" value="true" form="downloadForm" />
    <form id="uploadForm" action="upload.php" method="POST" style="text-align: right;" enctype="multipart/form-data">
        <p>Upload CSV: <input type="file" name="file" /></p>
        <p><input type="submit" name="upload" value="アップロード" /></p>
    </form>
    <h3>全体リスト</h3>

    <form name="selectform" action="delete_regist.php" method="POST" onsubmit="return confirm('選択したエントリを削除しますか?');">
        <table style="width:100%" border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>削除・一斉チェック<input type='checkbox' id="select-all"></th>
                <?php
                for ($x = 0; $x < $num_cols; $x++) {
                    print '<th><a href="" onclick=setSortingField("' . $my_db->column_names[$x] . '");>' . $comment_table_fields[$x] . "</a>" . "\n";
                    if ($_COOKIE["sort_field"] == $my_db->column_names[$x]) {
                        if ($_COOKIE["ascending"] == true) {
                            print "△";
                        } else if ($_COOKIE["descending"] == true) {
                            print "▽";
                        }
                    }
                    print "</th>\n";
                }
                ?>
            </tr>
            <br />
            <?php
            foreach ($postal_data as $data_row) {
                for ($x = 0; $x < $num_cols; $x++) {
                    if ($x % $num_cols == 0) {
                        print "<tr>" . "\n";
                        print "<td><input type='checkbox' name='checkboxval[]' value='{$data_row['public_group_code']}/{$data_row['zip_code_old']}/{$data_row['zip_code']}' /></td>";
                    }
                    if ($x % $num_cols == 2) {
                        $updateLink = '';
                        $updateLink .= '<td><a href="update.php?public_group_code=' . $data_row['public_group_code'];
                        $updateLink .= '&zip_code_old=' . $data_row['zip_code_old'];
                        $updateLink .= '&zip_code=' . $data_row['zip_code'] . '">' .  $data_row[$my_db->column_names[$x]];
                        $updateLink .= "</a></td>" . "\n";
                        print $updateLink;
                    } else {
                        print "<td>" . htmlspecialchars($data_row[$my_db->column_names[$x]], ENT_COMPAT, 'utf-8') . "</td>" . "\n";
                    }
                }
                print "<input type='hidden' name='downloadcheckboxval[]' form='downloadForm' value='{$data_row['public_group_code']}/{$data_row['zip_code_old']}/{$data_row['zip_code']}'>";
                print "</tr>\n";
            }
            ?>
        </table>
        <input type="submit" name="submitdelete" value="削除" />
    </form>
    <form id="saveForm" action="input.php" method="GET">
        <input type="submit" name="submit" value="入力へ" form="saveForm">
    </form>
    <div class="pagination-parent">
        <div class="pagination">
            <!-- Insert the html generated string from pager class here -->
            <?php
            print $pager_html;
            ?>
        </div>
    </div>
    <script type="text/javascript">
        // Set the cookie value in javascript if there is a GET parameter
        const urlParams = new URLSearchParams(window.location.search);
        const pageno = urlParams.get('pageno');
        if (pageno) {
            document.cookie = `pageno=${pageno}`;
        } else {
            document.cookie = "pageno=0";
        }
        document.getElementById('select-all').onclick = function() {
            var checkboxes = document.getElementsByName('checkboxval[]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }

        function setSortingField(my_val) {
            let ascendingCookie;
            if (ascendingCookie = getCookie("ascending")) {
                if (getCookie("sort_field") == my_val) {
                    // Delete the ascending cookie
                    document.cookie = "ascending=;"
                    document.cookie = "descending=true;";
                    document.cookie = `sort_field=${my_val}`;
                } else {
                    // We set a new field so set the ascending value
                    document.cookie = "ascending=true;";
                    document.cookie = `sort_field=${my_val}`;
                }
            } else {
                // Delete the descending cookie if it existed
                document.cookie = "descending=;"
                // We set a new field so set the ascending value
                document.cookie = "ascending=true;";
                document.cookie = `sort_field=${my_val}`;
            }
        }

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
    </script>
</body>

</html>