<?php

$app = require "../bootstrap/app.php";

echo $app->handle()->getContent();
