<x-mail::message>
# Issuer Rejection Notification

Hello {{ $user->name }},

We regret to inform you that the issuer ❌ **{{ $issuer->issuer_name }}** has been rejected and will not proceed to the preparer process.

<x-mail::panel>
## Issuer Details
- 🏢 **Issuer Name:** {{ $issuer->issuer_name }}
- 🔠 **Short Name:** {{ $issuer->issuer_short_name }}
- 🔢 **Registration Number:** {{ $issuer->registration_number }}
- 🏛️ **Debenture Type:** {{ $issuer->debenture ?? 'N/A' }}
- 👥 **Trustee Role 1:** {{ $issuer->trustee_role_1 ?? 'N/A' }}
- 👥 **Trustee Role 2:** {{ $issuer->trustee_role_2 ?? 'N/A' }}
- 📅 **Trust Deed Date:** {{ $issuer->trust_deed_date ? $issuer->trust_deed_date->toFormattedDateString() : 'N/A' }}
- 💰 **Escrow Trust Amount:** {{ $issuer->trust_amount_escrow_sum ?? 'N/A' }}
- 💵 **Outstanding Size:** {{ $issuer->outstanding_size ?? 'N/A' }}
- 📊 **Number of Shares:** {{ $issuer->no_of_share ?? 'N/A' }}

## Rejection Information
- ❌ **Rejection Status:** Rejected
- 📅 **Rejection Date:** {{ now()->toFormattedDateString() }}
- 👤 **Rejected By:** {{ $issuer->verified_by ?? 'N/A' }}
- ⏱️ **Rejection Timestamp:** {{ $issuer->approval_datetime ? $issuer->approval_datetime->toFormattedDateString() : 'N/A' }}

</x-mail::panel>

<x-mail::button :url="route('issuer-m.show', ['issuer' => $issuer->id])">
View Issuer Details
</x-mail::button>

We kindly ask that you review the issuer details again and address the necessary adjustments to proceed with the next steps.

If you have any questions or require additional clarification, please feel free to reach out.

Thank you for your attention and cooperation.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
