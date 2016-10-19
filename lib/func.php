<?php

function _require($path, $exclude = []) {
    if (is_dir($path)) {
        foreach (new DirectoryIterator($path) as $fileinfo) {
            if (empty($exclude)) {
                if (!$fileinfo->isDot() && $fileinfo->getExtension() == 'php') {
                    require($fileinfo->getPathname());
                }
            } else {
                if (!$fileinfo->isDot() && $fileinfo->getExtension() == 'php' && !in_array($fileinfo->getFilename(), $exclude)) {
                    require($fileinfo->getPathname());
                }
            }
        }
    } elseif (is_file($path)) {
        require($path);
    } else {
        throw new Exception("File not found: " . $path);
    }
}

function _files($path, $extensions = [], $exclude = []) {
    if (!is_array($extensions) && !empty($extensions)) {
        $extensions = [$extensions];
    }

    if (!is_array($exclude) && !empty($exclude)) {
        $exclude = [$exclude];
    }

    $files = [];
    if (is_dir($path)) {
        foreach (new DirectoryIterator($path) as $fileinfo) {
            if (empty($extensions)) {
                if (empty($exclude)) {
                    if (!$fileinfo->isDot() && $fileinfo->isFile()) {
                        $files[] = basename($fileinfo->getPathname(), '.' . pathinfo($fileinfo->getPathname(), PATHINFO_EXTENSION));
                    }
                } else {
                    if (!$fileinfo->isDot() && $fileinfo->isFile() && !in_array($fileinfo->getFilename(), $exclude)) {
                        $files[] = basename($fileinfo->getPathname(), '.' . pathinfo($fileinfo->getPathname(), PATHINFO_EXTENSION));
                    }
                }
            } else {
                if (empty($exclude)) {
                    if (!$fileinfo->isDot() && in_array($fileinfo->getExtension(), $extensions)) {
                        $files[] = basename($fileinfo->getPathname(), '.' . pathinfo($fileinfo->getPathname(), PATHINFO_EXTENSION));
                    }
                } else {
                    if (!$fileinfo->isDot() && in_array($fileinfo->getExtension(), $extensions) && !in_array($fileinfo->getFilename(), $exclude)) {
                        $files[] = basename($fileinfo->getPathname(), '.' . pathinfo($fileinfo->getPathname(), PATHINFO_EXTENSION));
                    }
                }
            }
        }
    } else {
        throw new Exception("Dir not found: " . $path);
    }

    return $files;
}

function _contains($needle, $haystack) {
    return (strpos($haystack, $needle) !== false);
}
?>