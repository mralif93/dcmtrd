<x-mail::message>
# Fund Transfer Notification

Hello {{ $user->name }},

The following placement & fund transfer has been ❌ **rejected** in the system.

<x-mail::panel>
## Fund Transfer Details
- 📅 **Date:** {{ \Carbon\Carbon::parse($fundTransfer->date)->format('d M Y') }}
- 💬 **Details:** {{ $fundTransfer->details ?? 'N/A' }}
- 💰 **Placement Amount:** RM {{ number_format($fundTransfer->placement_amount, 2) }}
- 💸 **Fund Transfer Amount:** RM {{ number_format($fundTransfer->fund_transfer_amount, 2) }}
- 👤 **Prepared By:** {{ $fundTransfer->prepared_by ?? 'N/A' }}
- 👁️ **Verified By:** {{ $fundTransfer->verified_by ?? 'N/A' }}
- 🔴 **Status:** Rejected
</x-mail::panel>

<x-mail::button :url="route('fund-transfer-m.index')">
View Fund Transfer Details
</x-mail::button>

Please proceed with any necessary actions as per your workflow.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
