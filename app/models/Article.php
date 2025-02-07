<?php

class article extends model
{
    public $errors = [];
    protected $table = "article";

    protected $afterSelect= [
        'get_category_id',
        'get_user_id',
    ];

    protected $queryColumns= [
        'title',
        'description',
        'user_id',
        'price',
        'primary_subject',
        'article_image',
        'category_id',
        'content',
        'created_at',
        'text_content'
    ];
    public function validate($data): bool {
        $this->errors = [];
        if (empty($data['title'])) {
            $this->errors['title'] = "A article title is required";
        }elseif(!preg_match("/^[a-zA-Z \_\-\&]+$/",trim((string) $data['title']))){
            $this->errors['title'] = "A article title onley can have small and capital letters, spaces or [_&-]";
        }

        if (empty($data['primary_subject'])) {
            $this->errors['primary_subject'] = "Primary subject is required";
        }elseif(!preg_match("/^[a-zA-Z \_\-\&]+$/",trim((string) $data['primary_subject']))){
            $this->errors['primary_subject'] = "Primary subject onley can have small and capital letters, spaces or [_&-]";
        }

        if (empty($data['price'])) {
            $this->errors['price'] = "price is required";
        }elseif(!preg_match("/^\\d+\$/",trim((string) $data['price']))){
            $this->errors['price'] = "price onley can only be an integer";
        }

        if (empty($data['category_id'])) {
            $this->errors['category_id'] = "Category is required";
        }
        return empty($this->errors);
    }

    protected function get_category_id(array $rows): array
    {
        $db = new database();
        if (!empty($rows[0]['category_id'])) {
            foreach ($rows as $key => $row) {
                $query = "select * from categories where id = :id limit 1";
                $cate = $db->query($query,['id'=>$row['category_id']]);
                if (!empty($cate)) {
                    $rows[$key]['category_row'] = $cate[0];
                }
            }
        }
        return $rows;
    }
    protected function get_user_id(array $rows): array
    {
        $db = new database();
        if (!empty($rows[0]['user_id'])) {
            foreach ($rows as $key => $row) {
                $query = "select * from users where user_id = :id limit 1";
                $user = $db->query($query,['id'=>$row['user_id']]);
                if (!empty($user)) {
                    $user[0]['name'] = $user[0]['firstname']." ".$user[0]['lastname'];
                    $rows[$key]['user_row'] = $user[0];
                }
            }
        }
        return $rows;
    }
}