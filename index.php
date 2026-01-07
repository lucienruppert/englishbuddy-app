<?php
// Root entry point for EnglishBuddy application
// This file routes all requests to pages/index.php

// Change to pages directory so relative paths work correctly
chdir(__DIR__ . '/pages');

// Include the actual entry point
require_once __DIR__ . '/pages/index.php';
