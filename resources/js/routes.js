// @ts-nocheck
import VueRoute from 'vue-router'

// finance
import transactions from './components/admin/finance/transactions.vue'
import chart_of_account from './components/admin/finance/chart_of_account.vue'

// Department of Human Resource
import manage_emp from './components/admin/dept_of_hr/manage_employees/manage_emp.vue'
import emp_infos_create from './components/admin/dept_of_hr/manage_employees/emp_infos_create.vue'
import show_employee from './components/admin/dept_of_hr/manage_employees/show_employee.vue'
import permission from './components/admin/dept_of_hr/manage_employees/permission.vue'
import organizational_structure from './components/admin/dept_of_hr/organizational_structure.vue'
import attendance_logs from './components/admin/dept_of_hr/attendance_logs.vue'
import attendance_session_create from './components/admin/dept_of_hr/attendance_session_create.vue'
import shift_management from './components/admin/dept_of_hr/attendance/shift_management.vue'
import settings from './components/admin/dept_of_hr/settings/settings.vue'
import holiday_lists from './components/admin/dept_of_hr/settings/holiday_lists.vue'
import machines from './components/admin/dept_of_hr/settings/machines.vue'
import leave_policies from './components/admin/dept_of_hr/settings/leave_policies.vue'

// Washing Tickets
import car_washing from './components/admin/washing_tickets/car_washing.vue'
import carpets_washing from './components/admin/washing_tickets/carpets_washing.vue'
import daily_report from './components/admin/washing_tickets/daily_report.vue'
import sales_reports from './components/admin/washing_tickets/sales_reports.vue'

// Tickets Management
import washing_machines from './components/admin/tickets_manage/washing_machines.vue'
import maintenance_management from './components/admin/tickets_manage/maintenance_management.vue'

// Store Management
import stored_management from './components/admin/store_management/stored_management.vue'
import products_management from './components/admin/store_management/products_management.vue'


import Vue from 'vue'
import { Form, HasError, AlertError } from 'vform'

const routes = [
    // finance module
    { name: 'transactions', path: '/transactions', component: transactions },
    { name: 'chart_of_account', path: '/chart_of_account', component: chart_of_account },

    // Human Resource Routes
    { name: 'permission', path: '/permissions', component: permission },
    { name: 'organizational_structure', path: '/organizational_structure', component: organizational_structure },
    { name: 'attendance_logs', path: '/attendance_logs', component: attendance_logs },
    { name: 'attendance_session_create', path: '/attendance_session_create', component: attendance_session_create },
    { name: 'manage_emp', path: '/manage_emp', component: manage_emp },
    { name: 'emp_infos_create', path: '/emp_infos_create', component: emp_infos_create },
    { name: 'show_employee', path: '/show_employee', component: show_employee },
    { name: 'shift_management', path: '/shift_management', component: shift_management },
    { name: 'settings', path: '/settings', component: settings },
    { name: 'holiday_lists', path: '/holiday_lists', component: holiday_lists },
    { name: 'machines', path: '/machines', component: machines },
    { name: 'leave_policies', path: '/leave_policies', component: leave_policies },

    // Washing Tickets Routes
    { name: 'car_washing', path: '/car_washing', component: car_washing },
    { name: 'carpets_washing', path: '/carpets_washing', component: carpets_washing },
    { name: 'daily_report', path: '/daily_report', component: daily_report },
    { name: 'sales_reports', path: '/sales_reports', component: sales_reports },

    // Ticket Managements
    { name: 'washing_machines', path: '/washing_machines', component: washing_machines },
    { name: 'maintenance_management', path: '/maintenance_management', component: maintenance_management },

    // Store Managements
    { name: 'stored_management', path: '/stored_management', component: stored_management },
    { name: 'products_management', path: '/products_management', component: products_management },
]


window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination', require('laravel-vue-pagination'))

Vue.use(VueRoute);

const router = new VueRoute({
    routes,
    mode: 'history'

});

export default router
