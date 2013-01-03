<?php
Yii::import('ext.curl.ACurl');
/**
 * TApiConnection
 **/
class TTumblrApi extends CApplicationComponent
{
    /**
     * @var ACurl
     */
    private $_curl;

    /**
     * @var string api key from registered application
     */
    public $api_key;

    /**
     * @var string url for Tumblr Api requests
     **/
    protected $url = 'http://api.tumblr.com/v2';

    /**
     * @var hostname of the blog
     */
    private $_hostname;

    public function getCurl()
    {
        if($this->_curl===null) {
            $this->_curl=new ACurl();
        }
        return $this->_curl;
    }

    /**
     * If no hostname is set then the id of the TApiConnection
     * component will be used as the blog name
     * @return string the hostname of the blog
     **/
    public function getHostname()
    {
        if($this->_hostname===null) {
            $this->_hostname="{$this->id}.tumblr.com";
        }
        return $this->_hostname;
    }

    /**
     * If no . char is in the name then tumblr.com is appended
     * @param string $name the name of the blog
     */
    public function setHostname($name)
    {
        $this->_hostname=(strpos($name, '.')===false)?"{$name}.tumblr.com":$name;
    }

    public function blogUrl()
    {
        return "{$this->url}/blog/{$this->hostname}";
    }

    public function info()
    {
        return $this->request('info')->fromJSON();
    }

    public function avatar($size=null)
    {
        $size=(in_array($size,array(16, 24, 30, 40, 48, 64, 96, 128, 512)))?$size:64;
        return $this->request("avatar/{$size}")->info->url;
    }

    public function posts($params=array('reblog_info'=>'true','notes_info'=>'true'))
    {
        return $this->request('posts',$params)->fromJSON();
    }
    private function request($type,$params=array())
    {
        $params['api_key']=$this->api_key;
        $url=$this->blogUrl().'/'.$type.'?'.http_build_query($params);
        CVarDumper::dump($url,10,1);
        return $this->curl->get($url);
    }
}
