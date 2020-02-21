<?php

namespace App\Observers;

use App\Events\UserEvent;

class UserObserver
{
    public function created($user){
      event(new UserEvent($user));
    }
}
