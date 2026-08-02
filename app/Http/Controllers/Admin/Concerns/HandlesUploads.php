<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HandlesUploads
{
    /**
     * Store a newly uploaded file and delete the one it replaces.
     * Returns the value that should be written to the model column, or false when untouched.
     */
    protected function handleUpload(Request $request, string $field, string $directory, ?string $current = null): string|null|false
    {
        if ($request->boolean($field.'_remove')) {
            $this->deleteUpload($current);

            return null;
        }

        if (! $request->hasFile($field)) {
            return false;
        }

        $path = $request->file($field)->store($directory, 'public');

        $this->deleteUpload($current);

        return $path;
    }

    protected function deleteUpload(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Apply the result of handleUpload() onto a validated data array.
     */
    protected function withUpload(array $data, string $field, string|null|false $result): array
    {
        if ($result === false) {
            unset($data[$field]);

            return $data;
        }

        $data[$field] = $result;

        return $data;
    }
}
