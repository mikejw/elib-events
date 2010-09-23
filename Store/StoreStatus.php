<?php

namespace ELib\Store;

class StoreStatus
{
  const CREATED = 0;
  const AVAILABLE = 1;
  const DELETED = 2;
  const SOLD_OUT = 3;

  public static function getStatus($status)
  {
    $status_text = '';
    switch($status)
      {
      case self::CREATED:
	$status_text = 'Hidden';
	break;
      case self::AVAILABLE:
	$status_text = 'Available';
	break;
      case self::DELETED:
	$status_text = 'Deleted';
	break;
      case self::SOLD_OUT:
	$status_text = 'Sold Out';
	break;
      default:
	break;
      }
    return $status_text;
  }
}
?>