<?php

/**
 * Page: Account treatment (retired)
 * Purpose: The treatment cards now live in the Overview (/account). Keeps old links working.
 */

$query = is_string($_SERVER['QUERY_STRING'] ?? null) && $_SERVER['QUERY_STRING'] !== ''
  ? '?' . $_SERVER['QUERY_STRING'] : '';

header('Location: ' . asset_url('account') . $query, true, 301);
exit;
