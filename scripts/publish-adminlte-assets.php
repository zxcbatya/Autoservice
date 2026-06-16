<?php

declare(strict_types=1);

/**
 * Копирует AdminLTE и плагины в public/vendor (кроссплатформенная замена ln -s).
 */

$root = dirname(__DIR__);

$copies = [
    'vendor/almasaeed2010/adminlte/dist' => 'public/vendor/dist',
    'vendor/almasaeed2010/adminlte/plugins' => 'public/vendor/plugins',
];

if (is_dir($root . '/vendor/studio-42/elfinder')) {
    $copies['vendor/studio-42/elfinder'] = 'public/vendor/elfinder-2.1.62';
}

function removePath(string $path): void
{
    if (is_link($path)) {
        unlink($path);

        return;
    }

    if (! is_dir($path)) {
        if (is_file($path)) {
            unlink($path);
        }

        return;
    }

    $items = scandir($path);
    if ($items === false) {
        return;
    }

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        removePath($path . DIRECTORY_SEPARATOR . $item);
    }

    rmdir($path);
}

function copyDirectory(string $source, string $destination): void
{
    if (! is_dir($source)) {
        fwrite(STDERR, "Source not found: {$source}\n");
        exit(1);
    }

    if (! is_dir($destination) && ! mkdir($destination, 0755, true) && ! is_dir($destination)) {
        fwrite(STDERR, "Cannot create: {$destination}\n");
        exit(1);
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST,
    );

    foreach ($iterator as $item) {
        $target = $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathname();

        if ($item->isDir()) {
            if (! is_dir($target) && ! mkdir($target, 0755, true) && ! is_dir($target)) {
                fwrite(STDERR, "Cannot create directory: {$target}\n");
                exit(1);
            }
        } elseif (! copy($item->getPathname(), $target)) {
            fwrite(STDERR, "Cannot copy: {$item->getPathname()}\n");
            exit(1);
        }
    }
}

foreach ($copies as $from => $to) {
    $source = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $from);
    $target = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $to);

    echo "Publishing {$from} -> {$to}\n";

    if (file_exists($target)) {
        removePath($target);
    }

    $parent = dirname($target);
    if (! is_dir($parent) && ! mkdir($parent, 0755, true) && ! is_dir($parent)) {
        fwrite(STDERR, "Cannot create: {$parent}\n");
        exit(1);
    }

    copyDirectory($source, $target);
}

echo "AdminLTE assets published successfully.\n";
