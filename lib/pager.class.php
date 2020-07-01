<?php
class Pager
{
    //------------
    // 属性
    //------------

    // Ints
    var $items_per_page = 30;
    var $current_page;
    var $total_count;
    var $num_pages;

    // Bools
    var $can_go_back;
    var $can_go_forward;

    function __construct($cur_page, $total_count)
    {
        $this->current_page = $cur_page;
        $this->total_count = $total_count;
        $this->num_pages = ceil($this->total_count / $this->items_per_page);
        if ($cur_page == 0) {
            $this->can_go_back = false;
            $this->can_go_forward = true;
        } elseif ($cur_page == $this->num_pages - 1) {
            $this->can_go_back = true;
            $this->can_go_forward = false;
        } else {
            // We're somewhere in the middle
            $this->can_go_back = true;
            $this->can_go_forward = true;
        }
    }

    function generate_pager_html()
    {
        $htmlReturnString = "";        
        if ($this->can_go_back) {
            $htmlReturnString .= '<a href="index.php?pageno=' . ($this->current_page-1) . '">&laquo;</a>';
        }
        for($x = 0; $x < $this->num_pages; $x++) {
            $htmlReturnString .= '<a href="index.php?pageno=' . $x . '"';
            if ($x == $this->current_page) {
                $htmlReturnString .= ' class="active"';
            }
            $htmlReturnString .= ">" . ($x+1) . "</a>";
        }
        if ($this->can_go_forward) {
            $htmlReturnString .= '<a href="index.php?pageno=' . ($this->current_page+1) . '">&raquo;</a>';
        }
        return $htmlReturnString;
    }

    function console_log($data)
    {
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

}
?>