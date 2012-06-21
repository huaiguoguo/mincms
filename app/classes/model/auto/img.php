<?php
class Model_Auto_Img extends \Orm\Model
{
	protected static $_table_name = 'auto_img';
	protected static $_primary_key = array('id');
	protected static $_belongs_to =	
			array (
  'r_uid' => 
  array (
    'key_from' => 'uid',
    'model_to' => 'Model_Users',
    'key_to' => 'id',
    'cascade_save' => false,
    'cascade_delete' => false,
  ),
  'r_album' => 
  array (
    'key_from' => 'album',
    'model_to' => 'Model_Auto_album',
    'key_to' => 'id',
    'cascade_save' => false,
    'cascade_delete' => false,
  ),
);

}
