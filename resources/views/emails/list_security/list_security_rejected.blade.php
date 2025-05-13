<x-mail::message>
# ❌ Security Rejection Notification

Hello {{ $user->name }},

We regret to inform you that the following security submission has been **rejected**.

<x-mail::panel>
## Security Details
- 🏢 **Issuer Short Name:** {{ $security->issuer->issuer_short_name ?? 'N/A' }}
- 🏷️ **Security Name:** {{ $security->security_name }}
- 🔢 **Security Code:** {{ $security->security_code }}
- 💼 **Asset Name Type:** {{ $security->asset_name_type }}
- 📅 **Rejection Date:** {{ \Carbon\Carbon::parse($security->approval_datetime)->format('d/m/Y h:i A') }}
- ❌ **Rejected By:** {{ $security->verified_by ?? 'N/A' }}
- 📝 **Remarks:**  
  {{ $security->remarks ?? 'No reason provided.' }}
</x-mail::panel>

<x-mail::button :url="route('list-security-m.details', ['security' => $security->id])">
Review & Resubmit
</x-mail::button>

Please review the remarks and make the necessary adjustments before resubmitting for approval.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
