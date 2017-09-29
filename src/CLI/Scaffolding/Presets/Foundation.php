<?php

namespace Tonik\CLI\Scaffolding\Presets;

use Symfony\Component\Filesystem\Filesystem;

class Foundation extends Preset
{
    /**
     * Preset name.
     *
     * @var string
     */
    private $name = 'foundation';

    /**
     * Scaffold a Foundation boilerplate preset.
     *
     * @return void
     */
    public function scaffold()
    {
        $this->updatePackages([
            'foundation-sites' => '^6.3.0',
            'motion-ui' => '^1.2.0',
        ]);
        $this->updateConfig([
            'foundation' => [
                './resources/assets/js/foundation.js',
                './resources/assets/sass/foundation.scss',
            ],
        ]);
        $this->updateSass($this->name);
        $this->updateJavascript($this->name);
        $this->updateAssets($this->name);
    }
}
