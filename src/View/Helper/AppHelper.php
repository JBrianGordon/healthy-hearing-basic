<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

/**
 * Admin helper
 */
class AppHelper extends Helper
{
    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    protected $helpers = ['Identity', 'Html'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function isMobileDevice() { 
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]); 
    }

    public function splitBy($array = array(), $by = 2) {
        if (is_object($array)) {
            $array = json_decode(json_encode($array), true);
        }
        if (empty($array)) {
            $retval = array();
            for ($i = 0; $i < count($by); $i++) {
                $retval[$i] = array();
            }
            return $retval;
        }
        $length = (int)ceil(count($array)/$by);
        return array_chunk($array, $length, true);
    }

    /**
    * Author line with optional schema
    */
    public function author($data, $options = []) {
        $author = isset($data->author) ? $data->author : null;
        $contributors = isset($data->contributors) ? $data->contributors : null;
        if (empty($author->first_name)) {
            return '';
        }
        $options = array_merge([
            'schema' => false,
            'mobile' => false,
            'just_name' => false,
            'date' => false,
            'format' => $this->dateFormat,
            'dateNewLine' => false,
            'localAnchor' => false,
        ], (array) $options);
        extract($options);

        if ($localAnchor && !empty($author->bio)) {
            // Save a url that points to the author bio on the local page
            $author->localUrl = '#about-author-' . strtolower($author->first_name);
            if (!empty($author->last_name)) {
                $author->localUrl .= '-' . strtolower($author->last_name);
            }
            foreach ($contributors as $countributor) {
                $countributor->localUrl = '#about-author-' . strtolower($countributor->first_name);
                if (!empty($countributor->last_name)) {
                    $countributor->localUrl .= '-' . strtolower($countributor->last_name);
                }
            }
        }

        $name_line = $this->person($author, $just_name, $schema, $localAnchor);
        $additional_line = '';
        if (!empty($contributors)) {
            foreach ($contributors as $contributor) {
                if ($contributor->is_active && ($contributor->id != $author->id)) {
                    $additional_line .= ', and '.$this->person($contributor, $just_name, $schema);
                }
            }
        }
        $retval = $name_line . $additional_line;

        if ($date) {
            $createdDate = $this->date(null, $format, 'date');
            $modifiedDate = $this->date(null, $format);
            if ($dateNewLine) {
                $retval .= '<br />';
            } else {
                $retval .= ' | ';
            }
            $retval .= '<span>';
            if ($createdDate != $modifiedDate) {
                $retval .= 'Last updated ';
            }
            $retval .= '<time datetime="' . $this->date(null, 'c') . '">' . $this->date(null, 'F j, Y') . '</time></span>';
            $retval .= '<span style="display:none" itemprop="dateModified">'. $modifiedDate .'</span>';
        }
        if ($schema) {
            $retval = $this->Html->tag('p', '<em>Contributed by ' . $retval . '</em>', array('class' => 'text-caption'));
        }
        return $retval;
    }

    /**
    * Markup for a person including degrees, credentials, title, company. Optional schema.
    */
    public function person($data, $just_name=false, $schema=false, $localAnchor=false) {
        $name_line = $title_line = $company_line = '';
        if (!empty($data->first_name)) {
            $name_line .= $data->first_name . ' ' . $data->last_name;
            if ($schema) {
                $name_line = $this->Html->tag('span', $name_line, array('itemprop' => 'name'));
            }
            // Link to local bio or about-us page
            $url = $data->url;
            if ($localAnchor && !empty($data->localUrl)) {
                $url = $data->localUrl;
            }
            if (!empty($url)) {
                $name_line = $this->Html->link($name_line, $url, array(
                    'class' => 'text-link',
                    'escape' => false)
                );
            }
            $suffix = array();
            if (!empty($data->degrees)) {
                $suffix = array_map('trim', explode(',', $data->degrees));
            }
            if (!empty($data->credentials)) {
                $suffix = array_merge($suffix, array_map('trim', explode(',', $data->credentials)));
            }
            if (!empty($suffix)) {
                $suffix = implode(', ', $suffix);
                if ($schema) {
                    $suffix = '<span itemprop="honorificSuffix">'.$suffix.'</span>';
                }
                $name_line .= ', '.$suffix;
            }
        }
        if (!empty($data->title_dept_company)) {
            if ($schema) {
                $title_line = ', <span itemprop="jobTitle">'.$data->title_dept_company.'</span>';
            } else {
                $title_line = ', ' . $data->title_dept_company;
            }
        }
        if (!empty($data->company)) {
            if ($schema) {
                $company_line = ', <span itemprop="worksFor"><span itemprop="affiliation">'.$data->company.'</span></span>';
            } else {
                $company_line = ', ' . $data->company;
            }
        }
        if (!$just_name) {
            $name_line = $name_line . $title_line . $company_line;
        }
        if ($schema) {
            $name_line = '<span itemprop="author" itemscope itemtype="https://schema.org/Person">'.$name_line.'</span>';
        }
        return $name_line;
    }

    /**
    * Format the author's or authors' bio for display on the bottom of a Wiki/Report page.
    * $param array $author
    * @return string
    */
    public function getAuthorBio($mainAuthor, $contributors = []) {
        // If there's no information, you can skip the rest.
        if (empty($mainAuthor) || empty($mainAuthor['bio'])) {
            return false;
        }

        // Combine the author with the list of contributors, keeping the main author first
        $authors = array_merge([$mainAuthor], $contributors);

        $retval = '<div class="about-author">';

        $authorIds = array();
        // Generate the about bio for each of our authors.
        foreach ($authors as $author) {
            // Make sure we don't repeat an author, if they're listed as the main author, and also a contributor.
            if (in_array($author->id, $authorIds)) {
                continue;
            }
            $authorIds[] = $author->id;

            // Generate the anchor for the top of the page.
            $anchor = 'about-author-' . $author->first_name . '-' . $author->last_name;

            // The bulk of the HTML being returned
            $retval .= '  <div class="about-author-bio">';
            $retval .= '    <a class="anchor" name="' . strtolower($anchor) . '"></a>';
            $retval .= '    <h3>';
            $retval .= '      <span>' . $author->first_name . ' ' . $author->last_name . '</span>';
            if (!empty($author->degrees)) {
                $retval .= ', <span>' . $author->degrees . '</span>';
            }
            if (!empty($author->title_dept_company)) {
                $retval .= ', <span>' . $author->title_dept_company . '</span>';
            }
            if (!empty($author->company)) {
                $retval .= ', <span><span>' . $author->company . '</span></span>';
            }
            $retval .= '    </h3>';
            $retval .= '    <p class="bio">';

            // Include the author's image, if there's one uploaded.
            if (!empty($author->image_url) && file_exists($_SERVER['DOCUMENT_ROOT'] . $author->image_url)) {
                $img =  '<img';
                $img .= ' loading="lazy"';
                $img .= ' src="' . $author->image_url . '" ';
                $img .= ' alt="' . $author->first_name . ' ' . $author->last_name . '" ';
                $img .= ' class="about-team pull-left"';
                $img .= ' width="80"';
                $img .= ' height="100" />';

                // Add our image to the return
                $retval .= $img;
            }

            // Add our tags to the bio
            $bio = $author->bio;

            // Append the actual bio to the return
            $retval .= strip_tags($bio);

            if ($author->url) {
                // Add a link to the actual about page.  Set it up in an array to make it easier to read the code.
                $aboutLink = [
                    'url'   => $author->url,
                    'text'  => 'Read more about ' . ucfirst(trim($author->first_name)) . '.',
                    'opts'  => [
                        'itemprop' => 'url'
                    ]
                ];
                $retval .= $this->Html->link($aboutLink['text'], $aboutLink['url'], $aboutLink['opts']);
            }

            $retval .= '    </p>';
            $retval .= '  <div class="clearfix"></div>';
            $retval .= '  </div>';
        }
        $retval .= '</div>';

        // Return our bio for display on the page.
        return $retval;
    }
}
