<?php
declare(strict_types=1);

namespace App\Test\TestCase\Form;

use App\Form\ContactUsForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\ContactUsForm Test Case
 */
class ContactUsFormTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Form\ContactUsForm
     */
    protected $ContactUs;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->ContactUs = new ContactUsForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ContactUs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Form\ContactUsForm::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
