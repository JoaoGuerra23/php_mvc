<?php

namespace App\Libraries;

/**
 * App Core Class
 * Creates URL & Loads Core Controller
 * URL FORMAT - /controller/method/params
 */
class Core
{
    /**
     * @var string
     */
    protected $currentController = 'Pages';
    /**
     * @var string
     */
    protected $currentMethod = 'index';
    /**
     * @var array
     */
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        //Look in controllers for controller for first value
        if (file_exists('../App/Controllers/' . ucwords($url[0]) . '.php')) {
            //If exists, set as controller
            $this->currentController = ucwords($url[0]);
            //Unset 0 Index
            unset($url[0]);
        }

        //Require de controller
        $class = "\App\Controllers\\" . $this->currentController;

        //Instantiate controller class
        $this->currentController = new $class;

        //Check for second part of url
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];

                unset($url[1]);
            }
        }

        //Get params
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    /**
     * @return false|string[]|void
     */
    public function getUrl()
    {

        if (isset($_SERVER['REQUEST_URI'])) {

            $url = ltrim($_SERVER['REQUEST_URI'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);

        }

    }

}
