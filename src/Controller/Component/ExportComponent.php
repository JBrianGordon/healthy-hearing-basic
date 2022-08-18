<?php
declare(strict_types=1);
namespace Cake\Controller\Component;

use Cake\Controller\Component;
use Cake\Utility\Inflector;
use Cake\Datasource\ConnectionManager;

class ExportComponent extends Component
{
    protected $_ignoreFields = [];
    protected $_additionalFields = [];
    protected $_overwriteLabels = [];

    /**
     * Set an array of fields to ignore
     *
     * @param array ['field_name']
     */
    public function setIgnoreFields(array $ignoreFields)
    {
        $this->_ignoreFields = $ignoreFields;
    }

    /**
     * Set an array of fields to add
     *
     * @param array ['TableName.field_name']
     */
    public function setAdditionalFields(array $additionalFields)
    {
        $this->_additionalFields = $additionalFields;
    }

    /**
     * Set an array of fields to overwrite label
     *
     * @param array ['field_name' => 'label']
     */
    public function setOverwriteLabels(array $overwriteLabels)
    {
        $this->_overwriteLabels = $overwriteLabels;
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
        $contain = [];
        // Export all fields for this table
        $fields = array_keys($model->getSchema()->typeMap());
        // Remove fields to ignore
        if (!empty($this->_ignoreFields)) {
            $fields = array_diff($fields, $this->_ignoreFields);
        }
        // Add additional fields from another table
        if (!empty($this->_additionalFields)) {
            $fields = array_merge($fields, $this->_additionalFields);
            foreach ($this->_additionalFields as $field) {
                if ($offset = strpos($field, '.')) {
                    $contain[] = substr($field, 0, $offset);
                }
            }
        }
        $queryParams = $controller->getRequest()->getQueryParams();
        $tables = ConnectionManager::get('default')->getSchemaCollection()->listTables();
        foreach ($tables as $table) {
            foreach ($queryParams as $key => $value) {
                if ($key == Inflector::camelize($table)) {
                    // We are querying data from another table. Add it to the contain list.
                    $contain[] = $key;
                }
            }
        }
        $contain = array_unique($contain);
        $query = $model->find('search', [
            'search' => $queryParams,
            'contain' => $contain
        ]);
        // Don't store results in memory
        $query->disableBufferedResults();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);
        $output = fopen('php://output', 'w');
        // Add Header
        $headerRow = [];
        foreach ($fields as $field) {
            $label = $field;
            if (array_key_exists($field, $this->_overwriteLabels)) {
                $label = $this->_overwriteLabels[$field];
            } else if ($offset = strpos($field, '.')) {
                // Data from another table, remove the table name from label
                $label = substr($field, $offset+1);
            }
            $headerRow[] = $label;
        }
        fputcsv($output, $headerRow);
        foreach ($query as $data) {
            $row = [];
            foreach ($fields as $field) {
                if ($offset = strpos($field, '.')) {
                    // Data from another table
                    $associatedTable = substr($field, 0, $offset);
                    $table = Inflector::singularize($model->$associatedTable->getTable());
                    $field = substr($field, $offset+1);
                    $row[] = $data->$table->$field;
                } else {
                    $row[] = $data->$field;
                }
            }
            fputcsv($output, $row);
        }
        fclose($output);
    }
}
