<x-mail::message>
# Security Document Return Notification

Hello {{ $user->name }},

Please be informed that the following **Security Document Request** has been 🔄 **returned** for further action or clarification.

<x-mail::panel>
## Return Details
- 🆔 **Request ID:** {{ $docRequest->id }}
- 🏢 **List Security ID:** {{ $docRequest->list_security_id }}
- 📅 **Request Date:** {{ \Carbon\Carbon::parse($docRequest->request_date)->format('d M Y') }}
- 🎯 **Purpose:** {{ $docRequest->purpose }}
- 👤 **Prepared By:** {{ $docRequest->prepared_by }}
- 🔁 **Current Status:** {{ $docRequest->status }}
- 📅 **Return Date:** {{ \Carbon\Carbon::parse($docRequest->return_date)->format('d M Y') }}
@if($docRequest->return_remarks)
- 📝 **Return Remarks:** {{ $docRequest->return_remarks }}
@endif
</x-mail::panel>

<x-mail::button :url="route('legal.sec-documents')">
View Return Details
</x-mail::button>

Please review the remarks and take the necessary follow-up actions to resubmit the request.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
