<?php

namespace App\Controllers;

class Pages extends AbstractController
{

    /**
     * @return void
     */
    public function index()
    {
        $data = [
            'title' => 'PHP MVC Project',
            'description' => 'Simple social network built with PHP'
        ];

        $this->view('Pages/index', $data);
    }

    /**
     * @return void
     */
    public function about()
    {
        $data = [
            'title' => 'About Us',
            'description' => 'App to share Posts with other Users'
        ];

        $this->view('Pages/about', $data);
    }
}
