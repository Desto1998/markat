<?php

defined('BASEPATH') or exit('No direct script access allowed');

function app_init_admin_sidebar_menu_items()
{
    $CI = &get_instance();

    $CI->app_menu->add_sidebar_menu_item('hauptinfo', [
        'name' =>  get_menu_option('hauptinfo', _l('Hauptinfo ')),
        'collapse' => true,
        'position' => 1,
        'icon' => 'fa fa-home',
    ]);

    $CI->app_menu->add_sidebar_children_item('hauptinfo', [
        'slug' => 'hauptinfo',
        'name' => _l('als_dashboard'),
        'href' => admin_url(),
        'position' => 1
    ]);


    $CI->app_menu->add_sidebar_menu_item('projects', [
        'name' => 'Project-Original',
        'href' => admin_url('projects'),
        'icon' => 'fa fa-bars',
        'position' => 99,
    ]);


    if (has_permission('firma', '', 'edit')) {
        $CI->app_menu->add_sidebar_children_item('hauptinfo', [
            'slug' => 'hauptinfo',
            'name' => get_menu_option('firma', _l('MEINE FIRMA')),
            'href' => admin_url('firma'),
            'position' => 2,
        ]);
    }

    if (has_permission('cars', '', 'view')
        || has_permission('cars', '', 'create')) {
        $CI->app_menu->add_sidebar_children_item('hauptinfo', [
            'slug' => 'hauptinfo',
            'name' => get_menu_option('cars', _l('Fahrzeugliste')),
            'href' => admin_url('cars'),
            'position' => 8
        ]);
    }


    $CI->app_menu->add_sidebar_menu_item('personal', [
        'name' => get_menu_option('personal', _l('Personal')),
        'collapse' => true,
        'position' => 10,
        'icon' => 'fa fa-file',
    ]);

    if (has_permission('staff', '', 'view')
        || has_permission('staff', '', 'create')) {
        $CI->app_menu->add_sidebar_children_item('personal', [
            'name' => get_menu_option('staff', _l('Mitarbeiter ')),
            'slug' => 'personal',
            'href' => admin_url('staff'),
            'position' => 5,
        ]);
    }

    if (has_permission('roles', '', 'view')
        || has_permission('roles', '', 'create')) {
        $CI->app_menu->add_sidebar_children_item('personal', [
            'slug' => 'personal',
            'href' => admin_url('roles'),
            'name' => _l('acs_roles'),
            'position' => 20]);
    }
    $CI->app_menu->add_sidebar_children_item('personal', [
        'slug' => 'personal',
        'name' => _l('Personalplan'),
        'href' => admin_url('utilities/calendar'),
        'position' => 15,
    ]);


    $CI->app_menu->add_sidebar_menu_item('mieterbetreuung', [
        'name' =>   get_menu_option('mieterbetreuung', _l('Mieterbetreuung ')),
        'collapse' => true,
        'position' => 20,
        'icon' => 'fa fa-file',
    ]);

    if (has_permission('wohnungen', '', 'view')
        || has_permission('wohnungen', '', 'create')) {
        $CI->app_menu->add_sidebar_children_item('mieterbetreuung', [
            'slug' => 'mieterbetreuung',
            'name' => get_menu_option('wohnungen', _l('AQ')),
            'href' => admin_url('wohnungen'),
            'position' => 1,
        ]);
    }
/*    $CI->app_menu->add_sidebar_children_item('mieterbetreuung', [
        'slug' => 'mieterbetreuung',
        'name' => get_menu_option('visualisierung', _l('Visualisierung')),
        'href' => admin_url('visualisierung'),
        'position' => 9,
    ]);*/

    if (has_permission('belegungsplan', '', 'view')
        || has_permission('belegungsplan', '', 'create')) {

        $CI->app_menu->add_sidebar_children_item('mieterbetreuung', [
            'slug' => 'mieterbetreuung',
            'name' => get_menu_option('belegungsplan', _l('Belegungsplan')),
            'href' => admin_url('belegungsplan'),
            'position' => 5,
            'icon' => '',
        ]);
    }
    if (has_permission('mieter', '', 'view')
        || has_permission('mieter', '', 'create')) {
        $CI->app_menu->add_sidebar_children_item('mieterbetreuung', [
            'slug' => 'mieterbetreuung',
            'name' => get_menu_option('mieter', _l('Mieter')),
            'href' => admin_url('mieter'),
            'position' => 10,
            'icon' => '',
        ]);
    }
    if (has_permission('inventar', '', 'view')
        || has_permission('inventar', '', 'create')) {

        $CI->app_menu->add_sidebar_children_item('mieterbetreuung', [
            'slug' => 'mieterbetreuung',
            'name' => get_menu_option('inventarlistes', _l('Inventar')),
            'href' => admin_url('wohnungen/inventarlistes'),
            'position' => 15,
            'icon' => '',
        ]);

    }
    $CI->app_menu->add_sidebar_children_item('mieterbetreuung', [
        'slug' => 'mieterbetreuung',
        'name' => get_menu_option('inventarlistes_un', _l('Inventar-Umzugsliste')),
        'href' => admin_url('wohnungen/move_inventory'),
        'position' => 19,
        'new' => true,
        'icon' => '',
    ]);

    $CI->app_menu->add_sidebar_children_item('mieterbetreuung', [
        'slug' => 'mieterbetreuung',
        'name' => get_menu_option('rb', _l('Räumung/Beräumung')),
        'href' => admin_url('rb'),
        'position' => 25,
        'icon' => '',
    ]);
    if (has_permission('belegungsplan', '', 'view')
        || has_permission('belegungsplan', '', 'create')) {

        $CI->app_menu->add_sidebar_children_item('mieterbetreuung', [
            'slug' => 'mieterbetreuung',
            'name' => get_menu_option('reinigung', _l('Reinigung')),
            'href' => admin_url('reinigung'),
            'position' => 30,
            'icon' => '',
        ]);
    }


    if ($GLOBALS['current_user']->role == 2) {
        /*        $CI->app_menu->add_sidebar_menu_item('staff', [
                    'name' => get_menu_option('staff',_l('als_staff')),
                    'href' => admin_url('staff'),
                    'position' => 12,
                    'icon' => 'fa fa-users',
                ]);*/

        if (1 == 2) {


            $CI->app_menu->add_sidebar_menu_item('leistungsverz', [
                'name' => get_menu_option('leistungsverz', _l('Leistungsverz')),
                'href' => '#',
                'position' => 82,
                'icon' => 'fa fa-clock-o',
            ]);
            $CI->app_menu->add_sidebar_menu_item('lager', [
                'name' => get_menu_option('lager', _l('Lager')),
                'href' => '#',
                'position' => 83,
                'icon' => 'fa fa-archive'
            ]);

            $CI->app_menu->add_sidebar_menu_item('buchhaltung', [
                'name' => get_menu_option('buchhaltung', _l('Buchhaltung')),
                'href' => '#',
                'position' => 84,
                'icon' => 'fa fa-calculator',
            ]);
            $CI->app_menu->add_sidebar_menu_item('aufgrabenplanung', [
                'name' => get_menu_option('aufgrabenplanung', _l('Aufgrabenplanung')),
                'href' => '#',
                'position' => 85,
                'icon' => 'fa fa-linode',
            ]);

            $CI->app_menu->add_sidebar_menu_item('angebote', [
                'name' => get_menu_option('angebote', _l('Angebote')),
                'href' => '#',
                'position' => 86,
                'icon' => 'fa fa-linode',
            ]);
        }
    }

    $CI->app_menu->add_sidebar_menu_item('stock_manager', [
        'name' => get_menu_option('stock_manager', _l('stock_manager')),
        'href' => admin_url('stock_manager'),
        'position' => 88,
        'icon' => 'fa fa-linode',
    ]);
/*

    if (has_permission('wohnungen', '', 'view')
        || has_permission('wohnungen', '', 'create') ||
        has_permission('inventar', '', 'view') ||
        has_permission('inventar', '', 'create') ||
        has_permission('visualisierung', '', 'view') ||
        has_permission('visualisierung', '', 'create')) {
        $CI->app_menu->add_sidebar_menu_item('wohnungen', [
            'name' => get_menu_option('wohnungen', _l('AQ ')),
            'collapse' => true,
            'position' => 6,
            'icon' => 'fa fa-building',
        ]);

        if (has_permission('visualisierung', '', 'view')
            || has_permission('visualisierung', '', 'create')) {
            $CI->app_menu->add_sidebar_children_item('wohnungen', [
                'slug' => 'wohnungen',
                'name' => get_menu_option('visualisierung', _l('Visualisierung')),
                'href' => admin_url('visualisierung'),
                'position' => 9,
            ]);
        }

    }*/

    $CI->app_menu->add_sidebar_menu_item('workstation', [
        'name' =>    get_menu_option('workstation', _l('Workstation ')),
        'collapse' => true,
        'position' => 30,
        'icon' => 'fa fa-file',
    ]);

    if (has_permission('tasks', '', 'view')
        || has_permission('tasks', '', 'edit')
        || has_permission('tasks', '', 'create')) {

        $CI->app_menu->add_sidebar_children_item('workstation', [
            'slug' => 'workstation',
            'name' => get_menu_option('tasks', _l('Task-Planer')),
            'href' => admin_url('tasks'),
            'icon' => '',
            'position' => 10,
        ]);
    }
    $CI->app_menu->add_sidebar_children_item('workstation', [
        'slug' => 'workstation',
        'name' => get_menu_option('dokumente', _l('Dokumente')),
        'href' => admin_url('dokumente'),
        'position' => 15,
        'icon' => '',
    ]);

    if (has_permission('lieferanten', '', 'view')
        || has_permission('lieferanten', '', 'create')) {
        $CI->app_menu->add_sidebar_children_item('workstation', [
            'slug' => 'workstation',
            'name' => get_menu_option('lieferanten', _l('Lieferanten')),
            'href' => admin_url('lieferanten'),
            'position' => 20,
            'icon' => '',
        ]);
    }
    $CI->app_menu->add_sidebar_children_item('workstation', [
        'slug' => 'workstation',
        'name' => get_menu_option('projekte', _l('Projekte')),
        'href' => admin_url('projekte'),
        'position' => 25,
        'icon' => '',
    ]);


    $CI->app_menu->add_sidebar_children_item('workstation', [
        'slug' => 'workstation',
        'name' => get_menu_option('solution-box', _l('Solution-Box')),
        'href' => admin_url('solutionbox'),
        'position' => 30,
        'icon' => '',
    ]);

    $CI->app_menu->add_sidebar_menu_item('kommunikation', [
        'name' => get_menu_option('kommunikation', _l('Kommunikation')),
        'collapse' => true,
        'position' => 80,
        'icon' => 'fa fa-file',
    ]);
    if (get_option('pusher_chat_enabled') == '1') {
        $CI->app_menu->add_sidebar_children_item('kommunikation', [
            'slug' => 'kommunikation',
            'name'     => 'Chat',
            'href'     => admin_url('prchat/Prchat_Controller/chat_full_view'),
            'icon'     => '',
            'position' => 10,
        ]);
    }

    $CI->app_menu->add_sidebar_children_item('kommunikation', [
        'slug' => 'kommunikation',
        'name' => get_menu_option('emailsettings', _l('Email Einstellungen')),
        'href' => admin_url('emailsettings'),
        'position' => 20,
        'icon' => '',
    ]);


    $CI->app_menu->add_sidebar_menu_item('buchhaltung', [
        'name' =>   get_menu_option('buchhaltung',_l('Buchhaltung ')),
        'collapse' => true,
        'position' => 90,
        'icon' => 'fa fa-info',
    ]);

    if (has_permission('factoring', '', 'view')
        || has_permission('factoring', '', 'create')) {
        $CI->app_menu->add_sidebar_children_item('buchhaltung', [
            'slug' => 'buchhaltung',
            'name' => get_menu_option('factoring', _l('Factoring')),
            'href' => 'https://fundflow.de/?ref=martinkatzky',
            'position' => 10,
            'icon' => '',
        ]);
    }

    if ((has_permission('invoices', '', 'view') || has_permission('invoices', '', 'view_own'))
        || (staff_has_assigned_invoices() && get_option('allow_staff_view_invoices_assigned') == 1)) {

        $CI->app_menu->add_sidebar_children_item('buchhaltung', [
            'slug' => 'buchhaltung',
            'name' => get_menu_option('invoices', _l('Rechnungen')),
            'href' => admin_url('invoices'),
            'position' => 20,
            'icon' => 'fa fa-linode',
        ]);
    }

    /*    if (has_permission('staff', '', 'view')
            || has_permission('staff', '', 'create')) {
            $CI->app_menu->add_sidebar_menu_item('staff', [
                'name' => get_menu_option('staff', _l('Mitarbeiter ')),
                'collapse' => true,
                'position' => 6,
                'icon' => 'fa fa-address-card'
            ]);

        }*/

    if (has_permission('customers', '', 'view')
        || (have_assigned_customers()
            || (!have_assigned_customers() && has_permission('customers', '', 'create')))) {
        $CI->app_menu->add_sidebar_menu_item('customers', [
            'name' => get_menu_option('clients', _l('als_clients')),
            'href' => admin_url('clients'),
            'position' => 5,
            'icon' => 'fa fa-user-o',
        ]);
    }

    /*    $CI->app_menu->add_sidebar_menu_item('sales', [
            'collapse' => true,
            'name' => _l('als_sales'),
            'position' => 10,
            'icon' => 'fa fa-balance-scale',
        ]);*/

    if ((has_permission('proposals', '', 'view') || has_permission('proposals', '', 'view_own'))
        || (staff_has_assigned_proposals() && get_option('allow_staff_view_proposals_assigned') == 1)) {
        $CI->app_menu->add_sidebar_children_item('sales', [
            'slug' => 'proposals',
            'name' => _l('proposals'),
            'href' => admin_url('proposals'),
            'position' => 5,
        ]);
    }

    if ((has_permission('estimates', '', 'view') || has_permission('estimates', '', 'view_own'))
        || (staff_has_assigned_estimates() && get_option('allow_staff_view_estimates_assigned') == 1)) {
        $CI->app_menu->add_sidebar_children_item('sales', [
            'slug' => 'estimates',
            'name' => _l('estimates'),
            'href' => admin_url('estimates'),
            'position' => 10,
        ]);
    }

    /*    if ((has_permission('invoices', '', 'view') || has_permission('invoices', '', 'view_own'))
            || (staff_has_assigned_invoices() && get_option('allow_staff_view_invoices_assigned') == 1)) {
            $CI->app_menu->add_sidebar_children_item('sales', [
                'slug' => 'invoices',
                'name' => _l('invoices'),
                'href' => admin_url('invoices'),
                'position' => 15,
            ]);
        }*/

    if (has_permission('payments', '', 'view') || has_permission('invoices', '', 'view_own')
        || (get_option('allow_staff_view_invoices_assigned') == 1 && staff_has_assigned_invoices())) {
        $CI->app_menu->add_sidebar_children_item('sales', [
            'slug' => 'payments',
            'name' => _l('payments'),
            'href' => admin_url('payments'),
            'position' => 20,
        ]);
    }

    if (has_permission('credit_notes', '', 'view') || has_permission('credit_notes', '', 'view_own')) {
        $CI->app_menu->add_sidebar_children_item('sales', [
            'slug' => 'credit_notes',
            'name' => _l('credit_notes'),
            'href' => admin_url('credit_notes'),
            'position' => 25,
        ]);
    }

    if (has_permission('items', '', 'view')) {
        $CI->app_menu->add_sidebar_children_item('sales', [
            'slug' => 'items',
            'name' => _l('items'),
            'href' => admin_url('invoice_items'),
            'position' => 30,
        ]);
    }

    if (has_permission('subscriptions', '', 'view') || has_permission('subscriptions', '', 'view_own')) {
        $CI->app_menu->add_sidebar_menu_item('subscriptions', [
            'name' => _l('subscriptions'),
            'href' => admin_url('subscriptions'),
            'icon' => 'fa fa-repeat',
            'position' => 15,
        ]);
    }

    if (has_permission('expenses', '', 'view') || has_permission('expenses', '', 'view_own')) {
        $CI->app_menu->add_sidebar_menu_item('expenses', [
            'name' => _l('expenses'),
            'href' => admin_url('expenses'),
            'icon' => 'fa fa-file-text-o',
            'position' => 20,
        ]);
    }

    if (has_permission('contracts', '', 'view') || has_permission('contracts', '', 'view_own')) {
        $CI->app_menu->add_sidebar_menu_item('contracts', [
            'name' => _l('contracts'),
            'href' => admin_url('contracts'),
            'icon' => 'fa fa-file',
            'position' => 25,
        ]);
    }

    if (has_permission('projects', '', 'view')) {

/*
        $CI->app_menu->add_sidebar_menu_item('tasks', [
            'name' => _l('als_tasks'),
            'href' => admin_url('tasks'),
            'icon' => 'fa fa-tasks',
            'position' => 35,
        ]);*/
    }

    if ((!is_staff_member() && get_option('access_tickets_to_none_staff_members') == 1)/* || is_staff_member()*/) {
        $CI->app_menu->add_sidebar_menu_item('support', [
            'name' => _l('support'),
            'href' => admin_url('tickets'),
            'icon' => 'fa fa-ticket',
            'position' => 40,
        ]);
    }

    if (is_admin()) {
        $CI->app_menu->add_sidebar_menu_item('leads', [
            'name' => _l('als_leads'),
            'href' => admin_url('leads'),
            'icon' => 'fa fa-tty',
            'position' => 45,
        ]);
    }

    if (has_permission('knowledge_base', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('knowledge-base', [
            'name' => _l('als_kb'),
            'href' => admin_url('knowledge_base'),
            'icon' => 'fa fa-folder-open-o',
            'position' => 50,
        ]);
    }

    if (is_admin()) {
        // Utilities
        $CI->app_menu->add_sidebar_menu_item('utilities', [
            'collapse' => true,
            'name' => _l('als_utilities'),
            'position' => 55,
            'icon' => 'fa fa-cogs',
        ]);

        $CI->app_menu->add_sidebar_children_item('utilities', [
            'slug' => 'media',
            'name' => _l('als_media'),
            'href' => admin_url('utilities/media'),
            'position' => 5,
        ]);

        if (has_permission('bulk_pdf_exporter', '', 'view')) {
            $CI->app_menu->add_sidebar_children_item('utilities', [
                'slug' => 'bulk-pdf-exporter',
                'name' => _l('bulk_pdf_exporter'),
                'href' => admin_url('utilities/bulk_pdf_exporter'),
                'position' => 10,
            ]);
        }

        $CI->app_menu->add_sidebar_children_item('utilities', [
            'slug' => 'calendar',
            'name' => _l('als_calendar_submenu'),
            'href' => admin_url('utilities/calendar'),
            'position' => 15,
        ]);


        $CI->app_menu->add_sidebar_children_item('utilities', [
            'slug' => 'announcements',
            'name' => _l('als_announcements_submenu'),
            'href' => admin_url('announcements'),
            'position' => 20,
        ]);

        $CI->app_menu->add_sidebar_children_item('utilities', [
            'slug' => 'activity-log',
            'name' => _l('als_activity_log_submenu'),
            'href' => admin_url('utilities/activity_log'),
            'position' => 25,
        ]);

        $CI->app_menu->add_sidebar_children_item('utilities', [
            'slug' => 'ticket-pipe-log',
            'name' => _l('ticket_pipe_log'),
            'href' => admin_url('utilities/pipe_log'),
            'position' => 30,
        ]);
    }

    if (has_permission('reports', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('reports', [
            'collapse' => true,
            'name' => _l('als_reports'),
            'href' => admin_url('reports'),
            'icon' => 'fa fa-area-chart',
            'position' => 60,
        ]);
        $CI->app_menu->add_sidebar_children_item('reports', [
            'slug' => 'sales-reports',
            'name' => _l('als_reports_sales_submenu'),
            'href' => admin_url('reports/sales'),
            'position' => 5,
        ]);
        $CI->app_menu->add_sidebar_children_item('reports', [
            'slug' => 'expenses-reports',
            'name' => _l('als_reports_expenses'),
            'href' => admin_url('reports/expenses'),
            'position' => 10,
        ]);
        $CI->app_menu->add_sidebar_children_item('reports', [
            'slug' => 'expenses-vs-income-reports',
            'name' => _l('als_expenses_vs_income'),
            'href' => admin_url('reports/expenses_vs_income'),
            'position' => 15,
        ]);
        $CI->app_menu->add_sidebar_children_item('reports', [
            'slug' => 'leads-reports',
            'name' => _l('als_reports_leads_submenu'),
            'href' => admin_url('reports/leads'),
            'position' => 20,
        ]);

        if (is_admin()) {
            $CI->app_menu->add_sidebar_children_item('reports', [
                'slug' => 'timesheets-reports',
                'name' => _l('timesheets_overview'),
                'href' => admin_url('staff/timesheets?view=all'),
                'position' => 25,
            ]);
        }

        $CI->app_menu->add_sidebar_children_item('reports', [
            'slug' => 'knowledge-base-reports',
            'name' => _l('als_kb_articles_submenu'),
            'href' => admin_url('reports/knowledge_base_articles'),
            'position' => 30,
        ]);
    }

    // Setup menu
    if (is_admin()) {
        $CI->app_menu->add_setup_menu_item('staff', [
            'name' => _l('als_staff'),
            'href' => admin_url('staff'),
            'position' => 5,
        ]);
        $CI->app_menu->add_setup_menu_item('customers', [
            'collapse' => true,
            'name' => _l('clients'),
            'position' => 10,
        ]);

        $CI->app_menu->add_setup_children_item('customers', [
            'slug' => 'customer-groups',
            'name' => _l('customer_groups'),
            'href' => admin_url('clients/groups'),
            'position' => 5,
        ]);
        $CI->app_menu->add_setup_menu_item('support', [
            'collapse' => true,
            'name' => _l('support'),
            'position' => 15,
        ]);

        $CI->app_menu->add_setup_children_item('support', [
            'slug' => 'departments',
            'name' => _l('acs_departments'),
            'href' => admin_url('departments'),
            'position' => 5,
        ]);
        $CI->app_menu->add_setup_children_item('support', [
            'slug' => 'tickets-predefined-replies',
            'name' => _l('acs_ticket_predefined_replies_submenu'),
            'href' => admin_url('tickets/predefined_replies'),
            'position' => 10,
        ]);
        $CI->app_menu->add_setup_children_item('support', [
            'slug' => 'tickets-priorities',
            'name' => _l('acs_ticket_priority_submenu'),
            'href' => admin_url('tickets/priorities'),
            'position' => 15,
        ]);
        $CI->app_menu->add_setup_children_item('support', [
            'slug' => 'tickets-statuses',
            'name' => _l('acs_ticket_statuses_submenu'),
            'href' => admin_url('tickets/statuses'),
            'position' => 20,
        ]);

        $CI->app_menu->add_setup_children_item('support', [
            'slug' => 'tickets-services',
            'name' => _l('acs_ticket_services_submenu'),
            'href' => admin_url('tickets/services'),
            'position' => 25,
        ]);
        $CI->app_menu->add_setup_children_item('support', [
            'slug' => 'tickets-spam-filters',
            'name' => _l('spam_filters'),
            'href' => admin_url('spam_filters/view/tickets'),
            'position' => 30,
        ]);

        $CI->app_menu->add_setup_menu_item('leads', [
            'collapse' => true,
            'name' => _l('acs_leads'),
            'position' => 20,
        ]);
        $CI->app_menu->add_setup_children_item('leads', [
            'slug' => 'leads-sources',
            'name' => _l('acs_leads_sources_submenu'),
            'href' => admin_url('leads/sources'),
            'position' => 5,
        ]);
        $CI->app_menu->add_setup_children_item('leads', [
            'slug' => 'leads-statuses',
            'name' => _l('acs_leads_statuses_submenu'),
            'href' => admin_url('leads/statuses'),
            'position' => 10,
        ]);
        $CI->app_menu->add_setup_children_item('leads', [
            'slug' => 'leads-email-integration',
            'name' => _l('leads_email_integration'),
            'href' => admin_url('leads/email_integration'),
            'position' => 15,
        ]);
        $CI->app_menu->add_setup_children_item('leads', [
            'slug' => 'web-to-lead',
            'name' => _l('web_to_lead'),
            'href' => admin_url('leads/forms'),
            'position' => 20,
        ]);

        $CI->app_menu->add_setup_menu_item('finance', [
            'collapse' => true,
            'name' => _l('acs_finance'),
            'position' => 25,
        ]);
        $CI->app_menu->add_setup_children_item('finance', [
            'slug' => 'taxes',
            'name' => _l('acs_sales_taxes_submenu'),
            'href' => admin_url('taxes'),
            'position' => 5,
        ]);
        $CI->app_menu->add_setup_children_item('finance', [
            'slug' => 'currencies',
            'name' => _l('acs_sales_currencies_submenu'),
            'href' => admin_url('currencies'),
            'position' => 10,
        ]);
        $CI->app_menu->add_setup_children_item('finance', [
            'slug' => 'payment-modes',
            'name' => _l('acs_sales_payment_modes_submenu'),
            'href' => admin_url('paymentmodes'),
            'position' => 15,
        ]);
        $CI->app_menu->add_setup_children_item('finance', [
            'slug' => 'expenses-categories',
            'name' => _l('acs_expense_categories'),
            'href' => admin_url('expenses/categories'),
            'position' => 20,
        ]);

        $CI->app_menu->add_setup_menu_item('contracts', [
            'collapse' => true,
            'name' => _l('acs_contracts'),
            'position' => 30,
        ]);
        $CI->app_menu->add_setup_children_item('contracts', [
            'slug' => 'contracts-types',
            'name' => _l('acs_contract_types'),
            'href' => admin_url('contracts/types'),
            'position' => 5,
        ]);

        $modules_name = _l('modules');

        if ($modulesNeedsUpgrade = $CI->app_modules->number_of_modules_that_require_database_upgrade()) {
            $modules_name .= '<span class="badge menu-badge bg-warning">' . $modulesNeedsUpgrade . '</span>';
        }

        $CI->app_menu->add_setup_menu_item('modules', [
            'href' => admin_url('modules'),
            'name' => $modules_name,
            'position' => 35,
        ]);

        $CI->app_menu->add_setup_menu_item('custom-fields', [
            'href' => admin_url('custom_fields'),
            'name' => _l('asc_custom_fields'),
            'position' => 45,
        ]);

        $CI->app_menu->add_setup_menu_item('gdpr', [
            'href' => admin_url('gdpr'),
            'name' => _l('gdpr_short'),
            'position' => 50,
        ]);

        $CI->app_menu->add_setup_menu_item('roles', [
            'href' => admin_url('roles'),
            'name' => _l('acs_roles'),
            'position' => 55,
        ]);

        /*             $CI->app_menu->add_setup_menu_item('api', [
                                  'href'     => admin_url('api'),
                                  'name'     => 'API',
                                  'position' => 65,
                          ]);*/
    }

    if (has_permission('settings', '', 'view')) {
        $CI->app_menu->add_setup_menu_item('settings', [
            'href' => admin_url('settings'),
            'name' => _l('acs_settings'),
            'position' => 200,
        ]);
    }

    if (has_permission('email_templates', '', 'view')) {
        $CI->app_menu->add_setup_menu_item('email-templates', [
            'href' => admin_url('emails'),
            'name' => _l('acs_email_templates'),
            'position' => 40,
        ]);
    }
}
