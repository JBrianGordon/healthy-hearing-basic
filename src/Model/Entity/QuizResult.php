<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Core\Configure;
use Cake\Routing\Router;

/**
 * QuizResult Entity
 *
 * @property int $id
 * @property string $results
 * @property \Cake\I18n\FrozenTime|null $created
 */
class QuizResult extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<bool>
     */
    protected $_accessible = [
        'results' => true,
        'created' => true,
    ];

	/**
	* Email the results to specified email
	* @param array of data
	* @return boolean success
	*/
	public function emailResults($data) {
		if (!isset($data['results'])) {
			return false;
		}
		$results = json_decode($data['results'], true);

		return $this->sendEmail(
			$results['email'], //to
			Configure::read('email'), //from
			'quiz_result_' . $results['hearingResult'] . '_' . strtolower(Configure::read('country')), //template
			'Your ' . Configure::read('siteName') . ' Test Results', //subject
			[ //viewvars
				'url' => $this->resultUrl($data['results'], true),
				'name' => $results['firstName'] . ' ' . $results['lastName'],
				'symptoms' => $results['emailSymptoms']
			]
		);
	}

	/**
	* string URL of results
	* @param string of results
	* @return string url to online test
	*/
	public function resultUrl($results, $encoded = false) {
		if ($encoded) {
			$results = base64_encode($results);
		}
		return Router::url(['admin' => false, 'controller' => 'quiz_results', 'action' => 'online_hearing_test']) . '?r=' . $results;
	}
}
