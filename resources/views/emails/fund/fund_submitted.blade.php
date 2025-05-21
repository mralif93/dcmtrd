<x-mail::message>
# Fund Transfer Submission Notification

Hello {{ $user->name }},

A new **Placement & Fund Transfer** has been 📝 **submitted** and is now pending your review.

<x-mail::panel>
## Fund Transfer Details
- 📅 **Date:** {{ \Carbon\Carbon::parse($fundTransfer->date)->format('d M Y') }}
- 💬 **Details:** {{ $fundTransfer->details ?? 'N/A' }}
- 💰 **Placement Amount:** RM {{ number_format($fundTransfer->placement_amount, 2) }}
- 💸 **Fund Transfer Amount:** RM {{ number_format($fundTransfer->fund_transfer_amount, 2) }}
- 👤 **Prepared By:** {{ $fundTransfer->prepared_by ?? 'N/A' }}
- 👁️ **Verified By:** {{ $fundTransfer->verified_by ?? 'N/A' }}
- 🟡 **Status:** {{ $fundTransfer->status }}

@if ($fundTransfer->remarks)
- 📝 **Remarks:** {{ $fundTransfer->remarks }}
@endif
</x-mail::panel>

<x-mail::button :url="route('fund-transfer-a.index')">
Review Fund Transfer
</x-mail::button>

Please proceed with the necessary review and action according to your internal workflow.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
