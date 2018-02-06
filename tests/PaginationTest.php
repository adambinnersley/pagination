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
        $this->assertEquals('', $this->pagination->paging(10, '/test-page'));
        $this->markTestIncomplete('Test not yet implemented');
    }
    
    /**
     * @covers Pager\Pagination::setPaginationClass
     * @covers Pager\Pagination::getPaginationClass
     * @covers Pager\Pagination::paging
     * @covers Pager\Pagination::buildLink
     * @covers Pager\Pagination::getPage
     * @covers Pager\Pagination::preLinks
     * @covers Pager\Pagination::postLinks
     */
    public function testPagerWithArrows(){
        $this->markTestIncomplete('Test not yet implemented');
    }
    
    /**
     * @covers Pager\Pagination::paging
     * @covers Pager\Pagination::buildLink
     * @covers Pager\Pagination::getPage
     * @covers Pager\Pagination::preLinks
     * @covers Pager\Pagination::postLinks
     */
    public function testPagerWithQueryString(){
        $this->markTestIncomplete('Test not yet implemented');
    }
    
    /**
     * @covers Pager\Pagination::setPaginationClass
     * @covers Pager\Pagination::getPaginationClass
     */
    public function testSetPagerClass(){
        $this->assertEquals('pagination', $this->pagination->getPaginationClass());
        $this->pagination->setPaginationClass('my-class');
        $this->assertNotEquals('pagination', $this->pagination->getPaginationClass());
        $this->assertEquals('my-class', $this->pagination->getPaginationClass());
        $this->pagination->setPaginationClass('paginationclass6');
        $this->assertEquals('paginationclass6', $this->pagination->getPaginationClass());
    }
    
    /**
     * @covers Pager\Pagination::setPaginationClass
     * @covers Pager\Pagination::getPaginationClass
     */
    public function testSetActiveClass(){
        $this->assertEquals('active', $this->pagination->getActiveClass());
        $this->pagination->setActiveClass('current');
        $this->assertNotEquals('active', $this->pagination->getActiveClass());
        $this->assertEquals('current', $this->pagination->getActiveClass());
        $this->pagination->setActiveClass('current active-class');
        $this->assertEquals('current active-class', $this->pagination->getActiveClass());
    }
}
