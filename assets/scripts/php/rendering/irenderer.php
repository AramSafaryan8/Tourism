<?php
declare(strict_types = 1);

namespace Rendering;

interface IRenderer
{
    public function render() : string;
}