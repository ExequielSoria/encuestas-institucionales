<?php

function redirigir($url) {
    header("Location: $url");
    exit;
}
