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
    public $department = '';
    public $province = '';
    public $district = '';
    public $address;
    public $reference;
    public $address_type = 'home';
    public $is_default = false;

    // Ubigeo Data
    public $departments = [];
    public $provinces = [];
    public $districts = [];
    
    public $selectedDeptId = '';
    public $selectedProvId = '';
    public $selectedDistId = '';

    protected $rules = [
        'department' => 'required|string|max:255',
        'province' => 'required|string|max:255',
        'district' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'reference' => 'nullable|string|max:255',
        'address_type' => 'required|in:home,work,other',
        'is_default' => 'boolean',
    ];

    public function mount()
    {
        $this->loadDepartments();
    }

    public function render()
    {
        $this->addresses = Auth::user()->addresses;
        return view('livewire.user-addresses');
    }

    protected function loadDepartments()
    {
        $path = storage_path('app/ubigeo/departamentos.json');
        if (file_exists($path)) {
            $this->departments = json_decode(file_get_contents($path), true);
        }
    }

    public function updatedSelectedDeptId($value)
    {
        $dept = collect($this->departments)->firstWhere('id_ubigeo', $value);
        $this->department = $dept['nombre_ubigeo'] ?? '';
        
        $this->selectedProvId = '';
        $this->selectedDistId = '';
        $this->province = '';
        $this->district = '';
        $this->provinces = [];
        $this->districts = [];

        if ($value) {
            $path = storage_path('app/ubigeo/provincias.json');
            if (file_exists($path)) {
                $allProvinces = json_decode(file_get_contents($path), true);
                $this->provinces = $allProvinces[$value] ?? [];
            }
        }
    }

    public function updatedSelectedProvId($value)
    {
        $prov = collect($this->provinces)->firstWhere('id_ubigeo', $value);
        $this->province = $prov['nombre_ubigeo'] ?? '';
        
        $this->selectedDistId = '';
        $this->district = '';
        $this->districts = [];

        if ($value) {
            $path = storage_path('app/ubigeo/distritos.json');
            if (file_exists($path)) {
                $allDistricts = json_decode(file_get_contents($path), true);
                $this->districts = $allDistricts[$value] ?? [];
            }
        }
    }

    public function updatedSelectedDistId($value)
    {
        $dist = collect($this->districts)->firstWhere('id_ubigeo', $value);
        $this->district = $dist['nombre_ubigeo'] ?? '';
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

        // Reverse lookup for dropdowns
        $this->reverseLookupUbigeo();

        $this->isEditing = true;
        $this->isCreating = false;
    }

    protected function reverseLookupUbigeo()
    {
        // 1. Find Department ID
        $dept = collect($this->departments)->firstWhere('nombre_ubigeo', $this->department);
        if ($dept) {
            $this->selectedDeptId = $dept['id_ubigeo'];
            
            // Load Provinces
            $pathProv = storage_path('app/ubigeo/provincias.json');
            if (file_exists($pathProv)) {
                $allProvinces = json_decode(file_get_contents($pathProv), true);
                $this->provinces = $allProvinces[$this->selectedDeptId] ?? [];
                
                // 2. Find Province ID
                $prov = collect($this->provinces)->firstWhere('nombre_ubigeo', $this->province);
                if ($prov) {
                    $this->selectedProvId = $prov['id_ubigeo'];
                    
                    // Load Districts
                    $pathDist = storage_path('app/ubigeo/distritos.json');
                    if (file_exists($pathDist)) {
                        $allDistricts = json_decode(file_get_contents($pathDist), true);
                        $this->districts = $allDistricts[$this->selectedProvId] ?? [];
                        
                        // 3. Find District ID
                        $dist = collect($this->districts)->firstWhere('nombre_ubigeo', $this->district);
                        if ($dist) {
                            $this->selectedDistId = $dist['id_ubigeo'];
                        }
                    }
                }
            }
        }
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
        $this->address_type = 'home';
        $this->is_default = false;
        $this->address_id = null;
        
        $this->selectedDeptId = '';
        $this->selectedProvId = '';
        $this->selectedDistId = '';
        $this->provinces = [];
        $this->districts = [];
    }
}
