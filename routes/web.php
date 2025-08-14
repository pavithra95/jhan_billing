<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CashBillInvoiceController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GstStateMasterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\SalesInvoiceController;
use App\Http\Controllers\PurchaseInvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PurchasePaymentController;
use App\Http\Controllers\SalesPaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\TaxGroupController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoanRepaymentController;
use App\Http\Controllers\PurchaseReturnInvoiceController;
use App\Http\Controllers\SalesReturnInvoiceController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\SettingController;
use App\Models\PurchaseReturnInvoice;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', function() {
//     return view('home');
// })->name('home')->middleware('auth');

//Route::resource('/home', 'Homecontroller');
Route::get('logout',[\App\Http\Controllers\Auth\LoginController::class,'logout']);

Route::get('home',[HomeController::class,'index']);





Route::resource('users', Usercontroller::class);

// Route::get('register', function () {
//     return view('users.create');
// });

Route::get('register',[Usercontroller::class,'create']);
Route::get('users/{id}/edit',[Usercontroller::class,'edit']);
Route::post('user-edit',[Usercontroller::class,'update'])->name('user-edit');

Route::post('register',[Usercontroller::class,'store']);
Route::get('/delete/{id}',[Usercontroller::class,'destroy']);
// Route::resource('branches',BranchController::class);
// Route::get('branches/{id}/delete','BranchController::class,'destroy');
Route::get('/getTest',[ProductCategoryController::class,'category']);
Route::resource('products',ProductController::class);
Route::get('products/{id}/delete',[ProductController::class,'destroy']);

Route::resource('gst-state-masters', GstStateMasterController::class);
Route::resource('customers', CustomerController::class);
Route::get('customers/{id}/delete',[CustomerController::class,'destroy']);

Route::resource('vendors', VendorsController::class);
Route::get('vendors/{id}/delete',[VendorsController::class,'destroy']);

Route::resource('sales-invoices', SalesInvoiceController::class);
Route::get('sales-invoices/{id}/delete',[SalesInvoiceController::class,'destroy']);

Route::get('purchase-invoices/{id}/show',[SalesInvoiceController::class,'show']);

Route::resource('purchase-invoices', PurchaseInvoiceController::class);
Route::get('purchase-invoices/{id}/delete',[PurchaseInvoiceController::class,'destroy']);



Route::post('/create-payment-from-purchase-invoice/{id}',[PaymentController::class,'storePaymentforPurchaseInvoice']);

// purchase payments
Route::get('payment-purchase-invoices', [PurchasePaymentController::class,'index']);
Route::get('new-purchase-payment', [PurchasePaymentController::class,'create']);
Route::post('new-purchase-payment', [PurchasePaymentController::class,'store']);
Route::get('payment-purchase-invoices/{id}', [PurchasePaymentController::class,'show']);
Route::get('/create-payment-from-purchase-invoice/{id}',[PurchasePaymentController::class,'createSinglePayment']);
Route::post('/create-payment-from-purchase-invoice/{id}',[PurchasePaymentController::class,'storeSinglePayment']);



Route::resource('reports', ReportController::class);

Route::get('payment-sales-invoices', [SalesPaymentController::class,'index']);

Route::get('new-sales-payment', [SalesPaymentController::class,'create']);
Route::post('new-sales-payment', [SalesPaymentController::class,'store']);
Route::get('payment-sales-invoices/{id}', [SalesPaymentController::class,'show']);
Route::get('/create-payment-from-invoice/{id}',[SalesPaymentController::class,'createSingleSalesPayment']);
Route::post('/create-payment-from-invoice/{id}',[SalesPaymentController::class,'storeSingleSalesPayment']);

Route::get('/edit-sales-payment/{id}',[SalesPaymentController::class,'edit']);
Route::put('/edit-sales-payment/{id}',[SalesPaymentController::class,'update']);
Route::get('/edit-purchase-payment/{id}',[PurchasePaymentController::class,'edit']);
Route::put('/edit-purchase-payment/{id}',[PurchasePaymentController::class,'update']);



Route::get('delete-sales-payment/{id}/delete',[SalesPaymentController::class,'destroy']);
Route::get('delete-purchase-payment/{id}/delete',[PurchasePaymentController::class,'destroy']);
Route::get('loan-repayments/{id}/delete',[LoanRepaymentController::class,'destroy']);
Route::post('check-quantity',[SalesInvoiceController::class,'checkQuantity']);

