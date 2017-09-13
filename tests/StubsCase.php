<?php

class StubsCase extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->fixturesDir = __DIR__.'/fixtures';
        $this->tempDir = "{$this->fixturesDir}/.temp";
        $this->stubsDir = dirname(__DIR__).'/src/CLI/Scaffolding/Presets/stubs';
        $this->scaffoldingDir = "{$this->fixturesDir}/scaffolding";

        $dir = escapeshellarg($this->scaffoldingDir);
        $temp = escapeshellarg($this->tempDir);

        exec("cp -R $dir $temp");
    }

    protected function tearDown()
    {
        $dir = escapeshellarg($this->scaffoldingDir);
        $temp = escapeshellarg($this->tempDir);

        exec("rm -rf $dir");
        exec("mv $temp $dir");
    }

    public function assertFileContains($expected, $input)
    {
        $this->assertContains($expected, file_get_contents($input));
    }
}
