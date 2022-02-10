<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\DraftBehavior;
use Cake\ORM\Table;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\DraftBehavior Test Case
 */
class DraftBehaviorTest extends TestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Content'
    ];

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContentTable
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
        $this->Content = $this->getTableLocator()->get('Content');
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
     * Test that ModelTables have 'Draft' behavior
     *
     * @return void
     * @test
     * @testdox Test that ContentTable has 'Draft' behavior
     */
    public function contentTableHasDraftBehavior(): void
    {
        $this->assertTrue($this->Content->behaviors()->has('Draft'));
    }

    /**
     * Test checkForDraft() method
     *
     * @return void
     * @test
     * @testdox Test that checkForDraft() method works
     */
    public function canCheckForDraftContent(): void
    {
        $contentWithDraft = $this->Content->checkForDraft(1);
        $this->assertIsInt($contentWithDraft);
        $this->assertEquals(7, $contentWithDraft);

        $contentWithoutDraft = $this->Content->checkForDraft(2);
        $this->assertIsInt($contentWithoutDraft);
        $this->assertEquals(0, $contentWithoutDraft);
    }

    /**
     * Test copy() method
     *
     * @return void
     * @test
     * @testdox Test that copy() method works
     */
    public function canCopyAndCreateContentDraft(): void
    {
        $result = $this->Content->copy(1);
        $this->assertInstanceOf('Cake\Datasource\EntityInterface', $result);
        $this->assertEquals(9, $result->id);
        $this->assertEquals(0, $result->is_active);
        $this->assertEquals(1, $result->id_draft_parent);
    }

    /**
     *
     * @return void
     * @test
     * @testdox Test that publish method returns true after draft is published
     */
    public function publishReturnsTrueWhenSuccessful(): void
    {
        $this->assertEquals(true, $this->Content->publish(7));
    }

    /**
     *
     * @return void
     * @test
     * @testdox Test that publish method returns FALSE after draft is published
     */
    public function publishReturnsFalseWhenValidation(): void
    {
        $this->assertEquals(false, $this->Content->publish(8));
    }


    /**
     *
     * @return void
     * @test
     * @testdox Publish method decreases total Content count by one item
     */
    public function publishDecreasesContentCountByOne(): void
    {
        $this->Content->publish(7);
        $this->assertEquals(
            7,
            $this->Content->find()->all()->count()
        );
    }

    /**
     *
     * @return void
     * @test
     * @testdox Publish method replaces original Content with draft properties - title is updated
     */
    public function publishReplacesOriginalContentWithDraftCheckTitle(): void
    {
        $this->Content->publish(7);
        $this->assertEquals(
            'This is draft content',
            $this->Content->get(1)->title
        );
    }

    /**
     *
     * @return void
     * @test
     * @testdox Publish method replaces original Content with draft properties - last_modified is updated
     */
    public function publishReplacesOriginalContentWithDraftCheckLastModified(): void
    {
        $this->Content->publish(7);
        $this->assertEquals(
            'Apr 3, 2022, 1:14 PM',
            $this->Content->get(1)->last_modified->nice()
        );
    }

    /**
     *
     * @return void
     * @test
     * @testdox Publish method replaces original Content with draft properties - id_draft_parent is 0
     */
    public function publishReplacesOriginalContentWithDraftCheckIdDraftParent(): void
    {
        $this->Content->publish(7);
        $this->assertEquals(
            0,
            $this->Content->get(1)->id_draft_parent
        );
    }


}
