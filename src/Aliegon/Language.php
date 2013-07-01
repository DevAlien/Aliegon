<?php
namespace Aliegon;

/**
 * Language file.
 *
 * <code>
 * $session = Session::getInstance();
 * $session->myVar = 'my value';
 * echo $session->myVar;
 * </code>
 */
final class Language {

    private $lang = array();
    private $language;
    private $session;
    private $spyc;
    private $config;

    public function __construct(\Aliegon\Config $config, \Aliegon\Spyc $spyc) {
        $this->config = $config;
        $this->spyc = $spyc;
        if(isset($_GET['lang']) && $this->exists($_GET['lang']))
            $this->language = $_GET['lang'];
        else{
            $this->language = $this->get('lang');
        }
        $this->setLanguage();
    }

    public function get($key, $subkey = false) {
        $key = strtolower($key);
        $subkey = strtolower($subkey);
        if(isset($subkey) && $subkey == false){
            if (array_key_exists($key, $this->lang)) {
                return $this->lang[$key];
            } else {
                return '<span style="color: #00CD00">' . $key . '</span><span style="color: red">' . $this->language . '</span>';
            }
        }
        else{
            if (array_key_exists($key, $this->lang) && array_key_exists($subkey, $this->lang[$key])) {
                return $this->lang[$key][$subkey];
            } else {
                return '<span style="color: #00CD00">' . $key . '+ ' . $subkey  . '</span><span style="color: red">' . $this->language . '</span>';
            }
        }
    }

    private function exists($lang){
        return file_exists('./app/language/' . $lang . '/main.yaml');
    }
    
    private function setLanguage() {
        if(!$this->exists($this->language)){
            if(!$this->config->has('lang')){
                return false;
            }
            else
                $lang = $this->config->get('lang');
        }
        else
            $lang = $this->language;

        $language = $this->spyc->loadLanguageFile(ROOT . '/app/Language/' . $lang . '/main.yaml');
        $this->lang = $language;
        //$this->session->lang = $lang;
    }

}