<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\EditorialHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\EditorialHelper Test Case
 */
class EditorialHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\EditorialHelper
     */
    protected $Editorial;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->Editorial = new EditorialHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Editorial);

        parent::tearDown();
    }
}
