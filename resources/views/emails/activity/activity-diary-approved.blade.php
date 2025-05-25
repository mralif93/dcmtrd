<x-mail::message>
# Activity Diary Approval Notification

Hello {{ $user->name }},

The following activity diary has been ✅ **approved** in the system.

<x-mail::panel>
## Activity Diary Details
- 📅 **Letter Date:** {{ optional($activityDiary->letter_date)->format('d M Y') ?? 'N/A' }}
- 📅 **Due Date:** {{ optional($activityDiary->due_date)->format('d M Y') ?? 'N/A' }}
@if ($activityDiary->extension_date_1)
- ⏳ **Extension 1:** {{ \Carbon\Carbon::parse($activityDiary->extension_date_1)->format('d M Y') }}
    - 💬 Note: {{ $activityDiary->extension_note_1 ?? 'N/A' }}
@endif
@if ($activityDiary->extension_date_2)
- ⏳ **Extension 2:** {{ \Carbon\Carbon::parse($activityDiary->extension_date_2)->format('d M Y') }}
    - 💬 Note: {{ $activityDiary->extension_note_2 ?? 'N/A' }}
@endif
- 📝 **Purpose:** {{ $activityDiary->purpose ?? 'N/A' }}
- 👤 **Prepared By:** {{ $activityDiary->prepared_by ?? 'N/A' }}
- 👁️ **Verified By:** {{ $activityDiary->verified_by ?? 'N/A' }}
- 🟢 **Status:** Approved
@if ($activityDiary->remarks)
- 🗒️ **Remarks:** {{ $activityDiary->remarks }}
@endif
</x-mail::panel>

<x-mail::button :url="route('activity-diary-m.index')">
View Activity Diary
</x-mail::button>

Please proceed with any necessary actions as per your workflow.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
