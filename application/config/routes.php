<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//access routs
//$route['default_controller'] = 'access';
//$route['default_controller'] = 'user';
$route['default_controller'] = 'access';
$route['login'] = 'access';
$route['admin-login'] = 'access/user_access';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//vendor pacage
$route['package-list'] = 'admin/package_list';
$route['add-vendor-package'] = 'admin/add_vendor_package';
$route['edit-package/(:any)'] = 'admin/edit_package/$1';
$route['update-vendor-package/(:any)'] = 'admin/update_vendor_package/$1';

//vendor client
$route['new-client'] = 'admin/new_client';
$route['save-client'] = 'admin/save_client';
$route['active-client-list'] = 'admin/active_client_list';
$route['expired-client-list'] = 'admin/expired_client_list';
$route['edit-client/(:any)'] = 'admin/edit_client/$1';
$route['update-client/(:any)'] = 'admin/update_client/$1';
$route['reniew-client/(:any)'] = 'admin/reniew_client/$1';
$route['update-reniew-client/(:any)'] = 'admin/update_reniew_client/$1';
$route['deactivate-client/(:any)'] = 'admin/deactivate_client_id/$1';
$route['activate-client/(:any)'] = 'admin/activate_client_id/$1';
$route['reset-client-password/(:any)'] = 'admin/reset_client_password/$1';
$route['reset-client-password'] = 'admin/update_client_password';

$route['menu-setup'] = 'admin/menu_setup';
$route['save-menu'] = 'admin/menu_entry';
$route['edit-menu/(:any)'] = 'admin/edit_menu/$1';
$route['update-menu/(:any)'] = 'admin/update_menu/$1';



//client
$route['log-out'] = 'client/client_log_out';
$route['client-password/(:any)'] = 'client/client_password/$1';
$route['update-client-password/(:any)'] = 'client/update_client_password/$1';

//manufacturer
$route['manufacturer-list'] = 'client/manufacturer_list';
$route['save-manufacturer'] = 'client/save_manufacturer';
$route['edit-manufacturer/(:any)'] = 'client/edit_manufacturer/$1';
$route['update-manufacturer/(:any)'] = 'client/update_manufacturer/$1';

//supplier
$route['new-supplier'] = 'client/new_supplier';
$route['supplier-list'] = 'client/supplier_list';
$route['save-supplier'] = 'client/save_supplier';
$route['edit-supplier/(:any)'] = 'client/edit_supplier/$1';
$route['update-supplier/(:any)'] = 'client/update_supplier/$1';

//customer
$route['new-customer'] = 'client/new_customer';
$route['customer-list'] = 'client/customer_list';
$route['walking-customer-list'] = 'client/walking_customer_list';
$route['save-customer'] = 'client/save_customer';
$route['edit-customer/(:any)'] = 'client/edit_customer/$1';
$route['update-customer/(:any)'] = 'client/update_customer/$1';


//location
// $route['location-list'] = 'client/location_list';
// $route['save-location'] = 'client/save_location';
// $route['edit-location/(:any)'] = 'client/edit_location/$1';
// $route['update-location/(:any)'] = 'client/update_location/$1';

//expense type
//$route['expense-type-list'] = 'client/expense_type_list';
//$route['save-expense-type'] = 'client/save_expense_type';
//$route['edit-expense-type/(:any)'] = 'client/edit_expense_type/$1';
//$route['update-expense-type/(:any)'] = 'client/update_expense_type/$1';

//expense head
$route['expense-head-list'] = 'client/expense_head_list';
$route['save-expense-head'] = 'client/save_expense_head';
$route['edit-expense-head/(:any)'] = 'client/edit_expense_head/$1';
$route['update-expense-head/(:any)'] = 'client/update_expense_head/$1';

//expense entry
$route['add-expense'] = 'client/expense_entry_form';
$route['save-expense'] = 'client/save_expense_entry';
$route['expense-voucher/(:any)'] = 'client/expense_voucher_detail/$1';


$route['expense-ledger'] = 'client/expense_ledger_form';
$route['expense-ledger-report'] = 'client/datewise_expense_ledger_report';

//Category
$route['product-category'] = 'client/product_category_list';
$route['add-product-category'] = 'client/save_product_category';
$route['edit-product-category/(:any)'] = 'client/edit_product_category/$1';
$route['update-product-category/(:any)'] = 'client/update_product_category/$1';

//unit
$route['unit-list'] = 'client/unit_list';
$route['save-unit'] = 'client/save_unit';
$route['edit-unit/(:any)'] = 'client/edit_unit/$1';
$route['update-unit/(:any)'] = 'client/update_unit/$1';

//product
$route['product-list'] = 'client/product_list';
$route['new-product'] = 'client/new_product';
$route['add-product'] = 'client/add_product';
$route['view-product/(:any)'] = 'client/view_product/$1';
$route['edit-product/(:any)'] = 'client/edit_product_id/$1';
$route['update-product/(:any)'] = 'client/update_product_id/$1';
$route['activate-product/(:any)'] = 'client/activate_product_id/$1';
$route['deactivate-product/(:any)'] = 'client/deactivate_product_id/$1';
$route['product-barcode/(:any)'] = 'client/product_barcode_print/$1';
$route['barcode-print'] = 'client/barcode_print';
$route['barcode-generate'] = 'client/product_barcode_generate_form';


