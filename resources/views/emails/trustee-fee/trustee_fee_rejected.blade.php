<x-mail::message>
# Trustee Fee Rejection Notification

Hello {{ $user->name }},

We regret to inform you that the Trustee Fee ❌ has been **rejected** and will not proceed further in the approval workflow.

<x-mail::panel>
## Trustee Fee Details
- 📝 **Description:** {{ $trusteeFee->description ?? 'N/A' }}
- 💰 **Trustee Fee Amount 1:** RM {{ number_format($trusteeFee->trustee_fee_amount_1, 2) }}
- 💰 **Trustee Fee Amount 2:** RM {{ number_format($trusteeFee->trustee_fee_amount_2, 2) }}
- 📅 **Start Anniversary Date:** {{ $trusteeFee->start_anniversary_date ?? 'N/A' }}
- 📅 **End Anniversary Date:** {{ $trusteeFee->end_anniversary_date ?? 'N/A' }}
- 🧾 **Invoice No:** {{ $trusteeFee->invoice_no ?? 'N/A' }}
- 🗓️ **Date Letter to Issuer:** {{ $trusteeFee->date_letter_to_issuer ?? 'N/A' }}
- ❌ **Rejection Status:** {{ $trusteeFee->status ?? 'Rejected' }}
- 📅 **Rejection Date:** {{ now()->toFormattedDateString() }}
- 👤 **Rejected By:** {{ $trusteeFee->verified_by ?? 'N/A' }}
- ⏱️ **Rejection Timestamp:** {{ $trusteeFee->approval_datetime ? \Carbon\Carbon::parse($trusteeFee->approval_datetime)->toFormattedDateString() : 'N/A' }}

</x-mail::panel>

<x-mail::button :url="route('trustee-fee-m.show', ['trusteeFee' => $trusteeFee->id])">
View Trustee Fee
</x-mail::button>

We kindly ask that you review the Trustee Fee submission and make the necessary corrections before resubmitting for approval.

If you have any questions or require additional clarification, please feel free to reach out.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
