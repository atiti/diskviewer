<?php

class Template {
    private $buffer = "";
    private $orig_buffer = "";
    private $replace_main = false;
    public function __construct($filename) {
        $fd = fopen($filename, "r");
        if ($fd) {
            $this->buffer = fread($fd, filesize($filename));
	    $this->orig_buffer = $this->buffer;
            fclose($fd);
        }
    }
    public function reset() {
	$this->buffer = $this->orig_buffer;	
    }
    public function replace($vars_to_replace) {
        $SEPARATOR = "@@";
        foreach ($vars_to_replace as $key => $value) {
            $this->buffer = str_replace($SEPARATOR.$key.$SEPARATOR, $value, $this->buffer);
        }       
    }
    public function getbuffer() {
	//echo $this->buffer;
	$this->buffer = preg_replace('/\<!--IF 0--\>(.+?)\<!--\/IF--\>/s','',$this->buffer);
	$this->buffer = str_replace("<!--IF 1-->", "", $this->buffer);
	$this->buffer = str_replace("<!--/IF-->", "", $this->buffer);
    	return $this->buffer;
    }
    public function display() {
	echo $this->getbuffer();
    }
}

?>
