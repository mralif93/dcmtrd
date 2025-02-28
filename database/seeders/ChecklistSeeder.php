<?php

namespace Database\Seeders;

use App\Models\Checklist;
use App\Models\ChecklistItem;
use Illuminate\Database\Seeder;

class ChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Move-in Checklist Template
        $moveInTemplate = Checklist::create([
            'name' => 'Standard Move-in Checklist',
            'type' => 'Move-in',
            'description' => 'Standard checklist for all new tenant move-ins',
            'is_template' => true,
            'sections' => ['General', 'Kitchen', 'Bathroom', 'Bedroom', 'Living Room'],
            'active' => true,
        ]);

        // Add items to Move-in template
        $moveInItems = [
            // General section
            [
                'section' => 'General',
                'item_name' => 'Keys Handed Over',
                'description' => 'Confirm all keys have been provided to tenant',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
            [
                'section' => 'General',
                'item_name' => 'Tenant Information',
                'description' => 'Confirm tenant contact information is correct',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
            [
                'section' => 'General',
                'item_name' => 'Overall Condition',
                'description' => 'Rate the overall condition of the property',
                'type' => 'Rating',
                'required' => true,
                'options' => ['Poor', 'Fair', 'Good', 'Excellent'],
            ],
            
            // Kitchen section
            [
                'section' => 'Kitchen',
                'item_name' => 'Appliances Working',
                'description' => 'Check all appliances are in working order',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
            [
                'section' => 'Kitchen',
                'item_name' => 'Kitchen Notes',
                'description' => 'Additional notes about kitchen condition',
                'type' => 'Text',
                'required' => false,
                'options' => null,
            ],
            
            // Bathroom section
            [
                'section' => 'Bathroom',
                'item_name' => 'Plumbing',
                'description' => 'Check for leaks and proper function',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
            [
                'section' => 'Bathroom',
                'item_name' => 'Bathroom Condition',
                'description' => 'Rate the condition of the bathroom',
                'type' => 'Rating',
                'required' => true,
                'options' => ['Poor', 'Fair', 'Good', 'Excellent'],
            ],
            
            // Bedroom section
            [
                'section' => 'Bedroom',
                'item_name' => 'Window Function',
                'description' => 'Ensure all windows open, close and lock properly',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
            
            // Living Room section
            [
                'section' => 'Living Room',
                'item_name' => 'Flooring Condition',
                'description' => 'Document condition of carpet/flooring',
                'type' => 'Photo',
                'required' => true,
                'options' => null,
            ],
        ];

        foreach ($moveInItems as $item) {
            ChecklistItem::create([
                'checklist_id' => $moveInTemplate->id,
                'section' => $item['section'],
                'item_name' => $item['item_name'],
                'description' => $item['description'],
                'type' => $item['type'],
                'required' => $item['required'],
                'options' => $item['options'],
                'order' => 0,
            ]);
        }

        // 2. Move-out Checklist Template
        $moveOutTemplate = Checklist::create([
            'name' => 'Standard Move-out Inspection',
            'type' => 'Move-out',
            'description' => 'Comprehensive checklist for tenant move-outs and security deposit returns',
            'is_template' => true,
            'sections' => ['General', 'Cleaning', 'Damages', 'Keys & Access', 'Utilities'],
            'active' => true,
        ]);

        // Add items to Move-out template
        $moveOutItems = [
            // General section
            [
                'section' => 'General',
                'item_name' => 'Final Walkthrough Date',
                'description' => 'Date when final inspection was conducted',
                'type' => 'Date',
                'required' => true,
                'options' => null,
            ],
            [
                'section' => 'General',
                'item_name' => 'Tenant Present',
                'description' => 'Was the tenant present during inspection?',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
            
            // Cleaning section
            [
                'section' => 'Cleaning',
                'item_name' => 'Kitchen Cleaning',
                'description' => 'Rate the cleanliness of the kitchen',
                'type' => 'Rating',
                'required' => true,
                'options' => ['Poor', 'Fair', 'Good', 'Excellent'],
            ],
            [
                'section' => 'Cleaning',
                'item_name' => 'Bathroom Cleaning',
                'description' => 'Rate the cleanliness of the bathroom',
                'type' => 'Rating',
                'required' => true,
                'options' => ['Poor', 'Fair', 'Good', 'Excellent'],
            ],
            
            // Damages section
            [
                'section' => 'Damages',
                'item_name' => 'Wall Condition',
                'description' => 'Document any holes, marks or damage to walls',
                'type' => 'Photo',
                'required' => true,
                'options' => null,
            ],
            [
                'section' => 'Damages',
                'item_name' => 'Damage Notes',
                'description' => 'Detailed description of any damages found',
                'type' => 'Text',
                'required' => false,
                'options' => null,
            ],
            
            // Keys & Access section
            [
                'section' => 'Keys & Access',
                'item_name' => 'Keys Returned',
                'description' => 'All keys returned by tenant',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
            
            // Utilities section
            [
                'section' => 'Utilities',
                'item_name' => 'Utilities Disconnected',
                'description' => 'Confirm tenant has canceled or transferred utilities',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
        ];

        foreach ($moveOutItems as $item) {
            ChecklistItem::create([
                'checklist_id' => $moveOutTemplate->id,
                'section' => $item['section'],
                'item_name' => $item['item_name'],
                'description' => $item['description'],
                'type' => $item['type'],
                'required' => $item['required'],
                'options' => $item['options'],
                'order' => 0,
            ]);
        }

        // 3. Regular Inspection Checklist
        $inspectionChecklist = Checklist::create([
            'name' => 'Quarterly Inspection',
            'type' => 'Inspection',
            'description' => 'Regular inspection checklist for quarterly property reviews',
            'is_template' => false,
            'sections' => ['Safety', 'Maintenance', 'Tenant Compliance'],
            'active' => true,
        ]);

        // Add items to Inspection checklist
        $inspectionItems = [
            // Safety section
            [
                'section' => 'Safety',
                'item_name' => 'Smoke Detectors',
                'description' => 'Verify smoke detectors are working properly',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
            [
                'section' => 'Safety',
                'item_name' => 'Fire Extinguisher',
                'description' => 'Check fire extinguisher expiration date',
                'type' => 'Date',
                'required' => true,
                'options' => null,
            ],
            
            // Maintenance section
            [
                'section' => 'Maintenance',
                'item_name' => 'HVAC Filter',
                'description' => 'Check and/or replace HVAC filter',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
            [
                'section' => 'Maintenance',
                'item_name' => 'Plumbing Leaks',
                'description' => 'Inspect for any plumbing leaks',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
            
            // Tenant Compliance section
            [
                'section' => 'Tenant Compliance',
                'item_name' => 'Unauthorized Occupants',
                'description' => 'Check for unauthorized occupants',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
            [
                'section' => 'Tenant Compliance',
                'item_name' => 'Pet Policy Compliance',
                'description' => 'Ensure compliance with pet policy',
                'type' => 'Checkbox',
                'required' => false,
                'options' => null,
            ],
        ];

        foreach ($inspectionItems as $item) {
            ChecklistItem::create([
                'checklist_id' => $inspectionChecklist->id,
                'section' => $item['section'],
                'item_name' => $item['item_name'],
                'description' => $item['description'],
                'type' => $item['type'],
                'required' => $item['required'],
                'options' => $item['options'],
                'order' => 0,
            ]);
        }

        // 4. Maintenance Checklist
        $maintenanceChecklist = Checklist::create([
            'name' => 'Annual Maintenance',
            'type' => 'Maintenance',
            'description' => 'Annual preventative maintenance checklist',
            'is_template' => true,
            'sections' => ['Exterior', 'Interior', 'Systems'],
            'active' => true,
        ]);

        // Add items to Maintenance checklist
        $maintenanceItems = [
            // Exterior section
            [
                'section' => 'Exterior',
                'item_name' => 'Roof Inspection',
                'description' => 'Check for damaged or missing shingles',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
            [
                'section' => 'Exterior',
                'item_name' => 'Gutter Cleaning',
                'description' => 'Clean gutters and downspouts',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
            
            // Interior section
            [
                'section' => 'Interior',
                'item_name' => 'Water Heater',
                'description' => 'Flush water heater tank',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
            [
                'section' => 'Interior',
                'item_name' => 'Caulking',
                'description' => 'Check and repair caulking around tubs and sinks',
                'type' => 'Checkbox',
                'required' => true,
                'options' => null,
            ],
            
            // Systems section
            [
                'section' => 'Systems',
                'item_name' => 'HVAC Service',
                'description' => 'Annual HVAC system service',
                'type' => 'Date',
                'required' => true,
                'options' => null,
            ],
            [
                'section' => 'Systems',
                'item_name' => 'System Notes',
                'description' => 'Additional notes about systems maintenance',
                'type' => 'Text',
                'required' => false,
                'options' => null,
            ],
        ];

        foreach ($maintenanceItems as $item) {
            ChecklistItem::create([
                'checklist_id' => $maintenanceChecklist->id,
                'section' => $item['section'],
                'item_name' => $item['item_name'],
                'description' => $item['description'],
                'type' => $item['type'],
                'required' => $item['required'],
                'options' => $item['options'],
                'order' => 0,
            ]);
        }

        // 5. Inactive Checklist (for testing filters)
        Checklist::create([
            'name' => 'Discontinued Inspection',
            'type' => 'Inspection',
            'description' => 'An old checklist that is no longer in use',
            'is_template' => false,
            'sections' => ['Old Section 1', 'Old Section 2'],
            'active' => false,
        ]);
    }
}