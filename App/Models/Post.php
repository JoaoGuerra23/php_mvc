<?php

namespace App\Models;

use App\Libraries\Database;

class Post
{

    /**
     * @var Database
     */
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * @return mixed
     */
    public function getPosts()
    {
        $this->db->query('SELECT *,
                        Posts.id as postId,
                        Users.id as userId,
                        Posts.created_at as postCreated,
                        Users.created_at as userCreated
                        FROM Posts
                        INNER JOIN Users
                        ON Posts.user_id = Users.id
                        ORDER BY Posts.created_at DESC
                        ');

        return $this->db->resultSet();
    }

    /**
     * @param $data
     * @return bool
     */
    public function addPost($data)
    {
        $this->db->query('INSERT INTO Posts (title, user_id, body) VALUES(:title, :user_id, :body)');
        // Bind values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':body', $data['body']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $data
     * @return bool
     */
    public function updatePost($data)
    {
        $this->db->query('UPDATE Posts SET title = :title, body = :body WHERE id = :id');
        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getPostById($id)
    {
        $this->db->query('SELECT * FROM Posts WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deletePost($id)
    {
        $this->db->query('DELETE FROM Posts WHERE id = :id');
        // Bind values
        $this->db->bind(':id', $id);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}