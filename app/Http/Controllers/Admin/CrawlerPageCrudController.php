<?php

namespace App\Http\Controllers\Admin;

use App\Models\CrawlerWebsite;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CrawlerPageRequest as StoreRequest;
use App\Http\Requests\CrawlerPageRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\DB;

/**
 * Class CrawlerPageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CrawlerPageCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\CrawlerPage');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/crawlerPage');
        $this->crud->setEntityNameStrings('crawlerpage', 'Crawler Pages');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        $crawler_website_arr = DB::table('crawler_website')->pluck('name', 'id');

        $this->crud->addField(['name' => 'crawler_website_id',
            'type' => 'select_from_array',
            'label' => 'Crawler Website',
            'options'=> $crawler_website_arr
        ]);
        $this->crud->addField(['name' => 'status',
            'type' => 'select_from_array',
            'label' => 'Status',
            'options'=> $this->crud->model::status(),
        ]);
        $this->crud->addField(['name' => 'crawler_post_time_element',
            'type' => 'text',
            'label' => 'Crawler post time element',
            'hint' => '<i>*** e.g. (ele[attr])</i>'
        ]);
        $this->crud->addField(['name' => 'crawler_post_time_format',
            'type' => 'text',
            'label' => 'Crawler post time format',
            'hint' => '<i>*** e.g. (%Y-%m-%dT%H:%M:%S.%fZ / %Y-%m-%d %H:%M:%S)</i>'
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
        $this->crud->addColumn(['name' => 'crawler_website_id',
            'type' => "select_from_array",
            'options'=> $crawler_website_arr
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

        // add asterisk for fields that are required in CrawlerPageRequest
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
