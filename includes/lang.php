<?php

/**
 * Language strings
 * Purpose: Look up UI copy from lang/<locale>/<file>.php with a dot key.
 * Structure: The first key segment is the file (site, dashboard); the rest walk the nested array.
 * Data: t('site.navbar.log_in'), or t('dashboard.patients.count', ['count' => 3]) for ":count" placeholders.
 *       Returns the raw string; escape on output with e(). Missing keys return the key so gaps show in the browser.
 */

if (!defined('APP_LOCALE')) {
  define('APP_LOCALE', 'en');
}

if (!function_exists('lang_file')) {
  function lang_file(string $file): array
  {
    static $cache = [];

    if (isset($cache[$file])) {
      return $cache[$file];
    }

    if (preg_match('/^[a-z0-9_-]+$/', $file) !== 1) {
      return [];
    }

    $path         = __DIR__ . '/../lang/' . APP_LOCALE . '/' . $file . '.php';
    $strings      = is_file($path) ? require $path : [];
    $cache[$file] = is_array($strings) ? $strings : [];

    return $cache[$file];
  }
}

if (!function_exists('t')) {
  function t(string $key, array $replace = []): string
  {
    $segments = explode('.', $key);
    $value    = lang_file(array_shift($segments));

    foreach ($segments as $segment) {
      if (!is_array($value) || !array_key_exists($segment, $value)) {
        return $key;
      }

      $value = $value[$segment];
    }

    if (!is_string($value)) {
      return $key;
    }

    if ($replace === []) {
      return $value;
    }

    $pairs = [];
    foreach ($replace as $name => $replacement) {
      $pairs[':' . $name] = (string) $replacement;
    }

    return strtr($value, $pairs);
  }
}
