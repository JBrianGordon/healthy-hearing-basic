<?php
declare(strict_types=1);

namespace Sitemap\Test\TestCase\Model\Behavior;

use Cake\ORM\Table;
use Cake\TestSuite\TestCase;
use Sitemap\Model\Behavior\SitemapBehavior;

/**
 * Sitemap\Model\Behavior\SitemapBehavior Test Case
 */
class SitemapBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Sitemap\Model\Behavior\SitemapBehavior
     */
    protected $Sitemap;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $table = new Table();
        $this->Sitemap = new SitemapBehavior($table);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Sitemap);

        parent::tearDown();
    }
}
