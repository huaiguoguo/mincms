fuel-pagecache
==============

Static cache for Fuelphp framework

This is a port of Lysender's kohana module
https://github.com/lysender/pagecache

How to
------

1. Enable the package in your fuel instance

2. Create a 'cache' folder in your docroot (or change config to update folder name)

3. Add this code to the Controller_Template 'before' function:

``` php
    $this->pagecache = new Pagecache();
    $this->pagecache->setResponse($this->response);
    $this->pagecache->setRequest($this->request);
```

4. Add this code to the Controller_Template 'after' function:
   (inside auto_render snippet)

``` php    
    if ($this->pagecache->isCacheable()) {
       $this->pagecache->cache($_SERVER['REQUEST_URI']);
    }
```
    
5. Enable cache in your controller

	$this->_pagecache->enableCache();

6. Update your .htaccess to have the following code

```
    RewriteRule ^/(.*)/$ /$1 [QSA]
    RewriteRule ^$ cache/index.html [QSA]
    RewriteRule ^([^.]+)/$ cache/$1/index.html [QSA]
    RewriteRule ^([^.]+)$ cache/$1/index.html [QSA]

    RewriteCond %{REQUEST_FILENAME} -s [OR]
    RewriteCond %{REQUEST_FILENAME} -l [OR]
    RewriteCond %{REQUEST_FILENAME} -f [OR]
    RewriteCond %{REQUEST_FILENAME} -d

    RewriteRule ^.*$ - [NC,L]
    RewriteRule ^.*$ index.php [NC,L]   
```
