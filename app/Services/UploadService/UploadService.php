<?php

namespace App\Services\UploadService;

use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

class UploadService
{
    /**
     * @param HasMedia $model
     * @param string $collectionName
     * @return Collection|array
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function upload(HasMedia $model, string $collectionName): Collection|array
    {
        return $model->addAllMediaFromRequest()
            ->each(function (FileAdder $fileAdder) use ($collectionName) {
                $fileAdder
                    ->setFileName(md5(microtime(true)) . ".jpg")
                    ->toMediaCollection($collectionName);
            });
    }
}
