<?php
class Model_Auto_Media extends \Vendor\Model
{
	protected static $_table_name = 'auto_media';
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
  'r_file' => 
  array (
    'key_from' => 'file',
    'model_to' => 'Model_File',
    'key_to' => 'id',
    'cascade_save' => false,
    'cascade_delete' => false,
  ),
);

}
