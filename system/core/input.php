<?php
class input {
    function __construct() {
        echo magic_quotes_gpc() ? 1 : 0;
    }

    public function item($index) {
        if (isset($this->segments[$index])) {
            return $this->segments[$index];
        } else {
            return '';
        }
    }
}