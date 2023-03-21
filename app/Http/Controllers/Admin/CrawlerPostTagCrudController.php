<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CrawlerPostTagRequest as StoreRequest;
use App\Http\Requests\CrawlerPostTagRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class CrawlerPostTagCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CrawlerPostTagCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\CrawlerPostTag');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/crawlerPostTag');
        $this->crud->setEntityNameStrings('crawlerposttag', 'Crawler Post Tags');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        $this->crud->addField(['name' => 'status',
            'type' => 'select_from_array',
            'label' => 'Status',
            'options'=> $this->crud->model::status(),
        ]);
        $this->crud->addField(['name' => 'created_time',
            'type' => 'text',
            'label' => 'Created Time',
            'attributes' => ['readonly'=>'readonly']
        ]);
        $this->crud->addField(['name' => 'updated_time',
            'type' => 'text',
            'label' => 'Updated Time',
            'attributes' => ['readonly'=>'readonly']
        ]);

        // add asterisk for fields that are required in CrawlerPostTagRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
