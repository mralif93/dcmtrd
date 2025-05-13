<x-mail::message>
# Security Approval Notification

Hello {{ $user->name }},

We are pleased to inform you that the following security has been ✅ **submitted for approval** and is now under review in the system.

<x-mail::panel>
## Security Details
- 🏢 **Issuer Short Name:** {{ $security->issuer->issuer_short_name ?? 'N/A' }}
- 🏷️ **Security Name:** {{ $security->security_name }}
- 🔢 **Security Code:** {{ $security->security_code }}
- 💼 **Asset Name Type:** {{ $security->asset_name_type }}
- 🟡 **Status:** {{ $security->status }}

@if ($security->status === 'Rejected' && $security->remarks)
- 📝 **Rejection Reason:** {{ $security->remarks }}
@endif
</x-mail::panel>

<x-mail::button :url="route('list-security-m.details', ['security' => $security->id])">
View Security Details
</x-mail::button>

Please take any required follow-up actions as per your internal workflow.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
