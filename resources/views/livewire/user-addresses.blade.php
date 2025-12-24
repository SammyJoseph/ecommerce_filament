<div class="tw-relative">
    <h3>Billing Address</h3>
    
    @include('_partials.success-alert')
    @include('_partials.error-alert')
    
    @if($isCreating || $isEditing)
        <div class="account-details-form">
            <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="single-input-item">
                            <label for="address_type" class="required">Address Type</label>
                            <select id="address_type" wire:model="address_type" class="form-control tw-text-sm">
                                <option value="home">Home</option>
                                <option value="work">Work</option>
                                <option value="other">Other</option>
                            </select>
                            @error('address_type') <span class="text-danger tw-text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="single-input-item">
                            <label for="department" class="required">Department</label>
                            <select id="department" wire:model.live="selectedDeptId" class="form-control tw-text-sm">
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept['id_ubigeo'] }}">{{ $dept['nombre_ubigeo'] }}</option>
                                @endforeach
                            </select>
                            @error('department') <span class="text-danger tw-text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>                    
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="single-input-item">
                            <label for="province" class="required">Province</label>
                            <select id="province" wire:model.live="selectedProvId" {{ empty($provinces) ? 'disabled' : '' }} class="form-control tw-text-sm">
                                <option value="">Select Province</option>
                                @foreach($provinces as $prov)
                                    <option value="{{ $prov['id_ubigeo'] }}">{{ $prov['nombre_ubigeo'] }}</option>
                                @endforeach
                            </select>
                            @error('province') <span class="text-danger tw-text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="single-input-item">
                            <label for="district" class="required">District</label>
                            <select id="district" wire:model.live="selectedDistId" {{ empty($districts) ? 'disabled' : '' }} class="form-control tw-text-sm">
                                <option value="">Select District</option>
                                @foreach($districts as $dist)
                                    <option value="{{ $dist['id_ubigeo'] }}">{{ $dist['nombre_ubigeo'] }}</option>
                                @endforeach
                            </select>
                            @error('district') <span class="text-danger tw-text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>                    
                </div>

                <div class="single-input-item">
                    <label for="address" class="required">Address</label>
                    <input type="text" id="address" wire:model="address" placeholder="Street address" />
                    @error('address') <span class="text-danger tw-text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="single-input-item">
                    <label for="reference">Reference</label>
                    <input type="text" id="reference" wire:model="reference" placeholder="Near to..." />
                    @error('reference') <span class="text-danger tw-text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="single-input-item">
                    <div class="custom-control custom-checkbox tw-flex tw-items-center tw-gap-2">
                        <input type="checkbox" class="custom-control-input tw-w-4" id="is_default" wire:model="is_default">
                        <label class="custom-control-label !tw-mb-0" for="is_default">Set as default address</label>
                    </div>
                </div>

                <div class="single-input-item tw-flex tw-gap-4">
                    <button type="submit" class="check-btn sqr-btn">Save Address</button>
                    <button type="button" wire:click="cancel" class="check-btn sqr-btn tw-bg-gray-500 hover:tw-bg-gray-600">Cancel</button>
                </div>
            </form>
        </div>
    @else
        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4">
            @forelse($addresses as $addr)
                <div class="tw-bg-gray-50 tw-p-4 tw-rounded">
                    <div class="tw-border tw-rounded tw-relative {{ $addr->is_default ? 'tw-border-red-500' : 'tw-border-gray-200' }}">
                        @if($addr->is_default)
                            <span class="tw-absolute tw-top-0 -tw-right-px tw-bg-red-500 tw-text-white !tw-text-xs tw-px-2 tw-py-1 tw-rounded tw-scale-90">Default</span>
                        @endif
                        <address>
                            <p class="tw-capitalize"><strong>{{ $addr->address_type ?: 'Address' }}</strong></p>
                            <p>{{ $addr->address }} <br>
                            {{ $addr->district }}, {{ $addr->province }}, {{ $addr->department }}</p>
                            @if($addr->reference)
                                <p class="tw-text-sm tw-text-gray-500">Ref: {{ $addr->reference }}</p>
                            @endif
                        </address>
                        <div class="tw-flex tw-justify-between tw-items-center tw-gap-2 tw-mt-2">
                            <a href="#" wire:click.prevent="edit({{ $addr->id }})" class="check-btn sqr-btn">Edit</a>
                            <a href="#" wire:click.prevent="confirmAddressDeletion({{ $addr->id }})">
                                <svg class="tw-w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm80-160h80v-360h-80v360Zm160 0h80v-360h-80v360Z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>You have no saved addresses.</p>
                </div>
            @endforelse
        </div>    
        @if($addresses->count() < 5)
            <div class="btn-style-1 tw-absolute tw-top-0 tw-right-0">
                <a class="animated tw-px-2 tw-py-1 !tw-text-xs" href="#" wire:click.prevent="create" tabindex="0">
                    <svg class="tw-w-4 tw-inline-block -tw-mt-px" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                    <span>New Address</span>
                </a>
            </div>
        @endif    
    @endif
    <x-confirmation-modal wire:model="confirmingAddressDeletion">
        <x-slot name="title">
            Delete Address
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete this address? Once deleted, it cannot be recovered.
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingAddressDeletion')" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-danger-button class="tw-ms-3" wire:click="deleteAddress" wire:loading.attr="disabled">
                Delete Address
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>