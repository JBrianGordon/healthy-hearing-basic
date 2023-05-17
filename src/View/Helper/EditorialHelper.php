<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;

/**
 * Editorial helper
 */
class EditorialHelper extends Helper
{
    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    protected $helpers = ['Html'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function initialize(array $config): void
    {
        $this->ContentTable = TableRegistry::getTableLocator()->get('Content');
    }

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
        foreach ($contributors as $key => $contributor) {
            if ($contributor->id == $primaryAuthor->id) {
                // In case we accidentally mark the primary author as a contributor as well,
                // we only want to display them once.
                unset($contributors[$key]);
            }
        }
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
    public function getReviewersByline($reviewers)
    {
        $reviewerBylines = [];
        foreach ($reviewers as $reviewer) {
            $reviewerByline = '<a class="text-link" data-toggle="popover" data-trigger="hover" data-content="'.$reviewer->short_bio.'">'.$reviewer->full_name.'</a>';
            $fields = ['degrees', 'credentials', 'title_dept_company', 'company'];
            $additionalReviewerInfo = '';
            foreach ($fields as $field) {
                if (!empty($reviewer->$field)) {
                    $additionalReviewerInfo .= ', '.$reviewer->$field;
                }
            }
            $reviewerByline .= $additionalReviewerInfo;
            if (!empty($reviewerByline)) {
                $reviewerBylines[] = $reviewerByline;
            }
        }
        if (empty($reviewerBylines)) {
            return '';
        }
        return '<br><span><img src="/img/checked.png" alt="check mark" class="mr5" style="width:12px;position:relative;bottom:1px;"> Reviewed by '.implode(' and ', $reviewerBylines).'</span>';
    }

    /**
     * Return author information for bylines as a formatted string
     *
     * @param \App\Model\Entity\User $primaryAuthor First author
     * @param \App\Model\Entity\User[] $contributors Contributors
     * @param string $leadingText
     * @return string Imploded list of authors beginning with 'Contributed by' and joined by ' and '
     */
    public function getAuthorsByline($primaryAuthor, $contributors, $leadingText='Contributed by')
    {
        $authors = $this->getAuthorsArray($primaryAuthor, $contributors);
        $authorBylines = [];
        foreach ($authors as $author) {
            $authorByline = $this->getAuthorByline($author);
            if (!empty($authorByline)) {
                $authorBylines[] = $authorByline;
            }
        }
        if (empty($authorBylines)) {
            return '';
        }
        return $leadingText.' '.implode(' and ', $authorBylines);
    }

    /**
     * Return author information for bylines as a formatted string
     *
     * @param \App\Model\Entity\User $primaryAuthor First author
     * @param \App\Model\Entity\User[] $contributors Contributors
     * @return string Imploded list of authors beginning with 'Contributed by' and joined by ' and '
     */
    public function getAuthorByline($author)
    {
        if (empty($author->full_name)) {
            return '';
        }
        $anchorName = strtolower(str_replace(' ', '-', $author->full_name));
        $fields = ['degrees', 'credentials', 'title_dept_company', 'company'];
        $additionalAuthorInfo = '';
        foreach ($fields as $field) {
            if (!empty($author->$field)) {
                $additionalAuthorInfo .= ', '.$author->$field;
            }
        }
        return '<a href="#about-author-' . $anchorName . '">'.$author->full_name.'</a>'.$additionalAuthorInfo;
    }

    public function getAuthorsBio($primaryAuthor, $contributors)
    {
        $authors = $this->getAuthorsArray($primaryAuthor, $contributors);
        $bioBlock = '';
        foreach ($authors as $author) {
            $authorName = $author->full_name;
            $anchorName = strtolower(str_replace(' ', '-', $authorName));

            $bioBlock .= '<div class="about-author-bio">';
            $bioBlock .= '<a class="anchor" name="about-author-' . $anchorName . '"></a>';
            $bioBlock .= '<h3>'.$author->full_personal_info.'</h3>';
            $bioBlock .= '<p class="bio"><img loading="lazy" src="' .  $author->image_url .'" alt="' . $authorName . '" class="about-team float-start" width="80" height="100" />';
            $bioBlock .= strip_tags($author->bio);
            if (!empty($author->url)) {
                $bioBlock .= '<a href="' . $author->url . ' itemprop="url">Read more about ' . $author->first_name . '</a>';
            }
            $bioBlock .= '</p><div class="clearfix"></div></div>';
        }
        return $bioBlock;
    }

    public function image($content = null) {
        if (!is_object($content)) {
            $content = $this->ContentTable->get($content);
        }
        if ($image = $content->facebook_image) {
            $imageAlt = $content->facebook_image_alt ? $content->facebook_image_alt : 'An article image';
            return $this->Html->link('<img src="' . $image . '" width="340" height="260" loading="lazy" class="img-responsive" alt="' . $imageAlt .'">', $content->hh_url, ['escape' => false]);
        }
        return null;
    }

    public function adminLink($contentId, $isAdmin) {
        if (is_object($contentId)) {
            $contentId = $contentId->id;
        }
        return $this->Html->link('Edit', ['prefix' => 'Admin', 'controller' => 'content', 'action' => 'edit', $contentId], ['class' => 'btn btn-inverse']);
    }

    public function displayDate($content) {
        if (!is_object($content)) {
            $content = $this->ContentTable->get($content);
        }
        $createdDate = date('F j, Y', $content->created->timestamp);
        $modifiedDate = date('F j, Y', $content->last_modified->timestamp);
        $isoFormatDate = date('c', $content->last_modified->timestamp);
        $retval = '<span>';
        if ($createdDate != $modifiedDate) {
            $retval .= 'Last updated ';
        }
        $retval .= '<time datetime="' . $isoFormatDate . '">' . $modifiedDate . '</time></span>';
        $retval .= '<span style="display:none" itemprop="dateModified">'. $isoFormatDate .'</span>';
        return $retval;
    }
}
