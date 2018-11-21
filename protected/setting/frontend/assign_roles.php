<?php
/************##User Role setting;##*******************/
$user_role = $db->get_var('users', array('user_id' => $_SESSION['user_id']), 'role_id');
$roles = $db->get_row('roles', array('id' => $user_role));
//echo '<pre>';
//print_r($roles);
//echo '</pre>';
$role = $roles['role'];
$description = $roles['description'];
$dtd_bank_account = unserialize($roles['dtd_bank_account']);
$dtd_transfer_money = unserialize($roles['dtd_transfer_money']);

$dtd_bank_payment = unserialize($roles['dtd_bank_payment']);
$dtd_estimate = unserialize($roles['dtd_estimate']);
$dtd_invoice = unserialize($roles['dtd_invoice']);
$dtd_adjustment_notes = unserialize($roles['dtd_adjustment_notes']);
$dtd_receipt = unserialize($roles['dtd_receipt']);
$dtd_bills = unserialize($roles['dtd_bills']);
$dtd_supplier_adjustment_notes = unserialize($roles['dtd_supplier_adjustment_notes']);
$dtd_payment = unserialize($roles['dtd_payment']);
$dtd_projects = unserialize($roles['dtd_projects']);
$dtd_items = unserialize($roles['dtd_items']);


/************##User Report start;##*******************/
$dtd_timesheets = unserialize($roles['dtd_timesheets']);
$dtd_expense_claims = unserialize($roles['dtd_expense_claims']);
$rp_budgets = unserialize($roles['rp_budgets']);
$fr_profit_and_loss = unserialize($roles['fr_profit_and_loss']);
$fr_balance_sheet = unserialize($roles['fr_balance_sheet']);
$fr_trial_balance = unserialize($roles['fr_trial_balance']);
$fr_account_enquary = unserialize($roles['fr_account_enquary']);
$tr_gst_summery = unserialize($roles['tr_gst_summery']);
$tr_tax_code_transaction = unserialize($roles['tr_tax_code_transaction']);
$cr_aged_debtors = unserialize($roles['cr_aged_debtors']);
$cr_aged_debtor_transaction = unserialize($roles['cr_aged_debtor_transaction']);
$cr_invoice_list = unserialize($roles['cr_invoice_list']);
$cr_customer_transaction = unserialize($roles['cr_customer_transaction']);
$sr_aged_creditors = unserialize($roles['sr_aged_creditors']);
$sr_aged_creditors_transaction = unserialize($roles['sr_aged_creditors_transaction']);
$sr_bill_list = unserialize($roles['sr_bill_list']);
$sr_supplier_transaction = unserialize($roles['sr_supplier_transaction']);
$ar_aged_debtor_summery = unserialize($roles['ar_aged_debtor_summery']);
$ar_aged_creditor_summery = unserialize($roles['ar_aged_creditor_summery']);
$ar_top_ten_customers = unserialize($roles['ar_top_ten_customers']);
$ar_top_ten_suppliers = unserialize($roles['ar_top_ten_suppliers']);
$ar_top_ten_income_accounts = unserialize($roles['ar_top_ten_income_accounts']);
$ar_top_ten_expense_accounts = unserialize($roles['ar_top_ten_expense_accounts']);
$ar_budget = unserialize($roles['ar_budget']);
$lr_account_list = unserialize($roles['lr_account_list']);
$lr_bank_account_list = unserialize($roles['lr_bank_account_list']);
$lr_item_list = unserialize($roles['lr_item_list']);
$lr_project_list = unserialize($roles['lr_project_list']);
$lr_customer_list = unserialize($roles['lr_customer_list']);
$lr_supplier_list = unserialize($roles['lr_supplier_list']);
$lr_employee_list = unserialize($roles['lr_employee_list']);
$lr_tax_code_list = unserialize($roles['lr_tax_code_list']);
$advr_journal_list = unserialize($roles['advr_journal_list']);
$advr_payment_and_receipt = unserialize($roles['advr_payment_and_receipt']);
$advr_bank_account_reconcilation = unserialize($roles['advr_bank_account_reconcilation']);
/************##User Report start;##*******************/

/************##User JOURNAL;##*******************/
$adv_journal = unserialize($roles['adv_journal']);
$adv_activity_statement = unserialize($roles['adv_activity_statement']);
$adv_tpar = unserialize($roles['adv_tpar']);


$con_cintact = unserialize($roles['con_cintact']);
$con_payroll_employee_details = unserialize($roles['con_payroll_employee_details']);
$con_superfunds = unserialize($roles['con_superfunds']);
$adm_accounts = unserialize($roles['adm_accounts']);
$adm_users = unserialize($roles['adm_users']);
$adm_roles = unserialize($roles['adm_roles']);
//print_r($adm_users);
$adm_book_settings = unserialize($roles['adm_book_settings']);
$adm_selling_settigs = unserialize($roles['adm_selling_settigs']);

$adm_payment_terms = unserialize($roles['adm_payment_terms']);
$adm_buying_settings = unserialize($roles['adm_buying_settings']);
$adm_time_and_expense_settings = unserialize($roles['adm_time_and_expense_settings']);
$adm_email_settings = unserialize($roles['adm_email_settings']);
$adm_email_history = unserialize($roles['adm_email_history']);
$adm_report_settings = unserialize($roles['adm_report_settings']);
$adm_tax_settings = unserialize($roles['adm_tax_settings']);
$adm_payroll_items = unserialize($roles['adm_payroll_items']);
$adm_payroll_settings = unserialize($roles['adm_payroll_settings']);

// define('DTD_BANK_ACCOUNT',$dtd_bank_account);
/* define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 define(,$ );
 */