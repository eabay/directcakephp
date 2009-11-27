<?php
class CombineHelper extends AppHelper
{
	public $helpers = array('Html', 'Javascript');
	
	private $_pattern = ':url/combine.php?type=:type&files=:files';
	
	public function js($files, $url = '..')
	{
		echo $this->Javascript->link($this->_format($files, $url));
	}
    
    public function css($files, $url = '..')
    {
        echo $this->Html->css($this->_format($files, $url, 'css'));
    }
	
	private function _format($files = array(), $url, $type = 'javascript')
	{
		return String::insert($this->_pattern, array('type' => $type, 'url' => $url, 'files' => implode(',', $files)));
	}
}