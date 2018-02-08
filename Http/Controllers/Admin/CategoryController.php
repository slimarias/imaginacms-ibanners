<?php

namespace Modules\Ibanners\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Ibanners\Entities\Category;
use Modules\Ibanners\Http\Requests\IbannersRequest;

use Modules\Bcrud\Http\Controllers\BcrudController;
use Modules\User\Contracts\Authentication;


class CategoryController extends BcrudController
{


    /**
     * @var CategoryRepository
     */
    private $category;
    private $auth;

    public function __construct(Authentication $auth)
    {
        parent::__construct();

        $this->auth = $auth;


        $driver = config('asgard.user.config.driver');
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('Modules\Ibanners\Entities\Category');
        $this->crud->setRoute('backend/ibanners/category');
        $this->crud->setEntityNameStrings('category', 'categories');
        $this->access = [];


        $this->crud->allowAccess('reorder');
        $this->crud->enableReorder('title', 2);

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */
        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'id',
            'label' => 'ID',
        ]);


        $this->crud->addColumn([
            'name' => trans('ibanners::category.table.category'),
            'label' => 'Title',
        ]);

        $this->crud->addColumn([
            'label' => trans('ibanners::category.table.parent'),
            'type' => 'select',
            'name' => 'parent_id',
            'entity' => 'parent',
            'attribute' => 'title',
            'model' => 'Modules\Ibanners\Entities\Category',
        ]);


        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => trans('ibanners::category.table.create'),
        ]);

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'title',
            'label' => trans('ibanners::category.form.title'),
            'viewposition' => 'left'

        ]);

        $this->crud->addField([
            'name' => 'slug',
            'label' => trans('ibanners::category.table.slug'),
            'type' => 'text',
            'viewposition' => 'left'

        ]);

        $this->crud->addField([
            'label' => trans('ibanners::category.table.parent'),
            'type' => 'select',
            'name' => 'parent_id',
            'entity' => 'parent',
            'attribute' => 'title',
            'model' => 'Modules\Ibanners\Entities\Category',
            'viewposition' => 'right'
        ]);


        $this->crud->addField([
            'name' => 'description',
            'label' => trans('ibanners::category.table.description'),
            'type' => 'wysiwyg',
            'viewposition' => 'left'

        ]);

    }

    public function setup()
    {
        parent::setup();

        $permissions = ['index', 'create', 'edit', 'destroy'];
        $allowpermissions = [];
        foreach($permissions as $permission) {

            if($this->auth->hasAccess("ibanners.categories.$permission")) {
                if($permission=='index') $permission = 'list';
                if($permission=='edit') $permission = 'update';
                if($permission=='destroy') $permission = 'delete';
                $allowpermissions[] = $permission;
            }

            $allowpermissions[] = 'reorder';

        }

        $this->crud->access = $allowpermissions;
    }

    public function store(IbannersRequest $request)
    {
        return parent::storeCrud();
    }



    public function update(IbannersRequest $request)
    {
        return parent::updateCrud($request);
    }


}
