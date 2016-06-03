<?php
class application {
    public function run() {
        Fl::logger()->debug("--------------");
        Fl::logger()->debug("[ Controller = " .base::controller()." ] [ IP = ".base::ip()." ] ", base::url());
        Fl::logger()->debug(" Agent : ", $_SERVER['HTTP_USER_AGENT']);
    }
}
