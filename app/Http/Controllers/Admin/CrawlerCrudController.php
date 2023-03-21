<?php

namespace App\Http\Controllers\Admin;

use App\Models\Crawler;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CrawlerRequest as StoreRequest;
use App\Http\Requests\CrawlerRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class CrawlerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CrawlerCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Crawler');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/crawler');
        $this->crud->setEntityNameStrings('crawler', 'crawlers');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
//        $this->crud->setFromDb();
        $this->crud->addField([
            'name'        => 'name',
            'label'       => 'Name',
            'type'        => 'text',
        ]);
        $this->crud->addField([
            'name'        => 'prefix',
            'label'       => 'Prefix',
            'type'        => 'text',
        ]);
        $this->crud->addField([
            'name'        => 'url',
            'label'       => 'URL',
            'type'        => 'text',
        ]);
        $this->crud->addField([   // radio
            'name'        => 'status', // the name of the db column
            'label'       => 'Status', // the input label
            'type'        => 'radio',
            'options'     => Crawler::status(),
            // optional
            //'inline'      => false, // show the radios all on the same line?
        ]);

        $this->crud->addColumns(['name','prefix','url']);
        $this->crud->addColumn([
            'name'=>'status',
            'label'=>'Status',
            'type'=>'radio',
            'options'=>Crawler::status()
        ]);

        // add asterisk for fields that are required in CrawlerRequest
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
