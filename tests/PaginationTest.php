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
     * @covers Pager\Pagination::buildQueryString
     * @covers Pager\Pagination::getActiveClass
     * @covers Pager\Pagination::getPaginationClass
     * @covers Pager\Pagination::postLinks
     * @covers Pager\Pagination::preLinks
     */
    public function testCreatePager(){
        $pager = $this->pagination->paging(106, '/test-page');
        $this->assertStringStartsWith("<ul", $pager);
        $this->assertStringEndsWith("ul>", $pager);
        $this->assertContains('<li class="active"><a href="/test-page?page=1" title="Page 1">1</a></li>', $pager);
        $this->assertEquals('<ul class="pagination"><li class="active"><a href="/test-page?page=1" title="Page 1">1</a></li><li><a href="/test-page?page=2" title="Page 2">2</a></li><li><a href="/test-page?page=3" title="Page 3">3</a></li><li><a href="/test-page?page=2" title="Page &gt;">&gt;</a></li><li><a href="/test-page?page=3" title="Page &raquo;">&raquo;</a></li></ul>', $pager);
        
        $alternateCurrent = $this->pagination->paging(106, '/test-page', 3);
        $this->assertStringStartsWith("<ul", $alternateCurrent);
        $this->assertStringEndsWith("ul>", $alternateCurrent);
        $this->assertContains('<li class="active"><a href="/test-page?page=3" title="Page 3">3</a></li>', $pager);
        $this->assertEquals('<ul class="pagination"><li><a href="/test-page?" title="Page &laquo;">&laquo;</a></li><li><a href="/test-page?page=2" title="Page &lt;">&lt;</a></li><li><a href="/test-page?page=1" title="Page 1">1</a></li><li><a href="/test-page?page=2" title="Page 2">2</a></li><li class="active"><a href="/test-page?page=3" title="Page 3">3</a></li></ul>', $alternateCurrent);
    }
    
    /**
     * @covers Pager\Pagination::paging
     * @covers Pager\Pagination::buildLink
     * @covers Pager\Pagination::getPage
     * @covers Pager\Pagination::buildQueryString
     * @covers Pager\Pagination::getActiveClass
     * @covers Pager\Pagination::getPaginationClass
     * @covers Pager\Pagination::postLinks
     * @covers Pager\Pagination::preLinks
     */
    public function testNoPagerNeeded(){
        $this->assertFalse($this->pagination->paging(10, '/test-page'));
    }
    
    /**
     * @covers Pager\Pagination::paging
     * @covers Pager\Pagination::buildLink
     * @covers Pager\Pagination::getPage
     * @covers Pager\Pagination::buildQueryString
     * @covers Pager\Pagination::getActiveClass
     * @covers Pager\Pagination::getPaginationClass
     * @covers Pager\Pagination::postLinks
     * @covers Pager\Pagination::preLinks
     */
    public function testPagerArrows(){
        $this->markTestIncomplete('Test not yet implemented');
    }
    
    /**
     * @covers Pager\Pagination::paging
     * @covers Pager\Pagination::buildLink
     * @covers Pager\Pagination::getPage
     * @covers Pager\Pagination::buildQueryString
     * @covers Pager\Pagination::getActiveClass
     * @covers Pager\Pagination::getPaginationClass
     * @covers Pager\Pagination::postLinks
     * @covers Pager\Pagination::preLinks
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
     * @covers Pager\Pagination::setActiveClass
     * @covers Pager\Pagination::getActiveClass
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
