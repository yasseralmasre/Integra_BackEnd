<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $SApermissionNames = ['Marketing', 'HR', 'Repository' ,
                            'index campaign', 'store campaign', 'update campaign', 'show campaign', 'destroy campaign' , 'attach CampaignToLead' , 'detach CampaignToLead' ,'show CampaignEvents' ,'show CampaignTvs' ,'show CampaignSocialMedia' ,'show CampaignLeads' , "show CampaignsRevenues" , "show CampaignsDetailsRevenue" ,
                            'index socialMedia' ,'store socialMedia' ,'update socialMedia' ,'show socialMedia' ,'destroy socialMedia',
                            'index tv' ,'store tv' ,'update tv' ,'show tv' ,'destroy tv',
                            'index event' ,'store event' ,'update event' ,'show event' ,'destroy event',
                            'index lead' ,'store lead' ,'update lead' ,'show lead' ,'destroy lead' ,'attach LeadToCustomer' ,'detach LeadToCustomer' ,'show LeadCustomers' ,'show LeadCampaigns',
                            'index customer' ,'store customer' ,'update customer' ,'show customer' ,'destroy customer' ,'show CustomerLeads',

                            'index benefit' ,'store benefit' ,'update benefit' ,'show benefit' ,'destroy benefit' ,'show benefitEmployees' ,
                            'index department' ,'store department' ,'update department' ,'show department' ,'destroy department' ,'show departmentEmployees',
                            'index employee' ,'store employee' ,'update employee' ,'show employee' ,'destroy employee' ,'show EmployeeDetails' ,'attach BenefitToEmployee',
                            'index employeeCertificate' ,'store employeeCertificate' ,'update employeeCertificate' ,'show employeeCertificate' ,'destroy employeeCertificate',
                            'index employeePerformance' ,'store employeePerformance' ,'update employeePerformance' ,'show employeePerformance' ,'destroy employeePerformance',
                            'index employeeVacation' ,'store employeeVacation' ,'update employeeVacation' ,'show employeeVacation' ,'destroy employeeVacation',
                            'index employeeEducation' ,'store employeeEducation' ,'update employeeEducation' ,'show employeeEducation' ,'destroy employeeEducation',

                            'index catagory' ,'store catagory' ,'update catagory' ,'show catagory' ,'destroy catagory' ,'get ProductsByCategory',
                            'index export' ,'store export' ,'update export' ,'show export' ,'destroy export',
                            'index exportProducts' ,'store exportProducts' ,'update exportProducts' ,'show exportProducts' ,'destroy exportProducts' ,'get productsByExportId ',
                            'index import' ,'store import' ,'update import' ,'show import' ,'destroy import',
                            'index importProducts' ,'store importProducts' ,'update importProducts' ,'show importProducts' ,'destroy importProducts' ,'get productsByImportId ',
                            'index product' ,'store product' ,'update product' ,'show product' ,'destroy product',
                            'index productDetails' ,'store productDetails' ,'update productDetails' ,'show productDetails' ,'destroy productDetails',
                            'index attribute' ,'store attribute' ,'update attribute' ,'show attribute' ,'destroy attribute',
                            'index attributeGroup' ,'store attributeGroup' ,'update attributeGroup' ,'show attributeGroup' ,'destroy attributeGroup' , 'get AttributesByGroup',
                            'index supplier' ,'store supplier' ,'update supplier' ,'show supplier' ,'destroy supplier','get ProductsBySupplier',

                            'index role' ,'store role' ,'update role' ,'show role' ,'destroy role', 'attach RolePermissions' ,'detach RolePermissions' ,'assign Role ' ,'unassign Role',
                            'index user' ,'store user' ,'update user' ,'show user' ,'destroy user', 'show UserRoles',
                            'show PermissionRoles' ,'index permission' ,

                            'index pdf' ,'store Import pdf' , 'store Campaign pdf' ,'store Export pdf' ,'store EmployeeVacation pdf' ,'show pdf' ,'destroy pdf',
                            ];
        foreach ($SApermissionNames as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            $superAdminRole->givePermissionTo($permission);
        }


        $marketingMangerRole = Role::where('name', 'Marketing Manager')->first();
        $MMpermissionNames = ['Marketing',
                            'index campaign', 'store campaign', 'update campaign', 'show campaign', 'destroy campaign' , 'attach CampaignToLead' , 'detach CampaignToLead' ,'show CampaignEvents' ,'show CampaignTvs' ,'show CampaignSocialMedia' ,'show CampaignLeads' ,
                            'index socialMedia' ,'store socialMedia' ,'update socialMedia' ,'show socialMedia' ,'destroy socialMedia',
                            'index tv' ,'store tv' ,'update tv' ,'show tv' ,'destroy tv',
                            'index event' ,'store event' ,'update event' ,'show event' ,'destroy event',
                            'index lead' ,'store lead' ,'update lead' ,'show lead' ,'destroy lead' ,'attach LeadToCustomer' ,'detach LeadToCustomer' ,'show LeadCustomers' ,'show LeadCampaigns',
                            'index customer' ,'store customer' ,'update customer' ,'show customer' ,'destroy customer' ,'show CustomerLeads',

                            'index pdf'         , 'store Campaign pdf' ,'show pdf' ,'destroy pdf',
                            ];
        foreach ($MMpermissionNames as $permissionName) {
            $Mpermission = Permission::where('name', $permissionName)->first();
            $marketingMangerRole->givePermissionTo($Mpermission);
        }


        $HRMangerRole = Role::where('name', 'HR Manager')->first();
        $HRMpermissionNames = ['HR',
                                'index benefit' ,'store benefit' ,'update benefit' ,'show benefit' ,'destroy benefit' ,'show benefitEmployees' ,
                                'index department' ,'store department' ,'update department' ,'show department' ,'destroy department' ,'show departmentEmployees',
                                'index employee' ,'store employee' ,'update employee' ,'show employee' ,'destroy employee' ,'show EmployeeDetails' ,'attach BenefitToEmployee',
                                'index employeeCertificate' ,'store employeeCertificate' ,'update employeeCertificate' ,'show employeeCertificate' ,'destroy employeeCertificate',
                                'index employeePerformance' ,'store employeePerformance' ,'update employeePerformance' ,'show employeePerformance' ,'destroy employeePerformance',
                                'index employeeVacation' ,'store employeeVacation' ,'update employeeVacation' ,'show employeeVacation' ,'destroy employeeVacation',
                                'index employeeEducation' ,'store employeeEducation' ,'update employeeEducation' ,'show employeeEducation' ,'destroy employeeEducation',

                            'index pdf' ,'store EmployeeVacation pdf' ,'show pdf' ,'destroy pdf',
                            ];
        foreach ($HRMpermissionNames as $permissionName) {
            $HRpermission = Permission::where('name', $permissionName)->first();
            $HRMangerRole->givePermissionTo($HRpermission);
        }


        $repositoryAdminRole = Role::where('name', 'Repository Manager')->first();
        $RMpermissionNames = ['Repository' ,
                                'index catagory' ,'store catagory' ,'update catagory' ,'show catagory' ,'destroy catagory' ,'get ProductsByCategory',
                                'index export' ,'store export' ,'update export' ,'show export' ,'destroy export',
                                'index exportProducts' ,'store exportProducts' ,'update exportProducts' ,'show exportProducts' ,'destroy exportProducts' ,'get productsByExportId ',
                                'index import' ,'store import' ,'update import' ,'show import' ,'destroy import',
                                'index importProducts' ,'store importProducts' ,'update importProducts' ,'show importProducts' ,'destroy importProducts' ,'get productsByImportId ',
                                'index product' ,'store product' ,'update product' ,'show product' ,'destroy product',
                                'index productDetails' ,'store productDetails' ,'update productDetails' ,'show productDetails' ,'destroy productDetails',
                                'index attribute' ,'store attribute' ,'update attribute' ,'show attribute' ,'destroy attribute',
                                'index attributeGroup' ,'store attributeGroup' ,'update attributeGroup' ,'show attributeGroup' ,'destroy attributeGroup' , 'get AttributesByGroup',
                                'index supplier' ,'store supplier' ,'update supplier' ,'show supplier' ,'destroy supplier','get ProductsBySupplier',
                                                    'index pdf' ,'store Import pdf' ,'store Export pdf' ,'show pdf' ,'destroy pdf',
                            ];
        foreach ($RMpermissionNames as $permissionName) {
            $Rpermission = Permission::where('name', $permissionName)->first();
            $repositoryAdminRole->givePermissionTo($Rpermission);
        }
    }

}
