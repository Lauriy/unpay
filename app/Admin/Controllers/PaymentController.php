<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Payment;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PaymentController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Payment);

        $grid->id('Id');
        $grid->amount_in_cents('Amount in cents');
        $grid->currency('Currency');
        $grid->country('Country');
        $grid->callback_url('Callback url');
        $grid->chosen_method('Chosen method');
        $grid->request_data('Request data');
        $grid->response_data('Response data');
        $grid->paid_at('Paid at');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->deleted_at('Deleted at');

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
        $show = new Show(Payment::findOrFail($id));

        $show->id('Id');
        $show->amount_in_cents('Amount in cents');
        $show->currency('Currency');
        $show->country('Country');
        $show->callback_url('Callback url');
        $show->chosen_method('Chosen method');
        $show->request_data('Request data');
        $show->response_data('Response data');
        $show->paid_at('Paid at');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->deleted_at('Deleted at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Payment);

        $form->number('amount_in_cents', 'Amount in cents');
        $form->text('currency', 'Currency');
        $form->text('country', 'Country');
        $form->text('callback_url', 'Callback url');
        $form->text('chosen_method', 'Chosen method');
        $form->textarea('request_data', 'Request data');
        $form->textarea('response_data', 'Response data');
        $form->datetime('paid_at', 'Paid at')->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
