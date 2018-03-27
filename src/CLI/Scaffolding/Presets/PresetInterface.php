<?php

namespace Tonik\CLI\Scaffolding\Presets;

interface PresetInterface
{
    /**
     * Scaffold a preset.
     *
     * @return void
     */
    public function scaffold();
}
