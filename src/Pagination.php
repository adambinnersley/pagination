<?php
namespace Pager;

class Pagination {
    public static $current;
    protected $queryString;

    protected static $page;
    protected static $pageURL;
    protected static $lastpage;
    protected static $totalPages;
    
    public $pagerClass = 'pagination justify-content-center';
    public $liClass = 'page-item';
    public $liActiveClass = 'active';
    public $aClass = 'page-link';
    public $aActiveClass = '';
    
    /**
     * Sets the class assigned to the UL element of the pagination object
     * @param string $class This should be the class or classes that you wish to give to the pagination object 
     * @return $this
     */
    public function setPaginationClass($class) {
        if ((!empty(trim($class)))) {
            $this->pagerClass = $class;
        }
        return $this;
    }
    
    /**
     * Returns the class to give to the pagination object
     * @return string The pagination class will be returned
     */
    public function getPaginationClass() {
        return $this->pagerClass;
    }
    
    /**
     * Sets the default li class
     * @param string $class This should be the class that you want to all to all li elements
     * @return $this
     */
    public function setLiClass($class) {
        $this->liClass = trim($class);
        return $this;
    }
    
    /**
     * Gets the current li class
     * @return string This should be the class to assign on li elements
     */
    public function getLiClass() {
        return $this->liClass;
    }
    
    /**
     * Sets the active class to assign on the li elements
     * @param string $class This should be the class to assign on active elements
     * @return $this
     */
    public function setLiActiveClass($class) {
        $this->liActiveClass = trim($class);
        return $this;
    }

    /**
     * Returns the class to assign to active li elements
     * @return string This should be the class to assign on active elements
     */
    public function getLiActiveClass() {
        return $this->liActiveClass;
    }
    
    
    /**
     * Sets the default class on a elements
     * @param string $class This should be the class to add to a elements
     * @return $this
     */
    public function setAClass($class) {
        $this->aClass = trim($class);
        return $this;
    }
    
    /**
     * Returns the class assigned to a elements
     * @return string Returns the class assigned to a elements
     */
    public function getAClass() {
        return $this->aClass;
    }
    
    /**
     * Sets the class to assign to active a elements
     * @param string $class This should be the class to add to active a elements
     * @return $this
     */
    public function setAActiveClass($class) {
        $this->aActiveClass = trim($class);
        return $this;
    }
    
    /**
     * Returns the class assigned to active a elements 
     * @return string This should be the class to add to active a elements
     */
    public function getAActiveClass() {
        return $this->aActiveClass;
    }
    
    /**
     * Returns paging buttons for the number of records
     * @param int $records The total number of records
     * @param string $pageURL The URL of the page you are creating the paging for
     * @param int $start The start number for the results
     * @param int $maxshown The number of records that are shown on each page
     * @param int $numpagesshown The number of pagination buttons to display
     * @param boolean $arrows If you want arrows to display before and after for next and previous set to true (default) else set to false
     * @param array $additional Any additional get values to include in the URL
     * @return string|false Returns the pagination menu if required else will return false
     */
    public function paging($records, $pageURL, $start = 0, $maxshown = 50, $numpagesshown = 11, $arrows = true, $additional = array()) {
        self::$pageURL = $pageURL;
        $this->queryString = $additional;
        if ($records > $maxshown) {
            self::$current = $start >= 1 ? intval($start) : 1;
            self::$totalPages = ceil(intval($records) / ($maxshown >= 1 ? intval($maxshown) : 1));
            self::$lastpage = self::$totalPages;
            $this->getPage($records, $maxshown, $numpagesshown);
            
            $paging = '<ul class="'.$this->getPaginationClass().'">'.$this->preLinks($arrows);
            while (self::$page <= self::$lastpage) {
                $paging .= $this->buildLink(self::$page, self::$page, (self::$current == self::$page));
                self::$page = (self::$page + 1);
            }
            return $paging.$this->postLinks($arrows).'</ul>';
        }
        return false;
    }
    
    /**
     * Build a link item with the given values
     * @param string $link This should be any additional items to be included as part of the link
     * @param mixed $page This should be the link test on the link normally set as numbers but may be anything like arrows or dots etc
     * @param boolean $current If this is the current link item set this as true so the class is added to the link item
     * @return string This will return the paging item as a string
     */
    protected function buildLink($link, $page, $current = false) {
        return '<li'.(!empty($this->getLiClass()) || ($current === true && !empty($this->getLiActiveClass())) ? ' class="'.trim($this->getLiClass().(($current === true && !empty($this->getLiActiveClass())) ? ' '.$this->getLiActiveClass() : '').'"') : '').'><a href="'.self::$pageURL.(!empty($this->buildQueryString($link)) ? '?'.$this->buildQueryString($link) : '').'" title="Page '.$page.'"'.(!empty($this->getAClass()) || ($current === true && !empty($this->getAActiveClass())) ? ' class="'.trim($this->getAClass().(($current === true && !empty($this->getAActiveClass())) ? ' '.$this->getAActiveClass() : '')).'"' : '').'>'.$page.'</a></li>';
    }
    
    /**
     * Builds the query string to add to the URL
     * @param mixed $page If the page variable is set to a number will add the page number to the query string else will not add any additional items
     * @return string The complete string will be returned to add to the link item
     */
    protected function buildQueryString($page) {
        $pageInfo = is_numeric($page) ? ['page' => $page] : [];
        return http_build_query(array_filter(array_merge($pageInfo, $this->queryString)), '', '&amp;');
    }
    
    /**
     * Gets the current page
     * @param int $records The total number of records
     * @param int $maxshown The number of records that are shown on each page
     * @param int $numpages The number of pagination buttons to display
     * return void Nothing is returned
     */
    protected function getPage($records, $maxshown, $numpages) {
        $show = floor($numpages / 2);
        if (self::$lastpage > $numpages) {
            self::$page = (self::$current > $show ? (self::$current - $show) : 1);
            if (self::$current < (self::$lastpage - $show)) {
                self::$lastpage = ((self::$current <= $show) ? (self::$current + ($numpages - self::$current)) : (self::$current + $show));
            }
            else { self::$page = self::$current - ($numpages - ((ceil(intval($records) / ($maxshown >= 1 ? intval($maxshown) : 1)) - self::$current)) - 1); }
        }
        else { self::$page = 1; }
    }
    
    /**
     * Returns the previous arrows as long as arrows is set to true and the page is not the first page
     * @param boolean $arrows If you want to display previous arrows set to true else set to false
     * @return string Any previous link arrows will be returned as a string
     */
    protected function preLinks($arrows = true) {
        $paging = '';
        if (self::$current != 1 && $arrows) {
            if (self::$current != 2) { $paging .= $this->buildLink('', '&laquo;'); }
            $paging .= $this->buildLink((self::$current - 1), '&lt;');
        }
        return $paging;
    }
    
    /**
     * Returns the next arrows as long as arrows is set to true and the page is not the last page
     * @param boolean $arrows If you want to display next arrows set to true else set to false
     * @return string Any next link arrows will be returned as a string
     */
    protected function postLinks($arrows = true) {
        $paging = '';
        if (self::$current != self::$totalPages && $arrows) {
            $paging .= $this->buildLink((self::$current + 1), '&gt;');
            if (self::$current != (self::$totalPages - 1)) { $paging .= $this->buildLink(self::$totalPages, '&raquo;'); }
        }
        return $paging;
    }
}
