<x-mail::message>
# Security Document Withdrawal Notification

Hello {{ $user->name }},

We would like to notify you that the following **Security Document Request** has been ✅ **approved** and is now marked for **withdrawal**.

<x-mail::panel>
## Withdrawal Details
- 🆔 **Request ID:** {{ $docRequest->id }}
- 🏢 **List Security ID:** {{ $docRequest->list_security_id }}
- 📅 **Request Date:** {{ \Carbon\Carbon::parse($docRequest->request_date)->format('d M Y') }}
- 🎯 **Purpose:** {{ $docRequest->purpose }}
- 👤 **Prepared By:** {{ $docRequest->prepared_by }}
- 🟣 **Current Status:** {{ $docRequest->status }}
- 🟡 **Withdrawal Date:** {{ \Carbon\Carbon::parse($docRequest->withdrawal_date)->format('d M Y') }}
</x-mail::panel>

<x-mail::button :url="route('legal.sec-documents')">
View Withdrawal Details
</x-mail::button>

Please proceed with any follow-up action required by your team or workflow.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
