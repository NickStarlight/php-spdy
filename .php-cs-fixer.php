<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src');

$config = new PhpCsFixer\Config();
return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR1' => true,
        '@PSR2' => true,
        '@PSR12' => true,
        '@PSR12:risky' => true,
        'phpdoc_order' => true,
        'strict_param' => true,
        'declare_strict_types' => true,
        'array_syntax' => ['syntax' => 'short'],
        'array_push' => true,
        'no_mixed_echo_print' => true,
        'ordered_imports' => true,
        'phpdoc_types_order' => true,
        'phpdoc_types' => true
    ])
    ->setFinder($finder);
