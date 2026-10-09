<?php
declare(strict_types = 1);

namespace Rendering;

use AppData\Config;

class Parser
{
    private static $mustacheRE = '/{{2}@[a-zA-Z]+(-?[\w\d]+)*}{2}/';
    protected $mustaches = NULL;
    protected string $resultHtml = '';
    protected string $path = '';

    protected function __construct (string $documentPath) {
        $this->path = $documentPath;
        (!empty($this->path) && '#' != $this->path) && ($this->resultHtml = $this->get_page_html());
        $this->mustaches = $this->retrieve_mustaches();
    }

    private function retrieve_mustaches () : array {
        preg_match_all(self::$mustacheRE, $this->resultHtml, $matches);

        return $matches[0];
    }

    protected function get_page_html (?string $path = NULL) : string {
        $dirs = Config::get_dirs();

        ob_start();

        require($dirs->views . ($path ?? $this->path));
        
        $resultHtml = ob_get_clean();
        
        return $resultHtml;
    }

    protected function remove_unused_mustaches () : void {
        foreach ($this->mustaches as $mustache) {
            $this->resultHtml = str_replace($mustache, ($mustache == '{{@title}}') ? 'Tourism | Home page' : '', $this->resultHtml);
        }
    }
}