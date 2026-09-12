<?php
/**
 * CLDA Application Root Entry
 * 
 * This file ensures the application loads correctly even if served
 * from the project root instead of the public directory.
 */

// If accessed directly, route request to public/index.php
require_once __DIR__ . '/public/index.php';
