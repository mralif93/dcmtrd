<x-mail::message>
# Trustee Fee Submission Notification

Hello {{ $user->name }},

A trustee fee has been submitted and is pending your review.

<x-mail::panel>
## Trustee Fee Details
- 🆔 **Fee ID:** {{ $trusteeFee->id }}
- 📝 **Description:** {{ $trusteeFee->description ?? 'N/A' }}
- 💸 **Fee Amount 1:** RM {{ number_format($trusteeFee->trustee_fee_amount_1, 2) }}
- 💸 **Fee Amount 2:** RM {{ number_format($trusteeFee->trustee_fee_amount_2, 2) }}
- 🗓️ **Start Anniversary:** {{ \Carbon\Carbon::parse($trusteeFee->start_anniversary_date)->toFormattedDateString() }}
- 🗓️ **End Anniversary:** {{ \Carbon\Carbon::parse($trusteeFee->end_anniversary_date)->toFormattedDateString() }}
- 🧾 **Invoice No.:** {{ $trusteeFee->invoice_no }}
- 📄 **Memo to FAD:** {{ $trusteeFee->memo_to_fad ? \Carbon\Carbon::parse($trusteeFee->memo_to_fad)->toFormattedDateString() : 'N/A' }}
- 📬 **Letter to Issuer:** {{ $trusteeFee->date_letter_to_issuer ? \Carbon\Carbon::parse($trusteeFee->date_letter_to_issuer)->toFormattedDateString() : 'N/A' }}
- 🔔 **Reminders:**
  - 1st: {{ $trusteeFee->first_reminder ? \Carbon\Carbon::parse($trusteeFee->first_reminder)->toFormattedDateString() : 'N/A' }}
  - 2nd: {{ $trusteeFee->second_reminder ? \Carbon\Carbon::parse($trusteeFee->second_reminder)->toFormattedDateString() : 'N/A' }}
  - 3rd: {{ $trusteeFee->third_reminder ? \Carbon\Carbon::parse($trusteeFee->third_reminder)->toFormattedDateString() : 'N/A' }}
- 💬 **Reminder Remarks:** {{ $trusteeFee->remarks_reminder ?? 'N/A' }}
- 💰 **Payment Received:** {{ $trusteeFee->payment_received ? \Carbon\Carbon::parse($trusteeFee->payment_received)->toFormattedDateString() : 'N/A' }}
- 📌 **Payment Status:** {{ $trusteeFee->payment_status ?? 'N/A' }}
- 🏦 **TT / Cheque No.:** {{ $trusteeFee->tt_cheque_no ?? 'N/A' }}
- 📄 **Memo Receipt to FAD:** {{ $trusteeFee->memo_receipt_to_fad ? \Carbon\Carbon::parse($trusteeFee->memo_receipt_to_fad)->toFormattedDateString() : 'N/A' }}
- 📥 **Receipt to Issuer:** {{ $trusteeFee->receipt_to_issuer ? \Carbon\Carbon::parse($trusteeFee->receipt_to_issuer)->toFormattedDateString() : 'N/A' }}
- 🧾 **Receipt No.:** {{ $trusteeFee->receipt_no ?? 'N/A' }}

## Approval Process
- ⏳ **Status:** {{ $trusteeFee->status }}
- 👤 **Prepared By:** {{ $trusteeFee->prepared_by }}
- 💬 **Remarks to Management:** {{ $trusteeFee->remark_to_management ?? 'N/A' }}
- 📅 **Submitted At:** {{ $trusteeFee->updated_at->toFormattedDateString() }}

</x-mail::panel>

<x-mail::button :url="route('trustee-fee-m.show', ['trusteeFee' => $trusteeFee->id])">
View Trustee Fee
</x-mail::button>

Please log in to the system and proceed with the verification and approval process.

If you have any questions, feel free to reach out.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