//purchase
$route['new-purchase'] = 'client/new_purchase_form';
$route['purchase-supplier'] = 'client/get_supplier_list';
$route['purchase-product'] = 'client/get_purchase_product_list';
$route['add-purchase'] = 'client/save_purchase';
$route['purchase-detail/(:any)'] = 'client/purchase_invoice_detail/$1';
$route['print-purchase-detail/(:any)'] = 'client/purchase_invoice_print/$1';
$route['print-purchase-challan/(:any)'] = 'client/purchase_challan_print/$1';
$route['manage-purchase'] = 'client/purchase_invoice_list';
$route['purchase-edit/(:any)'] = 'client/purchase_edit_form/$1';
$route['add-purchase-edit/(:any)'] = 'client/save_purchase_edit/$1';
$route['purchase-return'] = 'client/purchase_return_search';
$route['purchase-return-search'] = 'client/purchase_return_search_list';
$route['purchase-return-entry/(:any)'] = 'client/purchase_return_form/$1';
$route['add-purchase-return/(:any)'] = 'client/save_purchase_return/$1';
$route['purchase-return-list'] = 'client/purchase_return_list';
$route['purchase-return-detail/(:any)'] = 'client/purchase_return_detail/$1';

//sales
$route['new-sales'] = 'client/new_sales_form';
$route['sales-customer'] = 'client/get_customer_list';
$route['sales-product'] = 'client/get_sales_product_list';
$route['add-sales'] = 'client/sales_invoice_entry';
$route['sales-detail/(:any)'] = 'client/sales_detail/$1';
$route['print-sales-detail/(:any)'] = 'client/sales_detail_print/$1';
$route['print-sales-challan/(:any)'] = 'client/sales_challan_print/$1';
$route['manage-sales'] = 'client/sales_invoice_list';
$route['sales-edit/(:any)'] = 'client/sales_edit_form/$1';
$route['add-sales-edit/(:any)'] = 'client/save_sales_edit/$1';
$route['sales-return'] = 'client/sales_return_search';
$route['sales-return-search'] = 'client/sales_return_search_list';
$route['sales-return-entry/(:any)'] = 'client/sales_return_form/$1';
$route['add-sales-return/(:any)'] = 'client/save_sales_return/$1';
$route['sales-return-list'] = 'client/sales_return_list';
$route['sales-return-detail/(:any)'] = 'client/sales_return_detail/$1';

//supplier payment
$route['supplier-invoice-payment'] = 'client/supplier_invoice_payment';
$route['view-supplier-invoice-payment'] = 'client/supplier_invoice_payment_form';
$route['supplier-invoice-payment-entry'] = 'client/supplier_invoice_payment_entry';
$route['supplier-payment-list'] = 'client/supplier_payment_list';
$route['supplier-payment-detail/(:any)'] = 'client/supplier_payment_detail/$1';



//customer payment
$route['customer-invoice-payment'] = 'client/customer_invoice_payment';
$route['view-customer-invoice-payment'] = 'client/customer_invoice_payment_form';
$route['customer-invoice-payment-entry'] = 'client/customer_invoice_payment_entry';
$route['customer-payment-list'] = 'client/customer_payment_list';
$route['customer-payment-detail/(:any)'] = 'client/customer_payment_detail/$1';


//stock adjustment
 //$route['inventory-adjustment'] = 'client/product_inventory_adjustment';
 //$route['save-inventory-adjustment'] = 'client/product_inventory_adjustment_entry';
 //$route['save-inventory-adjustment-single'] = 'client/product_inventory_adjustment_entry_single';


//bank
$route['bank-list'] = 'client/bank_list';
$route['save-bank'] = 'client/save_bank';
$route['edit-bank/(:any)'] = 'client/edit_bank/$1';
$route['update-bank/(:any)'] = 'client/update_bank/$1';

$route['bank-transaction'] = 'client/bank_transaction_form';
$route['save-bank-transaction'] = 'client/bank_transaction_entry';

$route['bank-ledger'] = 'client/bank_ledger_form';
$route['bank-ledger-report'] = 'client/datewise_bank_ledger_report';



//report
$route['daily-purchase-sales-report'] = 'client/purchase_sales_report_today';
$route['datewise-purchase-sales'] = 'client/datewise_purchase_sales';
$route['daily-purchase-report'] = 'client/purchase_report';
$route['datewise-purchase'] = 'client/datewise_purchase';
$route['daily-sales-report'] = 'client/sales_report';
$route['datewise-sales'] = 'client/datewise_sales';
$route['supplier-ledger'] = 'client/supplier_ledger';
$route['supplierwise-ledger'] = 'client/supplierwise_ledger';
$route['customer-ledger'] = 'client/customer_ledger';
$route['customerwise-ledger'] = 'client/customerwise_ledger';
$route['profit-loss-report'] = 'client/profit_loss_report_today';
$route['datewise-profit-loss-report'] = 'client/profit_loss_report_datewise';
$route['supplier-due-report'] = 'client/supplier_due_report';
$route['supplierwise-due'] = 'client/supplierwise_due';
$route['customer-due-report'] = 'client/customer_due_report';
$route['customerwise-due'] = 'client/customerwise_due';
$route['stock-report'] = 'client/stock_report';
$route['stock-search-report'] = 'client/stock_search';
$route['low-stock-report'] = 'client/low_stock_report';

