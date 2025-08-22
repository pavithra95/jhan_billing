<nav class="sidebar">
   <div class="sidebar-header">
      <a href="#" class="sidebar-brand">
      KG GL
      </a>
      <div class="sidebar-toggler not-active">
         <span></span>
         <span></span>
         <span></span>
      </div>
   </div>
   <div class="sidebar-body">
      <ul class="nav">
         <li class="nav-item nav-category">Main</li>
         <li class="nav-item ">
            <a href="/home" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
            </a>
         </li>
        
         <li class="nav-item nav-category">Sales</li>
         
     <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#customer" role="button" aria-expanded="" aria-controls="customer">
            <i class="link-icon" data-feather="users"></i>
            <span class="link-title">Customer</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="customer">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/customers/create" class="nav-link">New Customer</a>
                  </li>
                  <li class="nav-item">
                     <a href="/customers" class="nav-link">Manage Customer</a>
                  </li> 
                  <li class="nav-item">
                     <a href="/customer-types" class="nav-link">Customer Type</a>
                  </li>
               </ul>
            </div>
         </li>

        
     <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#sale" role="button" aria-expanded="" aria-controls="sale">
            <i class="link-icon" data-feather="clipboard"></i>
            <span class="link-title">Sales</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="sale">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/sales-invoices/create" class="nav-link">New Invoice</a>
                  </li>
                  <li class="nav-item">
                     <a href="/sales-invoices" class="nav-link">Manage Invoices</a>
                  </li>
          <!-- <li class="nav-item">
                     <a href="/cash-bills/create" class="nav-link">New CashBill</a>
                  </li>
          <li class="nav-item">
                     <a href="/cash-bills" class="nav-link">Manage CashBill</a>
                  </li> -->
               </ul>
            </div>
         </li>
		 
     <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#products" role="button" aria-expanded="" aria-controls="products">
            <i class="link-icon" data-feather="archive"></i>
            <span class="link-title">Products</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="products">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/products/create" class="nav-link">New Product</a>
                  </li>
          <li class="nav-item">
                     <a href="/products" class="nav-link">Manage Products</a>
                  </li>
                  <li class="nav-item">
                     <a href="/product-categories" class="nav-link">Product Category</a>
                  </li>
                  <li class="nav-item">
                     <a href="/subcategories" class="nav-link">Sub Category</a>
                  </li> 
                  <li class="nav-item">
                     <a href="/types" class="nav-link">Type</a>
                  </li> 
                  <li class="nav-item">
                     <a href="/brands" class="nav-link">Brand</a>
                  </li>
                  <li class="nav-item">
                     <a href="/size" class="nav-link">Size</a>
                  </li>
               </ul>
            </div>
         </li>
     <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#supplier" role="button" aria-expanded="" aria-controls="supplier">
            <i class="link-icon" data-feather="user-check"></i>
            <span class="link-title">Supplier</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="supplier">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/vendors/create" class="nav-link">New Supplier</a>
                  </li>
                  <li class="nav-item">
                     <a href="/vendors" class="nav-link">Manage Supplier</a>
                  </li>
               </ul>
            </div>
         </li>
     <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#purchase" role="button" aria-expanded="" aria-controls="purchase">
            <i class="link-icon" data-feather="plus-square"></i>
            <span class="link-title">Purchase</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="purchase">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/purchase-invoices/create" class="nav-link">New Purchase</a>
                  </li>
                  <li class="nav-item">
                     <a href="/purchase-invoices" class="nav-link">Manage Purchase</a>
                  </li>
               </ul>
            </div>
         </li>
		 
		 <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#return" role="button" aria-expanded="" aria-controls="return">
            <i class="link-icon" data-feather="clipboard"></i>
            <span class="link-title">Returns</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="return">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/sales-return-invoices/create" class="nav-link">New Sale Return</a>
                  </li>
                  <li class="nav-item">
                     <a href="/sales-return-invoices" class="nav-link">Manage Sale Return</a>
                  </li>
				  <li class="nav-item">
					 <a href="/purchase-return-invoices/create" class="nav-link">New Purchase Return</a>
				  </li>
				  <li class="nav-item">
					 <a href="/purchase-return-invoices" class="nav-link">Manage Purchase Return</a>
				  </li>
               </ul>
            </div>
         </li>
		 
     <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#expenses" role="button" aria-expanded="" aria-controls="expenses">
            <i class="link-icon" data-feather="corner-right-up"></i>
            <span class="link-title">Expenses</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="expenses">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/expenses/create" class="nav-link">New Expenses</a>
                  </li>
                  <li class="nav-item">
                     <a href="/expenses" class="nav-link">Manage Expenses</a>
                  </li>
          <li class="nav-item">
                     <a href="/expense-categories" class="nav-link">Expenses Category</a>
                  </li>
               </ul>
            </div>
         </li>
         @if(auth()->user()->privilege == "admin")
     <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#taxes" role="button" aria-expanded="" aria-controls="taxes">
            <i class="link-icon" data-feather="tag"></i>
            <span class="link-title">Taxes</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="taxes">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/taxes" class="nav-link">Taxes</a>
                  </li>
                  <li class="nav-item">
                     <a href="/tax-groups" class="nav-link">Tax Group</a>
                  </li>
               </ul>
            </div>
         </li>
     <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#units" role="button" aria-expanded="" aria-controls="units">
            <i class="link-icon" data-feather="filter"></i>
            <span class="link-title">Units</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="units">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/units/create" class="nav-link">Add Units</a>
                  </li>
                  <li class="nav-item">
                     <a href="/units" class="nav-link">Manage Units</a>
                  </li>
               </ul>
            </div>
         </li> -->
         @if(auth()->user()->privilege == "admin")
     <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#reports" role="button" aria-expanded="" aria-controls="reports">
            <i class="link-icon" data-feather="hard-drive"></i>
            <span class="link-title">Reports</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="reports">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/stock-report" class="nav-link">Stock Report</a>
                  </li>
                  <li class="nav-item">
                     <a href="/purchase-invoice-report" class="nav-link">Purchase Report</a>
                  </li>
          <li class="nav-item">
                     <a href="/sales-invoice-report" class="nav-link">Sales Invoice Report</a>
                  </li>
                  <li class="nav-item">
                     <a href="/purchase-return-invoice-report" class="nav-link">Purchase Return Report</a>
                  </li>
                  <li class="nav-item">
                     <a href="/sales-return-invoice-report" class="nav-link">Sales Return Report</a>
                  </li>
          <!-- <li class="nav-item">
                     <a href="/cashbill-report" class="nav-link">CashBill Report</a>
                  </li> -->
          <li class="nav-item">
                     <a href="/product-report" class="nav-link">Product Report</a>
                  </li>
                  <li class="nav-item">
                     <a href="/hsn-report" class="nav-link">HSN Report</a>
                  </li>
          <li class="nav-item">
                     <a href="/supplier-report" class="nav-link">Supplier Report</a>
                  </li>
          <li class="nav-item">
                     <a href="/customer-report" class="nav-link">Customer Report</a>
                  </li>
        {{--   <li class="nav-item">
                     <a href="/tax-report" class="nav-link">Tax Report</a>
                  </li> --}}
               </ul>
            </div>
         </li>
         @endif
     <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#paymenttype" role="button" aria-expanded="" aria-controls="paymenttype">
            <i class="link-icon" data-feather="credit-card"></i>
            <span class="link-title">Payment Type</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="paymenttype">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/payment-methods/create" class="nav-link">New Payment Type</a>
                  </li>
                  <li class="nav-item">
                     <a href="/payment-methods" class="nav-link">Manage Payment Type</a>
                  </li>
               </ul>
            </div>
         </li>
     <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#users" role="button" aria-expanded="" aria-controls="users">
            <i class="link-icon" data-feather="user"></i>
            <span class="link-title">Users</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="users">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/register" class="nav-link">New User</a>
                  </li>
                  <li class="nav-item">
                     <a href="/users" class="nav-link">Manage User</a>
                  </li>
               </ul>
            </div>
         </li>
   
         <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#settings" role="button" aria-expanded="" aria-controls="settings">
            <i class="link-icon" data-feather="settings"></i>
            <span class="link-title">Settings</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse" id="settings">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/purchase-settings" class="nav-link">Purchase Settings</a>
                  </li>
                   <li class="nav-item">
                     <a href="/sales-settings" class="nav-link">Sales Settings</a>
                  </li>
                   <!-- <li class="nav-item">
                     <a href="/cashbill-settings" class="nav-link">Cash Bill Settings</a>
                  </li> -->
                  <!-- <li class="nav-item">
                     <a href="/stores" class="nav-link">Stores</a>
                  </li>
                  <li class="nav-item">
                     <a href="/variations" class="nav-link">Variations</a>
                  </li> -->
                
               </ul>
            </div>
         </li>
         @endif
         <!--<li class="nav-item nav-category">Sales</li>
         <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#email" role="button" aria-expanded="" aria-controls="email">
            <i class="link-icon" data-feather="mail"></i>
            <span class="link-title">Purchase</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse"  id="email">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/vendors" class="nav-link ">Suppliers</a>
                  </li>
                  <li class="nav-item">
                     <a href="/purchase-invoices" class="nav-link ">Purchase Invoice</a>
                  </li>
               </ul>
            </div>
         </li>
         <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#email" role="button" aria-expanded="" aria-controls="email">
            <i class="link-icon" data-feather="mail"></i>
            <span class="link-title">Products</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse"  id="email">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/products" class="nav-link ">Products</a>
                  </li>
                  <li class="nav-item">
                     <a href="/product-categories" class="nav-link ">Product Category</a>
                  </li>
               </ul>
            </div>
         </li>
         <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#email" role="button" aria-expanded="" aria-controls="email">
            <i class="link-icon" data-feather="mail"></i>
            <span class="link-title">Tax</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse"  id="email">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/taxes" class="nav-link ">Tax</a>
                  </li>
                  <li class="nav-item">
                     <a href="/tax-groups" class="nav-link ">Tax Group</a>
                  </li>
               </ul>
            </div>
         </li>
         <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#email" role="button" aria-expanded="" aria-controls="email">
            <i class="link-icon" data-feather="mail"></i>
            <span class="link-title">Expense</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse"  id="email">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="/expenses" class="nav-link ">Expense</a>
                  </li>
                  <li class="nav-item">
                     <a href="/expense-categories" class="nav-link ">Expense Category</a>
                  </li>
               </ul>
            </div>
         </li>
         <li class="nav-item">
            <a href="/units" class="nav-link">
            <i class="link-icon" data-feather="hash"></i>
            <span class="link-title">Units</span>
            </a>
         </li>
         <li class="nav-item">
            <a href="/payment-methods" class="nav-link">
            <i class="link-icon" data-feather="hash"></i>
            <span class="link-title">Payment Methods</span>
            </a>
         </li>
         <li class="nav-item">
            <a href="/reports" class="nav-link">
            <i class="link-icon" data-feather="hash"></i>
            <span class="link-title">Report</span>
            </a>
         </li>
         <li class="nav-item">
            <a href="/users" class="nav-link">
            <i class="link-icon" data-feather="hash"></i>
            <span class="link-title">Users</span>
            </a>
         </li>
         {{--  
         <li class="nav-item {{ active_class(['apps/chat']) }}">
            <a href="{{ url('/apps/chat') }}" class="nav-link">
            <i class="link-icon" data-feather="message-square"></i>
            <span class="link-title">Chat</span>
            </a>
         </li>
         <li class="nav-item {{ active_class(['apps/calendar']) }}">
            <a href="{{ url('/apps/calendar') }}" class="nav-link">
            <i class="link-icon" data-feather="calendar"></i>
            <span class="link-title">Calendar</span>
            </a>
         </li>
         <li class="nav-item nav-category">Components</li>
         <li class="nav-item {{ active_class(['ui-components/*']) }}">
            <a class="nav-link" data-toggle="collapse" href="#uiComponents" role="button" aria-expanded="{{ is_active_route(['ui-components/*']) }}" aria-controls="uiComponents">
            <i class="link-icon" data-feather="feather"></i>
            <span class="link-title">UI Kit</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse {{ show_class(['ui-components/*']) }}" id="uiComponents">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/alerts') }}" class="nav-link {{ active_class(['ui-components/alerts']) }}">Alerts</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/badges') }}" class="nav-link {{ active_class(['ui-components/badges']) }}">Badges</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/breadcrumbs') }}" class="nav-link {{ active_class(['ui-components/breadcrumbs']) }}">Breadcrumbs</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/buttons') }}" class="nav-link {{ active_class(['ui-components/buttons']) }}">Buttons</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/button-group') }}" class="nav-link {{ active_class(['ui-components/button-group']) }}">Button group</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/cards') }}" class="nav-link {{ active_class(['ui-components/cards']) }}">Cards</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/collapse') }}" class="nav-link {{ active_class(['ui-components/collapse']) }}">Collapse</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/dropdowns') }}" class="nav-link {{ active_class(['ui-components/dropdowns']) }}">Dropdowns</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/list-group') }}" class="nav-link {{ active_class(['ui-components/list-group']) }}">List group</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/media-object') }}" class="nav-link {{ active_class(['ui-components/media-object']) }}">Media object</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/modal') }}" class="nav-link {{ active_class(['ui-components/modal']) }}">Modal</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/navs') }}" class="nav-link {{ active_class(['ui-components/navs']) }}">Navs</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/navbar') }}" class="nav-link {{ active_class(['ui-components/navbar']) }}">Navbar</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/pagination') }}" class="nav-link {{ active_class(['ui-components/pagination']) }}">Pagination</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/popovers') }}" class="nav-link {{ active_class(['ui-components/popovers']) }}">Popvers</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/progress') }}" class="nav-link {{ active_class(['ui-components/progress']) }}">Progress</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/scrollbar') }}" class="nav-link {{ active_class(['ui-components/scrollbar']) }}">Scrollbar</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/scrollspy') }}" class="nav-link {{ active_class(['ui-components/scrollspy']) }}">Scrollspy</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/spinners') }}" class="nav-link {{ active_class(['ui-components/spinners']) }}">Spinners</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/tabs') }}" class="nav-link {{ active_class(['ui-components/tabs']) }}">Tabs</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/ui-components/tooltips') }}" class="nav-link {{ active_class(['ui-components/tooltips']) }}">Tooltips</a>
                  </li>
               </ul>
            </div>
         </li>
         <li class="nav-item {{ active_class(['advanced-ui/*']) }}">
            <a class="nav-link" data-toggle="collapse" href="#advanced-ui" role="button" aria-expanded="{{ is_active_route(['advanced-ui/*']) }}" aria-controls="advanced-ui">
            <i class="link-icon" data-feather="anchor"></i>
            <span class="link-title">Advanced UI</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse {{ show_class(['advanced-ui/*']) }}" id="advanced-ui">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="{{ url('/advanced-ui/cropper') }}" class="nav-link {{ active_class(['advanced-ui/cropper']) }}">Cropper</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/advanced-ui/owl-carousel') }}" class="nav-link {{ active_class(['advanced-ui/owl-carousel']) }}">Owl Carousel</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/advanced-ui/sweet-alert') }}" class="nav-link {{ active_class(['advanced-ui/sweet-alert']) }}">Sweet Alert</a>
                  </li>
               </ul>
            </div>
         </li>
         <li class="nav-item {{ active_class(['forms/*']) }}">
            <a class="nav-link" data-toggle="collapse" href="#forms" role="button" aria-expanded="{{ is_active_route(['forms/*']) }}" aria-controls="forms">
            <i class="link-icon" data-feather="inbox"></i>
            <span class="link-title">Forms</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse {{ show_class(['forms/*']) }}" id="forms">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="{{ url('/forms/basic-elements') }}" class="nav-link {{ active_class(['forms/basic-elements']) }}">Basic Elements</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/forms/advanced-elements') }}" class="nav-link {{ active_class(['forms/advanced-elements']) }}">Advanced Elements</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/forms/editors') }}" class="nav-link {{ active_class(['forms/editors']) }}">Editors</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/forms/wizard') }}" class="nav-link {{ active_class(['forms/wizard']) }}">Wizard</a>
                  </li>
               </ul>
            </div>
         </li>
         <li class="nav-item {{ active_class(['charts/*']) }}">
            <a class="nav-link" data-toggle="collapse" href="#charts" role="button" aria-expanded="{{ is_active_route(['charts/*']) }}" aria-controls="charts">
            <i class="link-icon" data-feather="pie-chart"></i>
            <span class="link-title">Charts</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse {{ show_class(['charts/*']) }}" id="charts">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="{{ url('/charts/apex') }}" class="nav-link {{ active_class(['charts/apex']) }}">Apex</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/charts/chartjs') }}" class="nav-link {{ active_class(['charts/chartjs']) }}">ChartJs</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/charts/flot') }}" class="nav-link {{ active_class(['charts/flot']) }}">Flot</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/charts/morrisjs') }}" class="nav-link {{ active_class(['charts/morrisjs']) }}">MorrisJs</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/charts/peity') }}" class="nav-link {{ active_class(['charts/peity']) }}">Peity</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/charts/sparkline') }}" class="nav-link {{ active_class(['charts/sparkline']) }}">Sparkline</a>
                  </li>
               </ul>
            </div>
         </li>
         <li class="nav-item {{ active_class(['tables/*']) }}">
            <a class="nav-link" data-toggle="collapse" href="#tables" role="button" aria-expanded="{{ is_active_route(['tables/*']) }}" aria-controls="tables">
            <i class="link-icon" data-feather="layout"></i>
            <span class="link-title">Tables</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse {{ show_class(['tables/*']) }}" id="tables">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="{{ url('/tables/basic-tables') }}" class="nav-link {{ active_class(['tables/basic-tables']) }}">Basic Tables</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/tables/data-table') }}" class="nav-link {{ active_class(['tables/data-table']) }}">Data Table</a>
                  </li>
               </ul>
            </div>
         </li>
         <li class="nav-item {{ active_class(['icons/*']) }}">
            <a class="nav-link" data-toggle="collapse" href="#icons" role="button" aria-expanded="{{ is_active_route(['icons/*']) }}" aria-controls="icons">
            <i class="link-icon" data-feather="smile"></i>
            <span class="link-title">Icons</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse {{ show_class(['icons/*']) }}" id="icons">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="{{ url('/icons/feather-icons') }}" class="nav-link {{ active_class(['icons/feather-icons']) }}">Feather Icons</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/icons/flag-icons') }}" class="nav-link {{ active_class(['icons/flag-icons']) }}">Flag Icons</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/icons/mdi-icons') }}" class="nav-link {{ active_class(['icons/mdi-icons']) }}">Mdi Icons</a>
                  </li>
               </ul>
            </div>
         </li>
         <li class="nav-item nav-category">Pages</li>
         <li class="nav-item {{ active_class(['general/*']) }}">
            <a class="nav-link" data-toggle="collapse" href="#general" role="button" aria-expanded="{{ is_active_route(['general/*']) }}" aria-controls="general">
            <i class="link-icon" data-feather="book"></i>
            <span class="link-title">Special Pages</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse {{ show_class(['general/*']) }}" id="general">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="{{ url('/general/blank-page') }}" class="nav-link {{ active_class(['general/blank-page']) }}">Blank page</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/general/faq') }}" class="nav-link {{ active_class(['general/faq']) }}">Faq</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/general/invoice') }}" class="nav-link {{ active_class(['general/invoice']) }}">Invoice</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/general/profile') }}" class="nav-link {{ active_class(['general/profile']) }}">Profile</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/general/pricing') }}" class="nav-link {{ active_class(['general/pricing']) }}">Pricing</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/general/timeline') }}" class="nav-link {{ active_class(['general/timeline']) }}">Timeline</a>
                  </li>
               </ul>
            </div>
         </li>
         <li class="nav-item {{ active_class(['auth/*']) }}">
            <a class="nav-link" data-toggle="collapse" href="#auth" role="button" aria-expanded="{{ is_active_route(['auth/*']) }}" aria-controls="auth">
            <i class="link-icon" data-feather="unlock"></i>
            <span class="link-title">Authentication</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse {{ show_class(['auth/*']) }}" id="auth">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="{{ url('/auth/login') }}" class="nav-link {{ active_class(['auth/login']) }}">Login</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/auth/register') }}" class="nav-link {{ active_class(['auth/register']) }}">Register</a>
                  </li>
               </ul>
            </div>
         </li>
         <li class="nav-item {{ active_class(['error/*']) }}">
            <a class="nav-link" data-toggle="collapse" href="#error" role="button" aria-expanded="{{ is_active_route(['error/*']) }}" aria-controls="error">
            <i class="link-icon" data-feather="cloud-off"></i>
            <span class="link-title">Error</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse {{ show_class(['error/*']) }}" id="error">
               <ul class="nav sub-menu">
                  <li class="nav-item">
                     <a href="{{ url('/error/404') }}" class="nav-link {{ active_class(['error/404']) }}">404</a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ url('/error/500') }}" class="nav-link {{ active_class(['error/500']) }}">500</a>
                  </li>
               </ul>
            </div>
         </li>
         <li class="nav-item nav-category">Docs</li>
         <li class="nav-item">
            <a href="https://www.nobleui.com/laravel/documentation/docs.html" target="_blank" class="nav-link">
            <i class="link-icon" data-feather="hash"></i>
            <span class="link-title">Documentation</span>
            </a>
         </li>
         --}}-->
      </ul>
   </div>
</nav>