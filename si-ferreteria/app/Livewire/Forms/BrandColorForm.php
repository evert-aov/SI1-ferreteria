<?php

namespace App\Livewire\Forms;

class BrandColorForm
{
    public $name_color = '';

    public $brand_name = '';
    public $brand_description = '';

    public function rules(): array
    {
        return [
            'name_color' => 'required|string|min:3|max:255',
            'brand_name' => 'required|string|min:3|max:255',
            'brand_description' => 'nullable|string|max:255',
        ];
    }

    public function set($brand, $color): void
    {
        $this->brand_name = $brand->name;
        $this->brand_description = $brand->description;

        $this->name_color = $color->name;
    }
}
