<?php

namespace App\Http\Controllers\Admin;

use App\Models\CrawlerTag;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CrawlerTagRequest as StoreRequest;
use App\Http\Requests\CrawlerTagRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class CrawlerTagCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CrawlerTagCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\CrawlerTag');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/crawlerTag');
        $this->crud->setEntityNameStrings('crawlertag', 'Crawler Tags');

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

        // add asterisk for fields that are required in CrawlerTagRequest
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
