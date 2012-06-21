<?php
class Model_Auto_Post extends \Vendor\Model
{
	protected static $_table_name = 'auto_post';
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
);

}
