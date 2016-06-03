<?php
class application {
    public function run() {
        Fl::logger()->debug("--------------");
        Fl::logger()->debug("[ Service = " . $this->_service." ] [ IP = ".common::getIp()." ] ", 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        Fl::logger()->debug(" Agent : ", $_SERVER['HTTP_USER_AGENT']);
    }
}