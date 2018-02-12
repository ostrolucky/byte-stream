<?php

namespace Amp\ByteStream;

use Amp\Promise;
use function Amp\call;

// @codeCoverageIgnoreStart
if (\strlen('…') !== 3) {
    throw new \Error(
        'The mbstring.func_overload ini setting is enabled. It must be disabled to use the stream package.'
    );
} // @codeCoverageIgnoreEnd

if (!\defined('STDOUT')) {
    \define('STDOUT', \fopen('php://stdout', 'w'));
}

if (!\defined('STDERR')) {
    \define('STDERR', \fopen('php://stderr', 'w'));
}

/**
 * @param \Amp\ByteStream\InputStream  $source
 * @param \Amp\ByteStream\OutputStream $destination
 *
 * @return int
 */
function pipe(InputStream $source, OutputStream $destination): int {
    $written = 0;

    while (null !== $chunk = $source->read()) {
        $written += \strlen($chunk);
        $destination->write($chunk);
    }

    return $written;
}
