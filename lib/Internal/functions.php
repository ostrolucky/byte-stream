<?php

namespace Amp\ByteStream\Internal;

use Amp\ByteStream\{ ReadableStream, WritableStream };

/**
 * @internal
 */
function pipe(ReadableStream $source, WritableStream $destination, int $bytes = null): \Generator {
    if (!$destination->isWritable()) {
        throw new \LogicException("The destination is not writable");
    }

    if (null !== $bytes) {
        return yield $destination->write(
            yield $source->read($bytes)
        );
    }

    $written = 0;

    do {
        $written += yield $destination->write(
            yield $source->read()
        );
    } while ($source->isReadable() && $destination->isWritable());

    return $written;
}