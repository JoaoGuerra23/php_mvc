<?php

namespace App\Controllers;

class Posts extends AbstractController
{
    /**
     * @var mixed
     */
    private $postModel;
    /**
     * @var mixed
     */
    private $userModel;


    public function __construct()
    {
        parent::__construct();
        if (!$this->sessionHelper->isLoggedIn()) {
            $this->urlHelper->redirect('users/login');
        }

        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }


    /**
     * @return void
     */
    public function index()
    {
        // Get Posts
        $posts = $this->postModel->getPosts();

        $data = [
            'Posts' => $posts
        ];

        $this->view('Posts/index', $data);
    }

    /**
     * @return void
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''
            ];

            // Validate data
            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }
            if (empty($data['body'])) {
                $data['body_err'] = 'Please enter body text';
            }

            // Make sure no errors
            if (empty($data['title_err']) && empty($data['body_err'])) {
                // Validated
                if ($this->postModel->addPost($data)) {
                    $this->sessionHelper->flash('post_message', 'Post Added');
                    $this->urlHelper->redirect('Posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('Posts/add', $data);
            }

        } else {
            $data = [
                'title' => '',
                'body' => ''
            ];

            $this->view('Posts/add', $data);
        }
    }

    /**
     * @param $id
     * @return void
     */
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''
            ];

            // Validate data
            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }
            if (empty($data['body'])) {
                $data['body_err'] = 'Please enter body text';
            }

            // Make sure no errors
            if (empty($data['title_err']) && empty($data['body_err'])) {
                // Validated
                if ($this->postModel->updatePost($data)) {
                    $this->sessionHelper->flash('post_message', 'Post Updated');
                    $this->urlHelper->redirect('Posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('Posts/edit', $data);
            }

        } else {
            // Get existing post from model
            $post = $this->postModel->getPostById($id);

            // Check for owner
            if ($post->user_id != $_SESSION['user_id']) {
                $this->urlHelper->redirect('Posts');
            }

            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body
            ];

            $this->view('Posts/edit', $data);
        }
    }

    /**
     * @param $id
     * @return void
     */
    public function show($id)
    {
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);

        $data = [
            'post' => $post,
            'user' => $user
        ];

        $this->view('Posts/show', $data);
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get existing post from model
            $post = $this->postModel->getPostById($id);

            // Check for owner
            if ($post->user_id != $_SESSION['user_id']) {
                $this->urlHelper->redirect('Posts');
            }

            if ($this->postModel->deletePost($id)) {
                $this->sessionHelper->flash('post_message', 'Post Removed');
                $this->urlHelper->redirect('Posts');
            } else {
                die('Something went wrong');
            }
        } else {
            $this->urlHelper->redirect('Posts');
        }
    }
}
