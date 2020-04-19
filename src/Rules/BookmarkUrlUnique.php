<?php

namespace Aleksei4er\TaskBookmarks\Rules;

use Aleksei4er\TaskBookmarks\Models\Bookmark;
use Illuminate\Contracts\Validation\Rule;

class BookmarkUrlUnique implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Bookmark::findByUrl($value) === null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Bookmark with such url alreay exists';
    }
}
