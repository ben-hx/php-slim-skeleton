<?php

declare (strict_types = 1);

namespace BenHx\Api\Exceptions;

class FileNotWritableException extends \Exception
{
    /**
     * @param \SplFileInfo $file
     */
    public function __construct($file)
    {
        parent::__construct($file->getPathname().' is not writable.');
    }
}
