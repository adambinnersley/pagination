<?php
namespace Pager\Tests;

use Pager\Pagination;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
    
    protected $pagination;
    
    public function setUp(): void
    {
        $this->pagination = new Pagination();
    }
    
    public function tearDown(): void
    {
        unset($this->pagination);
    }
    
    /**
     * @covers Pager\Pagination::paging
     * @covers Pager\Pagination::buildLink
     * @covers Pager\Pagination::getPage
     * @covers Pager\Pagination::buildQueryString
     * @covers Pager\Pagination::getLiActiveClass
     * @covers Pager\Pagination::getPaginationClass
     * @covers Pager\Pagination::getAActiveClass
     * @covers Pager\Pagination::getAClass
     * @covers Pager\Pagination::getLiClass
     * @covers Pager\Pagination::postLinks
     * @covers Pager\Pagination::preLinks
     * @covers Pager\Pagination::setAActiveClass
     * @covers Pager\Pagination::setAClass
     * @covers Pager\Pagination::setLiClass
     * @covers Pager\Pagination::setPaginationClass
     */
    public function testCreatePager()
    {
        $pager = $this->pagination->setAClass('')->setLiClass('')->setPaginationClass('pagination')->paging(106, '/test-page');
        $this->assertStringStartsWith("<ul", $pager);
        $this->assertStringEndsWith("ul>", $pager);
        $this->assertStringContainsString('<li class="active"><a href="/test-page?page=1" title="Page 1">1</a></li>', $pager);
        $this->assertEquals('<ul class="pagination"><li class="active"><a href="/test-page?page=1" title="Page 1">1</a></li><li><a href="/test-page?page=2" title="Page 2">2</a></li><li><a href="/test-page?page=3" title="Page 3">3</a></li><li><a href="/test-page?page=2" title="Page &gt;">&gt;</a></li><li><a href="/test-page?page=3" title="Page &raquo;">&raquo;</a></li></ul>', $pager);
        
        $alternateCurrent = $this->pagination->setAClass('')->setLiClass('')->setAActiveClass('newactive')->setPaginationClass('pagination')->paging(106, '/test-page', 3);
        $this->assertStringStartsWith("<ul", $alternateCurrent);
        $this->assertStringEndsWith("ul>", $alternateCurrent);
        $this->assertStringContainsString('<li class="active"><a href="/test-page?page=3" title="Page 3" class="newactive">3</a></li>', $alternateCurrent);
        $this->assertEquals('<ul class="pagination"><li><a href="/test-page" title="Page &laquo;">&laquo;</a></li><li><a href="/test-page?page=2" title="Page &lt;">&lt;</a></li><li><a href="/test-page?page=1" title="Page 1">1</a></li><li><a href="/test-page?page=2" title="Page 2">2</a></li><li class="active"><a href="/test-page?page=3" title="Page 3" class="newactive">3</a></li></ul>', $alternateCurrent);
        
        $maxLinks = $this->pagination->paging(2506, '/test-page', 0, 50, 11, true);
        $this->assertStringContainsString('Page 11', $maxLinks);
        $this->assertStringNotContainsString('Page 12', $maxLinks);
        
        $maxLinksDiff = $this->pagination->paging(2506, '/test-page', 8, 50, 11, true);
        $this->assertStringContainsString('Page 12', $maxLinksDiff);
        $this->assertStringContainsString('&gt;', $maxLinksDiff);
        $this->assertStringContainsString('&lt;', $maxLinksDiff);
        $this->assertStringContainsString('&raquo;', $maxLinksDiff);
        $this->assertStringContainsString('&laquo;', $maxLinksDiff);
    }
    
    /**
     * @covers Pager\Pagination::paging
     * @covers Pager\Pagination::buildLink
     * @covers Pager\Pagination::getPage
     * @covers Pager\Pagination::buildQueryString
     * @covers Pager\Pagination::getLiActiveClass
     * @covers Pager\Pagination::getPaginationClass
     * @covers Pager\Pagination::postLinks
     * @covers Pager\Pagination::preLinks
     */
    public function testNoPagerNeeded()
    {
        $this->assertFalse($this->pagination->paging(10, '/test-page'));
    }
    
    /**
     * @covers Pager\Pagination::paging
     * @covers Pager\Pagination::buildLink
     * @covers Pager\Pagination::getPage
     * @covers Pager\Pagination::buildQueryString
     * @covers Pager\Pagination::getLiActiveClass
     * @covers Pager\Pagination::getPaginationClass
     * @covers Pager\Pagination::getAActiveClass
     * @covers Pager\Pagination::getAClass
     * @covers Pager\Pagination::getLiClass
     * @covers Pager\Pagination::postLinks
     * @covers Pager\Pagination::preLinks
     */
    public function testPagerArrows()
    {
        $pager = $this->pagination->paging(320, '/test-page', 3, 50, 11, true);
        $this->assertStringContainsString('&lt;', $pager);
        $this->assertStringContainsString('&gt;', $pager);
        
        $pagerNoArrows = $this->pagination->paging(320, '/test-page', 3, 50, 11, false);
        $this->assertStringNotContainsString('&lt;', $pagerNoArrows);
        $this->assertStringNotContainsString('&gt;', $pagerNoArrows);
    }
    
    /**
     * @covers Pager\Pagination::paging
     * @covers Pager\Pagination::buildLink
     * @covers Pager\Pagination::getPage
     * @covers Pager\Pagination::buildQueryString
     * @covers Pager\Pagination::getLiActiveClass
     * @covers Pager\Pagination::getPaginationClass
     * @covers Pager\Pagination::getAActiveClass
     * @covers Pager\Pagination::getAClass
     * @covers Pager\Pagination::getLiClass
     * @covers Pager\Pagination::postLinks
     * @covers Pager\Pagination::preLinks
     */
    public function testPagerWithQueryString()
    {
        $this->assertStringContainsString('/test-page?page=1&amp;search=dave&amp;age=45', $this->pagination->paging(100, '/test-page', 0, 50, 11, true, array('search' => 'dave', 'age' => '45')));
    }
    
    /**
     * @covers Pager\Pagination::setPaginationClass
     * @covers Pager\Pagination::getPaginationClass
     */
    public function testSetPagerClass()
    {
        $this->assertEquals('pagination justify-content-center', $this->pagination->getPaginationClass());
        $this->pagination->setPaginationClass('my-class');
        $this->assertNotEquals('pagination justify-content-center', $this->pagination->getPaginationClass());
        $this->assertEquals('my-class', $this->pagination->getPaginationClass());
        $this->pagination->setPaginationClass('paginationclass6');
        $this->assertEquals('paginationclass6', $this->pagination->getPaginationClass());
    }
    
    /**
     * @covers Pager\Pagination::setLiActiveClass
     * @covers Pager\Pagination::getLiActiveClass
     */
    public function testSetActiveClass()
    {
        $this->assertEquals('active', $this->pagination->getLiActiveClass());
        $this->pagination->setLiActiveClass('current');
        $this->assertNotEquals('active', $this->pagination->getLiActiveClass());
        $this->assertEquals('current', $this->pagination->getLiActiveClass());
        $this->pagination->setLiActiveClass('current active-class');
        $this->assertEquals('current active-class', $this->pagination->getLiActiveClass());
    }
}
