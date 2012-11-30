<?php

namespace Empathy\ELib\File;

use Empathy\ELib\File;

class GImage extends File
{

    public function create()
    {
        $this->orig = new \Gmagick($this->target);
        $this->origX = $this->orig->getimagewidth();
        $this->origY = $this->orig->getimageheight();
    }

    public function spawn($newX, $newY, $prefix, $quality)
    {
        $newImage = clone $this->orig;
        $newTarget = $this->target_dir.$prefix.$this->filename;
        $newImage->resizeimage($newX, $newY, null, 1);
        $newImage->write($newTarget);
        $this->destroy($newImage);
    }

    public function destroy($image)
    {
        $image->destroy();
    }

}
