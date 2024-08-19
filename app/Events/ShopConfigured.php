<?php

namespace App\Events;

use App\Models\Appearance as AppearanceModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ShopConfigured
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public AppearanceModel $appearance;

    public function __construct(AppearanceModel $appearance
    ) {
        $this->appearance = $appearance;
    }
}
