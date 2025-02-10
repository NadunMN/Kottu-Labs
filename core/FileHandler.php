<?php

namespace app\core;

class FileHandler
{
    private static $allowedFileTypes = [
        'image' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'document' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'],
        'video' => ['mp4', 'avi', 'mkv', 'mov'],
    ];

    private static $maxFileSize = 5 * 1024 * 1024; // 5 MB

    private static $basePath = __DIR__ . '/../public/';

    /**
     * Uploads a file to the specified destination.
     *
     * @param array $file $_FILES['file']
     * @param string $destination Directory to save the file
     * @param array $allowedExtensions (Optional) Array of allowed extensions
     * @return string|false File path on success, false on failure
     */

    public static function fileUploader(array $file, string $destination, array $allowedExtensions = []): string|false
    {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return false;
        }

        $fileName = basename($file['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = $allowedExtensions ?: self::getAllowedExtensions();

        // Validate file extension
        if (!in_array($fileExtension, $allowedExtensions)) {
            return false;
        }

        // Validate file size
        if ($file['size'] > self::$maxFileSize) {
            return false;
        }

        // Create destination folder if it doesn't exist
        if (!is_dir(self::$basePath . $destination)) {
            mkdir(self::$basePath . $destination, 0777, true);
        }

        $newFileName = uniqid() . '.' . $fileExtension;
        $filePath = rtrim($destination, '/') . '/' . $newFileName;
        $absolutePath = self::$basePath . $filePath ;

        return move_uploaded_file($file['tmp_name'], $absolutePath) ? $filePath : false;
    }

    /**
     * Uploads an image to the specified destination with validation.
     *
     * @param array $file $_FILES['file']
     * @param string $destination Directory to save the image
     * @return string|false Image path on success, false on failure
     */
    public static function imageUploader(array $file, string $destination): string|false
    {
        return self::fileUploader($file, $destination, self::$allowedFileTypes['image']);
    }

    /**
     * Deletes a file from the system.
     *
     * @param string $filePath Path to the file
     * @return bool True on success, false on failure
     */
    public static function deleteFile(string $filePath): bool
    {
        return file_exists($filePath) ? unlink($filePath) : false;
    }

    /**
     * Validates a file by its extension and size.
     *
     * @param array $file $_FILES['file']
     * @param array $allowedExtensions Array of allowed extensions
     * @param int|null $maxFileSize Maximum file size in bytes (optional)
     * @return bool True if valid, false otherwise
     */
    public static function validateFile(array $file, array $allowedExtensions, ?int $maxFileSize = null): bool
    {
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $maxFileSize = $maxFileSize ?? self::$maxFileSize;

        return in_array($fileExtension, $allowedExtensions) && $file['size'] <= $maxFileSize;
    }

    /**
     * Reads the content of a file.
     *
     * @param string $filePath Path to the file
     * @return string|false File content or false on failure
     */
    public static function readFile(string $filePath): string|false
    {
        return file_exists($filePath) ? file_get_contents($filePath) : false;
    }

    /**
     * Writes content to a file.
     *
     * @param string $filePath Path to the file
     * @param string $content Content to write
     * @return bool True on success, false on failure
     */
    public static function writeFile(string $filePath, string $content): bool
    {
        return file_put_contents($filePath, $content) !== false;
    }

    /**
     * Lists files in a directory.
     *
     * @param string $directory Path to the directory
     * @param bool $recursive Whether to list files recursively
     * @return array List of files
     */
    public static function listFiles(string $directory, bool $recursive = false): array
    {
        $files = [];
        if (!is_dir($directory)) {
            return $files;
        }

        $iterator = $recursive ? new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory)) : new \DirectoryIterator($directory);

        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile()) {
                $files[] = $fileInfo->getPathname();
            }
        }

        return $files;
    }

    /**
     * Gets allowed file extensions.
     *
     * @param string|null $type File type (e.g., 'image', 'document', etc.)
     * @return array Allowed extensions
     */
    public static function getAllowedExtensions(?string $type = null): array
    {
        return $type && isset(self::$allowedFileTypes[$type]) ? self::$allowedFileTypes[$type] : array_merge(...array_values(self::$allowedFileTypes));
    }

    /**
     * Sets the maximum allowed file size.
     *
     * @param int $size File size in bytes
     */
    public static function setMaxFileSize(int $size): void
    {
        self::$maxFileSize = $size;
    }
}