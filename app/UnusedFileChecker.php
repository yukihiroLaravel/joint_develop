<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnusedFileChecker extends Model
{
    /**
     * 「unused_file_checkers」のinsert処理
     */
    public static function isert($type, $uuid, $fileName)
    {
        // insert
        $unusedFileChecker = new UnusedFileChecker;
        $unusedFileChecker->type = $type;
        $unusedFileChecker->check_count = 0;
        $unusedFileChecker->uuid = $uuid;
        $unusedFileChecker->file_name = $fileName;
        $unusedFileChecker->save();
    }
}
