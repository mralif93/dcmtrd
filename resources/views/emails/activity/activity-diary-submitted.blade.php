<x-mail::message>
# Activity Diary Submission Notification

Hello {{ $user->name }},

A new **Activity Diary** has been 📝 **submitted** and is now pending your review.

<x-mail::panel>
## Activity Diary Details
- 🧾 **Purpose:** {{ $activityDiary->purpose ?? 'N/A' }}
- 🗓️ **Letter Date:** {{ optional($activityDiary->letter_date)->format('d M Y') ?? 'N/A' }}
- 📆 **Due Date:** {{ optional($activityDiary->due_date)->format('d M Y') ?? 'N/A' }}

@if ($activityDiary->extension_date_1)
- ⏩ **Extension Date 1:** {{ \Carbon\Carbon::parse($activityDiary->extension_date_1)->format('d M Y') }}
- 📝 **Note 1:** {{ $activityDiary->extension_note_1 ?? 'N/A' }}
@endif

@if ($activityDiary->extension_date_2)
- ⏭️ **Extension Date 2:** {{ \Carbon\Carbon::parse($activityDiary->extension_date_2)->format('d M Y') }}
- 📝 **Note 2:** {{ $activityDiary->extension_note_2 ?? 'N/A' }}
@endif

- 👤 **Prepared By:** {{ $activityDiary->prepared_by ?? 'N/A' }}
- 👁️ **Verified By:** {{ $activityDiary->verified_by ?? 'N/A' }}
- 🟡 **Status:** {{ $activityDiary->status ?? 'N/A' }}

@if ($activityDiary->remarks)
- 💬 **Remarks:** {{ $activityDiary->remarks }}
@endif
</x-mail::panel>

<x-mail::button :url="route('activity-diary-a.show', $activityDiary->id)">
View Activity Diary
</x-mail::button>

Please review and take action as per your internal workflow.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
