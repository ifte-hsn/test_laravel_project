<?php

namespace App\Helpers;

class Helper
{
    public static function formatStandardApiResponse($success, $errors = null, $data = null)

    {
        $array['success'] = $success;

        ($errors) ? $array['errors'] = $errors : $array['errors'] = null;
        ($data) ? $array['data'] = $data : $array['data'] = [];

        return $array;
    }
}
