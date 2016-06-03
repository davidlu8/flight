<?php
class application {
    public function run() {
        $controller = sprintf('%s.%s', FL::uri()->segments[0], FL::uri()->segments[1]);
        Fl::logger()->debug("--------------");
        Fl::logger()->debug("[ Controller = " .$controller." ] [ IP = ".base::getIp()." ] ", base::currentPath());
        Fl::logger()->debug(" Agent : ", $_SERVER['HTTP_USER_AGENT']);
    }
}

echo '<pre>';
print_r($_SERVER);