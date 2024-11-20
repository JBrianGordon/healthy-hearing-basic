<?php
declare(strict_types=1);

namespace App\Utility\Writer;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Table;
use Josegonzalez\Upload\File\Writer\DefaultWriter;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemInterface;
use Psr\Http\Message\UploadedFileInterface;

class CkBoxWriter extends DefaultWriter
{
    public function __construct(
        Table $table,
        EntityInterface $entity,
        ?UploadedFileInterface $data,
        string $field,
        array $settings
    ) {
        parent::__construct(
            $table,
            $entity,
            $data,
            $field,
            $settings
        );
    }

    /**
     * Writes a set of files to an output
     *
     * @param \League\Flysystem\FilesystemOperator $filesystem a filesystem wrapper
     * @param string $file a full path to a temp file
     * @param string $path that path to which the file should be written
     * @return bool
     */
    public function writeFile(FilesystemOperator $filesystem, $file, $path): bool
    {
        $stream = @fopen($file, 'r');

        if ($stream === false) {
            return false;
        }

        $success = false;

        try {
            $filesystem->writeStream($path, $stream);
            $success = true;
        } catch (FilesystemException $e) {
            // noop
        }

        is_resource($stream) && fclose($stream);

        return $success;
    }
}