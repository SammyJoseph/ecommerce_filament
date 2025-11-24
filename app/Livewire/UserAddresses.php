<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class UserAddresses extends Component
{
    public $addresses;
    public $isEditing = false;
    public $isCreating = false;

    // Form fields
    public $address_id;
    public $department;
    public $province;
    public $district;
    public $address;
    public $reference;
    public $address_type;
    public $is_default = false;

    protected $rules = [
        'department' => 'required|string|max:255',
        'province' => 'required|string|max:255',
        'district' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'reference' => 'nullable|string|max:255',
        'address_type' => 'nullable|string|max:255',
        'is_default' => 'boolean',
    ];

    public function render()
    {
        $this->addresses = Auth::user()->addresses;
        return view('livewire.user-addresses');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isCreating = true;
        $this->isEditing = false;
    }

    public function edit($id)
    {
        $address = UserAddress::findOrFail($id);
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $this->address_id = $id;
        $this->department = $address->department;
        $this->province = $address->province;
        $this->district = $address->district;
        $this->address = $address->address;
        $this->reference = $address->reference;
        $this->address_type = $address->address_type;
        $this->is_default = (bool) $address->is_default;

        $this->isEditing = true;
        $this->isCreating = false;
    }

    public function store()
    {
        $this->validate();

        try {
             UserAddress::create([
                'user_id' => Auth::id(),
                'department' => $this->department,
                'province' => $this->province,
                'district' => $this->district,
                'address' => $this->address,
                'reference' => $this->reference,
                'address_type' => $this->address_type,
                'is_default' => $this->is_default,
            ]);
            
            session()->flash('message', 'Address created successfully.');
            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function update()
    {
        $this->validate();

        $address = UserAddress::findOrFail($this->address_id);
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->update([
            'department' => $this->department,
            'province' => $this->province,
            'district' => $this->district,
            'address' => $this->address,
            'reference' => $this->reference,
            'address_type' => $this->address_type,
            'is_default' => $this->is_default,
        ]);

        session()->flash('message', 'Address updated successfully.');
        $this->cancel();
    }

    public function delete($id)
    {
        $address = UserAddress::findOrFail($id);
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }
        $address->delete();
        session()->flash('message', 'Address deleted successfully.');
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->isCreating = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->department = '';
        $this->province = '';
        $this->district = '';
        $this->address = '';
        $this->reference = '';
        $this->address_type = '';
        $this->is_default = false;
        $this->address_id = null;
    }
}
