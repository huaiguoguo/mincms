<?php

namespace Xvp;

class Pagecache
{
    const EXPIRED_HOUR  = 3600;
    const EXPIRED_DAY   = 86400;
    const EXPIRED_WEEK  = 604800;
    const EXPIRED_MONTH = 2592000;

	/**
	 * Is cache enabled?
	 * @var boolean
	 */
    protected $_cache_enabled = false;

    /**
     * Request object
     * @var \Request
     */
    protected $_request  = null;

    /**
     * Response object
     * @var \Response
     */
    protected $_response = null;

    /**
     * Do we need to minify the cached output?
     * @var boolean
     */
    protected $_minified = null;

    /**
     * Path where we will save our cached files
     * @var string
     */
    protected $_cache_dir = null;

    /**
     * Do we need to output a special label in the cached response?
	 * @var boolean
	 */
    protected $_write_output_status = false;

    public function __construct()
    {
        \Config::load('fuel-pagecache', true);
        $this->_cache_dir = \Config::get('fuel-pagecache.cache_dir');

        if (substr($this->_cache_dir, -1) == '/')
        { 
            $this->_cache_dir = substr($this->_cache_dir, 0, -1);
        }         
    }

    /**
     * Set the response object
     * @param \Response $response
     */
    public function setResponse(\Response $response)
    {
        $this->_response = $response;
    }

    /**
     * Set the request object
     * @param \Request $request
     */
    public function setRequest(\Request $request)
    {
        $this->_request = $request;
    }

    /**
     * Enable the minified flag
     */
    public function enableMinified()
    {
        $this->_minified = true;
    }

    /**
     * Enable the cache system
     */
    public function enableCache()
    {
        $this->_cache_enabled = true;
    }

    /**
     * Disable the cache system
     */
    public static function disableCache()
    {
        $this->_cache_enabled = false;
    }

    /**
     * Indicates if the request is cacheable or not
     * @return boolean
     */
    public function isCacheable()
    {        
        if ($this->_response->status == 200 && $this->_cache_enabled && count($_GET) == 0 && count($_POST) == 0)
        {
            return true;
        }
        return false;
    }

    /**
     * Cache the response based on the parameter $uri
     * @param string $uri
     */
    public function cache($uri)
    {
        $base = $this->_cache_dir;

        // try to create the base cache dir
        if (!is_dir($base))
        {
            mkdir($base, 0777);
            chmod($base, 0777);
        }

        
        // create the path using the uri structure
        $paths = array();

        if ($uri)
        {
            $paths = explode('/', $uri);
        }

        
        $path = $base;

        foreach ($paths as $sub)
        {
        	// blank segments are not allowed
            if ($sub != '')
            {
                $path .= "/$sub";

                if (!is_dir($path))
                {
                    mkdir($path, 0777);
                    chmod($path, 0777);
                }
            }
        }

        // Cached file path
        $file = "$path/index.html";

        // do not overwrite
        if (!is_file($file))
        {
            $content = $this->_response->body();

            if ($this->_minified)
            {
                $search  = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
                $replace = array('>', '<', '\\1');
                $content = preg_replace($search, $replace, $content);
            }

            if ($this->_write_output_status)
            {
            	$content .= PHP_EOL . '<!-- CACHED: ' . date('Y-m-d H:i:s') . ' -->';
            }

            $fh = fopen($file, 'w+');

            fwrite($fh, $content, strlen($content));

            fclose($fh);

            chmod($file, 0777);
        }
    }
    
    /**
     * Deletes home cache
     */
    public function cleanupHome()
    {
        $path  = $this->_cache_dir.'/index.html';
        @unlink($path);
    }
    
    /**
     * Cleans the whole cache.
     * If $expired is passed, the file modification time will be checked against $expired.
     * If "file modification time" + $expired < "actual time" --> file will be removed
     * @param integer|boolean $expired
     */
    public function cleanup($expired = false)
    {
        $this->_cleanup($this->_cache_dir, $expired);
    }

    /**
     * Method to delete a specific path
     * Usage: 
     * - cleanupDirectory('users/list');
     * - cleanupDirectory('product/automatic-spam-checker');
     */
    public function cleanupDirectory($directory, $expired = false)
    {
        $this->_cleanup($this->_cache_dir . '/' . $directory, $expired);
    }
    
    /**
     * Deletes files and directories recursively
     * @param string $directory
     * @param integer|boolean $expired 
     * @return  boolean
     */
    protected function _cleanup($directory, $expired = false)
    {   
        if ($directory == '/')
        {
            return;
        }
        
        if (substr($directory, -1) == '/')
        { 
            $directory = substr($directory, 0, -1);
        } 
        
        if (!is_dir($directory) || !is_readable($directory))
        { 
            return;
        }
        
        $directory_handle = opendir($directory);
    
        while ($contents = readdir($directory_handle))
        {            
            // Do not include directories starting with dot (.)
            if (strpos($contents, '.') !== 0)
            { 
                $path = $directory.'/'.$contents;                
    
                // if it's a folder, remove contents and try to remove folder at the end.
                // otherwise, remove the index file
                if (is_dir($path))
                { 
                    self::_cleanup($path);                                         
                    @rmdir($path);     
                } 
                else 
                {        
                    if ($expired) 
                    {                        
                        if(filemtime($path) + $expired > time()) 
                        {
                            @unlink($path);                                   
                        }
                    }
                    else 
                    {
                        @unlink($path);
                    }                
                }
            } 
        }
    
        closedir($directory_handle);
    }    

    /**
     * Get the number of cached files stored in the filesystem
     * @return integer
     */
    public function getStats()
    {
        $directory = $this->_cache_dir;

        $file_count = 0;

        $this->_getStats($directory, $file_count);

        return $file_count;
    }

    /**
     * Counts cached files recursively
     * @param string $directory
     * @param integer $file_count
     */
    protected function _getStats($directory, &$file_count)
    {   
        if (substr($directory, -1) == '/')
        { 
            $directory = substr($directory, 0, -1);
        } 
        
        if (!is_dir($directory) || !is_readable($directory))
        { 
            return;
        }
        
        $directory_handle = opendir($directory);
    
        while ($contents = readdir($directory_handle))
        {            
            // Do not include directories starting with dot (.)
            if (strpos($contents, '.') !== 0)
            { 
                $path = $directory.'/'.$contents;                
    
                // if it's a folder, remove contents and try to remove folder at the end.
                // otherwise, remove the index file
                if (is_dir($path))
                { 
                    self::_getStats($path, $file_count);                    
                } 
                else 
                {        
                    $file_count++;
                }
            } 
        }
    
        closedir($directory_handle);
    }
}