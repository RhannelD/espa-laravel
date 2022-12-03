<?php

namespace App\Traits;

use Carbon\Carbon;

trait AlertTrait {
    public function alert_success($messsage, $text = '')
    {
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => $messsage, 
            'text' => $text,
        ]);
    }

    public function alert_error($messsage, $text = '')
    {
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'error',
            'message' => $messsage, 
            'text' => $text,
        ]);
    }

    public function alert_info($messsage, $text = '')
    {
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'info',
            'message' => $messsage, 
            'text' => $text,
        ]);
    }

    public function session_flash_alert_info($messsage, $text='')
    {
        session()->flash('alert_info', [
            'messsage' => $messsage,
            'text' => $text,
        ]);
    }

    public function session_flash_alert_success($messsage, $text='')
    {
        session()->flash('alert_success', [
            'messsage' => $messsage,
            'text' => $text,
        ]);
    }

    public function session_flash_alert_error($messsage, $text='')
    {
        session()->flash('alert_error', [
            'messsage' => $messsage,
            'text' => $text,
        ]);
    }

    public function redirect_to_blank($url)
    {
        $this->dispatchBrowserEvent('redirect-blank', ['url' => $url]);
    }
}