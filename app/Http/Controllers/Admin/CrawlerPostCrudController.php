<?php

namespace App\Http\Controllers\Admin;

use App\Models\CrawlerPost;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CrawlerPostRequest as StoreRequest;
use App\Http\Requests\CrawlerPostRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\DB;

/**
 * Class CrawlerPostCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CrawlerPostCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\CrawlerPost');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/crawlerPost');
        $this->crud->setEntityNameStrings('crawlerpost', 'Crawler Posts');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        $this->crud->query->orderBy('id', 'DESC');

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        $this->crud->addField(['name' => 'content', 'type' => 'wysiwyg', 'label' => 'Content']);
        $this->crud->addField(['name' => 'status',
            'type' => 'select_from_array',
            'label' => 'Status',
            'options'=> $this->crud->model::status(),
            ]);
        $this->crud->addField(['name' => 'post_time',
            'type' => 'datetime',
            'label' => 'Post Time',
            'attributes' => ['readonly'=>'readonly']
        ]);
        $this->crud->addField(['name' => 'created_time',
            'type' => 'datetime',
            'label' => 'Created Time',
            'attributes' => ['readonly'=>'readonly']
        ]);
        $this->crud->addField(['name' => 'updated_time',
            'type' => 'datetime',
            'label' => 'Updated Time',
            'attributes' => ['readonly'=>'readonly']
        ]);

        $crawler_page_arr = DB::table('crawler_page')
                                ->join('crawler_website','crawler_page.crawler_website_id','=','crawler_website.id')
                                ->select('crawler_page.id', DB::raw('CONCAT(crawler_website.name,"-",crawler_page.name) as name'))
                                ->pluck('name', 'crawler_page.id');

        $this->crud->addColumn(['name' => 'crawler_page_id',
            'type' => "select_from_array",
            'options'=> $crawler_page_arr
        ]);
        $this->crud->addColumn(['name' => 'status',
            'type' => "select_from_array",
            'options'=> $this->crud->model::status(),
        ]);
        $this->crud->addColumn(['name' => 'status',
            'type' => "select_from_array",
            'options'=> $this->crud->model::status(),
        ]);
        $this->crud->addColumn(['name' => 'post_time',
            'type' => "datetime",
        ]);
        $this->crud->addColumn(['name' => 'created_time',
            'type' => "datetime",
        ]);
        $this->crud->addColumn(['name' => 'updated_time',
            'type' => "datetime",
        ]);

        // add asterisk for fields that are required in CrawlerPostRequest
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
        $request->request->remove("post_time");
        $request->request->remove("created_time");
        $request->request->set('updated_time',time());
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
