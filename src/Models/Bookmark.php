<?php

namespace Aleksei4er\TaskBookmarks\Models;

use Aleksei4er\TaskBookmarks\Facades\TaskBookmarks;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Bookmark extends Model
{
    protected $fillable = [
        'title',
        'description',
        'keywords',
        'favicon',
        'url',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model)
        {
            if (self::findByUrl($model->url)) {
                throw new Exception("Bookmark with such url alreay exists");
            }

            $model->url_hash = self::getUrlHash($model->url);
            $model->password = Hash::make($model->password);

            $data = TaskBookmarks::getData($model->url);

            $model->fill($data);
        });
    }

    /**
     * Find bookmark by url using hash
     *
     * @param string $url
     * @return Bookmark|null
     */
    public static function findByUrl(string $url)
    {
        return self::where('url_hash', self::getUrlHash($url))->first();
    }

    /**
     * Hash method for url
     *
     * @param string $url
     * @return string
     */
    public static function getUrlHash(string $url): string
    {
        return hash('sha512', $url);
    }
}
