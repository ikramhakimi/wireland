<?php

declare(strict_types=1);

$project_root = dirname(__DIR__);
$dist_root    = $project_root . '/dist';

function fail_export(string $message): never
{
  fwrite(STDERR, $message . PHP_EOL);
  exit(1);
}

function ensure_directory(string $directory): void
{
  if (is_dir($directory)) {
    return;
  }

  if (!mkdir($directory, 0755, true) && !is_dir($directory)) {
    fail_export('Unable to create directory: ' . $directory);
  }
}

function delete_directory_contents(string $directory): void
{
  if (!is_dir($directory)) {
    return;
  }

  $items = scandir($directory);
  if ($items === false) {
    fail_export('Unable to read directory: ' . $directory);
  }

  foreach ($items as $item) {
    if ($item === '.' || $item === '..') {
      continue;
    }

    $path = $directory . '/' . $item;

    if (is_dir($path)) {
      delete_directory_contents($path);

      if (!rmdir($path)) {
        fail_export('Unable to remove directory: ' . $path);
      }

      continue;
    }

    if (!unlink($path)) {
      fail_export('Unable to remove file: ' . $path);
    }
  }
}

function copy_path(string $source, string $destination): void
{
  if (is_dir($source)) {
    ensure_directory($destination);

    $items = scandir($source);
    if ($items === false) {
      fail_export('Unable to read asset directory: ' . $source);
    }

    foreach ($items as $item) {
      if ($item === '.' || $item === '..' || strpos($item, '.') === 0) {
        continue;
      }

      copy_path($source . '/' . $item, $destination . '/' . $item);
    }

    return;
  }

  if (!is_file($source)) {
    fail_export('Missing asset for static export: ' . $source);
  }

  ensure_directory(dirname($destination));

  if (!copy($source, $destination)) {
    fail_export('Unable to copy asset: ' . $source);
  }
}

function render_route(string $project_root, string $request_path): string
{
  $server_state = $_SERVER;

  $_SERVER['REQUEST_URI'] = $request_path;
  $_SERVER['SCRIPT_NAME'] = '/index.php';

  ob_start();
  include $project_root . '/index.php';
  $html = ob_get_clean();

  $_SERVER = $server_state;

  if (!is_string($html) || $html === '') {
    fail_export('Static route rendered no HTML: ' . $request_path);
  }

  return $html;
}

ensure_directory($dist_root);
delete_directory_contents($dist_root);

$pages_root = $project_root . '/views/pages';
$page_files = new RecursiveIteratorIterator(
  new RecursiveDirectoryIterator($pages_root, FilesystemIterator::SKIP_DOTS),
);

$pages = [
  '/' => $dist_root . '/index.html',
];

foreach ($page_files as $page_file) {
  if (!$page_file->isFile() || $page_file->getExtension() !== 'php') {
    continue;
  }

  $page_name = substr($page_file->getPathname(), strlen($pages_root) + 1, -4);
  if ($page_name === 'home' || $page_name === '404') {
    continue;
  }

  $pages['/' . $page_name] = $dist_root . '/' . $page_name . '.html';
}

$pages['/404'] = $dist_root . '/404.html';

foreach ($pages as $request_path => $output_path) {
  $html = render_route($project_root, $request_path);

  ensure_directory(dirname($output_path));

  if (file_put_contents($output_path, $html) === false) {
    fail_export('Unable to write static page: ' . $output_path);
  }
}

copy_path($project_root . '/assets', $dist_root . '/assets');

fwrite(STDOUT, 'Exported static site to dist/.' . PHP_EOL);
