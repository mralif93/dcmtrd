<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Checklist;
use App\Models\ChecklistPropertyDevelopment;

class ChecklistPropertyDevelopmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all existing checklist IDs
        $checklistIds = Checklist::pluck('id')->toArray();
        
        // If no checklists exist, create a warning
        if (empty($checklistIds)) {
            $this->command->warn('No checklists found in the database. Please run the ChecklistSeeder first.');
            return;
        }
        
        // Status options
        $statusOptions = ['active', 'pending', 'rejected', 'inactive'];
        
        // Staff members who might prepare or verify checklists
        $staffMembers = [
            'John Doe',
            'Jane Smith',
            'Michael Johnson',
            'Lisa Anderson',
            'Robert Wilson'
        ];
        
        // Development scope of work templates
        $developmentScopeTemplates = [
            'Construction of additional office space on 3rd floor',
            'Expansion of retail area on ground floor',
            'Building of new wing for commercial tenants',
            'Development of rooftop garden and recreational area',
            'Construction of additional parking levels',
            'Infrastructure upgrades to support increased occupancy',
            'Construction of dedicated server room and IT infrastructure',
            'Development of conference center in east wing',
            'Addition of childcare facility for tenants',
            'Construction of fitness center for building occupants'
        ];
        
        // Renovation scope of work templates
        $renovationScopeTemplates = [
            'Modernization of lobby and reception area',
            'Complete renovation of bathrooms on floors 1-5',
            'Upgrade of HVAC systems throughout the building',
            'Renovation of tenant spaces on 2nd floor',
            'Modernization of elevator systems',
            'Installation of energy-efficient lighting systems',
            'Replacement of flooring in common areas',
            'Renovation of staff break rooms',
            'Modernization of security systems',
            'Upgrade of fire suppression systems'
        ];
        
        // External repainting scope of work templates
        $repaintingScopeTemplates = [
            'Complete exterior repainting with weather-resistant coating',
            'Repainting of north and east facades',
            'Restoration and repainting of historical facade elements',
            'Application of protective coating to exterior surfaces',
            'Repainting of exterior trim and decorative elements',
            'Color update to comply with new corporate branding',
            'Graffiti removal and protective coating application',
            'Repainting of external fixtures and fittings',
            'Application of anti-UV coating to south-facing surfaces',
            'Touch-up painting of weather-damaged areas'
        ];
        
        // Other proposals scope of work templates
        $othersScopeTemplates = [
            'Installation of solar panels on roof',
            'Implementation of rainwater collection system',
            'Proposal for green wall on south facade',
            'Installation of EV charging stations in parking area',
            'Development of shared tenant workspace in unused areas',
            'Proposal for outdoor seating area for staff',
            'Implementation of smart building technology',
            'Approval for signage changes',
            'Installation of bicycle storage facilities',
            'Proposal for building accessibility improvements'
        ];
        
        // Create property development records
        foreach ($checklistIds as $checklistId) {
            // Generate overall status
            $status = $statusOptions[array_rand($statusOptions)];
            
            // Set timestamps
            $createdAt = Carbon::now()->subDays(rand(1, 180));
            $updatedAt = $createdAt->copy()->addDays(rand(0, 30));
            $approvalDateTime = $status === 'active' ? 
                $updatedAt->copy()->addDays(rand(1, 5)) : null;
            
            // Determine if record has data based on status
            $hasValues = in_array($status, ['active', 'rejected']);
            
            // Development section (70% chance to have data if overall record has values)
            $hasDevelopment = $hasValues && (rand(1, 10) <= 7);
            $developmentDate = $hasDevelopment ? 
                $createdAt->copy()->subDays(rand(30, 365)) : null;
            $developmentScope = $hasDevelopment ? 
                $developmentScopeTemplates[array_rand($developmentScopeTemplates)] : null;
            
            // Renovation section (60% chance to have data if overall record has values)
            $hasRenovation = $hasValues && (rand(1, 10) <= 6);
            $renovationDate = $hasRenovation ? 
                $createdAt->copy()->subDays(rand(30, 180)) : null;
            $renovationScope = $hasRenovation ? 
                $renovationScopeTemplates[array_rand($renovationScopeTemplates)] : null;
            
            // External repainting section (50% chance to have data if overall record has values)
            $hasRepainting = $hasValues && (rand(1, 10) <= 5);
            $repaintingDate = $hasRepainting ? 
                $createdAt->copy()->subDays(rand(30, 120)) : null;
            $repaintingScope = $hasRepainting ? 
                $repaintingScopeTemplates[array_rand($repaintingScopeTemplates)] : null;
            
            // Others proposals section (40% chance to have data if overall record has values)
            $hasOthers = $hasValues && (rand(1, 10) <= 4);
            $othersDate = $hasOthers ? 
                $createdAt->copy()->subDays(rand(7, 90)) : null;
            $othersScope = $hasOthers ? 
                $othersScopeTemplates[array_rand($othersScopeTemplates)] : null;
                
            // Create the record
            ChecklistPropertyDevelopment::create([
                'checklist_id' => $checklistId,
                
                // Development fields
                'development_date' => $developmentDate,
                'development_scope_of_work' => $developmentScope,
                'development_status' => null,
                
                // Renovation fields
                'renovation_date' => $renovationDate,
                'renovation_scope_of_work' => $renovationScope,
                'renovation_status' => null,
                
                // External repainting fields
                'external_repainting_date' => $repaintingDate,
                'external_repainting_scope_of_work' => $repaintingScope,
                'external_repainting_status' => null,
                
                // Others proposals/approvals fields
                'others_proposals_approvals_date' => $othersDate,
                'others_proposals_approvals_scope_of_work' => $othersScope,
                'others_proposals_approvals_status' => null,
                
                // System information
                'status' => $status,
                'prepared_by' => in_array($status, ['active', 'rejected', 'inactive']) ? 
                    $staffMembers[array_rand($staffMembers)] : null,
                'verified_by' => in_array($status, ['active', 'rejected']) ? 
                    $staffMembers[array_rand($staffMembers)] : null,
                'remarks' => $this->getRemarks($status, $hasDevelopment, $hasRenovation, $hasRepainting, $hasOthers),
                'approval_datetime' => $approvalDateTime,
                
                // Timestamps
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
                'deleted_at' => rand(1, 20) === 1 ? 
                    $updatedAt->copy()->addDays(rand(1, 30)) : null, // ~5% chance of being soft deleted
            ]);
        }
    }
    
    /**
     * Get remarks based on status and which sections have data
     */
    private function getRemarks(
        string $status, 
        bool $hasDevelopment, 
        bool $hasRenovation, 
        bool $hasRepainting, 
        bool $hasOthers
    ): ?string {
        // 30% chance of having no remarks
        if (rand(1, 100) <= 30) {
            return null;
        }
        
        $statusRemarks = [
            'active' => [
                'All development plans properly documented and approved.',
                'Property development tracking up to date.',
                'Development history verified against building records.',
                'All plans checked against municipal records.'
            ],
            'pending' => [
                'Awaiting additional development history from property management.',
                'Development documentation in progress.',
                'Records being compiled from multiple sources.',
                'Historical development data being researched.'
            ],
            'rejected' => [
                'Incomplete development history provided.',
                'Development documentation does not match building inspection.',
                'Missing critical approvals for listed developments.',
                'Conflicting information needs resolution.'
            ],
            'inactive' => [
                'Development tracking no longer required for this property.',
                'Historical record maintained for reference only.',
                'Superseded by updated development tracking system.',
                'Archive status applied to development records.'
            ]
        ];
        
        $sectionRemarks = [];
        
        if ($hasDevelopment) {
            $sectionRemarks[] = "Major development project documented.";
        }
        
        if ($hasRenovation) {
            $sectionRemarks[] = "Recent renovation work tracked.";
        }
        
        if ($hasRepainting) {
            $sectionRemarks[] = "External repainting schedule maintained.";
        }
        
        if ($hasOthers) {
            $sectionRemarks[] = "Additional proposals under consideration.";
        }
        
        $statusRemark = $statusRemarks[$status][array_rand($statusRemarks[$status])];
        
        // If we have section remarks, add them to the status remark
        if (!empty($sectionRemarks)) {
            // Choose a random section remark
            $sectionRemark = $sectionRemarks[array_rand($sectionRemarks)];
            return "$statusRemark $sectionRemark";
        }
        
        return $statusRemark;
    }
}