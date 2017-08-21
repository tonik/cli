<?php

namespace Tonik\CLI\Scaffolding;

use Tonik\CLI\Renaming\Renamer;

class AssetsRenamer extends Renamer
{
    /**
     * Files to search.
     *
     * @var array
     */
    protected $searchedFiles = [
        'assets.php',
    ];
}
