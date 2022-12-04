<?php

namespace App\Traits;

trait ModalTrait {
    public function hide_modal($modal_id)
    {
        $this->dispatchBrowserEvent('modal-toggle', ['id'=>$modal_id, 'action' => 'hide']);
    }

    public function show_modal($modal_id)
    {
        $this->dispatchBrowserEvent('modal-toggle', ['id'=>$modal_id, 'action' => 'show']);
    }
}
