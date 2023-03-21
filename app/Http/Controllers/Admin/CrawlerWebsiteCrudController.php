<?php

namespace App\Http\Controllers\Admin;

use App\Models\CrawlerWebsite;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CrawlerWebsiteRequest as StoreRequest;
use App\Http\Requests\CrawlerWebsiteRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class CrawlerWebsiteCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CrawlerWebsiteCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\CrawlerWebsite');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/crawlerWebsite');
        $this->crud->setEntityNameStrings('crawlerwebsite', 'Crawler Websites');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        $this->crud->addFilter([ // add a "simple" filter called Draft
            'type' => 'dropdown',
            'name' => 'status',
            'label'=> 'Status'
        ],
        [
            '1'=>"Enable",
            '0'=>"Disable"
        ],
        function($value) {
            $this->crud->addClause('where', 'status', $value);
        });

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

        $this->crud->addColumn(['name' => 'status',
            'type' => "select_from_array",
            'options'=> $this->crud->model::status(),
            ]);
        $this->crud->addColumn(['name' => 'created_time',
            'type' => "datetime",
        ]);
        $this->crud->addColumn(['name' => 'updated_time',
            'type' => "datetime",
        ]);

        // add asterisk for fields that are required in CrawlerWebsiteRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $request->request->set('created_time',time());
        $request->request->set('updated_time',time());
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $request->request->set('updated_time',time());
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
