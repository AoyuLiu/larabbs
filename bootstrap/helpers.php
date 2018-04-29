<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function make_excerpt($value, $length=200)
{
   $excerpt = trim(preg_replace('/\r\n|\r|\n+/','',strip_tags($value) ));
   //辅助方法 见字符串
   return str_limit($excerpt, $length);
}
