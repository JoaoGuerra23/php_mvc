<?php

class Pages extends Controller
{
    public function __construct()
    {

    }

    /**
     * @return void
     */
    public function index()
    {
        $data = [
            'title' => 'PHP MVC Project',
            'description' => 'Simple social network built with PHP'
        ];

        $this->view('pages/index', $data);
    }

    /**
     * @return void
     */
    public function about()
    {
        $data = [
            'title' => 'About Us',
            'description' => 'App to share posts with other users'
        ];

        $this->view('pages/about', $data);
    }
}