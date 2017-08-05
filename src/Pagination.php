<?php
namespace Pager;

class Pagination {
    public static $current;
    protected static $page;
    protected static $lastpage;
    
    /**
     * Returns paging buttons for the number of records
     * @param int $records The total number of records
     * @param string $pageURL The URL of the page you are creating the paging for
     * @param int $start The start number for the results
     * @param string $additional Any additional get values to include in the URL
     * @param int $maxshown The number of records that are shown on each page
     * @param int $numpagesshown The number of pagination buttons to display
     * @return string Returns the pagination menu
     */
    public static function paging($records, $pageURL, $start = 0, $additional = '', $maxshown = 50, $numpagesshown = 11) {
        if ($records > $maxshown) {
            if ($start >= 1) {self::$current = $start;} else {self::$current = 1;}
            self::$lastpage = ceil($records / $maxshown);
            
            if (!empty($additional)) {$additional = 'search='.$additional.'&amp;';}
            
            self::getPage($records, $maxshown, $numpagesshown);
            $paging = '<ul class="pagination">';
            if (self::$current != 1) {
                if (self::$current != 2) {$paging.= '<li><a href="'.$pageURL.'?'.$additional.'">&laquo;</a></li>';}
                $paging.= '<li><a href="'.$pageURL.'?'.$additional.'page='.($start - 1).'">&lt;</a></li>';
            }
            while (self::$page <= self::$lastpage) {
                if (self::$current == self::$page) {$curselect = ' class="active"';}else {$curselect = '';}
                $paging.= '<li'.$curselect.'><a href="'.$pageURL.'?'.$additional.'page='.self::$page.'">'.self::$page.'</a></li>';
                self::$page = (self::$page + 1);
            }
            if (self::$current != self::$lastpage) {
                $paging.= '<li><a href="'.$pageURL.'?'.$additional.'page='.($start + 1).'">&gt;</a></li>';
                if (self::$current != (self::$lastpage - 1)) {$paging.= '<li><a href="'.$pageURL.'?'.$additional.'page='.ceil($records / $maxshown).'">&raquo;</a></li>';}
            }
            $paging.= '</ul>';
            return $paging;
        }
        return false;
    }
    
    /**
     * Gets the current page
     * @param int $records The total number of records
     * @param int $maxshown The number of records that are shown on each page
     * @param int $numpages The number of pagination buttons to display
     * return void Nothing is returned
     */
    protected static function getPage($records, $maxshown, $numpages) {
        $show = floor($numpages / 2);
        if (self::$lastpage > $numpages) {
            if (self::$current > $show) {self::$page = self::$current - $show;}else{self::$page = 1;}

            if (self::$current < (self::$lastpage - $show)) {
                self::$lastpage = self::$current + $show;
                if (self::$current <= $show) {self::$lastpage = self::$current + ($numpages - self::$current);}
            } else {self::$page = self::$current - ($numpages - ((ceil($records / $maxshown) - self::$current)) - 1);}
        } else {self::$page = 1;}
    }
}
