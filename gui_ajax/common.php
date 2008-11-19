<?php

function microtime_float(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec+(float)$sec);
}

function format_user_list(&$data, $course) {
    global $CFG, $DB;
    $users = array();
    foreach($data as $v){
        $user['name'] = fullname($v);
        $user['url'] = $CFG->wwwroot.'/user/view.php?id='.$v->id.'&amp;course='.$course->id;
        $user['picture'] = print_user_picture($v->id, 0, $v->picture, false, true, false);
        $users[] = $user;
    }
    return $users;
}

class file_cache{
    private $dir = '';
    public function __construct($dir='/dev/shm'){
        $this->dir = $dir.'/chat_cache';
        if(!is_dir($this->dir)) {
            // create cache folder
            if(mkdir($this->dir, 777)) {
                $this->write('test', 'Deny from all');
            }
        }
    }
    private function write($name, $content){
        $name = $this->dir.'/'.$name.'.data';
        if (file_exists($name)) {
            unlink($name);
        }

        $fp = fopen($name, 'w');
        if($fp) {
            fputs($fp, $content);
            fclose($fp);
        }
    }
    public function get($name){
        $content = '';
        $fp = fopen($this->dir.'/'.$name.'.data', 'r');
        if ($fp){
            while(!feof($fp))
                $content .= fread($fp, 4096);
            fclose($fp);
            return unserialize($content);
        } else {
            return false;
        }
    }
    public function set($name, $content){
        $this->write($name, serialize($content));
    }
}
