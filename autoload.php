<?php

spl_autoload_register(function ($class) {
    $possible_files = [];
    $server_root = __DIR__ . "/";

    // class files
    $possible_files[] = ($server_root . str_replace("\\", DIRECTORY_SEPARATOR, $class) . ".php");

    // namespace files (containing the desired class)
    $parts = explode("\\", $class);
    array_pop($parts);
    if (count($parts) > 0)
        $possible_files[] = ($server_root . join(DIRECTORY_SEPARATOR, $parts) . ".php");

    foreach ($possible_files as $f) {
        if (!file_exists($f)) continue;
        require_once($f);
        return true;
    }

    return false;
});
