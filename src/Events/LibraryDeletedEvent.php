<?php

namespace OnkaarGujarr\Library\Events;

use OnkaarGujarr\Library\Models\Library;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LibraryDeletedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $library;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Library $library)
    {
        $this->library = $library;
    }
}
