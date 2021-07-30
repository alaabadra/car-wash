<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/config-cache', function () {
    Artisan::call('config:cache');
});
Route::group(['namespace' => 'API'], function () {
                #######################Country###############################
                Route::group(['prefix'=>'country','namespace'=>'Country'],function(){
                    Route::get('index','CountryController@index');
                    Route::post('store','CountryController@store');
                    Route::post('update/{id}','CountryController@update');
                    Route::post('show/{id}','CountryController@show');
    
                    Route::get('destroy/{id}','CountryController@destroy');
                });
                #######################city###############################
                Route::group(['prefix'=>'city','namespace'=>'City'],function(){
                    Route::get('index','CityController@index');
                    Route::post('store','CityController@store');
                    Route::post('update/{id}','CityController@update');
                    Route::get('show/{id}','CityController@show');
                    Route::get('get-cities-country/{countryid}','CityController@getCitiesCountry');
                    Route::get('destroy/{id}','CityController@destroy');
                });
                            #######################state###############################
                            Route::group(['prefix'=>'state','namespace'=>'State'],function(){
                                Route::get('index','StateController@index');
                                Route::post('store','StateController@store');
                                Route::post('update/{id}','StateController@update');
                                Route::get('show/{id}','StateController@show');
                                Route::get('get-states-city/{cityid}','StateController@getStatesCity');
    
                                Route::get('destroy/{id}','StateController@destroy');
                            });

            #######################Org Info###############################
            Route::group(['prefix'=>'org-info','namespace'=>'OrgInfo'],function(){
                Route::get('index','OrgInfoController@index');
                Route::post('store','OrgInfoController@store');
                Route::get('show/{id}','OrgInfoController@show');
                Route::post('update/{id}','OrgInfoController@update');
                Route::get('destroy/{id}','OrgInfoController@destroy');
            });

    #######################Washing Management###############################
    Route::group(['prefix' => 'washing-management', 'namespace' => 'WashingMachine'], function () {
        Route::get('index', 'WashingMachineController@index');
        Route::post('store', 'WashingMachineController@store');
        Route::post('update/{id}', 'WashingMachineController@update');
        Route::get('destroy/{id}', 'WashingMachineController@destroy');
    });
    #######################Type###############################
    Route::group(['prefix' => 'type', 'namespace' => 'Type'], function () {
        Route::get('index', 'TypeController@index');
        Route::post('store', 'TypeController@store');
        Route::post('update/{id}', 'TypeController@update');
        Route::get('destroy/{id}', 'TypeController@destroy');
    });
    #######################Size###############################
    Route::group(['prefix' => 'size', 'namespace' => 'Size'], function () {
        Route::get('index', 'SizeController@index');
        Route::post('store', 'SizeController@store');
        Route::post('update/{id}', 'SizeController@update');
        Route::get('destroy/{id}', 'SizeController@destroy');
    });
    #######################Color###############################
    Route::group(['prefix' => 'color', 'namespace' => 'Color'], function () {
        Route::get('index', 'ColorController@index');
        Route::post('store', 'ColorController@store');
        Route::post('update/{id}', 'ColorController@update');
        Route::get('destroy/{id}', 'ColorController@destroy');
    });
    #######################Brand###############################
    Route::group(['prefix' => 'brand', 'namespace' => 'Brand'], function () {
        Route::get('index', 'BrandController@index');
        Route::post('store', 'BrandController@store');
        Route::post('update/{id}', 'BrandController@update');
        Route::get('destroy/{id}', 'BrandController@destroy');
    });
    #######################Client###############################
    Route::group(['prefix' => 'client', 'namespace' => 'Client'], function () {
        Route::get('index', 'ClientController@index');
        Route::post('store', 'ClientController@store');
        Route::get('show/{id}', 'ClientController@show');
        Route::post('update/{id}', 'ClientController@update');
        Route::get('destroy/{id}', 'ClientController@destroy');
    });
    // ############################################### Dashboard ##############################################
    Route::group(['namespace' => 'Dashboard'], function () {
        Route::get('dashboard', 'DashboardController@__invoke');
    });
    // ############################################### Accounts Management ##############################################
    #######################Status###############################
    Route::group(['prefix' => 'status', 'namespace' => 'Status'], function () {
        Route::get('index', 'StatusController@index');
        Route::post('store', 'StatusController@store');
        Route::post('update/{id}', 'StatusController@update');
        Route::get('destroy/{id}', 'StatusController@destroy');
    });
    #######################Account Bond###############################
    Route::group(['prefix' => 'account', 'namespace' => 'Accounts_manage'], function () {
        Route::group(['prefix' => 'account-bond'], function () {
            Route::get('index', 'AccBondController@index');
            Route::any('store', 'AccBondController@store');
            Route::any('update', 'AccBondController@update');
            Route::get('destroy', 'AccBondController@destroy');
        });
        #######################Account Cost center###############################
        Route::group(['prefix' => 'account-cost'], function () {
            Route::get('index', 'AccCostCenterController@index');
            Route::any('store', 'AccCostCenterController@store');
            Route::any('update', 'AccCostCenterController@update');
            Route::get('show', 'AccCostCenterController@show');
        });
        #######################Account center###############################
        Route::group(['prefix' => 'account-center'], function () {
            Route::get('index', 'AccountController@index');
            Route::get('main-index', 'AccountController@MainIndex');
            Route::get('sub-index', 'AccountController@SubIndex');
            Route::any('store', 'AccountController@store');
            Route::any('update', 'AccountController@update');
            Route::any('show', 'AccountController@show');
            Route::any('destroy', 'AccountController@destroy');
        });
        #######################Account transaction###############################
        Route::group(['prefix' => 'account-trans'], function () {
            Route::get('index', 'AccTransactionController@index');
            Route::any('store', 'AccTransactionController@store');
            Route::any('destroy', 'AccTransactionController@destroy');
        });
    });
    // ############################################### customer ##############################################
    Route::group(['prefix' => 'customer', 'namespace' => 'Customer'], function () {
        Route::get('index', 'CustomerController@index');
        Route::get('show', 'CustomerController@show');
        Route::any('store', 'CustomerController@store');
        Route::any('update', 'CustomerController@update');
        Route::any('destroy', 'CustomerController@destroy');
    });
    // ############################################### department ##############################################
    Route::group(['prefix' => 'department', 'namespace' => 'Department'], function () {
        Route::get('index', 'DepartmentController@index');
        Route::any('unites-index/{id}', 'DepartmentController@unitesIndex');
        Route::any('store', 'DepartmentController@store');
        Route::any('update', 'DepartmentController@update');
        Route::get('destroy', 'DepartmentController@destroy');
    });
    // ############################################### Destruction ##############################################
    Route::group(['prefix' => 'destruction', 'namespace' => 'Destruction'], function () {
        Route::any('store', 'DestructionController@store');
    });

    // ############################################### Employee ##############################################
    Route::group(['prefix' => 'employee', 'namespace' => 'Employee'], function () {
        #############################Employee#############################
        Route::get('index', 'EmployeeController@index');
        Route::any('store', 'EmployeeController@store');
        Route::any('update', 'EmployeeController@update');
        Route::any('show', 'EmployeeController@show');
        Route::any('destroy', 'EmployeeController@destroy');
        #############################permissions#############################
        Route::get('permission_roles', 'PermissionController@get_roles');
        Route::get('permission_modules', 'PermissionController@get_modules');
        Route::get('permissions_pages/{role}/{module}', 'PermissionController@get_pages');
        #############################Attendance_logController#############################
        Route::group(['prefix' => 'attendance-log'], function () {
            Route::get('index', 'Attendance_logController@index');
            Route::get('session-log/{id}', 'Attendance_logController@session_log');
            Route::get('emp-logs/{a}/{o}', 'Attendance_logController@emp_logs');
            Route::any('sign-num/{j}', 'Attendance_logController@sign_num');
            Route::any('machine_pull', 'Attendance_logController@machine_pull');

            Route::any('store', 'Attendance_logController@store');
            Route::any('destroy/{id}', 'Attendance_logController@destroy');
        });
        ###################################Attendance_permission##########################
        Route::group(['prefix' => 'attendance-permission'], function () {
            Route::get('index', 'Attendance_permissionController@index');
            Route::any('store', 'Attendance_permissionController@store');
            Route::post('update/{j}', 'Attendance_permissionController@update');
            Route::any('destroy/{id}', 'Attendance_permissionController@destroy');
        });
        #############################ManageEmployees#############################
        Route::group(['prefix'=>'manage-employees'],function(){
            Route::get('index','ManageEmployeesController@index');
            Route::get('get-all-employees','ManageEmployeesController@get_all_employees');
            Route::get('employee-show/{j}','ManageEmployeesController@employee_show');
            Route::any('store','ManageEmployeesController@store');
            Route::any('update/{id}','ManageEmployeesController@update');
            Route::any('save-data/{fileNewName}/{j}','ManageEmployeesController@saveData');
            Route::any('show/{id}','ManageEmployeesController@show');
            Route::any('destroy/{id}','ManageEmployeesController@destroy');
        });
        #############################Organization_structure#############################
        Route::group(['prefix'=>'organization-structure'],function(){
            Route::get('get-designations','Organization_structureController@getDesignations');
            Route::get('get-departments','Organization_structureController@getDepartments');
            Route::get('get-employments','Organization_structureController@getEmployments');
            Route::get('get-employees','Organization_structureController@getEmployees');
            Route::get('data-show/{i}/{k}','Organization_structureController@data_show');
            Route::get('get-month-days/{j}','Organization_structureController@get_month_days');
            Route::any('store-designation','Organization_structureController@storeDesignation');
            Route::any('store-department','Organization_structureController@storeDepartment');
            Route::get('get-emplyees-levels','Organization_structureController@getEmplyeesLevels');
            Route::post('store-emplyee-level','Organization_structureController@storeEmployeeLevel');
            Route::post('update-designation/{id}','Organization_structureController@updateDesignation');
            Route::post('update-department/{id}','Organization_structureController@updateDepartment');
            Route::post('update-emplyee-level/{id}','Organization_structureController@updateEmployeeLevel');
            Route::any('destroy-designation/{id}','Organization_structureController@destroyDesignation');
            Route::any('destroy-department/{id}','Organization_structureController@destroyDepartment');
            Route::any('destroy-emplyee-level/{id}','Organization_structureController@destroyEmplyeeLevel');
        });

        #############################role#############################
        Route::group(['prefix'=>'role'],function(){
            Route::get('index','RoleController@index');
            Route::any('store','RoleController@store');
            Route::any('show/{id}','RoleController@show');
            Route::any('get-roles/{role_name}','RoleController@getRoles');
            Route::any('permission-role/{role_name}/{module_name}','RoleController@permissionsRole');
            Route::any('update/{id}','RoleController@update');
            Route::any('destroy/{id}','RoleController@destroy');
        });
        
        #################shift#############################
        Route::group(['prefix' => 'shift'], function () {
            Route::get('index', 'ShiftController@index');
            Route::get('get-shifts', 'ShiftController@get_shifts');
            Route::post('store', 'ShiftController@store');
            Route::any('shift-show/{id}', 'ShiftController@shift_show');
            Route::post('update/{id}', 'ShiftController@update');
            Route::any('destroy/{id}', 'ShiftController@destroy');
        });
    });
    // ############################################### Equipment ##############################################
    Route::group(['prefix' => 'equipment', 'namespace' => 'Equipment'], function () {
        Route::get('index', 'EquipmentController@index');
        Route::get('show', 'EquipmentController@show');
        Route::any('store', 'EquipmentController@store');
        Route::any('update/{id}', 'EquipmentController@update');
        Route::any('destroy/{id}', 'EquipmentController@destroy');
    });

    // ############################################### Finance ##############################################
    Route::group(['prefix' => 'finance', 'namespace' => 'Finance'], function () {
        Route::group(['prefix' => 'account-chart'], function () {
            #############################AccountChart##############################
            Route::get('index', 'AccountChartController@index');
            Route::get('get_full_path', 'AccountChartController@get_full_path');
            Route::post('store', 'AccountChartController@store');
        });
        #############################Jornals##############################
        Route::group(['prefix' => 'jornals'], function () {
            Route::get('get-jornal-id', 'JornalsController@get_jornal_id');
            Route::get('jornal_details/{id}', 'JornalsController@jornal_details');
            Route::any('jornal-details-create', 'JornalsController@jornal_details_create');
            Route::any('jornal-details-update', 'JornalsController@jornal_details_update');
            Route::post('update/{id}', 'JornalsController@update');
            Route::any('jornal_details_delete/{id}', 'JornalsController@jornal_details_delete');
        });
    });
    // ############################################### Person ##############################################
    Route::group(['prefix' => 'persons', 'namespace' => 'Person'], function () {
        Route::get('index', 'PersonController@index');
        Route::get('show', 'PersonController@show');
        Route::any('store', 'PersonController@store');
        Route::any('update/{id}', 'PersonController@update');
        Route::any('destroy/{id}', 'PersonController@destroy');
    });

    // ############################################### RepaireOrder ##############################################
    Route::group(['prefix' => 'repaire-order', 'namespace' => 'RepaireOrder'], function () {
        Route::any('index', 'RepaireOrderController@index');
        Route::get('show', 'RepaireOrderController@show');
        Route::any('store', 'RepaireOrderController@store');
    });

    // ############################################### sales ##############################################
    Route::group(['prefix' => 'sales', 'namespace' => 'Sales'], function () {
        ############################SlsDelivery#######################
        Route::group(['prefix' => 'sls-delivery'], function () {
            Route::get('index', 'SlsDeliveryController@index');
            Route::get('show', 'SlsDeliveryController@show');
            Route::any('store', 'SlsDeliveryController@store');
            Route::any('update/{id}', 'SlsDeliveryController@update');
        });
        #########################SlsInvoice##############################
        Route::group(['prefix' => 'sls-invoice'], function () {
            Route::get('index', 'SlsInvoiceController@index');
            Route::get('show', 'SlsInvoiceController@show');
            Route::any('store', 'SlsInvoiceController@store');
            Route::any('update', 'SlsInvoiceController@update');
        });
        #########################SlsProductionOrder##############################
        Route::group(['prefix' => 'sls-production'], function () {
            Route::get('index', 'SlsProductionOrderController@index');
            Route::get('show', 'SlsProductionOrderController@show');
            Route::any('store', 'SlsProductionOrderController@store');
            Route::any('update', 'SlsProductionOrderController@update');
            Route::any('destroy', 'SlsProductionOrderController@destroy');
        });
    });
    // ############################################### settings ##############################################
    Route::group(['prefix' => 'settings', 'namespace' => 'Settings'], function () {
        #########################HolidayList##########################
        Route::group(['prefix' => 'holiday-list'], function () {
            Route::get('index', 'HolidayListController@index');
            Route::get('holiday-show/{id}', 'HolidayListController@holiday_show');
            Route::get('get-holidays', 'HolidayListController@get_holidays');
            Route::any('store', 'HolidayListController@store');
            Route::any('show/{id}', 'HolidayListController@show');
            Route::post('update/{id}', 'HolidayListController@update');
            Route::any('destroy/{id}', 'HolidayListController@destroy');
        });
        ######################LeavePolicies##########################
        Route::group(['prefix' => 'leave-policies'], function () {
            Route::get('index', 'LeavePoliciesController@index');
            Route::get('leave-show/{id}', 'LeavePoliciesController@leave_show');
            Route::get('get-leaves', 'LeavePoliciesController@get_leaves');
            Route::any('store', 'LeavePoliciesController@store');
            Route::any('update/{id}', 'LeavePoliciesController@update');
            Route::any('destroy/{id}', 'LeavePoliciesController@destroy');
        });
        ######################MachineSetting##########################
        Route::group(['prefix' => 'machine-setting'], function () {
            Route::get('index', 'MachineSettingController@index');
            Route::any('store', 'MachineSettingController@store');
            Route::any('update/{id}', 'MachineSettingController@update');
            Route::any('destroy/{id}', 'MachineSettingController@destroy');
        });
    });

    // ############################################### store ##############################################
    Route::group(['prefix' => 'store', 'namespace' => 'Store'], function () {
        Route::group(['prefix' => 'store-settings'], function () {
            Route::get('index', 'StoreController@index');
            Route::any('store', 'StoreController@store');
            Route::any('show', 'StoreController@show');
            Route::any('destroy', 'StoreController@destroy');
        });
        ######################StrProduct##########################
        Route::group(['prefix' => 'store-product'], function () {
            Route::get('index', 'StrProductController@index');
            Route::any('store', 'StrProductController@store');
            Route::any('show', 'StrProductController@show');
            Route::any('update', 'StrProductController@update');
            Route::any('destroy', 'StrProductController@destroy');
        });
    });

    // ############################################### store_manage ##############################################
    Route::group(
        ['prefix' => 'store-manage', 'namespace' => 'Store_manage'],
        function () {
            ########################Products_manage##########################
            Route::group(['prefix' => 'products-manage'], function () {
                Route::get('get-all-services', 'Products_manageController@getAllServices');
                Route::get('index', 'Products_manageController@index');
                Route::post('store', 'Products_manageController@store');
                Route::any('get-id', 'Products_manageController@getId');
                Route::any('destroy/{id}', 'Products_manageController@destroy');
            });
            ############################services_manage##############################
            Route::group(['prefix' => 'services-manage'], function () {
                Route::get('index', 'Services_manageController@index');
                Route::any('store', 'Services_manageController@store');
                Route::any('show/{id}', 'Services_manageController@show');
                Route::any('show-service/{id}/{type}', 'Services_manageController@showServiceBasedOnTicket');

                Route::post('update/{id}', 'Services_manageController@update');

                Route::any('store-service', 'Services_manageController@storeService');

                Route::any('destroy/{id}', 'Services_manageController@destroy');
            });
            ########################Units_manage###########################
            Route::group(['prefix' => 'units-manage'], function () {
                Route::get('index', 'Units_manageController@index');
                Route::get('show-unit/{id}', 'Services_manageController@show');
                Route::get('show/{id}', 'Units_manageController@show');
                Route::post('store', 'Units_manageController@store');
                Route::any('update/{id}', 'Units_manageController@update');
                Route::any('destroy/{id}', 'Units_manageController@destroy');
            });
        }
    );
    // ############################################### user ##############################################
    Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
        Route::get('index', 'UserController@index');
        Route::post('store', 'UserController@store');
        Route::post('show', 'UserController@show');
        Route::post('update', 'UserController@update');
        Route::any('destroy/{id}', 'UserController@destroy');
    });

    // ################################################## Role ###########################################
    Route::group(['prefix' => 'roles', 'namespace' => 'Role'], function () {
        Route::get('index', 'RoleController@index');
        Route::post('store', 'RoleController@store');
        Route::get('show', 'RoleController@show');
        Route::get('update', 'RoleController@update');
        Route::get('destroy', 'RoleController@destroy');
    });

    // ################################################## Washing Tickets ###########################################

    // Carpet Wash Ticket
    Route::get('carpet_wash_show/{id}', 'API\Washing_ticket\Carpets_washingController@show_ticket');
    // Route::apiResources(['carpet_material' => 'API\Washing_ticket\Carpets_materialController']);
    Route::group(['prefix' => 'washing-ticket', 'namespace' => 'Washing_ticket'], function () {
        Route::group(['prefix' => 'carpet-material'], function () {
            Route::get('show/{id}/{idd}', 'Carpets_materialController@show');
            Route::post('store', 'Carpets_materialController@store');
            Route::get('destroy/{id}', 'Carpets_materialController@destroy');
            Route::delete('carpet_material/{id}', 'Carpets_materialController@destroy');
            Route::get('carpet_material/{id}/{type}', 'Carpets_materialController@show');
        });
        Route::group(['prefix' => 'carpet-washing'], function () {
            Route::get('get-carpets', 'Carpets_washingController@getCarpets');

            Route::post('store', 'Carpets_washingController@store');
            Route::post('update/{id}', 'Carpets_washingController@update');
            Route::get('destroy/{id}', 'Carpets_washingController@destroy');

            Route::get('carpet_washing_get_id', 'Carpets_washingController@get_id');
            Route::get('carpet_washing_get_product_manages', 'Carpets_washingController@get_product_manages');
            Route::get('carpet_washing_get_units/{unit_id}', 'Carpets_washingController@get_units');
            Route::get('carpet_washing_get_cost/{unit_id}', 'Carpets_washingController@get_cost');
            Route::get('get_carpet_serial', 'Carpets_washingController@get_serial');
            Route::delete('carpet_wash/{id}', 'Carpets_washingController@destroy');
            Route::get('carpet_washing_get_total_cost/{ticket_id}', 'Carpets_washingController@get_total_cost');
            Route::get('carpet_washing_get_total_discount/{ticket_id}', 'Carpets_washingController@get_total_discount');
            Route::get('carpet_washing_get_total_services/{ticket_id}', 'Carpets_washingController@get_total_services');
            Route::get('get_total_tickets', 'Carpets_washingController@get_total_tickets');
            Route::get('carpet_washing_get_total_servs', 'Carpets_washingController@carpet_washing_get_total_servs');
            Route::get('carpet_washing_get_total_cost', 'Carpets_washingController@carpet_washing_get_total_cost');
            Route::get('carpet_wash/{filter}/{one}/{two}', 'Carpets_washingController@index');
        });
        Route::group(['prefix' => 'car-washing'], function () {
            //get all clients
            Route::get('get-all-clients', 'Car_washingController@getAllClients');
            // Car washing Tickets Routes

            Route::get('get-all-tickets', 'Car_washingController@getAllTickets');

            Route::get('index', 'Car_washingController@index');
            Route::post('store', 'Car_washingController@store');
            Route::get('show/{id}', 'Car_washingController@show');
            Route::get('show-car/{car_number}', 'Car_washingController@showCar');
            Route::get('get-car/{id}', 'Car_washingController@getCar');
            Route::get('destroy/{id}', 'Car_washingController@destroy');
            Route::post('update/{id}', 'Car_washingController@update');
            Route::get('car_wash_show/{id}', 'Car_washingController@show_ticket');
            Route::post('car_washing_add_code_table', 'Car_washingController@add_code_table');
            Route::get('car_washing_get_id', 'Car_washingController@get_id');
            Route::get('car_washing_get_product_manages', 'Car_washingController@get_product_manages');
            Route::get('car_washing_get_units/{unit_id}', 'Car_washingController@get_units');
            Route::get('car_washing_ge21t_cost/{unit_id}', 'Car_washingController@get_cost');
            Route::get('get_clients', 'Car_washingController@get_clients');
            Route::get('get_serial', 'Car_washingController@get_serial');
            Route::get('car_washing_get_total_cost/{ticket_id}', 'Car_washingController@get_total_cost');
            Route::get('get_total_tickets', 'Car_washingController@get_total_tickets');
            Route::get('car_washing_get_total_discount/{ticket_id}', 'Car_washingController@get_total_discount');
            Route::get('car_washing_get_total_services/{ticket_id}', 'Car_washingController@get_total_services');
            Route::get('car_washing_get_total_servs', 'Car_washingController@car_washing_get_total_servs');
            Route::get('car_washing_get_total_cost', 'Car_washingController@car_washing_get_total_cost');
            Route::get('car_washing_get_car/{number}/{letters}', 'Car_washingController@check_car_number');
            Route::get('car_washing/{filter}/{one}/{two}', 'Car_washingController@index');
            // client
            Route::post('create_client', 'Car_washingController@create_client');
            Route::get('get_client/{id}', 'Car_washingController@get_client');
            // update Rate
            Route::post('update_rate', 'Car_washingController@update_rate');
            // update ticket status
            Route::post('update_ticket_status', 'Car_washingController@update_ticket_status');
            Route::post('update_ticket_status_carpet', 'Carpets_washingController@update_ticket_status_carpet');

            // inform Admin
            Route::post('informAdmin', 'Car_washingController@inform');
        });
    });
    Route::group(['prefix' => 'sales-report'], function () {
        //Sales Report
        Route::get('sales_reports/{filter}', 'SalesReportController@index');
        Route::post('sales_reports', 'SalesReportController@store');
        Route::get('get_user', 'SalesReportController@get_user');
        Route::get('get_total_cost/{filter}', 'SalesReportController@get_total_cost');
        Route::get('get_total_tickets/{filter}', 'SalesReportController@get_total_tickets');
        Route::get('get_total_servs/{filter}', 'SalesReportController@get_total_servs');
        Route::get('get_total_fin_cost/{filter}', 'SalesReportController@get_total_fin_cost');
        Route::get('total_taxes/{filter}', 'SalesReportController@get_total_taxes');
    });
    Route::group(['prefix' => 'reports', 'namespace' => 'Role'], function () {
        Route::get('index', 'ReportController@index');
        Route::get('store', 'ReportController@store');
        Route::get('show', 'ReportController@show');
        Route::get('update', 'ReportController@update');
        Route::get('destroy', 'ReportController@destroy');
    });


    // ################################################## Store Management ###########################################
    Route::group(['prefix' => 'store-manage', 'namespace' => 'Store_manage'], function () {
        // Products Management
        Route::get('index', 'Products_manageController@index');
        Route::post('store', 'Products_manageController@store');
        Route::post('update/{id}', 'Products_manageController@update');
        Route::get('destroy/{id}', 'Products_manageController@destroy');
        Route::get('get_id', 'Products_manageController@getId');

        Route::get('index', 'Units_manageController@index');
        Route::post('store', 'Units_manageController@store');
        Route::get('show/{id}', 'Services_manageController@show');
        Route::get('destroy/{id}', 'Units_manageController@destroy');

        Route::get('index', 'Services_manageController@index');
        Route::post('store', 'Services_manageController@store');
        Route::get('show/{id}', 'Services_manageController@show');
        Route::get('destroy/{id}', 'Services_manageController@destroy');
    });
    // ################################################## Dictionary ###########################################
    // Route::group(['prefix'=>'dictionaries','namespace'=>'Dictionary'],function(){
    //     Route::get('index','DictionaryController');
    // });
});
