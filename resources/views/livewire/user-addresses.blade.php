<div class="myaccount-content">
    <h3>Billing Address</h3>
    
    @if (session()->has('message'))
        <div class="alert alert-success tw-mb-4">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger tw-mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($isCreating || $isEditing)
        <div class="account-details-form">
            <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="single-input-item">
                            <label for="department" class="required">Department</label>
                            <input type="text" id="department" wire:model="department" />
                            @error('department') <span class="text-danger tw-text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="single-input-item">
                            <label for="province" class="required">Province</label>
                            <input type="text" id="province" wire:model="province" />
                            @error('province') <span class="text-danger tw-text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="single-input-item">
                            <label for="district" class="required">District</label>
                            <input type="text" id="district" wire:model="district" />
                            @error('district') <span class="text-danger tw-text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="single-input-item">
                            <label for="address_type">Address Type (e.g. Home, Work)</label>
                            <input type="text" id="address_type" wire:model="address_type" />
                            @error('address_type') <span class="text-danger tw-text-sm">{{ $message }}</span> @enderror
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
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_default" wire:model="is_default">
                        <label class="custom-control-label" for="is_default">Set as default address</label>
                    </div>
                </div>

                <div class="single-input-item tw-flex tw-gap-4">
                    <button type="submit" class="check-btn sqr-btn">Save Address</button>
                    <button type="button" wire:click="cancel" class="check-btn sqr-btn tw-bg-gray-500 hover:tw-bg-gray-600">Cancel</button>
                </div>
            </form>
        </div>
    @else
        <div class="row">
            @forelse($addresses as $addr)
                <div class="col-lg-6 mb-4">
                    <div class="tw-border tw-p-4 tw-rounded tw-relative {{ $addr->is_default ? 'tw-border-blue-500' : 'tw-border-gray-200' }}">
                        @if($addr->is_default)
                            <span class="tw-absolute tw-top-2 tw-right-2 tw-bg-blue-500 tw-text-white tw-text-xs tw-px-2 tw-py-1 tw-rounded">Default</span>
                        @endif
                        <address>
                            <p><strong>{{ $addr->address_type ?: 'Address' }}</strong></p>
                            <p>{{ $addr->address }} <br>
                            {{ $addr->district }}, {{ $addr->province }}, {{ $addr->department }}</p>
                            @if($addr->reference)
                                <p class="tw-text-sm tw-text-gray-500">Ref: {{ $addr->reference }}</p>
                            @endif
                        </address>
                        <div class="tw-flex tw-gap-2 tw-mt-2">
                            <a href="#" wire:click.prevent="edit({{ $addr->id }})" class="check-btn sqr-btn tw-px-3 tw-py-1 tw-text-sm"><i class="fa fa-edit"></i> Edit</a>
                            <a href="#" wire:click.prevent="delete({{ $addr->id }})" onclick="confirm('Are you sure you want to delete this address?') || event.stopImmediatePropagation()" class="check-btn sqr-btn tw-px-3 tw-py-1 tw-text-sm tw-bg-red-500 hover:tw-bg-red-600"><i class="fa fa-trash"></i> Delete</a>
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
            <a href="#" wire:click.prevent="create" class="check-btn sqr-btn"><i class="fa fa-plus"></i> Add New Address</a>
        @endif
    @endif
</div>
