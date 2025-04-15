<x-mail::message>
# Trustee Fee Reminder

Dear User,

This is a reminder that **Trustee Fee #{{ $fee->id }}** has the following reminders due today:

@if($fee->first_reminder && $fee->first_reminder->isToday())
**First Reminder** on **{{ $fee->first_reminder->format('F j, Y') }}**<br>
@endif

@if($fee->second_reminder && $fee->second_reminder->isToday())
**Second Reminder** on **{{ $fee->second_reminder->format('F j, Y') }}**<br>
@endif

@if($fee->third_reminder && $fee->third_reminder->isToday())
**Third Reminder** on **{{ $fee->third_reminder->format('F j, Y') }}**<br>
@endif

### Description
{{ $fee->description }}

### Amounts:
- Trustee Fee 1: ${{ number_format($fee->trustee_fee_amount_1, 2) }}
- Trustee Fee 2: ${{ number_format($fee->trustee_fee_amount_2, 2) }}

### Important Dates:
- Start Anniversary Date: {{ $fee->start_anniversary_date ? $fee->start_anniversary_date->format('F j, Y') : 'N/A' }}
- End Anniversary Date: {{ $fee->end_anniversary_date ? $fee->end_anniversary_date->format('F j, Y') : 'N/A' }}

Prepared by: {{ $fee->prepared_by }}

<x-mail::button :url="'https://your-link-to-details.com'">
View Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
