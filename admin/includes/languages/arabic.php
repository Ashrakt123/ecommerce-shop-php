<?php
function lang ($phrase){
    static $lang =array(
        'message' => 'welcome arabic',
        'admin' => 'adminstrator arabic'
    );
        return $lang[$phrase];
}
