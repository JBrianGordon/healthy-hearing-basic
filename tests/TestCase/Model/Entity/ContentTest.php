<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Content;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Content Test Case
 */
class ContentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\Content
     */
    protected $Content;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->Content = new Content();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Content);

        parent::tearDown();
    }

    /**
     * @return void
     * @test
     * @testdox Accessing the hh_url field for a Content entity returns a routing array to Content::report_view with 'id' and 'slug' as passed params
     */
    public function getHhUrlReturnsRoutingArray(): void
    {
        $this->Content->id = 1;
        $this->Content->slug = "test slug";
        $hhUrl = $this->Content->hh_url;
        $this->assertEquals(
            [
                'controller' => 'Content',
                'action' => 'view',
                'id' => 1,
                'slug' => "test slug",
            ],
            $hhUrl
        );
    }
}
