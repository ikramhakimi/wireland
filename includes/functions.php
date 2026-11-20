<?php

if (!function_exists('e')) {
  function e($value): string
  {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
  }
}

require_once __DIR__ . '/svg.php';
require_once __DIR__ . '/lang.php';

if (!function_exists('include_view_file')) {
  function include_view_file(string $root, string $file, string $suffix = '.php'): ?string
  {
    if ($file === '' || strpos($file, '..') !== false || preg_match('/^[a-z0-9_\/-]+$/i', $file) !== 1) {
      return null;
    }

    $root_path = realpath($root);
    if ($root_path === false) {
      return null;
    }

    $candidate = realpath($root_path . '/' . $file . $suffix);
    if (!is_string($candidate)) {
      return null;
    }

    $is_within_root = strpos($candidate, $root_path . DIRECTORY_SEPARATOR) === 0;
    if (!$is_within_root || !is_file($candidate)) {
      return null;
    }

    return $candidate;
  }
}

if (!function_exists('component')) {
  function component(string $file, array $data = []): void
  {
    $targets = [];

    // Support explicit paths like "sections/services", "partials/site-header", "components/card".
    if (strpos($file, 'sections/') === 0) {
      $targets[] = [__DIR__ . '/../views/components/sections', substr($file, strlen('sections/'))];
    }

    if (strpos($file, '/') !== false) {
      $targets[] = [__DIR__ . '/../views', $file];
    }

    // Backward compatibility alias: "section-services" => "views/components/sections/services.php".
    if (strpos($file, 'section-') === 0) {
      $targets[] = [__DIR__ . '/../views/components/sections', substr($file, strlen('section-'))];
    }

    $targets[] = [__DIR__ . '/../views/components', $file];
    $targets[] = [__DIR__ . '/../views/partials', $file];
    $targets[] = [__DIR__ . '/../views/components/sections', $file];

    $component_path = null;
    foreach ($targets as [$root, $target_file]) {
      $component_path = include_view_file($root, $target_file);
      if ($component_path !== null) {
        break;
      }
    }

    if ($component_path === null) {
      return;
    }

    if ($data !== []) {
      extract($data, EXTR_SKIP);
    }

    include $component_path;
  }
}

if (!function_exists('section')) {
  function section(string $file, array $data = []): void
  {
    $section_path = include_view_file(__DIR__ . '/../views/sections', $file);
    if ($section_path === null) {
      return;
    }

    if ($data !== []) {
      extract($data, EXTR_SKIP);
    }

    include $section_path;
  }
}

if (!function_exists('asset_url')) {
  function asset_url(string $path): string
  {
    $asset_path  = ltrim($path, '/');
    $script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $base_path   = rtrim(dirname($script_name), '/');

    if ($base_path === '.' || $base_path === '/') {
      $base_path = '';
    }

    return $base_path . '/' . $asset_path;
  }
}

if (!function_exists('absolute_url')) {
  /**
   * Builds a full URL (scheme + host + base path) for canonical and social tags.
   */
  function absolute_url(string $path): string
  {
    if (preg_match('/^https?:\/\//i', $path) === 1) {
      return $path;
    }

    $is_https = ($_SERVER['HTTPS'] ?? '') !== '' && ($_SERVER['HTTPS'] ?? '') !== 'off';
    $host     = $_SERVER['HTTP_HOST'] ?? 'localhost';

    return ($is_https ? 'https' : 'http') . '://' . $host . asset_url($path);
  }
}

if (!function_exists('icon')) {
  function icon(string $icon_name, array $data = []): void
  {
    $resolved_icon_name = trim($icon_name);

    if ($resolved_icon_name === '') {
      return;
    }

    $data['icon_name'] = $resolved_icon_name;
    component('icon', $data);
  }
}

if (!function_exists('preview_groups')) {
  /**
   * Mockup preview states from includes/preview-states.php, loaded once.
   */
  function preview_groups(): array
  {
    static $groups = null;
    $groups ??= require __DIR__ . '/preview-states.php';

    return $groups;
  }
}

if (!function_exists('preview_state')) {
  /**
   * Current ?state= for a preview group, or the group's default when missing or unknown.
   */
  function preview_state(string $group): string
  {
    $config = preview_groups()[$group] ?? null;
    if ($config === null) {
      return '';
    }

    $requested = is_string($_GET['state'] ?? null) ? $_GET['state'] : '';

    return isset($config['states'][$requested]) ? $requested : $config['default'];
  }
}

if (!function_exists('preview_query')) {
  /**
   * Query string that keeps a group's current state on internal links ('' for the default state).
   */
  function preview_query(string $group, ?string $state = null): string
  {
    $state ??= preview_state($group);
    $default = preview_groups()[$group]['default'] ?? '';

    return $state === '' || $state === $default ? '' : '?state=' . rawurlencode($state);
  }
}
