<?php

namespace Webit\Terc\Infrastructure;

final class SourceFileOpeningException extends \RuntimeException
{
    public static function forFile(string $filename): SourceFileOpeningException
    {
        return new self(sprintf('Could not open a source file ("%s")', $filename));
    }
}
