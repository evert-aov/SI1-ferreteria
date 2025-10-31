<?php

namespace App\Livewire\Forms;

use AllowDynamicProperties;
use Livewire\Form;

#[AllowDynamicProperties]
class ProductForm extends Form
{
    public $name = '';
    public $description = '';
    public $image = '';
    public $purchase_price = '';
    public $purchase_price_unit = 'BOB';
    public $sale_price = '';
    public $sale_price_unit = 'BOB';
    public $input = '';
    public $output = '';
    public $stock = '';
    public $expiration_date = '';
    public $is_active = 1;
    public $color_id = '';
    public $brand_id = '';
    public $category_id = '';
    public $measure_id = '';
    public $volume_id = '';

    public $specifications = [];

    // Para crear nuevos colores y marcas
    public $color_name = '';
    public $brand_name = '';

    // Campos temporales para crear medidas
    public $length = '';
    public $length_unit = 'cm';
    public $width = '';
    public $width_unit = 'cm';
    public $height = '';
    public $height_unit = 'cm';
    public $thickness = '';
    public $thickness_unit = 'mm';

    // Campos temporales para crear volúmenes
    public $peso = '';
    public $peso_unit = 'kg';
    public $volume = '';
    public $volume_unit = 'L';

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'purchase_price' => 'required|numeric|min:0',
            'purchase_price_unit' => 'required|in:USD,EUR,BOB,ARS,CLP,COP,MXN,PEN',
            'sale_price' => 'required|numeric|min:0',
            'sale_price_unit' => 'required|in:USD,EUR,BOB,ARS,CLP,COP,MXN,PEN',
            'input' => 'required|integer|min:0',
            'output' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'expiration_date' => 'nullable|date',
            'is_active' => 'required|boolean',
            'color_id' => 'nullable|exists:colors,id',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'measure_id' => 'nullable|exists:measures,id',
            'volume_id' => 'nullable|exists:volumes,id',
            'color_name' => 'nullable|string|max:20',
            'brand_name' => 'nullable|string|max:20',

            'length' => 'nullable|numeric|min:0.01',
            'length_unit' => 'nullable|in:m,cm,mm,in',
            'width' => 'nullable|numeric|min:0.01',
            'width_unit' => 'nullable|in:m,cm,mm,in',
            'height' => 'nullable|numeric|min:0.01',
            'height_unit' => 'nullable|in:m,cm,mm,in',
            'thickness' => 'nullable|numeric|min:0.01',
            'thickness_unit' => 'nullable|in:mm,in,gauge',

            'peso' => 'nullable|numeric|min:0.01',
            'peso_unit' => 'nullable|in:kg,g,lb,oz',
            'volume' => 'nullable|numeric|min:0.01',
            'volume_unit' => 'nullable|in:L,ml,gal,oz',

            'specifications' => 'nullable|array',
            'specifications.*' => 'nullable|string|max:500',
        ];
    }

    public function set($product): void
    {
        $this->name = $product->name;
        $this->description = $product->description;
        $this->image = $product->image;
        $this->purchase_price = $product->purchase_price;
        $this->purchase_price_unit = $product->purchase_price_unit;
        $this->sale_price = $product->sale_price;
        $this->sale_price_unit = $product->sale_price_unit;
        $this->input = $product->input;
        $this->output = $product->output;
        $this->stock = $product->stock;
        $this->is_active = (int)$product->is_active;
        $this->expiration_date = $product->expiration_date;
        $this->color_id = $product->color_id ?? '';
        $this->brand_id = $product->brand_id ?? '';
        $this->category_id = $product->category_id ?? '';
        $this->measure_id = $product->measure_id ?? '';
        $this->volume_id = $product->volume_id ?? '';

        if ($product->measure) {
            $this->length = $product->measure->length ?? '';
            $this->length_unit = $product->measure->length_unit ?? 'cm';
            $this->width = $product->measure->width ?? '';
            $this->width_unit = $product->measure->width_unit ?? 'cm';
            $this->height = $product->measure->height ?? '';
            $this->height_unit = $product->measure->height_unit ?? 'cm';
            $this->thickness = $product->measure->thickness ?? '';
            $this->thickness_unit = $product->measure->thickness_unit ?? 'mm';
        }

        if ($product->volume) {
            $this->peso = $product->volume->peso ?? '';
            $this->peso_unit = $product->volume->peso_unit ?? 'kg';
            $this->volume = $product->volume->volume ?? '';
            $this->volume_unit = $product->volume->volume_unit ?? 'L';
        }

        $this->specifications = [];
        foreach ($product->technicalSpecifications as $spec) {
            $this->specifications[$spec->id] = $spec->pivot->value;
        }
    }

    public function getData(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description ?: null,
            'image' => $this->image ?: null,
            'purchase_price' => (float)$this->purchase_price,
            'purchase_price_unit' => $this->purchase_price_unit,
            'sale_price' => (float)$this->sale_price,
            'sale_price_unit' => $this->sale_price_unit,
            'input' => (int)$this->input,
            'output' => (int)$this->output,
            'stock' => (int)$this->stock,
            'is_active' => (bool)$this->is_active,
            'expiration_date' => $this->expiration_date ?: null,
            'color_id' => !empty($this->color_id) ? $this->color_id : null,
            'brand_id' => !empty($this->brand_id) ? $this->brand_id : null,
            'category_id' => !empty($this->category_id) ? $this->category_id : null,
            'measure_id' => !empty($this->measure_id) ? $this->measure_id : null,
            'volume_id' => !empty($this->volume_id) ? $this->volume_id : null,
        ];
    }
}
