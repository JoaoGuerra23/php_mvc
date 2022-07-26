<?php

namespace App\Controllers;

use App\Helpers\SessionHelper;
use App\Helpers\UrlHelper;

/**
 * Base Controller
 * Loads the Models and Views
 */
abstract class AbstractController
{
    /**
     * @var SessionHelper
     */
    protected $sessionHelper;
    /**
     * @var UrlHelper
     */
    protected $urlHelper;

    public function __construct()
    {

        $this->sessionHelper = new SessionHelper();
        $this->urlHelper = new UrlHelper();

    }

    /**
     *
     * Load model
     *
     * @param $model
     * @return mixed
     */
    public function model($model)
    {
        // Require model file
        require_once '../App/Models/' . $model . '.php';

        // Instantiate model
        return new $model();
    }

    /**
     *
     * Load view
     *
     * @param $view
     * @param $data
     * @return void
     */
    public function view($view, $data = [])
    {
        // Check for view file
        if (file_exists('../App/Views/' . $view . '.php')) {
            require_once '../App/Views/' . $view . '.php';
        } else {
            // View does not exist
            die('View does not exist');
        }
    }
}
