<?php

namespace Aleksei4er\TaskBookmarks\Admin\Exporters;

use Encore\Admin\Grid\Exporters\ExcelExporter;

class BookmarkExporter extends ExcelExporter
{
    protected $fileName = 'bookmarks.xlsx';

    protected $columns = [
        'id' => 'ID',
        'favicon' => 'Favicon',
        'title' => 'Title',
        'url' => 'Url',
        'description' => 'Description',
        'keywords' => 'Keywords',
        'created_at' => 'Created at',
    ];
}
