<?php
class application {
    public function run() {
        Fl::logger()->debug("--------------");
        Fl::logger()->debug("[ Controller = " .base::controller()." ] [ IP = ".base::ip()." ] ", base::url());
        Fl::logger()->debug(" Agent : ", $_SERVER['HTTP_USER_AGENT']);

        if (count($_POST) > 0) {
            Fl::logger()->debug(" Post : ", json_encode($_POST));
        }
        if (count($_FILES) > 0) {
            Fl::logger()->debug(" File : ", json_encode($_FILES));
        }


    }
}
