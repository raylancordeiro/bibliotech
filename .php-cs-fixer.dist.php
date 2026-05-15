<?php

$finder = (new PhpCsFixer\Finder())
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->ignoreVCSIgnored(true);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'ordered_attributes' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
