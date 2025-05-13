<x-mail::message>
# ✅ Security Approval Notification

Hello {{ $user->name }},

We are pleased to inform you that the following security has been successfully **approved** and is now marked as **Active** in the system.

<x-mail::panel>
## Security Details
- 🏢 **Issuer Short Name:** {{ $security->issuer->issuer_short_name ?? 'N/A' }}
- 🏷️ **Security Name:** {{ $security->security_name }}
- 🔢 **Security Code:** {{ $security->security_code }}
- 💼 **Asset Name Type:** {{ $security->asset_name_type }}
- 📅 **Approval Date:** {{ \Carbon\Carbon::parse($security->approval_datetime)->format('d/m/Y h:i A') }}
- 👤 **Approved By:** {{ $security->verified_by ?? 'N/A' }}
</x-mail::panel>

<x-mail::button :url="route('list-security-m.details', ['security' => $security->id])">
View Security Details
</x-mail::button>

If you have any questions or concerns, please reach out to the compliance team.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
