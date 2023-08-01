<?php

namespace App\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class TeamManager
{
    public function uploadImage(UploadedFile $file, $targetDir)
    {
        $newFilename = uniqid() . '.' . $file->guessExtension();

        // Esto copia la imagen al directorio public/images
        $file->move(
            $targetDir,
            $newFilename
        );
        //@TODO -> Habría que sustituir ese "move" por el upload a Cloudinary

        return '/images/' . $newFilename;
    }
}
