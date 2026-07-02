<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

class ModelObserver
{
    /**
     * Handle the model "creating" event.
     */
    public function creating($model): void
    {
        if (Auth::check() && in_array('created_by', $model->getFillable())) {
            $model->created_by = Auth::id();
        }
    }

    /**
     * Handle the model "updating" event.
     */
    public function updating($model): void
    {
        if (Auth::check() && in_array('updated_by', $model->getFillable())) {
            $model->updated_by = Auth::id();
        }
    }
}
