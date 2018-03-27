<?php

use Tonik\CLI\Scaffolding\Scaffolder;

class FoundationTest extends StubsCase
{
    public function test_updating_packages()
    {
        (new Scaffolder($this->destination))->build('foundation');

        $this->assertFileContains('foundation-sites', "{$this->destination}/package.json");
        $this->assertFileContains('motion-ui', "{$this->destination}/package.json");
    }

    public function test_updating_config()
    {
        (new Scaffolder($this->destination))->build('foundation');

        $this->assertFileContains('"foundation": [
            "./resources/assets/js/foundation.js",
            "./resources/assets/sass/foundation.scss"
        ]', "{$this->destination}/config/app.json");
    }

    public function test_updating_assets()
    {
        (new Scaffolder($this->destination))->build('foundation');

        $this->assertFileEquals("{$this->destination}/app/Http/assets.php", "{$this->stubs}/foundation/app/Http/assets.php");
    }

    public function test_scaffolding_files()
    {
        $stub = "{$this->stubs}/foundation/resources/assets";
        $assets = "{$this->destination}/resources/assets";

        (new Scaffolder($this->destination))->build('foundation');

        $this->assertFileEquals("{$assets}/sass/_variables.scss", "{$stub}/sass/_variables.scss");
        $this->assertFileEquals("{$assets}/sass/_settings.scss", "{$stub}/sass/_settings.scss");
        $this->assertFileEquals("{$assets}/sass/foundation.scss", "{$stub}/sass/foundation.scss");
        $this->assertFileEquals("{$assets}/sass/app.scss", "{$stub}/sass/app.scss");

        $this->assertFileEquals("{$assets}/js/foundation.js", "{$stub}/js/foundation.js");
        $this->assertFileEquals("{$assets}/js/app.js", "{$stub}/js/app.js");
    }
}
