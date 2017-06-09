<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Users as UsersModel;

class UsersController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('用户列表');
            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('编辑用户');
            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('新增配置');
            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(UsersModel::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->column('avatar','头像')->display(function (){
                return "<img src='{$this->profile['headimgurl']}' width='25' height='25' style='border-radius: 12.5px;'>";
            });
            $grid->column('nickname','微信昵称');
            $grid->openid();
            $grid->column('name','姓名');
            $grid->column('phone','手机号');
            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->like('nickname', '微信昵称');
                $filter->like('phone', '电话');
                $filter->like('name', '姓名');
            });
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
            $grid->disableCreation();
            //$grid->disableActions();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(UsersModel::class, function (Form $form) {
        });
    }

}
