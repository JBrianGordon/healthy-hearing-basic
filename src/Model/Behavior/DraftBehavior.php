<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;

/**
 * Draft behavior
 */
class DraftBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Check for existing draft item
     *
     * @param int $id Primary key/id
     * @return int ID of existing draft or 0 for non-existing draft
     */
    public function checkForDraft(int $id): int
    {
        $draftQuery = $this->_table->find('all', [
            'conditions' => ['id_draft_parent' => $id],
            'fields' => ['id'],
        ]);
        $draft = $draftQuery->first();
        if (is_null($draft)) {
            return 0;
        }

        return $draft->id;
    }

    /**
     * Copy method
     *
     * @param int $id Model entity id.
     * @return \Cake\Datasource\EntityInterface|false
     */
    public function copy(int $id)
    {
        $draft = $this->_table->duplicate($id);
        // DuplicatableBehavior unsets original entity ID so we set it here
        $draft->id_draft_parent = $id;

        return $this->_table->save($draft);
    }

    /**
     * FindPublishableItems method
     *
     * @param \Cake\ORM\Query $query The Query object to be modified
     * @param array $options List of options to pass to the finder
     * @return \Cake\ORM\Query Modified Query object
     */
    public function findPublishableItems(Query $query, array $options): Query
    {
        return $query
            ->where([
                'id_draft_parent >' => 0,
                'is_active' => 1,
                'last_modified < NOW()',
            ]);
    }

    /**
     * Publish method
     *
     * @param int $draftId Model draft id.
     * @return bool
     */
    public function publish(int $draftId): bool
    {
        $draftItem = $this->_table->get($draftId);
        $draftItemId = $draftItem->id;
        $draftItemArray = $draftItem->toArray();

        $originalItem = $this->_table->get($draftItem->id_draft_parent);

        // Unset fields that we don't want to update in the original
        unset($draftItemArray['id']);
        unset($draftItemArray['is_active']);
        unset($draftItemArray['id_draft_parent']);

        $updatedArticle = $this->_table->patchEntity($originalItem, $draftItemArray);
        if ($updatedArticle->getErrors()) {
            return false;
        }

        $this->_table->save($updatedArticle);
        $this->_table->delete($draftItem);

        return true;
    }
}
