<?php

class StubsCase extends PHPUnit_Framework_TestCase
{
    public $fixtures;
    public $stubs;
    public $destination;

    protected function setUp()
    {
        $this->setFixtures(__DIR__.'/fixtures');
        $this->setStubs(dirname(__DIR__).'/src/CLI/Scaffolding/Presets/stubs');
        $this->setDestination("{$this->fixtures}/scaffolding");

        $this->temp = "{$this->fixtures}/.temp";

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

    public function setFixtures($fixtures)
    {
        if (! isset($this->fixtures)) {
            $this->fixtures = $fixtures;
        }
    }

    public function setStubs($stubs)
    {
        if (! isset($this->stubs)) {
            $this->stubs = $stubs;
        }
    }

    public function setDestination($destination)
    {
        if (! isset($this->destination)) {
            $this->destination = $destination;
        }
    }
}
