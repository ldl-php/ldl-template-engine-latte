<?php

declare(strict_types=1);

namespace LDL\Template\Wrapper\Latte;

use Latte\Engine as Latte;
use Latte\Loaders\StringLoader;
use LDL\Template\Contracts\TemplateEngineInterface;

class LatteTemplateEngineWrapper implements TemplateEngineInterface
{
    /**
     * @var Latte
     */
    private $engine;

    public function __construct(Latte $engine = null)
    {
        $this->engine = $engine ?? new Latte();
    }

    public function renderFromString(string $string, $values): string
    {
        $engine = clone $this->engine;

        $loader = new StringLoader(['main' => $string]);

        $engine->setLoader($loader);

        $this->throwOnAnyError();

        $return = $engine->renderToString('main', $values);

        restore_error_handler();

        return $return;
    }

    public function render(string $template, $values): string
    {
        $this->throwOnAnyError();
        $result = $this->engine->renderToString($template, $values);

        restore_error_handler();

        return $result;
    }

    private function throwOnAnyError(): void
    {
        /*
         * Throw exceptions on any undefined variable ot whatever it might go wrong
         */
        set_error_handler(function ($errno, $errStr, $errFile, $errLine) {
            if (!(error_reporting() & $errno)) {
                return false;
            }

            throw new \RuntimeException("$errno: $errStr | File: $errFile | Line: $errLine");
        });
    }
}
