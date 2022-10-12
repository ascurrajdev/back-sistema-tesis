<?php
namespace App\Notifications;
class WhatsappMessage{
    private $config = [];

    public function useText(){
        $this->config['type'] = 'text';
        return $this;
    }

    public function textBody($text){
        $this->config['text']['body'] = $text;
        return $this;
    }

    public function useTemplate(){
        $this->config['type'] = 'template';
        return $this;
    }

    public function templateName($name){
        $this->config['template']['name'] = $name;
        return $this;
    }

    public function templateLang($lang){
        $this->config['template']['language']['code'] = $lang;
        return $this;
    }

    public function to($phoneNumber){
        $this->config['to'] = $phoneNumber;
        return $this;
    }

    public function toArray(){
        return $this->config;
    }
}