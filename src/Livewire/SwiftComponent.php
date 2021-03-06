<?php

namespace Redbastie\Swift\Livewire;

use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class SwiftComponent extends Component
{
    use WithFileUploads, WithPagination;

    public $routeUri;
    public $routeName;
    public $routeMiddleware;
    public $pageTitle;
    public $model = [];

    public function render()
    {
        return view('swift::livewire.swift-component')->layout('swift::layouts.app');
    }

    public function validate($rules = null, $messages = [], $attributes = [])
    {
        [$rules, $messages] = $this->providedOrGlobalRulesAndMessages($rules, $messages);
        $validator = Validator::make($this->model, $rules, $messages, $attributes);

        if (config('swift.toast_validation_error') && $validator->fails()) {
            $this->emit('toastError', trans('swift::swift.validation_error_message'));
        }

        $validatedData = $validator->validate();
        $this->resetErrorBag();

        return $validatedData;
    }

    public function updatedModelSearch()
    {
        $this->resetPage();
    }
}