Route::resource('transactions', TransactionController::class);
Route::resource('product-categories', ProductCategoryController::class);
Route::resource('units', UnitController::class);
Route::get('units/{id}/delete', [UnitController::class,'destroy']);
Route::resource('payment-methods', PaymentMethodController::class);
Route::get('payment-methods/{id}/delete', [PaymentMethodController::class,'destroy']);
Route::resource('taxes', TaxController::class);
Route::get('taxes/{id}/delete', [TaxController::class,'destroy']);
Route::resource('tax-groups', TaxGroupController::class);
Route::get('tax-groups/{id}/delete', [TaxGroupController::class,'destroy']);
Route::resource('expense-categories', ExpenseCategoryController::class);
Route::get('expense-categories/{id}/delete', [ExpenseCategoryController::class,'destroy']);
Route::resource('expenses', ExpenseController::class);
Route::get('expenses/{id}/delete', [ExpenseController::class,'destroy']);
Route::get('get-tax', [SalesInvoiceController::class,'tax']);

Route::resource('cash-bills', CashBillInvoiceController::class);
Route::get('cash-bills/{id}/delete',[CashBillInvoiceController::class,'destroy']);

Route::resource('sales-return-invoices', SalesReturnInvoiceController::class);
Route::get('sales-return-invoices/{id}/delete',[SalesReturnInvoiceController::class,'destroy']);

Route::resource('purchase-return-invoices', PurchaseReturnInvoiceController::class);
Route::get('purchase-return-invoices/{id}/delete',[PurchaseReturnInvoiceController::class,'destroy']);

Route::get('stock-report', [ReportController::class, 'stockReport']);
Route::get('product-report', [ReportController::class, 'productReport']);
Route::get('customer-report', [ReportController::class, 'customerReport']);
Route::get('reports-customer-invoice/{id}', [ReportController::class, 'customerReportShow']);
Route::get('supplier-report', [ReportController::class, 'supplierReport']);
Route::get('reports-supplier-invoice/{id}', [ReportController::class, 'supplierReportShow']);
Route::get('sales-invoice-report', [ReportController::class, 'salesReport']);
Route::get('sales-return-invoice-report', [ReportController::class, 'salesreturnReport']);
Route::get('purchase-return-invoice-report', [ReportController::class, 'purchasereturnReport']);
Route::get('purchase-invoice-report', [ReportController::class, 'purchaseReport']);
Route::get('cashbill-report', [ReportController::class, 'cashBillReport']);
Route::get('hsn-report', [ReportController::class, 'hsnReport']);


Route::resource('subcategories', SubCategoryController::class);

Route::get('/get-subcategories/{id}', [App\Http\Controllers\ProductController::class, 'getSubcategoriesAndHsn']);
Route::resource('customer-types', \App\Http\Controllers\CustomerTypeController::class);
Route::get('customer-types/{id}/delete', [\App\Http\Controllers\CustomerTypeController::class, 'destroy']);

Route::resource('stores', StoreController::class);
Route::get('stores/{id}/delete', [StoreController::class, 'destroy']);

Route::resource('variations', VariationController::class);
Route::get('variations/{id}/delete', [VariationController::class, 'destroy']);


Route::resource('brands', BrandController::class)->middleware('auth');
Route::resource('types', TypeController::class)->middleware('auth');


Route::get('/get-customer-by-phone', function (Request $request) {
    $phone = $request->query('phone');
    $customer = Customer::where('phone', $phone)->first();

    return response()->json($customer);
});

Route::get('/get-item-by-barcode', function (Request $request) {
    $barcode = $request->query('barcode');

    $item = Product::where('barcode', $barcode)->first();

    if ($item) {
        return response()->json([
            'barcode' => $item->barcode,
            'id' => $item->id,
            'name' => $item->name,
            'price' => $item->sale_price
        ]);
    } else {
        return response()->json(null);
    }
});


Route::get('/products/{product}/labels', function(\App\Models\Product $product){
    return view('products.labels', compact('product'));
});

// routes/web.php
Route::get('/get-product-types/{subcategory}', function ($subcategoryId) {
    return \App\Models\Type::where('subcategory_id', $subcategoryId)
        ->pluck('name', 'id');
});

Route::get('/get-item-by-id', [ProductController::class, 'getItemById']);

 Route::get('purchase-settings', [SettingController::class, 'purchaseNumberEdit']);
    Route::put('purchase-settings/{id}', [SettingController::class, 'purchaseNumberUpdate']);

    // Sales Number
    Route::get('sales-settings', [SettingController::class, 'salesNumberEdit']);
    Route::put('sales-settings/{id}', [SettingController::class, 'salesNumberUpdate']);

    // Cash Bill Number
    Route::get('cashbill-settings', [SettingController::class, 'cashbillNumberEdit']);
    Route::put('cashbill-settings/{id}', [SettingController::class, 'cashbillNumberUpdate']);