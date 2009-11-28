<?php
class DirectController extends AppController
{
	public $name = 'Direct';
    
    public $uses = array();
    
    public $components = array('Session');
	
	public $layout = 'ajax';
	
	public $autoRender = false;
	
	private $_api;
	private $_apiNamespace = 'Ext.app';
	private $_apiDescriptor = 'Ext.app.REMOTING_API';
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		
        App::import('Vendor', 'ExtDirect_API', array('file' => 'ExtDirect/API.php'));
        App::import('Vendor', 'ExtDirect_CacheProvider', array('file' => 'ExtDirect/CacheProvider.php'));
        App::import('Vendor', 'ExtDirect_Router', array('file' => 'ExtDirect/Router.php'));
        
        $this->_api = new ExtDirect_API();
	}
	
	public function api($output = true)
	{
        $cache = new ExtDirect_CacheProvider(CACHE.DS.'direct_cache');
        
		$this->_api->setRouterUrl(Router::url('router'));
		$this->_api->setCacheProvider($cache);
		$this->_api->setNamespace($this->_apiNamespace);
		$this->_api->setDescriptor($this->_apiDescriptor);
		$this->_api->setDefaults(array(
	        'autoInclude' => true,
	        'basePath' => APP.'vendors'.DS.'directclasses'
	    ));
		
	    /**
	     * TODO classes (controller classes(!)) should be automagically added to api
	     */
		$this->_api->add(
		    array(
		        'Echo' => array('prefix' => 'Class_'),
		        'Exception' => array('prefix' => 'Class_'),
		        'Time'
		    )
		);
		
		if ($output)
		    $this->_api->output();
		
		$this->Session->write('ext-direct-state', $this->_api->getState());
	}
    
    public function router()
    {
		if(!$this->Session->read('ext-direct-state'))
		    $this->_api(false);
		
		$this->_api->setState($this->Session->read('ext-direct-state'));
		  
		$router = new ExtDirect_Router($this->_api);
		$router->dispatch();
		$router->getResponse(true);
    }
}