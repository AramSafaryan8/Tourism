<?php
declare(strict_types = 1);

namespace Rendering;

use Rendering\IRenderer;
use Rendering\Parser;
use Controllers\Errors;
use Controllers\Auth;

class View
    extends Parser
    implements IRenderer
{
    private array $components = [];

    public function __construct (string $path = '', array $components = [], bool $isTemplate = true) {
        ('#' == $path) && ($this->resultHtml = array_shift($components));
        
        parent::__construct((($isTemplate) ? '/shared' : '') . $path);

        $this->components = $components;
    }

    public function render () : string {
        $mustacheIndex = 0;
        $content = '';
        $replacer = NULL;

        foreach ($this->components as $mustache => $component) {
            if (($mustacheIndex = array_search($mustache, $this->mustaches)) === false) {
                continue;
            }

            if ('string' == gettype($component)) {
                $content = $component;
            } else if ($component instanceof $this) {
                $content = $component->render();
            } else {
                header('HTTP/1.0 404 Not Found');

                $this->resultHtml = Errors::index()->render();

                unset($this->mustaches[$mustacheIndex]);

                break;
            }

            $this->resultHtml = str_replace($mustache, $content, $this->resultHtml);

            unset($this->mustaches[$mustacheIndex]);
        }
    
        $this->remove_unused_mustaches($this->resultHtml, $this->mustaches);

        return $this->resultHtml;
    }
}