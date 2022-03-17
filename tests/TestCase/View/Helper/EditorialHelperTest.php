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
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Content',
        'app.Users',
        'app.ContentUsers',
    ];

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

    /**
     * @return void
     * @test
     * @testdox getAuthorsArray can return single-author array
     */
    public function getAuthorsArrayForSingleAuthor(): void
    {
        $this->Content = $this->getTableLocator()->get('Content');
        $content = $this->Content->get(2, [
            'contain' => ['PrimaryAuthor', 'Contributors'],
        ]);

        $this->Users = $this->getTableLocator()->get('Users');
        $primaryAuthor = $this->Users->get(1);

        $testAuthorsArray = $this->Editorial->getAuthorsArray($content->primary_author, $content->contributors);
        $targetAuthorsArray = [$primaryAuthor];

        $this->assertCount(1, $testAuthorsArray);
        $this->assertSame($testAuthorsArray[0]['full_personal_info'], $targetAuthorsArray[0]['full_personal_info']);
    }

    /**
     * @return void
     * @test
     * @testdox getAuthorsArray can return multiple-author array
     */
    public function getAuthorsArrayForMultipleAuthors(): void
    {
        $this->Content = $this->getTableLocator()->get('Content');
        $content = $this->Content->get(1, [
            'contain' => ['PrimaryAuthor', 'Contributors'],
        ]);

        $this->Users = $this->getTableLocator()->get('Users');
        $primaryAuthor = $this->Users->get(1);
        $contributor = $this->Users->get(2);

        $testAuthorsArray = $this->Editorial->getAuthorsArray($content->primary_author, $content->contributors);
        $targetAuthorsArray = [$primaryAuthor, $contributor];

        $this->assertCount(2, $testAuthorsArray);
        $this->assertSame($testAuthorsArray[0]['full_personal_info'], $targetAuthorsArray[0]['full_personal_info']);
        $this->assertSame($testAuthorsArray[1]['full_personal_info'], $targetAuthorsArray[1]['full_personal_info']);
    }

    /**
     * @return void
     * @test
     * @testdox getAuthorsByline can generate single-author byline
     */
    public function getAuthorsBylineReturnsSingleAuthor(): void
    {
        $this->Content = $this->getTableLocator()->get('Content');
        $content = $this->Content->get(2, [
            'contain' => ['PrimaryAuthor', 'Contributors'],
        ]);
        $testAuthorByline = $this->Editorial->getAuthorsByline($content->primary_author, $content->contributors);
        $desiredAuthorByline = 'Contributed by Jane Smith, PhD, Writer of things, Healthy Hearing';
        $this->assertSame($desiredAuthorByline, $testAuthorByline);
    }

    /**
     * @return void
     * @test
     * @testdox getAuthorsByline can generate multiple-author byline
     */
    public function getAuthorsBylineReturnsMultipleAuthors(): void
    {
        $this->Content = $this->getTableLocator()->get('Content');
        $content = $this->Content->get(1, [
            'contain' => ['PrimaryAuthor', 'Contributors'],
        ]);
        $testAuthorByline = $this->Editorial->getAuthorsByline($content->primary_author, $content->contributors);
        $desiredAuthorByline = 'Contributed by Jane Smith, PhD, Writer of things, Healthy Hearing and John Smith, MS, CRED, Computer wrangler';
        $this->assertSame($desiredAuthorByline, $testAuthorByline);
    }
}
