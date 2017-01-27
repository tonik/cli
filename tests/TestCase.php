<?php

class TestCase extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }
}