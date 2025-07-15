<?php

use Gregwar\Captcha\CaptchaBuilder;

$builder = new CaptchaBuilder;
$builder->build(80, 30);

$_SESSION['captcha'] = $builder->getPhrase();

header("Content-Type: image/jpeg");
$builder->output();
