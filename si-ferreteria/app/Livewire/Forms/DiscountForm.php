<?php

namespace App\Livewire\Forms;

use App\Models\Discount;
use Carbon\Carbon;
use Livewire\Form;


class DiscountForm extends Form
{
    public $description = '';
    public $discount_type = 'PERCENTAGE';
    public $discount_value = 0;
    public $code = null;
    public $max_uses = 1;
    public $used_count = 0;
    public $is_active = 1;
    public $start_date = null;
    public $end_date = null;

    public function rules(): array
    {
        return [
            'description' => ['required', 'string', 'max:150'],
            'discount_type' => ['required', 'in:PERCENTAGE,FIXED'],
            'discount_value' => ['required', 'numeric', 'min:1'],
            'code' => ['required', 'string', 'max:50', 'unique:discounts,code'],
            'max_uses' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ];
    }

    public function set($discount): void
    {
        $this->description = $discount->description;
        $this->discount_type = $discount->discount_type;
        $this->discount_value = $discount->discount_value;
        $this->code = $discount->code;
        $this->max_uses = $discount->max_uses;
        $this->used_count = $discount->used_count;
        $this->is_active = $discount->is_active ? 1 : 0;
        $this->start_date = $discount->start_date->format('Y-m-d');
        $this->end_date = $discount->end_date->format('Y-m-d');
    }

    public function getData(bool $isNew = true): array
    {
        $data = [
            'description' => $this->description,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'max_uses' => $this->max_uses,
            'is_active' => $this->is_active ? true : false,
            'start_date' => Carbon::parse($this->start_date)->format('Y-m-d'),
            'end_date' => Carbon::parse($this->end_date)->format('Y-m-d'),
        ];

        // Solo inicializar used_count en 0 al crear, no al actualizar
        if ($isNew) {
            $data['code'] = $this->code;
            $data['used_count'] = 0;
        }

        return $data;
    }

    public function reset(...$properties): void
    {
        $this->description = '';
        $this->discount_type = 'PERCENTAGE';
        $this->discount_value = 1;
        $this->code = Discount::generateCode();
        $this->max_uses = 1;
        $this->used_count = 0;
        $this->is_active = 1;
        $this->start_date = now()->format('Y-m-d');
        $this->end_date = now()->addDay()->format('Y-m-d');
    }

}
