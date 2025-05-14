<x-mail::message>
# Compliance Covenant Rejection Notification

Hello {{ $user->name }},

We regret to inform you that the following compliance covenant submission has been ❌ **rejected** after review.

<x-mail::panel>
## Compliance Covenant Details
- 🏢 **Issuer Short Name:** {{ $compliance->issuer->issuer_short_name }}
- 📅 **Financial Year End:** {{ $compliance->financial_year_end }}
- 📬 **Letter to Issuer:** {{ $compliance->letter_to_issuer ? \Carbon\Carbon::parse($compliance->letter_to_issuer)->format('d/m/Y') : 'N/A' }}

## Document Submissions
- 📄 **Audited Financial Statements:** 
  {{ $compliance->afs_not_required ? 'Not Applicable' : ($compliance->audited_financial_statements ?? 'Not Submitted') }}
- 📅 **AFS Due Date:** 
  {{ $compliance->afs_not_required ? 'Not Applicable' : ($compliance->audited_financial_statements_due ?? 'Not Submitted') }}
- 📄 **Compliance Certificate:** 
  {{ $compliance->cc_not_required ? 'Not Applicable' : ($compliance->compliance_certificate ?? 'Not Submitted') }}
- 📄 **Annual Budget:** 
  {{ $compliance->budget_not_required ? 'Not Applicable' : ($compliance->annual_budget ?? 'Not Submitted') }}
- 📄 **Unaudited Financial Statements:** 
  {{ $compliance->ufs_not_required ? 'Not Applicable' : ($compliance->unaudited_financial_statements ?? 'Not Submitted') }}
- 📅 **UFS Due Date:** 
  {{ $compliance->ufs_not_required ? 'Not Applicable' : ($compliance->unaudited_financial_statements_due ?? 'Not Submitted') }}
- 📈 **Finance Service Cover Ratio:** 
  {{ $compliance->fscr_not_required ? 'Not Applicable' : ($compliance->finance_service_cover_ratio ?? 'Not Submitted') }}
- 📊 **Computation of Finance to EBITDA:** 
  {{ $compliance->ebitda_not_required ? 'Not Applicable' : ($compliance->computation_of_finance_to_ebitda ?? 'Not Submitted') }}

## Compliance Status
- 📌 **Overall Status:** {{ $compliance->isCompliant() ? 'Compliant ✅' : 'Non-Compliant ❌' }}
- ❌ **Rejection Reason:** {{ $compliance->remarks ?? 'No reason provided' }}
- 👤 **Rejected By:** {{ $compliance->verified_by ?? 'N/A' }}

@if (!$compliance->isCompliant())
- 📎 **Missing Documents:**
@foreach ($compliance->getMissingDocuments() as $document)
  - {{ $document }}
@endforeach
@endif

</x-mail::panel>

<x-mail::button :url="route('compliance-covenant-m.show', ['compliance' => $compliance->id])">
View Compliance Covenant
</x-mail::button>

Please review the feedback and consider resubmitting with the required corrections.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
