<?php

namespace Aleksei4er\TaskBookmarks\Admin\Controllers;

use Aleksei4er\TaskBookmarks\Admin\Exporters\BookmarkExporter;
use Aleksei4er\TaskBookmarks\Admin\RowActions\BookmarkDeletion;
use Aleksei4er\TaskBookmarks\Models\Bookmark;
use Aleksei4er\TaskBookmarks\Rules\BookmarkUrlUnique;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Grid\Filter;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class BookmarksController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Aleksei4er\TaskBookmarks\Models\Bookmark';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Bookmark());

        $grid->exporter(new BookmarkExporter());

        $grid->disableFilter();
        $grid->disableColumnSelector();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
            $actions->disableDelete();
            $actions->add(new BookmarkDeletion);
        });

        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        $grid->column('favicon', __('Favicon'))->image('', 32, 32);
        $grid->column('url', __('Url'))->link()->sortable();
        $grid->column('title', __('Title'))->sortable();
        $grid->column('created_at', __('Created at'))->date('d-m-Y')->sortable();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Bookmark::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('favicon', __('Favicon'))->image();
        $show->field('url', __('Url'))->link();
        $show->field('title', __('Title'));
        $show->field('description', __('Description'));
        $show->field('keywords', __('Keywords'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
            $tools->disableDelete();
        });;

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Bookmark());

        if ($form->isCreating()) {
            $form->url('url', __('Url'))->placeholder('https://example.com')
                ->attribute('autocomplete', 'off');
            $form->password('password', __('Password'))->placeholder('It will be asked before deletion')
                ->attribute('autocomplete', 'off');
        }

        $form->saving(function (Form $form) {

            $validator = Validator::make(request()->all(), [
                'url' => ['required', 'url', 'max:2083', new BookmarkUrlUnique],
                'password' => ['string', 'nullable', 'max:100'],
            ]);

            if ($validator->fails()) {
                $error = new MessageBag([
                    'title'   => 'Error',
                    'message' => $validator->getMessageBag()->all(),
                ]);

                return back()->with(compact('error'));
            }
        });

        $form->saved(function (Form $form) {
            return redirect()->route('bookmarks.show', ['bookmark' => $form->model()->id]);
        });

        return $form;
    }
}
