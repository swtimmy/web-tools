<?php

namespace App\Http\Controllers\Admin;

use Backpack\PageManager\app\Http\Controllers\Admin\PageCrudController;
//use Backpack\PageManager\App\Http\Controllers\Admin\PageCrudController as OriginalController;

class CenterPageController extends PageCrudController
{
    
    public function __construct($template_name = false)
    {
        parent::__construct();
        $this->crud->setModel("App\Models\CenterPage");

    }

    public function getTemplates($template_name = false)
    {
        $templates_array = [];

        $templates_trait = new \ReflectionClass('App\PageTemplates');
        $templates = $templates_trait->getMethods(\ReflectionMethod::IS_PRIVATE);

        if (! count($templates)) {
            abort(503, trans('backpack::pagemanager.template_not_found'));
        }
        return $templates;
    }

}
