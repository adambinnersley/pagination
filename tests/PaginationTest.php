<?php
namespace Pager\Tests;

use Pager\Pagination;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase{
    
    protected $pagination;
    
    public function setUp() {
        $this->pagination = new Pagination();
    }
    
    public function tearDown(){
        unset($this->pagination);
    }
    
    /**
     * @covers Pager\Pagination::paging
     * @covers Pager\Pagination::buildLink
     * @covers Pager\Pagination::getPage
     */
    public function testCreatePager(){
        $this->pagination->paging(72, '/test-page');
    }
    
    /**
     * @covers Pager\Pagination::paging
     * @covers Pager\Pagination::buildLink
     * @covers Pager\Pagination::getPage
     */
    public function testNoPagerNeeded(){
        
    }
    
    /**
     * @covers Pager\Pagination::paging
     * @covers Pager\Pagination::buildLink
     * @covers Pager\Pagination::getPage
     * @covers Pager\Pagination::preLinks
     * @covers Pager\Pagination::postLinks
     */
    public function testPagerWithArrows(){
        
    }
    
    /**
     * @covers Pager\Pagination::paging
     * @covers Pager\Pagination::buildLink
     * @covers Pager\Pagination::getPage
     * @covers Pager\Pagination::preLinks
     * @covers Pager\Pagination::postLinks
     */
    public function testPagerWithQueryString(){
        
    }
}
