<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageUploadService
{
    private array $uploadedFiles = [];

    /**
     * ANCHOR: Upload an image with validation
     */
    public function upload(UploadedFile $file, string $directory = 'products'): string
    {
        // Validate image file
        $this->validateImageFile($file);

        // Store file
        $path = $file->store($directory, 'public');

        // Track uploaded file for potential cleanup
        $this->uploadedFiles[] = $path;

        Log::info("Image uploaded successfully", ['path' => $path, 'size' => $file->getSize()]);

        return $path;
    }

    /**
     * ANCHOR: Upload multiple images
     */
    public function uploadMultiple(array $files, string $directory = 'products'): array
    {
        $paths = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $paths[] = $this->upload($file, $directory);
            }
        }

        return $paths;
    }

    /**
     * ANCHOR: Validate image file to prevent malicious uploads
     */
    private function validateImageFile(UploadedFile $file): void
    {
        // Check if file is actually an image by reading its content
        $imageInfo = @getimagesize($file->getRealPath());

        if ($imageInfo === false) {
            throw new \InvalidArgumentException('File is not a valid image');
        }

        // Verify image type
        $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF];
        if (!in_array($imageInfo[2], $allowedTypes)) {
            throw new \InvalidArgumentException('Invalid image type. Only JPEG, PNG, and GIF are allowed.');
        }

        // Check image dimensions (optional - prevent extremely large images)
        $maxWidth = 5000;
        $maxHeight = 5000;

        if ($imageInfo[0] > $maxWidth || $imageInfo[1] > $maxHeight) {
            throw new \InvalidArgumentException("Image dimensions too large. Maximum {$maxWidth}x{$maxHeight} pixels.");
        }
    }

    /**
     * ANCHOR: Delete a single file
     */
    public function delete(string $path): bool
    {
        try {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
                Log::info("Image deleted successfully", ['path' => $path]);
                return true;
            }

            Log::warning("Image file not found", ['path' => $path]);
            return false;
        } catch (\Exception $e) {
            Log::error("Failed to delete image", ['path' => $path, 'error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * ANCHOR: Delete multiple files
     */
    public function deleteMultiple(array $paths): array
    {
        $results = [];

        foreach ($paths as $path) {
            $results[$path] = $this->delete($path);
        }

        return $results;
    }

    /**
     * ANCHOR: Cleanup all tracked uploaded files (for rollback scenarios)
     */
    public function cleanup(): void
    {
        if (empty($this->uploadedFiles)) {
            return;
        }

        Log::info("Starting cleanup of uploaded files", ['count' => count($this->uploadedFiles)]);

        foreach ($this->uploadedFiles as $path) {
            $this->delete($path);
        }

        $this->uploadedFiles = [];
    }

    /**
     * ANCHOR: Get list of uploaded files (for tracking)
     */
    public function getUploadedFiles(): array
    {
        return $this->uploadedFiles;
    }

    /**
     * ANCHOR: Clear tracking without deleting files (after successful commit)
     */
    public function clearTracking(): void
    {
        $this->uploadedFiles = [];
    }

    /**
     * ANCHOR: Check if image file exists
     */
    public function exists(string $path): bool
    {
        return Storage::disk('public')->exists($path);
    }

    /**
     * ANCHOR: Get file size
     */
    public function getSize(string $path): int
    {
        if (!$this->exists($path)) {
            return 0;
        }

        return Storage::disk('public')->size($path);
    }

    /**
     * ANCHOR: Get file URL
     */
    public function getUrl(string $path): string
    {
        return asset('storage/' . $path);
    }
}

