<?php

namespace ELib\DSection;
use ELib\Model;

use Empathy\Controller\CustomController;

class BaseTemplate extends CustomController
{
  protected $section;
  protected $data_item;

  public function __construct($boot)
  {
    parent::__construct($boot);
    $this->section = Model::load('SectionItem');
    $this->data_item = Model::load('DataItem');
  }



}
?>