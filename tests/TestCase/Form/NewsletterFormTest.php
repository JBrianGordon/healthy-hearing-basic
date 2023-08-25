<?php
declare(strict_types=1);

namespace App\Test\TestCase\Form;

use App\Form\NewsletterForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\NewsletterForm Test Case
 */
class NewsletterFormTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Form\NewsletterForm
     */
    protected $Newsletter;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->Newsletter = new NewsletterForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Newsletter);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Form\NewsletterForm::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
