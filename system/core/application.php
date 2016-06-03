<?php
class application {
    public function run() {
        $service = sprintf('%s.%s', FL::uri()->segments[0], FL::uri()->segments[1]);
        Fl::logger()->debug("--------------");
        Fl::logger()->debug("[ Service = " .$service." ] [ IP = ".common::getIp()." ] ", 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        Fl::logger()->debug(" Agent : ", $_SERVER['HTTP_USER_AGENT']);
    }
}