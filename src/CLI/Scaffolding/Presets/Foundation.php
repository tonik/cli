<?php

namespace Tonik\CLI\Scaffolding\Presets;

use Symfony\Component\Filesystem\Filesystem;

class Foundation extends Preset
{
    public static $name = 'foundation';

    public function scaffold()
    {
        $this->updateSass();
        $this->updateJavascript();
        $this->updatePackages();
        $this->updateAssets(['vendor' => 'foundation']);
    }

    /**
     * Update the given package array with preset dependences.
     *
     * @param  array  $packages
     * @return array
     */
    protected function packages(array $packages)
    {
        return [
            'foundation-sites' => '^6.3.0',
            'motion-ui' => '^1.2.0',
        ] + $packages;
    }
}
