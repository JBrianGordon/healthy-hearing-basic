<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Wiki;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Wiki Test Case
 */
class WikiTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\Wiki
     */
    protected $Wiki;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->Wiki = new Wiki();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Wiki);

        parent::tearDown();
    }

    /**
     * @return void
     * @test
     * @testdox Accessing the hh_url field for a Wiki entity returns a routing array to Wikis::view with 'id' and 'slug' as passed params
     */
    public function getHhUrlReturnsRoutingArray(): void
    {
        $this->Wiki->id = 1;
        $this->Wiki->slug = "test slug";
        $hhUrl = $this->Wiki->hh_url;
        $this->assertEquals(
            [
                'controller' => 'Wikis',
                'action' => 'view',
                'slug' => "test slug",
            ],
            $hhUrl
        );
    }
}
