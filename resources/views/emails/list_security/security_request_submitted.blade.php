<x-mail::message>
# Security Document Request Notification

Hello {{ $user->name }},

A new **Security Document Request** has been ✅ **submitted** and is now under review.

<x-mail::panel>
## Document Request Details
- 🆔 **Request ID:** {{ $docRequest->id }}
- 🏢 **List Security ID:** {{ $docRequest->list_security_id }}
- 📅 **Request Date:** {{ \Carbon\Carbon::parse($docRequest->request_date)->format('d M Y') }}
- 🎯 **Purpose:** {{ $docRequest->purpose }}
- 👤 **Prepared By:** {{ $docRequest->prepared_by }}
- 🟡 **Status:** {{ $docRequest->status }}
</x-mail::panel>

<x-mail::button :url="route('list-security-request-a.show')">
View Request Details
</x-mail::button>

Please take any necessary follow-up action in your workflow.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
