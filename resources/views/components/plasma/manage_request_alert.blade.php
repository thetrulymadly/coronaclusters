@if(!empty($loggedInDonor))
    <div class="alert alert-success">
        <span class="text-base">
            {{ ($loggedInDonor->donor_type === \App\Dictionary\PlasmaDonorType::REQUESTER ? __('plasma.manage_request') : __('plasma.manage_donor')) .':' }}
        </span>
        <a href="{{ $loggedInDonor->url }}" class="ml-1">
            {{ '#' . $loggedInDonor->uuid_hex }}
        </a>
    </div>
@endif