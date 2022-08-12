<?php
declare(strict_types=1);
namespace Cake\Controller\Component;

use Cake\Controller\Component;

class ExportComponent extends Component
{
    /**
     * Default configuration
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
    ];

    protected $_contain = [];

    // Array of fields to ignore
    protected $_ignoreFields = [];

    // Array of fields to add
    protected $_additionalFields = [];

    public function setContain(array $contain)
    {
        $this->_contain = $contain;
    }

    public function setIgnoreFields(array $ignoreFields)
    {
        $this->_ignoreFields = $ignoreFields;
    }

    public function setAdditionalFields(array $additionalFields)
    {
        $this->_additionalFields = $additionalFields;
    }

    /**
     * Export data to a csv file
     *
     * @param string $filename The filename to save CSV data to
     */
    public function exportCsv(string $filename)
    {
        if (strpos($filename, '.csv') === false) {
            $filename .= '.csv';
        }
        $controller = $this->getController();
        $model = $controller->loadModel();
        $queryParams = $controller->getRequest()->getQueryParams();
        $query = $model->find('search', [
            'search' => $queryParams,
            'contain' => $this->_contain
        ]);
        // Don't store results in memory
        $query->disableBufferedResults();
        $fields = array_keys($model->getSchema()->typeMap());
        if (!empty($this->_additionalFields)) {
            // TODO: Need to test setting additional fields from other contained models
            $fields = array_merge($fields, $this->_additionalFields);
        }
        if (!empty($this->_ignoreFields)) {
            $fields = array_diff($fields, $this->_ignoreFields);
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);
        $output = fopen('php://output', 'w');
        // Add Header
        $headerRow = [];
        foreach ($fields as $field) {
            $headerRow[] = $field;
        }
        fputcsv($output, $headerRow);
        foreach ($query as $data) {
            $row = [];
            foreach ($fields as $field) {
                $row[] = $data[$field];
            }
            fputcsv($output, $row);
        }
        fclose($output);
    }
}
