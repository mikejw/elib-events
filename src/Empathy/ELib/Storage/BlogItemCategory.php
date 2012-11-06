<?php

namespace Empathy\ELib\Storage;

use Empathy\MVC\Entity;

class BlogItemCategory extends Entity
{
    const TABLE = 'blog_item_category';

    public $blog_id;
    public $blog_category_id;

}
