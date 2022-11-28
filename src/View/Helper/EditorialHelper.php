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
    
    public function getAuthorsBio($primaryAuthor, $contributors)
    {
	    
	    $authors = $this->getAuthorsArray($primaryAuthor, $contributors);
	    
	    $bioBlock = '';
	    
	    $authorName = array_column($authors, 'full_name')[0];
	    
	    $anchorName = strtolower(str_replace($authorName, '-', ' '));
	    
	    $bioBlock .= '<a class="anchor" name="about-author-' . $anchorName . '"></a>';
	    
	    $bioBlock .= '<h3>';
	    
	    $bioBlock .= '<span>' . $authorName . '</span>, <span>' . array_column($authors, 'title_dept_company')[0] . '</span>, <span>' . array_column($authors, 'company')[0] . '</span></h3>';
	    
	    $bioBlock .= '<p class="bio"><img loading="lazy" src="' .  array_column($authors, 'image_url')[0] .'" alt="' . $authorName . '" class="about-team float-start" width="80" height="100" />' . strip_tags(array_column($authors, 'bio')[0]) . '<a href="' . array_column($authors, 'url')[0] . ' itemprop="url">Read more about ' . array_column($authors, 'first_name')[0] . '</a></p></div>';

        return $bioBlock;
    }
}
