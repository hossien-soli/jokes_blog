<?php

namespace App\Util;

use Slim\Http\UploadedFile;
use App\Util\Config;

class FileUploader
{
    protected $file;
    protected $config;
    protected $validExtensions = [];
    protected $maxFileSize = 1024;

    public function __construct (UploadedFile $file,Config $config)
    {
        $this->file = $file;
        $this->config = $config;
    }

    public function setMaxFileSize ($fileSize)
    {
        $this->maxFileSize = (int) $fileSize;
    }

    public function addValidExtension ($extension)
    {
        array_push($this->validExtensions,$extension);
    }

    public function setValidExtensions (array $extensions)
    {
        $this->validExtensions = $extensions;
    }

    public function getClientFileNameExtension ()
    {
        $fileName = $this->file->getClientFilename();
        return pathinfo($fileName)['extension'];        
    }

    public function checkForValid ()
    {
        $uploadError = $this->file->getError();
        if ($uploadError != 0)
            return false;
        
        $fileSize = (int) $this->file->getSize();
        $fileSize = floor($fileSize / 1024);
        if ($fileSize > (int) $this->maxFileSize)
            return false;

        $fileExtension = $this->getClientFileNameExtension();
        if (!in_array($fileExtension,$this->validExtensions))
            return false;

        return true;
    }

    public function upload ()
    {
        $dir = $this->config->get('uploader.storage_dir');
        if (substr($dir,-1) != '/')
            $dir .= DIRECTORY_SEPARATOR;
        
        $fileName = $this->file->getClientFilename();
        $fullPath = $dir . $fileName;

        $this->file->moveTo($fullPath);
        return $fullPath;
    }

    public function uploadWithUniqueName ($dir)
    {
        if (substr($dir,-1) != '/')
            $dir .= DIRECTORY_SEPARATOR;

        $basename = uniqid() . rand(0,999999999);
        $basename = strtoupper($basename);
        $basename = str_shuffle($basename);
        $newName = $basename . '.' . $this->getClientFileNameExtension();
        $fullPath = $dir . $newName;

        $this->file->moveTo($fullPath);
        return $newName;
    }

    public function uploadAsUserAvatar ()
    {
        $dir = $this->config->get('uploader.users_avatar_dir_local');
        $publicPath = $this->config->get('uploader.users_avatar_dir_public');
        if (substr($publicPath,-1) != '/')
            $publicPath .= DIRECTORY_SEPARATOR;
        $publicPath .= $this->uploadWithUniqueName($dir);
        return $publicPath;
    }
}