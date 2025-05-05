<x-mail::message>
# Trustee Fee Approval Notification

Hello {{ $user->name }},

We are pleased to inform you that the Trustee Fee record has been ✅ **approved** and is now marked as *Active* in the system.

<x-mail::panel>
## Trustee Fee Details
- 📝 **Description:** {{ $trusteeFee->description ?? 'N/A' }}
- 💰 **Trustee Fee Amount 1:** RM {{ number_format($trusteeFee->trustee_fee_amount_1, 2) }}
- 💰 **Trustee Fee Amount 2:** RM {{ number_format($trusteeFee->trustee_fee_amount_2, 2) }}
- 📅 **Start Anniversary Date:** {{ $trusteeFee->start_anniversary_date ?? 'N/A' }}
- 📅 **End Anniversary Date:** {{ $trusteeFee->end_anniversary_date ?? 'N/A' }}
- 🧾 **Invoice No:** {{ $trusteeFee->invoice_no ?? 'N/A' }}
- 🗓️ **Date Letter to Issuer:** {{ $trusteeFee->date_letter_to_issuer ?? 'N/A' }}
- ✅ **Approval Status:** {{ $trusteeFee->status ?? 'N/A' }}
- 📅 **Approval Date:** {{ $trusteeFee->approval_datetime ? \Carbon\Carbon::parse($trusteeFee->approval_datetime)->toFormattedDateString() : 'N/A' }}
- 👤 **Approved By:** {{ $trusteeFee->verified_by ?? 'N/A' }}

</x-mail::panel>

<x-mail::button :url="route('trustee-fee-m.show', ['trusteeFee' => $trusteeFee->id])">
View Trustee Fee
</x-mail::button>

Please proceed with any subsequent tasks according to your internal process. If you need further information, feel free to get in touch.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
