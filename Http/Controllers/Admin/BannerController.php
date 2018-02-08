<?php

namespace Modules\Ibanners\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ibanners\Entities\Banner;
use Modules\Ibanners\Http\Requests\IbannersRequest;
use Modules\Media\Repositories\FileRepository;

use Modules\Bcrud\Http\Controllers\BcrudController;
use Modules\User\Contracts\Authentication;
use Illuminate\Contracts\Foundation\Application;


class BannerController extends BcrudController
{
    /**
     * @var BannerRepository
     */
    private $banner;
    private $auth;
    private $file;

    public function __construct(Authentication $auth, FileRepository $file)
    {
        parent::__construct();

        $this->auth = $auth;
        $this->file= $file;
        $driver = config('asgard.user.config.driver');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('Modules\Ibanners\Entities\Banner');
        $this->crud->setRoute('backend/ibanners/banner');
        $this->crud->setEntityNameStrings('banner', 'banners');
        $this->access = [];
        $this->crud->enableAjaxTable();
        $this->crud->orderBy('created_at', 'DESC');
        $this->crud->limit(100);


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
            'name' => 'title',
            'label' => trans('ibanners::banner.table.title'),
        ]);
        $this->crud->addColumn([
            'name' => 'categories', // The db column name
            'label' => trans('ibanners::banner.table.category'),// Table column heading
            'type' => 'select_multiple',
            'attribute' => 'title',
            'entity' => 'categories',
            'model' => "Modules\\Ibanners\\Entities\\Category", // foreign key model
            'pivot' => true,
        ]);
        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => trans('ibanners::banner.table.create'),
        ]);

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'title',
            'label' => trans('ibanners::banner.form.title'),
            'viewposition' => 'left',

        ]);

        $this->crud->addField([
            'name' => 'url',
            'label' => 'Url',
            'type' => 'text',
            'viewposition' => 'left',
        ]);
        $this->crud->addField([
            'name' => 'code',
            'label' => trans('ibanners::banner.form.code'),
            'type' => 'textarea',
            'viewposition' => 'left',
        ]);
        $this->crud->addField([   // DateTime
        'name' => 'created_at',
        'label' => trans('iblog::common.date') . ' ' . trans('iblog::common.optional'),
        'type' => 'datetime_picker',
        // optional:
        'datetime_picker_options' => [
            'format' => 'DD/MM/YYYY HH:mm:ss',
            'language' => 'es',
        ],
        'viewposition' => 'right',
    ]);

        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'label' => trans('ibanners::banner.form.categories'),
            'type' => 'checklist',
            'name' => 'categories', // the method that defines the relationship in your Model
            'entity' => 'categories', // the method that defines the relationship in your Model
            'attribute' => 'title', // foreign key attribute that is shown to user
            'model' => "Modules\\Ibanners\\Entities\\Category", // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
            'viewposition' => 'right',
        ]);


        $this->crud->addField([
            'name'        => 'status',
            'label'       => trans('ibanners::banner.form.status'),
            'type'        => 'radio',
            'options'     => [
                0 => trans('ibanners::banner.status.draft'),
                1 => trans('ibanners::banner.status.pending'),
                2 => trans('ibanners::banner.status.published'),
                3 => trans('ibanners::banner.status.unpublished')
            ],
            'viewposition' => 'right',
        ]);

        $this->crud->addField([ // image
            'label' => trans('ibanners::banner.form.image'),
            'name' => "mainimage",
            'type' => 'image',
            'upload' => true,
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 0, // ommit or set to 0 to allow any aspect ratio
            'fake' => true,
            'store_in' => 'options',
            'viewposition' => 'left',
        ]);

        $this->crud->addField([ // image
            'label' => __('Media File'),
            'name' => "mediafile",
            'type' => 'upload',
            'upload' => true,
            'fake' => true,
            'disk' => 'publicmedia',
            'store_in' => 'options'

        ]);
        if (config()->has('asgard.ibanner.config.fields')) {
            $fields = config()->get('asgard.ibanner.config.fields');
            foreach ($fields as $field) {
                $this->crud->addField($field);
            }

        }

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


        }

        $this->crud->access = $allowpermissions;
    }

    public function store(IbannersRequest $request)
    {

        if ($request['created_at'] == null) {
            unset($request['created_at']);
        }
        return parent::storeCrud();

    }



    public function update(IbannersRequest $request)
    {
              return parent::updateCrud($request);
    }


}
