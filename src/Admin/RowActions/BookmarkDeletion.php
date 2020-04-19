<?php

namespace Aleksei4er\TaskBookmarks\Admin\RowActions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BookmarkDeletion extends RowAction
{
    public $name = 'Delete';

    public function handle(Model $model, Request $request)
    {
        $password = $request->input('password');

        if (Hash::check($password, $model->password)) {
            $model->delete();
            return $this->response()->success('Bookmark has been deleted.')->refresh();
        } else {
            return $this->response()->error('Password is wrong.');
        }
    }

    public function form()
    {
        $this->password('password', 'Введите пароль');
    }
}