<x-mail::message>
# Payment Schedule Reminder for Bond #{{ $paymentSchedule->bond_id }}

Hello {{ $user->name }},

This is a friendly reminder regarding the **Payment Schedule** for **Bond #{{ $paymentSchedule->bond_id }}**. Please take note of the following important details:

<x-mail::panel>
## Payment Schedule Details
- **Bond ID:** {{ $paymentSchedule->bond_id }}
- **Start Date:** {{ \Carbon\Carbon::parse($paymentSchedule->start_date)->format('F j, Y') }}
- **End Date:** {{ \Carbon\Carbon::parse($paymentSchedule->end_date)->format('F j, Y') }}
- **Payment Date:** {{ \Carbon\Carbon::parse($paymentSchedule->payment_date)->format('F j, Y') }}
- **Ex-Date:** {{ $paymentSchedule->ex_date ? \Carbon\Carbon::parse($paymentSchedule->ex_date)->format('F j, Y') : 'N/A' }}
- **Adjustment Date:** {{ $paymentSchedule->adjustment_date ? \Carbon\Carbon::parse($paymentSchedule->adjustment_date)->format('F j, Y') : 'N/A' }}
- **Coupon Rate:** {{ $paymentSchedule->coupon_rate ?? 'N/A' }}%
- **Reminder Total Days:** {{ $paymentSchedule->reminder_total_date }} days before payment

## Important Dates
- **Reminder Date:** {{ \Carbon\Carbon::now()->format('F j, Y') }}
- **Payment Date:** {{ \Carbon\Carbon::parse($paymentSchedule->payment_date)->format('F j, Y') }}

</x-mail::panel>

Please ensure the payment is processed on or before the due date.

If you have any questions or need assistance, please don't hesitate to contact us.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
