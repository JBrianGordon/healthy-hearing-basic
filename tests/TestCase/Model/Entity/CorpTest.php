<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Corp;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Corp Test Case
 */
class CorpTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\Corp
     */
    protected $Corp;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->Corp = new Corp();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Corp);

        parent::tearDown();
    }

    /**
     * @return void
     * @test
     * @testdox Accessing the hh_url field for a Corp entity returns a routing array to Corps::view with 'id' and 'slug' as passed params
     */
    public function getHhUrlReturnsRoutingArray(): void
    {
        $this->Corp->id = 1;
        $this->Corp->slug = "test slug";
        $hhUrl = $this->Corp->hh_url;
        $this->assertEquals(
            [
                'controller' => 'Corps',
                'action' => 'view',
                'slug' => "test slug",
            ],
            $hhUrl
        );
    }
}
