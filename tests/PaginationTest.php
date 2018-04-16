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
        $this->assertStringStartsWith("<nav><ul", $pager);
        $this->assertStringEndsWith("ul></nav>", $pager);
        $this->assertContains('<li class="active page-item"><a href="/test-page?page=1" class="page-link" title="Page 1">1</a></li>', $pager);
        $this->assertEquals('<nav><ul class="pagination"><li class="active page-item"><a href="/test-page?page=1" class="page-link" title="Page 1">1</a></li><li class="page-item"><a href="/test-page?page=2" class="page-link" title="Page 2">2</a></li><li class="page-item"><a href="/test-page?page=3" class="page-link" title="Page 3">3</a></li><li class="page-item"><a href="/test-page?page=2" class="page-link" title="Page &gt;">&gt;</a></li><li class="page-item"><a href="/test-page?page=3" class="page-link" title="Page &raquo;">&raquo;</a></li></ul></nav>', $pager);
        
        $alternateCurrent = $this->pagination->paging(106, '/test-page', 3);
        $this->assertStringStartsWith("<nav><ul", $alternateCurrent);
        $this->assertStringEndsWith("ul></nav>", $alternateCurrent);
        $this->assertContains('<li class="active page-item"><a href="/test-page?page=3" class="page-link" title="Page 3">3</a></li>', $alternateCurrent);
        $this->assertEquals('<nav><ul class="pagination"><li class="page-item"><a href="/test-page?" class="page-link" title="Page &laquo;">&laquo;</a></li><li class="page-item"><a href="/test-page?page=2" class="page-link" title="Page &lt;">&lt;</a></li><li class="page-item"><a href="/test-page?page=1" class="page-link" title="Page 1">1</a></li><li class="page-item"><a href="/test-page?page=2" class="page-link" title="Page 2">2</a></li><li class="active page-item"><a href="/test-page?page=3" class="page-link" title="Page 3">3</a></li></ul></nav>', $alternateCurrent);
        
        $maxLinks = $this->pagination->paging(2506, '/test-page', 0, 50, 11, true);
        $this->assertContains('Page 11', $maxLinks);
        $this->assertNotContains('Page 12', $maxLinks);
        
        $maxLinksDiff = $this->pagination->paging(2506, '/test-page', 8, 50, 11, true);
        $this->assertContains('Page 12', $maxLinksDiff);
        $this->assertContains('&gt;', $maxLinksDiff);
        $this->assertContains('&lt;', $maxLinksDiff);
        $this->assertContains('&raquo;', $maxLinksDiff);
        $this->assertContains('&laquo;', $maxLinksDiff);
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
        $pager = $this->pagination->paging(320, '/test-page', 3, 50, 11, true);
        $this->assertContains('&lt;', $pager);
        $this->assertContains('&gt;', $pager);
        
        $pagerNoArrows = $this->pagination->paging(320, '/test-page', 3, 50, 11, false);
        $this->assertNotContains('&lt;', $pagerNoArrows);
        $this->assertNotContains('&gt;', $pagerNoArrows);
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
        $this->assertContains('/test-page?search=dave&amp;age=45&amp;page=1', $this->pagination->paging(100, '/test-page', 0, 50, 11, true, array('search' => 'dave', 'age' => '45')));
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
