<?php

namespace Core;

class Upload
{
    public function handle(
        string $upload_path_with_ds,
        string $file_global_name,
        int $upload_max_file_size,
        array $extensions,
        string $new_name_prefix = 'upload'
    )
    {
        if (isset($_FILES[$file_global_name]) && $_FILES[$file_global_name]['error'] === UPLOAD_ERR_OK) {

            if ($_FILES[$file_global_name]['size'] > $upload_max_file_size) {
                return false;
            }

            if (!is_uploaded_file($_FILES[$file_global_name]['tmp_name'])) {
                return false;
            }

            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $finfo_ext = $finfo->file($_FILES[$file_global_name]['tmp_name']);

            $ext = array_search($finfo_ext, $extensions, true);

            if ($ext === false) {
                return false;
            }

            $uploadName = uniqid($new_name_prefix . '_', false) . '_' . date('Y-m-d') . '.' . $ext;

            if (!move_uploaded_file(
                $_FILES[$file_global_name]['tmp_name'],
                $upload_path_with_ds . $uploadName)
            ) {
                return false;
            }

            $this->fixImage($upload_path_with_ds . $uploadName, $ext);

            return $uploadName;
        }

        return false;
    }

    private function fixImage(string $filename, string $ext)
    {
        $source = false;

        switch ($ext) {
            case 'jpeg':
            case 'jpg':
                $source = imagecreatefromjpeg($filename);
                break;
            case 'png':
                $source = imagecreatefrompng($filename);
                break;
        }

        if ($source === false) {
            return false;
        }

        $exif = @exif_read_data($filename);

        if ($exif === false || !\is_array($exif)) {
            return false;
        }

        if (!array_key_exists('Orientation', $exif)) {
            return false;
        }

        switch ($exif['Orientation']) {
            case 3:
                $source = imagerotate($source, 180, 0);
                break;

            case 6:
                $source = imagerotate($source, -90, 0);
                break;

            case 8:
                $source = imagerotate($source, 90, 0);
                break;
        }

        $success = false;

        switch ($ext) {
            case 'png':
                $success = imagepng($source, $filename);
                break;
            case 'jpg':
            case 'jpeg':
                $success = imagejpeg($source, $filename);
                break;
        }

        return $success;
    }
}