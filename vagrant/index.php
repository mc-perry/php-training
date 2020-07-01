<?php
    require_once '../lib/MyDBControllerMySQL.class.php';
    //declare arrays for saving properties
    $all_property = array();
    $title_array = array();
    $column_data = array();
  
    // number of rows/cols
    $num_rows = null;
    $num_cols = 15;

    $my_db = new MyDBControllerMySQL();
    $my_db->connect();
    $comment_table_query = 
      "SHOW FULL COLUMNS FROM kadai_jonathan_ziplist";
    /* Query for the rows data */
    $row_data_query = "SELECT * FROM kadai_jonathan_ziplist";
    $comment_table_fields = $my_db->query($comment_table_query, "Comment");
    $postal_data = $my_db->query($row_data_query, null);
    
    // Set data to render in the view
    setData($postal_data);

    // Close database connection
    $my_db->close();

    function setData($postal_data)
    {
      global $my_db;
      global $column_data;
      global $num_cols;
      $num_rows = sizeof($postal_data);
      //showing all data
      for ($x = 0; $x < $num_rows; $x++) {
          for ($y = 0; $y < $num_cols; $y++) {
            if ($y == 9 || $y == 10 || $y == 11 || $y == 12) {
              if ($postal_data[$x][$y] == 0) {
                array_push($column_data, "該当");
              }
              elseif ($postal_data[$x][$y] == 1) {
                array_push($column_data, "該当せず");
              } else {
                array_push($column_data, "不明");
              }
            } elseif ($y == 13) {
              if ($postal_data[$x][$y] == 0) {
                array_push($column_data, "変更なし");
              } elseif ($postal_data[$x][$y] == 1) {
                array_push($column_data, "変更あり");
              } elseif ($postal_data[$x][$y] == 2) {
                array_push($column_data, "廃止(廃止データのみ使用)");
              } else {
                array_push($column_data, "不明");
              }
            }
            elseif ($y == 14) {
              if ($postal_data[$x][$y] == 0) {
                array_push($column_data, "変更なし");
              }
              elseif ($postal_data[$x][$y] == 1) {
                array_push($column_data, "市政・区政・町政・分区・政令指定都市施行");
              }
              elseif ($postal_data[$x][$y] == 2) {
                array_push($column_data, "住居表示の実施");
              }
              elseif ($postal_data[$x][$y] == 3) {
                array_push($column_data, "区画整理");
              }
              elseif ($postal_data[$x][$y] == 4) {
                array_push($column_data, "郵便区調整等");
              }
              elseif ($postal_data[$x][$y] == 5) {
                array_push($column_data, "訂正");
              }
              elseif ($postal_data[$x][$y] == 6) {
                array_push($column_data, "廃止(廃止データのみ使用)");
              }
              else {
                array_push($column_data, "不明");
              }
            }
            else {
              // Just display value from database
              array_push($column_data, htmlspecialchars($postal_data[$x][$y]));
            }
        }
      }
    }
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>テストページ</title>
  </head>
  <body>
  <h2>課題3_X1へようこそ</h2>
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
        for ($x = 0; $x < sizeof($column_data); $x++) {
          if ($x % $num_cols == 0) {
            print "<tr>" . "\n";
          }
          print "<td>" . $column_data[$x] . "</td>" . "\n";
          if ($x % $num_cols == ($my_db->num_rows-1)) {
            print "</tr>" . "\n";
          }
        }
      ?>
    </table>
  </body>
</html>