<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use LDL\Template\Wrapper\Latte\LatteTemplateEngineWrapper;

$latte = new LatteTemplateEngineWrapper();

echo "Create the following template string\n";
echo "##############################################\n\n";

$template = '{$name} {$surname}';

echo "$template\n\n";

echo "Populate template variables\n";
echo "##############################################\n\n";

echo $latte->renderFromString('{$name} {$surname}', [
    'name' => 'My name',
    'surname' => 'My surname',
]);

echo "\n\n";
