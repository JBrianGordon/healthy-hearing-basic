<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\User;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\User Test Case
 */
class UserTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\User
     */
    protected $User;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->User = new User();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->User);

        parent::tearDown();
    }

    /**
     * @return void
     * @test
     * @testdox User full name is generated from first and last names
     */
    public function getFullNameReturnsConcatenatedFirstAndLastNames(): void
    {
        $this->User->first_name = 'Jane';
        $this->User->last_name = 'Smith';
        $fullName = $this->User->full_name;
        $this->assertEquals('Jane Smith', $fullName);
    }
}
