<?php

namespace App\Http\Controllers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    /**
     * Save a publication file in the storage
     *
     * @param string $heading
     * @param Illuminate\Http\UploadedFile $newFile
     * @return string
     */
    public static function storePublicationFile($heading, $newFile)
    {
        $newName = preg_replace('([^\w\s\d\-_~,;\[\]\(\)])', '', $heading);
        $newExtension = $newFile->extension();

        return $newFile->storeAs('publications', $newName . '.' . $newExtension);
    }

    /**
     * Replace existing publication file if newer one is given
     * or just rename it according to altered publication heading
     *
     * @param string $heading
     * @param Illuminate\Http\UploadedFile $newFile
     * @param string $oldFilePath
     * @return string
     */
    public static function updatePublicationFile($heading, $newFile, $oldFilePath)
    {
        $newName = preg_replace('([^\w\s\d\-_~,;\[\]\(\)])', '', $heading);

        if ($newFile) {
            // replace file
            $newExtension = $newFile->extension();
            Storage::delete($oldFilePath);

            return $newFile->storeAs('publications', $newName . '.' . $newExtension);
        } else {
            // update filename if necessary
            $oldExtension = (new Filesystem)->extension($oldFilePath);
            $newFilePath = 'publications/' . $newName . '.' . $oldExtension;
            if ($newFilePath != $oldFilePath) Storage::move($oldFilePath, $newFilePath);

            return $newFilePath;
        }
    }

    /**
     * Save or replace literature cover file
     *
     * @param Illuminate\Http\UploadedFile $newFile
     * @param string $oldFilePath
     * @return string
     */
    public static function updateLiteratureCover($newFile, $oldFilePath)
    {
        if ($newFile) {
            if ($oldFilePath) Storage::delete($oldFilePath);

            return $newFile->store('literature/covers');
        }

        return $oldFilePath;
    }
}
