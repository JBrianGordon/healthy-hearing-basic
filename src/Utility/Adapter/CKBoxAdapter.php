<?php
declare(strict_types=1);

namespace App\Utility\Adapter;

use App\Utility\CKBoxUtility;
use Cake\Core\Configure;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\Config;
use League\Flysystem\UnableToWriteFile;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToDeleteFile;
use League\Flysystem\UnableToCheckExistence;
use League\Flysystem\UnableToCreateDirectory;
use League\Flysystem\UnableToMoveFile;
use League\Flysystem\UnableToCopyFile;
use League\Flysystem\UnableToRetrieveMetadata;
use League\Flysystem\InvalidVisibilityProvided;
use League\Flysystem\StorageAttributes;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemException;

class CKBoxAdapter implements FilesystemAdapter
{
    protected $ckBoxUtility;

    public function __construct($categoryId = null)
    {
        $categoryId = $categoryId ?? Configure::read('CK.categoryId');
        $this->ckBoxUtility = new CKBoxUtility($categoryId);
    }

    /**
     * @param resource $contents
     *
     * @throws UnableToWriteFile
     * @throws FilesystemException
     */
    public function writeStream(string $path, $contents, Config $config): void
    {
        try {
            $this->upload($path, $contents, $config);
        } catch (FileystemException $e) {
            // noop
        }
    }

    private function upload(string $path, $body, Config $config): void
    {
        try {
            $this->ckBoxUtility->uploadImage($body, $path);
        } catch (Throwable $exception) {
            throw UnableToWriteFile::atLocation($path, $exception->getMessage(), $exception);
        }
    }

    /**
     * @throws UnableToDeleteFile
     * @throws FilesystemException
     */
    public function delete(string $imageId): void
    {
        try {
            $this->ckBoxUtility->deleteImage($imageId);
        } catch (Exception $e) {
            throw new UnableToDeleteFile("Deleting file(s) failed.");
        }
    }

    // Functions below exist only to satisfy interface requirements
    // -*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
    /**
     * @throws UnableToWriteFile
     * @throws FilesystemException
     */
    public function write(string $path, string $contents, Config $config): void
    {
        throw new UnableToWriteFile("Writing files is not implemented yet.");
    }

    /**
     * @throws FilesystemException
     * @throws UnableToCheckExistence
     */
    public function fileExists(string $path): bool
    {
        // Implement the logic to check if a file exists in CKBox
        throw new UnableToCheckExistence("Checking file existence is not implemented yet.");
    }

    /**
     * @throws FilesystemException
     * @throws UnableToCheckExistence
     */
    public function directoryExists(string $path): bool
    {
        // Implement the logic to check if a directory exists in CKBox
        throw new UnableToCheckExistence("Checking directory existence is not implemented yet.");
    }

    /**
     * @throws UnableToReadFile
     * @throws FilesystemException
     */
    public function read(string $path): string
    {
        // Implement the logic to read a file from CKBox
        throw new UnableToReadFile("Reading files is not implemented yet.");
    }

    /**
     * @return resource
     *
     * @throws UnableToReadFile
     * @throws FilesystemException
     */
    public function readStream(string $path)
    {
        // Implement the logic to read a file stream from CKBox
        throw new UnableToReadFile("Reading file streams is not implemented yet.");
    }

    /**
     * @throws UnableToDeleteDirectory
     * @throws FilesystemException
     */
    public function deleteDirectory(string $path): void
    {
        // Implement the logic to delete a directory from CKBox
        throw new UnableToDeleteDirectory("Deleting directories is not implemented yet.");
    }

    /**
     * @throws UnableToCreateDirectory
     * @throws FilesystemException
     */
    public function createDirectory(string $path, Config $config): void
    {
        // Implement the logic to create a directory in CKBox
        throw new UnableToCreateDirectory("Creating directories is not implemented yet.");
    }

    /**
     * @throws InvalidVisibilityProvided
     * @throws FilesystemException
     */
    public function setVisibility(string $path, string $visibility): void
    {
        // Implement the logic to set file visibility in CKBox
        throw new InvalidVisibilityProvided("Setting visibility is not implemented yet.");
    }

    /**
     * @throws UnableToRetrieveMetadata
     * @throws FilesystemException
     */
    public function visibility(string $path): FileAttributes
    {
        // Implement the logic to get file visibility from CKBox
        throw new UnableToRetrieveMetadata("Getting visibility is not implemented yet.");
    }

    /**
     * @throws UnableToRetrieveMetadata
     * @throws FilesystemException
     */
    public function mimeType(string $path): FileAttributes
    {
        // Implement the logic to get file MIME type from CKBox
        throw new UnableToRetrieveMetadata("Getting MIME type is not implemented yet.");
    }

    /**
     * @throws UnableToRetrieveMetadata
     * @throws FilesystemException
     */
    public function lastModified(string $path): FileAttributes
    {
        // Implement the logic to get file last modified time from CKBox
        throw new UnableToRetrieveMetadata("Getting last modified time is not implemented yet.");
    }

    /**
     * @throws UnableToRetrieveMetadata
     * @throws FilesystemException
     */
    public function fileSize(string $path): FileAttributes
    {
        // Implement the logic to get file size from CKBox
        throw new UnableToRetrieveMetadata("Getting file size is not implemented yet.");
    }

    /**
     * @return iterable<StorageAttributes>
     *
     * @throws FilesystemException
     */
    public function listContents(string $path, bool $deep): iterable
    {
        // Implement the logic to list directory contents from CKBox
        throw new UnableToRetrieveMetadata("Listing contents is not implemented yet.");
    }

    /**
     * @throws UnableToMoveFile
     * @throws FilesystemException
     */
    public function move(string $source, string $destination, Config $config): void
    {
        // Implement the logic to move a file in CKBox
        throw new UnableToMoveFile("Moving files is not implemented yet.");
    }

    /**
     * @throws UnableToCopyFile
     * @throws FilesystemException
     */
    public function copy(string $source, string $destination, Config $config): void
    {
        // Implement the logic to copy a file in CKBox
        throw new UnableToCopyFile("Copying files is not implemented yet.");
    }
}