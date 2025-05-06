<x-mail::message>
# Pending Issuer Approval Notification

Hello {{ $user->name }},

We are writing to inform you that the issuer 🚨 **{{ $issuer->issuer_name }}** is currently awaiting your approval. Kindly review the details of the issuer and take the necessary actions to proceed.

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

## Pending Approval Information
- ⚖️ **Approval Status:** Pending
- ⏰ **Date Requested:** {{ now()->toFormattedDateString() }}
</x-mail::panel>

<x-mail::button :url="route('issuer-m.show', ['issuer' => $issuer->id])">
View Issuer Details
</x-mail::button>

We kindly ask that you review the issuer's information and approve it to continue with the next steps.

If you have any questions or require further information, please feel free to contact us.

Thank you for your prompt attention.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
