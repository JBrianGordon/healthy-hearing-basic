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
        'app.Content',
        'app.Corps',
        'app.Wikis'
    ];

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContentTable
     * @var \App\Model\Table\CorpsTable
     * @var \App\Model\Table\WikisTable
     */
    protected $Content;
    protected $Corps;
    protected $Wikis;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->Content = $this->getTableLocator()->get('Content');
        $this->Corps = $this->getTableLocator()->get('Corps');
        $this->Wikis = $this->getTableLocator()->get('Wikis');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Content);
        unset($this->Wikis);
        parent::tearDown();
    }

    //--------- Content Table Draft Behavior tests ---------/

    /**
     * Test that ModelTables have 'Draft' behavior
     *
     * @return void
     * @test
     * @testdox ContentTable has 'Draft' behavior
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
     * @testdox ContentTable checkForDraft() method works
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
     * @testdox ContentTable copy() method works
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
     * @testdox ContentTable publish method returns true after draft is published
     */
    public function contentPublishReturnsTrueWhenSuccessful(): void
    {
        $this->assertEquals(true, $this->Content->publish(7));
    }

    /**
     *
     * @return void
     * @test
     * @testdox ContentTable publish method returns FALSE when non-validating draft is published
     */
    public function contentPublishReturnsFalseWhenValidationFails(): void
    {
        $this->assertEquals(false, $this->Content->publish(8));
    }

    /**
     *
     * @return void
     * @test
     * @testdox ContentTable publish method decreases total Content count by one item
     */
    public function contentPublishDecreasesCountByOne(): void
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
     * @testdox ContentTable publish method replaces original Content with draft properties - title is updated
     */
    public function contentPublishReplacesOriginalWithDraftCheckTitle(): void
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
     * @testdox ContentTable publish method replaces original Content with draft properties - last_modified is updated
     */
    public function contentPublishReplacesOriginalWithDraftCheckLastModified(): void
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
     * @testdox ContentTable publish method replaces original Content with draft properties - id_draft_parent is 0
     */
    public function contentPublishReplacesOriginalWithDraftCheckIdDraftParent(): void
    {
        $this->Content->publish(7);
        $this->assertEquals(
            0,
            $this->Content->get(1)->id_draft_parent
        );
    }

    //--------- Wikis Table Draft Behavior tests ---------/
    /**
     * Test that WikisTable has 'Draft' behavior
     *
     * @return void
     * @test
     * @testdox WikisTable has 'Draft' behavior
     */
    public function wikisTableHasDraftBehavior(): void
    {
        $this->assertTrue($this->Wikis->behaviors()->has('Draft'));
    }

    /**
     * Test checkForDraft() method
     *
     * @return void
     * @test
     * @testdox WikisTable checkForDraft() method works
     */
    public function canCheckForDraftWiki(): void
    {
        $wikiWithDraft = $this->Wikis->checkForDraft(1);
        $this->assertIsInt($wikiWithDraft);
        $this->assertEquals(4, $wikiWithDraft);

        $wikiWithoutDraft = $this->Wikis->checkForDraft(3);
        $this->assertIsInt($wikiWithoutDraft);
        $this->assertEquals(0, $wikiWithoutDraft);
    }

    /**
     * Test copy() method
     *
     * @return void
     * @test
     * @testdox WikisTable copy() method works
     */
    public function canCopyAndCreateWikiDraft(): void
    {
        $result = $this->Wikis->copy(2);
        $this->assertInstanceOf('Cake\Datasource\EntityInterface', $result);
        $this->assertEquals(6, $result->id);
        $this->assertEquals(0, $result->is_active);
        $this->assertEquals(2, $result->id_draft_parent);
    }

    /**
     *
     * @return void
     * @test
     * @testdox WikisTable publish method returns true after draft is published
     */
    public function wikiPublishReturnsTrueWhenSuccessful(): void
    {
        $this->assertEquals(true, $this->Wikis->publish(4));
    }

    /**
     *
     * @return void
     * @test
     * @testdox WikisTable publish method returns FALSE when non-validating draft is published
     */
    public function wikiPublishReturnsFalseWhenValidationFails(): void
    {
        $this->assertEquals(false, $this->Wikis->publish(5));
    }

    /**
     *
     * @return void
     * @test
     * @testdox WikisTable publish method decreases total Wiki count by one item
     */
    public function wikiPublishDecreasesCountByOne(): void
    {
        $this->Wikis->publish(4);
        $this->assertEquals(
            4,
            $this->Wikis->find()->all()->count()
        );
    }

    /**
     *
     * @return void
     * @test
     * @testdox WikisTable publish method replaces original Wiki with draft properties - title_head is updated
     */
    public function wikiPublishReplacesOriginalWithDraftCheckTitleHead(): void
    {
        $this->Wikis->publish(4);
        $this->assertEquals(
            'This is the draft wiki',
            $this->Wikis->get(1)->title_head
        );
    }

    /**
     *
     * @return void
     * @test
     * @testdox WikisTable publish method replaces original Wiki with draft properties - last_modified is updated
     */
    public function wikiPublishReplacesOriginalWithDraftCheckLastModified(): void
    {
        $this->Wikis->publish(4);
        $this->assertEquals(
            'Apr 3, 2022, 1:14 PM',
            $this->Wikis->get(1)->last_modified->nice()
        );
    }

    /**
     *
     * @return void
     * @test
     * @testdox WikisTable publish method replaces original Wiki with draft properties - id_draft_parent is 0
     */
    public function wikiPublishReplacesOriginalWithDraftCheckIdDraftParent(): void
    {
        $this->Wikis->publish(4);
        $this->assertEquals(
            0,
            $this->Wikis->get(1)->id_draft_parent
        );
    }

    //--------- Corps Table Draft Behavior tests ---------/
    /**
     * Test that CorpsTable has 'Draft' behavior
     *
     * @return void
     * @test
     * @testdox CorpsTable has 'Draft' behavior
     */
    public function corpsTableHasDraftBehavior(): void
    {
        $this->assertTrue($this->Corps->behaviors()->has('Draft'));
    }

    /**
     * Test checkForDraft() method
     *
     * @return void
     * @test
     * @testdox CorpsTable checkForDraft() method works
     */
    public function canCheckForDraftCorp(): void
    {
        $corpWithDraft = $this->Corps->checkForDraft(1);
        $this->assertIsInt($corpWithDraft);
        $this->assertEquals(4, $corpWithDraft);

        $corpWithoutDraft = $this->Corps->checkForDraft(3);
        $this->assertIsInt($corpWithoutDraft);
        $this->assertEquals(0, $corpWithoutDraft);
    }

    /**
     * Test copy() method
     *
     * @return void
     * @test
     * @testdox CorpsTable copy() method works
     */
    public function canCopyAndCreateCorpDraft(): void
    {
        $result = $this->Corps->copy(2);
        $this->assertInstanceOf('Cake\Datasource\EntityInterface', $result);
        $this->assertEquals(6, $result->id);
        $this->assertEquals(0, $result->is_active);
        $this->assertEquals(2, $result->id_draft_parent);
    }

    /**
     *
     * @return void
     * @test
     * @testdox CorpsTable publish method returns true after draft is published
     */
    public function corpPublishReturnsTrueWhenSuccessful(): void
    {
        $this->assertEquals(true, $this->Corps->publish(4));
    }

    /**
     *
     * @return void
     * @test
     * @testdox CorpsTable publish method returns FALSE when non-validating draft is published
     */
    public function corpPublishReturnsFalseWhenValidationFails(): void
    {
        $this->assertEquals(false, $this->Corps->publish(5));
    }

    /**
     *
     * @return void
     * @test
     * @testdox CorpsTable publish method decreases total Corp count by one item
     */
    public function corpPublishDecreasesCountByOne(): void
    {
        $this->Corps->publish(4);
        $this->assertEquals(
            4,
            $this->Corps->find()->all()->count()
        );
    }

    /**
     *
     * @return void
     * @test
     * @testdox CorpsTable publish method replaces original Corp with draft properties - title is updated
     */
    public function corpPublishReplacesOriginalWithDraftCheckTitle(): void
    {
        $this->Corps->publish(4);
        $this->assertEquals(
            'Corp 1 - DRAFT',
            $this->Corps->get(1)->title
        );
    }

    /**
     *
     * @return void
     * @test
     * @testdox CorpsTable publish method replaces original Corp with draft properties - last_modified is updated
     */
    public function corpPublishReplacesOriginalWithDraftCheckLastModified(): void
    {
        $this->Corps->publish(4);
        $this->assertEquals(
            'Apr 3, 2022, 1:14 PM',
            $this->Corps->get(1)->last_modified->nice()
        );
    }

    /**
     *
     * @return void
     * @test
     * @testdox CorpsTable publish method replaces original Corp with draft properties - id_draft_parent is 0
     */
    public function corpPublishReplacesOriginalWithDraftCheckIdDraftParent(): void
    {
        $this->Corps->publish(4);
        $this->assertEquals(
            0,
            $this->Corps->get(1)->id_draft_parent
        );
    }
}
