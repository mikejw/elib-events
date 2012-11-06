<?php

namespace Empathy\ELib\Storage;

use Empathy\MVC\Entity;

class BlogComment extends Entity
{
    const TABLE = 'blog_comment';

    public $id;
    public $blog_id;
    public $user_id;
    public $status;
    public $stamp;
    public $heading;
    public $body;

    public function validates()
    {
        if ($this->body == '') {
            $this->addValError('Invalid body');
        }
    }

}