$route['stock-history-report'] = 'client/stock_history_report';
$route['stock-history-search-report'] = 'client/stock_history_search_report';


$route['product-ledger'] = 'client/product_ledger';
$route['financial-statement'] = 'client/financial_statement';
$route['financial-statement-search'] = 'client/financial_statement_search';
$route['cash-flow-statement'] = 'client/cash_flow_statement';
$route['cash-flow-statement-search'] = 'client/cash_flow_statement_search';

$route['sales-ledger'] = 'client/sales_ledger';
$route['customerwise-sales-ledger'] = 'client/customerwise_sales_ledger';

$route['purchase-ledger'] = 'client/purchase_ledger';
$route['customerwise-purchase-ledger'] = 'client/supplierwise_purchase_ledger';

$route['receive-payment-report'] = 'client/receive_payment_report';
$route['datewise-receive-payment'] = 'client/datewise_receive_payment';

$route['user-collection-payment'] = 'client/user_collection_payment';





 //$route['purchase-report'] = 'client/purchase_report_today';
 //$route['datewise-purchase-report'] = 'client/purchase_report_datewise';

// $route['datewise-purchase-report'] = 'client/datewise_purchase_report';
// $route['datewise-purchase-report-search'] = 'client/datewise_purchase_report_search';

//stock
$route['daily-stock'] = 'access/daily_stock_history';


$route['cash-transaction'] = 'client/cash_transaction_form';
$route['save-cash-transaction'] = 'client/cash_transaction_entry';

$route['cash-ledger'] = 'client/cash_ledger_form';
$route['cash-ledger-report'] = 'client/datewise_cash_ledger_report';


$route['profile-setup'] = 'client/client_profile';
$route['update-profile/(:any)'] = 'client/update_profile/$1';

$route['new-sales-requisition'] = 'client/sales_requisition_form';
$route['add-sales-requisition'] = 'client/save_sales_requisition';
$route['sales-requisition-detail/(:any)'] = 'client/sales_requisition_detail/$1';
$route['pending-sales-requisition'] = 'client/pending_sales_requisition';
$route['approve-sales-requisition/(:any)'] = 'client/sales_requisition_approval/$1';
$route['add-sales-requisition-approval/(:any)'] = 'client/save_sales_requisition_approval/$1';
$route['sales-requisition-approve-detail/(:any)'] = 'client/sales_requisition_approve_detail/$1';
$route['approved-sales-requisition'] = 'client/approved_sales_requisition';
$route['sales-requisition-bill/(:any)'] = 'client/sales_requisition_bill/$1';

$route['cancel-sales-requisition/(:any)'] = 'client/cancel_sales_requisition/$1';


//user
$route['user-list'] = 'client/user_list';
$route['save-user'] = 'client/save_user';
$route['edit-user/(:any)'] = 'client/edit_user/$1';
$route['update-user/(:any)'] = 'client/update_user/$1';
$route['set-user-status/(:any)/(:any)'] = 'client/user_status_update/$1/$2';
$route['set-user-privilege/(:any)'] = 'client/user_privilege_form/$1';
$route['save-user-privilege/(:any)'] = 'client/user_privilege_entry/$1';

$route['get-member-type'] = 'admin/get_member_type';
$route['get-package-price'] = 'admin/get_package_price';

 //supplier ledger transaction
$route['supplier-advance'] = 'client/supplier_advance_form';
$route['ledger-supplier'] = 'client/ledger_supplier_list';
$route['save-supplier-transaction'] = 'client/supplier_transaction_entry';
$route['supplier-balance'] = 'client/get_supplier_balance';
$route['supplier-payment-receipt/(:any)'] = 'client/supplier_payment_receipt/$1';


 //customer ledger transaction
$route['customer-advance'] = 'client/customer_advance_form';
$route['ledger-customer'] = 'client/ledger_customer_list';
$route['save-customer-transaction'] = 'client/customer_transaction_entry';
$route['customer-balance'] = 'client/get_customer_balance';
$route['customer-payment-receipt/(:any)'] = 'client/customer_payment_receipt/$1';

$route['new-quotation'] = 'client/quotation_form';
$route['add-quotation'] = 'client/save_quotation';
$route['manage-quotation'] = 'client/quotation_list';
$route['quotation-detail/(:any)'] = 'client/quotation_detail/$1';
//$route['po-bill/(:any)'] = 'client/po_bill/$1';
//$route['cancel-quotation/(:any)'] = 'client/cancel_sales_requisition/$1';

$route['sales-product-code-data'] = 'client/sales_product_code_data';
$route['purchase-product-code-data'] = 'client/purchase_product_code_data';










