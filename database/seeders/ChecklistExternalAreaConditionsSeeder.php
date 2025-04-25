<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Checklist;
use App\Models\ChecklistExternalAreaCondition;

class ChecklistExternalAreaConditionsSeeder extends Seeder
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
        $statusOptions = ['pending', 'in_progress', 'completed', 'verified', 'rejected'];
        
        // Staff members who might prepare or verify checklists
        $staffMembers = [
            'John Doe',
            'Jane Smith',
            'Michael Johnson',
            'Lisa Anderson',
            'Robert Wilson'
        ];
        
        foreach ($checklistIds as $checklistId) {
            // Generate condition data with realistic variation
            $status = $statusOptions[array_rand($statusOptions)];
            
            // Set approval date based on status
            $createdAt = Carbon::now()->subDays(rand(1, 90));
            $updatedAt = $createdAt->copy()->addDays(rand(0, 30));
            $approvalDateTime = in_array($status, ['verified', 'completed']) ? 
                $updatedAt->copy()->addDays(rand(1, 5)) : null;
            
            // Determine if this record should have values filled in
            $hasValues = in_array($status, ['in_progress', 'completed', 'verified', 'rejected']);
            
            // Create the record
            ChecklistExternalAreaCondition::create([
                'checklist_id' => $checklistId,
                
                // External area conditions with random values
                'is_general_cleanliness_satisfied' => $hasValues ? $this->getRandomBoolean(0.85) : null,
                'general_cleanliness_remarks' => $hasValues ? $this->getRemarks('general_cleanliness') : null,
                
                'is_fencing_gate_satisfied' => $hasValues ? $this->getRandomBoolean(0.75) : null,
                'fencing_gate_remarks' => $hasValues ? $this->getRemarks('fencing_gate') : null,
                
                'is_external_facade_satisfied' => $hasValues ? $this->getRandomBoolean(0.8) : null,
                'external_facade_remarks' => $hasValues ? $this->getRemarks('external_facade') : null,
                
                'is_car_park_satisfied' => $hasValues ? $this->getRandomBoolean(0.9) : null,
                'car_park_remarks' => $hasValues ? $this->getRemarks('car_park') : null,
                
                'is_land_settlement_satisfied' => $hasValues ? $this->getRandomBoolean(0.7) : null,
                'land_settlement_remarks' => $hasValues ? $this->getRemarks('land_settlement') : null,
                
                'is_rooftop_satisfied' => $hasValues ? $this->getRandomBoolean(0.65) : null,
                'rooftop_remarks' => $hasValues ? $this->getRemarks('rooftop') : null,
                
                'is_drainage_satisfied' => $hasValues ? $this->getRandomBoolean(0.8) : null,
                'drainage_remarks' => $hasValues ? $this->getRemarks('drainage') : null,
                
                'external_remarks' => $hasValues ? $this->getOverallRemarks() : null,
                
                // System information
                'status' => $status,
                'prepared_by' => $status !== 'pending' ? $staffMembers[array_rand($staffMembers)] : null,
                'verified_by' => in_array($status, ['verified', 'rejected']) ? $staffMembers[array_rand($staffMembers)] : null,
                'remarks' => $status !== 'pending' ? $this->getSystemRemarks($status) : null,
                'approval_datetime' => $approvalDateTime,
                
                // Timestamps
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
                'deleted_at' => rand(1, 20) === 1 ? $updatedAt->copy()->addDays(rand(1, 30)) : null, // ~5% chance of being soft deleted
            ]);
        }
    }
    
    /**
     * Get a random boolean value with specified probability of true
     */
    private function getRandomBoolean(float $trueProbability = 0.7): bool
    {
        return (mt_rand(1, 100) <= ($trueProbability * 100));
    }
    
    /**
     * Get remarks for a specific condition field
     */
    private function getRemarks(string $field): ?string
    {
        // 50% chance of having no remarks if condition is satisfied
        if (rand(1, 100) <= 50) {
            return null;
        }
        
        $remarkTemplates = [
            'general_cleanliness' => [
                'Area requires additional cleaning',
                'Some trash accumulation found in corners',
                'Generally clean but some debris present',
                'Pristine condition, well maintained',
                'Excellent overall cleanliness'
            ],
            'fencing_gate' => [
                'Gate hinges need lubrication',
                'Some fence posts showing signs of rot',
                'Fence paint peeling in several sections',
                'Gate latch difficult to operate',
                'Fence in excellent condition, newly painted'
            ],
            'external_facade' => [
                'Paint chipping on south-facing wall',
                'Some cracks visible on exterior walls',
                'Facade appears recently maintained',
                'Minor staining near downpipes',
                'Excellent condition with no visible defects'
            ],
            'car_park' => [
                'Line markings faded and need repainting',
                'Some oil stains on parking surfaces',
                'Asphalt cracking in several spots',
                'Well maintained with clear markings',
                'Lighting fixtures need replacement in section B'
            ],
            'land_settlement' => [
                'Minor subsidence noted near west corner',
                'Some uneven paving observed',
                'No significant settlement issues found',
                'Historical settlement appears stable',
                'Recent repairs to affected areas appear effective'
            ],
            'rooftop' => [
                'Some water pooling after rainfall',
                'Several tiles need replacement',
                'Gutters contain debris and need cleaning',
                'Solar panel attachments need inspection',
                'Excellent condition following recent maintenance'
            ],
            'drainage' => [
                'Slow drainage observed after heavy rain',
                'Some drain covers missing or damaged',
                'Drainage channels partially blocked',
                'System functioning well, recently cleared',
                'New drainage improvements working effectively'
            ]
        ];
        
        $applicableRemarks = $remarkTemplates[$field] ?? ['No specific remarks'];
        return $applicableRemarks[array_rand($applicableRemarks)];
    }
    
    /**
     * Get overall external remarks
     */
    private function getOverallRemarks(): ?string
    {
        // 30% chance of having no overall remarks
        if (rand(1, 100) <= 30) {
            return null;
        }
        
        $remarkTemplates = [
            'Overall external condition is acceptable with minor issues noted.',
            'Property exterior is well-maintained with attention to detail.',
            'Several areas require maintenance attention in the next quarter.',
            'Recent improvements have significantly enhanced external appearance.',
            'External areas meet safety standards but aesthetic improvements recommended.',
            'Tenant has maintained external areas according to lease requirements.',
            'External condition exceeds expectations for property of this age.',
            'Regular maintenance schedule appears to be followed diligently.',
            'Some weather damage evident but within normal parameters.',
            'External features showing expected wear and tear for age of property.'
        ];
        
        return $remarkTemplates[array_rand($remarkTemplates)];
    }
    
    /**
     * Get system remarks based on status
     */
    private function getSystemRemarks(string $status): ?string
    {
        // 40% chance of having no system remarks
        if (rand(1, 100) <= 40) {
            return null;
        }
        
        $remarkTemplates = [
            'pending' => [
                'Inspection scheduled for next week.',
                'Waiting for tenant availability.',
                'Documentation being prepared.'
            ],
            'in_progress' => [
                'Partial inspection completed.',
                'Following up on several identified issues.',
                'Awaiting quotes for recommended repairs.'
            ],
            'completed' => [
                'All areas inspected and documented.',
                'Photos taken of key areas.',
                'Report ready for verification.'
            ],
            'verified' => [
                'Inspection verified by property manager.',
                'All documentation approved.',
                'Maintenance plan updated with findings.'
            ],
            'rejected' => [
                'Inspection failed to meet reporting standards.',
                'Insufficient detail in critical areas.',
                'Reinspection required for sections 3 and 7.'
            ]
        ];
        
        $applicableRemarks = $remarkTemplates[$status] ?? $remarkTemplates['pending'];
        return $applicableRemarks[array_rand($applicableRemarks)];
    }
}