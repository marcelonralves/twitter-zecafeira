<?php

use Src\Twitter;

require_once 'Twitter.php';
require_once __DIR__ . '/vendor/autoload.php';

if(date('l') == 'Wednesday') {
  $twitter = new Twitter();
  $twitter->postTweet();
}