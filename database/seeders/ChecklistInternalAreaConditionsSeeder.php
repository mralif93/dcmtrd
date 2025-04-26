<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Checklist;
use App\Models\ChecklistInternalAreaCondition;

class ChecklistInternalAreaConditionsSeeder extends Seeder
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
        
        foreach ($checklistIds as $checklistId) {
            // Generate condition data with realistic variation
            $status = $statusOptions[array_rand($statusOptions)];
            
            // Set approval date based on status
            $createdAt = Carbon::now()->subDays(rand(1, 90));
            $updatedAt = $createdAt->copy()->addDays(rand(0, 30));
            $approvalDateTime = $status === 'active' ? 
                $updatedAt->copy()->addDays(rand(1, 5)) : null;
            
            // Determine if this record should have values filled in
            $hasValues = in_array($status, ['active', 'rejected']);
            
            // Create the record
            ChecklistInternalAreaCondition::create([
                'checklist_id' => $checklistId,
                
                // Internal area conditions with random values
                'is_door_window_satisfied' => $hasValues ? $this->getRandomBoolean(0.8) : null,
                'door_window_remarks' => $hasValues ? $this->getRemarks('door_window') : null,
                
                'is_staircase_satisfied' => $hasValues ? $this->getRandomBoolean(0.85) : null,
                'staircase_remarks' => $hasValues ? $this->getRemarks('staircase') : null,
                
                'is_toilet_satisfied' => $hasValues ? $this->getRandomBoolean(0.7) : null,
                'toilet_remarks' => $hasValues ? $this->getRemarks('toilet') : null,
                
                'is_ceiling_satisfied' => $hasValues ? $this->getRandomBoolean(0.9) : null,
                'ceiling_remarks' => $hasValues ? $this->getRemarks('ceiling') : null,
                
                'is_wall_satisfied' => $hasValues ? $this->getRandomBoolean(0.85) : null,
                'wall_remarks' => $hasValues ? $this->getRemarks('wall') : null,
                
                'is_water_seeping_satisfied' => $hasValues ? $this->getRandomBoolean(0.75) : null,
                'water_seeping_remarks' => $hasValues ? $this->getRemarks('water_seeping') : null,
                
                'is_loading_bay_satisfied' => $hasValues ? $this->getRandomBoolean(0.8) : null,
                'loading_bay_remarks' => $hasValues ? $this->getRemarks('loading_bay') : null,
                
                'is_basement_car_park_satisfied' => $hasValues ? $this->getRandomBoolean(0.85) : null,
                'basement_car_park_remarks' => $hasValues ? $this->getRemarks('basement_car_park') : null,
                
                'internal_remarks' => $hasValues ? $this->getOverallRemarks() : null,
                
                // System information
                'status' => $status,
                'prepared_by' => in_array($status, ['active', 'rejected', 'inactive']) ? $staffMembers[array_rand($staffMembers)] : null,
                'verified_by' => in_array($status, ['active', 'rejected']) ? $staffMembers[array_rand($staffMembers)] : null,
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
            'door_window' => [
                'Some windows difficult to open/close',
                'Door hinges need lubrication',
                'Window seals showing signs of wear',
                'All doors and windows operating smoothly',
                'Minor frame damage on east-facing windows'
            ],
            'staircase' => [
                'Handrail loose on third floor staircase',
                'Some stair treads showing wear',
                'Non-slip strips need replacement',
                'Stairwell lighting adequate but could be improved',
                'All staircases in excellent condition'
            ],
            'toilet' => [
                'Flushing mechanism faulty in second floor toilet',
                'Minor water leakage around basin seals',
                'Hand dryers not functioning properly',
                'Ventilation system requires maintenance',
                'All facilities clean and fully operational'
            ],
            'ceiling' => [
                'Water stains visible on ceiling panels in room 204',
                'Some ceiling tiles misaligned',
                'Minor cracks in plaster ceiling of main hall',
                'Ceiling in excellent condition throughout',
                'Recent repairs visible but professionally done'
            ],
            'wall' => [
                'Paint peeling in high moisture areas',
                'Minor scuff marks throughout corridors',
                'Small cracks visible near door frames',
                'Walls recently painted and in excellent condition',
                'Wall coverings well maintained'
            ],
            'water_seeping' => [
                'Evidence of moisture at base of west wall',
                'Minor seepage around window frames after heavy rain',
                'Historical water damage visible but currently dry',
                'No signs of water ingress',
                'Previous seepage issues properly addressed'
            ],
            'loading_bay' => [
                'Loading dock bumpers need replacement',
                'Hydraulic leveler operating slower than normal',
                'Surface coating wearing thin in high traffic areas',
                'All equipment functioning properly',
                'Minor damage to safety barriers'
            ],
            'basement_car_park' => [
                'Drainage system requires cleaning',
                'Some lighting fixtures non-functional',
                'Ventilation system operating below optimal level',
                'Line markings faded in sections',
                'Overall excellent condition with good traffic flow'
            ]
        ];
        
        $applicableRemarks = $remarkTemplates[$field] ?? ['No specific remarks'];
        return $applicableRemarks[array_rand($applicableRemarks)];
    }
    
    /**
     * Get overall internal remarks
     */
    private function getOverallRemarks(): ?string
    {
        // 30% chance of having no overall remarks
        if (rand(1, 100) <= 30) {
            return null;
        }
        
        $remarkTemplates = [
            'Internal areas generally well-maintained with minor issues noted.',
            'Regular maintenance program appears effective for internal conditions.',
            'Several areas require attention but no critical issues identified.',
            'Internal finishes showing normal wear appropriate to building age.',
            'Recent renovations have significantly improved internal conditions.',
            'Tenant has maintained internal areas according to lease requirements.',
            'Overall condition meets industry standards with some exceptions noted.',
            'Internal systems functioning properly with regular maintenance evident.',
            'Some cosmetic issues noted but structural elements in good condition.',
            'Internal layout well-designed with efficient use of space.'
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
            'active' => [
                'All findings verified and approved.',
                'Documentation complete and archived.',
                'Maintenance schedule updated based on findings.'
            ],
            'pending' => [
                'Internal inspection scheduled for next week.',
                'Coordinating with tenant for access to all areas.',
                'Preliminary walkthrough completed.'
            ],
            'rejected' => [
                'Inspection report incomplete.',
                'Critical areas not properly assessed.',
                'Failed to meet minimum standards for multiple areas.'
            ],
            'inactive' => [
                'Inspection no longer relevant.',
                'Building section no longer in use.',
                'Superseded by more recent inspection.'
            ]
        ];
        
        $applicableRemarks = $remarkTemplates[$status] ?? $remarkTemplates['pending'];
        return $applicableRemarks[array_rand($applicableRemarks)];
    }
}