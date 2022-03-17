<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

/**
 * Editorial helper
 */
class EditorialHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Return array of authors/contributors
     *
     * @param \App\Model\Entity\User $primaryAuthor First author
     * @param \App\Model\Entity\User[] $contributors Contributors
     * @return array Author(s) of item
     */
    public function getAuthorsArray($primaryAuthor, $contributors)
    {
        $contributors = $contributors ?? [];

        return array_merge(
            [$primaryAuthor],
            is_array($contributors) ? $contributors : [$contributors]
        );
    }

    /**
     * Return author information for bylines as a formatted string
     *
     * @param \App\Model\Entity\User $primaryAuthor First author
     * @param \App\Model\Entity\User[] $contributors Contributors
     * @return string Imploded list of authors beginning with 'Contributed by' and joined by ' and '
     */
    public function getAuthorsByline($primaryAuthor, $contributors)
    {
        $authors = $this->getAuthorsArray($primaryAuthor, $contributors);

        $authorsInfo = array_column($authors, 'full_personal_info');

        return 'Contributed by ' . implode(' and ', $authorsInfo);
    }
}
