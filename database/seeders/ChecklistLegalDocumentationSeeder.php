<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Checklist;
use App\Models\ChecklistLegalDocumentation;
use Carbon\Carbon;

class ChecklistLegalDocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First ensure we have checklists to reference
        if (Checklist::count() === 0) {
            $this->command->info('No checklists found. Please run ChecklistSeeder first.');
            return;
        }

        // Get all checklist IDs
        $checklists = Checklist::all();
        
        // Define possible status values
        $statuses = ['pending', 'active', 'rejected', 'inactive'];
        
        // Define possible user names for prepared_by and verified_by
        $users = [
            'John Doe', 
            'Jane Smith', 
            'Michael Johnson', 
            'Emily Williams', 
            'Robert Brown', 
            'Sarah Davis'
        ];
        
        // Document locations
        $locations = [
            'Main Office Filing Cabinet',
            'Legal Department Archive',
            'Cloud Storage - Legal Folder',
            'Site Office Safe',
            'External Legal Counsel',
            'Corporate Registry',
            'Property Management Office',
            'Land Registry Office',
            'Regional Office Archive',
            'Digital Document Management System'
        ];
        
        // Document references pattern
        $refFormats = [
            'LD-{year}-{5digits}',
            'LEGAL/{year}/{4digits}',
            'DOC-{3letters}-{year}-{4digits}',
            'REF-{year}-{month}-{4digits}',
            'LGL-{3letters}-{5digits}'
        ];
        
        $totalCreated = 0;
        
        foreach ($checklists as $checklist) {
            // 80% chance to create legal documentation for each checklist
            if (rand(1, 10) <= 8) {
                $status = $statuses[array_rand($statuses)];
                $preparedBy = $users[array_rand($users)];
                
                // Only set verified_by and approval_datetime if status is 'active' or 'rejected'
                $verifiedBy = in_array($status, ['active', 'rejected']) ? $users[array_rand($users)] : null;
                $approvalDatetime = in_array($status, ['active', 'rejected']) ? Carbon::now()->subDays(rand(1, 30)) : null;
                
                // Generate document references and locations
                $titleRef = $this->generateReference($refFormats);
                $titleLocation = $locations[array_rand($locations)];
                
                $trustDeedRef = rand(1, 10) > 3 ? $this->generateReference($refFormats) : null;
                $trustDeedLocation = $trustDeedRef ? $locations[array_rand($locations)] : null;
                
                $salePurchaseAgreement = rand(1, 10) > 4 ? $this->generateReference($refFormats) : null;
                
                $leaseAgreementRef = rand(1, 10) > 3 ? $this->generateReference($refFormats) : null;
                $leaseAgreementLocation = $leaseAgreementRef ? $locations[array_rand($locations)] : null;
                
                $agreementToLease = rand(1, 10) > 5 ? $this->generateReference($refFormats) : null;
                
                $maintenanceAgreementRef = rand(1, 10) > 6 ? $this->generateReference($refFormats) : null;
                $maintenanceAgreementLocation = $maintenanceAgreementRef ? $locations[array_rand($locations)] : null;
                
                $developmentAgreement = rand(1, 10) > 7 ? $this->generateReference($refFormats) : null;
                
                // Generate other legal docs if needed (30% chance)
                $otherLegalDocs = rand(1, 10) <= 3 ? $this->generateOtherLegalDocs() : null;
                
                // Create the legal documentation record
                $legalDoc = new ChecklistLegalDocumentation([
                    'checklist_id' => $checklist->id,
                    'title_ref' => $titleRef,
                    'title_location' => $titleLocation,
                    'trust_deed_ref' => $trustDeedRef,
                    'trust_deed_location' => $trustDeedLocation,
                    'sale_purchase_agreement' => $salePurchaseAgreement,
                    'lease_agreement_ref' => $leaseAgreementRef,
                    'lease_agreement_location' => $leaseAgreementLocation,
                    'agreement_to_lease' => $agreementToLease,
                    'maintenance_agreement_ref' => $maintenanceAgreementRef,
                    'maintenance_agreement_location' => $maintenanceAgreementLocation,
                    'development_agreement' => $developmentAgreement,
                    'other_legal_docs' => $otherLegalDocs,
                    'status' => $status,
                    'prepared_by' => $preparedBy,
                    'verified_by' => $verifiedBy,
                    'remarks' => $this->generateRemarks($status),
                    'approval_datetime' => $approvalDatetime,
                ]);
                
                // Set timestamps manually to simulate older records
                $legalDoc->created_at = Carbon::now()->subDays(rand(1, 60));
                $legalDoc->updated_at = Carbon::now()->subDays(rand(0, 30));
                
                // Randomly soft delete about 5% of records
                if (rand(1, 100) <= 5) {
                    $legalDoc->deleted_at = Carbon::now()->subDays(rand(0, 15));
                }
                
                $legalDoc->save();
                $totalCreated++;
            }
        }
    }
    
    /**
     * Generate a realistic document reference based on the given formats
     */
    private function generateReference(array $formats): string
    {
        $format = $formats[array_rand($formats)];
        
        $year = rand(2020, 2025);
        $month = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
        $digits3 = str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);
        $digits4 = str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
        $digits5 = str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
        
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $letters3 = '';
        for ($i = 0; $i < 3; $i++) {
            $letters3 .= $letters[rand(0, strlen($letters) - 1)];
        }
        
        // Replace placeholders with generated values
        $reference = str_replace(
            ['{year}', '{month}', '{3digits}', '{4digits}', '{5digits}', '{3letters}'],
            [$year, $month, $digits3, $digits4, $digits5, $letters3],
            $format
        );
        
        return $reference;
    }
    
    /**
     * Generate other legal documents text
     */
    private function generateOtherLegalDocs(): string
    {
        $otherDocs = [
            'Environmental Compliance Certificate REF-ENV-',
            'Easement Agreement REF-EAS-',
            'Statutory Declaration SD-',
            'Power of Attorney POA-',
            'Restrictive Covenant RC-',
            'Mortgage Agreement MA-',
            'Indemnity Agreement IA-',
            'Water Rights Certificate WRC-',
            'Access Agreement AA-',
            'Building Permit BP-'
        ];
        
        $result = [];
        $numDocs = rand(1, 3);
        
        for ($i = 0; $i < $numDocs; $i++) {
            $doc = $otherDocs[array_rand($otherDocs)];
            $result[] = $doc . rand(1000, 9999) . '-' . rand(1, 99);
        }
        
        return implode('; ', $result);
    }
    
    /**
     * Generate realistic remarks based on the status
     */
    private function generateRemarks(string $status): ?string
    {
        if (rand(1, 10) > 7) { // 30% chance of having no remarks
            return null;
        }
        
        $pendingRemarks = [
            'Waiting for title certification',
            'Documents under legal review',
            'Pending signature from legal department',
            'Awaiting trust deed verification',
        ];
        
        $activeRemarks = [
            'All legal documents verified and compliant',
            'Documentation complete and active',
            'Legal review completed with no issues',
            'All required documentation in place',
        ];
        
        $rejectedRemarks = [
            'Missing critical legal documentation',
            'Title reference errors identified',
            'Issues with lease agreement terms',
            'Legal compliance concerns noted',
        ];
        
        $inactiveRemarks = [
            'Documentation superseded by new agreements',
            'Project phase completed, documents archived',
            'Properties sold, documentation transferred',
            'No longer legally relevant to current operations',
        ];
        
        switch ($status) {
            case 'pending':
                return $pendingRemarks[array_rand($pendingRemarks)];
            case 'active':
                return $activeRemarks[array_rand($activeRemarks)];
            case 'rejected':
                return $rejectedRemarks[array_rand($rejectedRemarks)];
            case 'inactive':
                return $inactiveRemarks[array_rand($inactiveRemarks)];
            default:
                return null;
        }
    }
}