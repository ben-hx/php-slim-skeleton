<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers\Exceptions;

class FileNotReadableException extends \Exception
{
    /**
     * @param \SplFileInfo $file
     */
    public function __construct($file)
    {
        parent::__construct($file->getPathname().' is not readable.');
    }
}
