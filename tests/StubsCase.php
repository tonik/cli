<?php

class StubsCase extends PHPUnit_Framework_TestCase
{
    public $destination;

    protected function setUp()
    {
        $this->fixtures = __DIR__.'/fixtures';
        $this->temp = "{$this->fixtures}/.temp";
        $this->stubs = dirname(__DIR__).'/src/CLI/Scaffolding/Presets/stubs';

        if (null === $this->destination) {
            $this->destination = "{$this->fixtures}/scaffolding";
        }

        $dir = escapeshellarg($this->destination);
        $temp = escapeshellarg($this->temp);

        exec("cp -R $dir $temp");
    }

    protected function tearDown()
    {
        $dir = escapeshellarg($this->destination);
        $temp = escapeshellarg($this->temp);

        exec("rm -rf $dir");
        exec("mv $temp $dir");
    }

    public function assertFileContains($expected, $input)
    {
        $this->assertContains($expected, file_get_contents($input));
    }
}
