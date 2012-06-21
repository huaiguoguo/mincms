#MinCMS is a real cool cms.
#it is base on FuelPHP 1.2, needs php 5.3+,mcrypt,gd2 

need create dir, 

mkdir cache 

chmod -R 777 

cache mkdir public/upload 

chmod -R 777 public/upload 

chmod -R 777 assets/cache 

it work fine on content module. 

it is a good way to create content type and fields. 

like drupal "Content Construction Kit" very easy use plugin. 

like swfupload ,ckeditor ETC we will keep working for mincms

 


how to install?

databse is in install/mincms.sql

you should import to mysql.

then config app\config\development\db.php 

if work fine, then into mysql change table name 'users', column email to your own email.

login url

/admins

username : admin

password : 111111


when you logined,config your website,such as smtp for send mail.

Technology:

FuelPHP 1.2             http://fuelphp.com/ [PHP,one php5.3+ framework]

theme use bootstrap      https://github.com/twitter/bootstrap [javascript css image]
 


