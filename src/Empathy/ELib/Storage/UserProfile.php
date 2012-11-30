<?php

namespace Empathy\ELib\Storage;

use Empathy\MVC\Entity,
    Empathy\MVC\Validate;



class UserProfile extends Entity
{
    const TABLE = 'user_profile';

    public $id;
    public $fullname;
    public $picture;
    public $about;

    public function validates()
    {
        if ($this->doValType(Validate::TEXT, 'fullname', $this->fullname, false)) {
            if (!strpos($this->fullname, ' ')) {
                $this->addValError('Must have space(s)', 'fullname');
            }
        }
        $this->doValType(Validate::TEXT, 'picture', $this->picture, true);
        $this->doValType(Validate::TEXT, 'about', $this->about, true);
    }
}
