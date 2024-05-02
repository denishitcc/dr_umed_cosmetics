@extends('layouts.sidebar')
@section('content')
<!-- Page content wrapper-->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>   -->
  <!-- <main> -->
          <div class="card">
              <div class="card-head">
              <div class="toolbar mb-0">
                <div class="tool-left">
                    <h4 class="small-title mb-0">Finance Management</h4>
                </div>
                <div class="tool-right">
                    <a href="#" class="btn btn-primary btn-md make_sale">Make Sale</a>
                </div>
            </div>
                
              </div>
              <div class="card-head py-3">
                <div class="toolbar">
                    <div class="tool-left">
                        <!-- <div class="cst-drop-select"><select class="location" multiple="multiple" id="MultiSelect_DefaultValues"></select></div> -->
                        <div class="tool-right">
                        <select class="form-select" id="locations">
                            @if(count($locations)>0)
                                @foreach($locations as $loc)
                                    <option value="{{$loc->id}}">{{$loc->location_name}}</option>
                                @endforeach
                            @endif
                        </select>
                        </div>
                    </div>
                </div>
            </div>
              <div class="card-body">
              <div class="row">
                        <table class="table data-table all-db-table align-middle display" style="width:100%;">
                        <thead>
                          <tr>
                            <th>Invoice</th>
                            <th>Client</th>
                            <th>Location</th>
                            <th>Product/Service</th>
                            <th>Type</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Time</th>
                            <th>Total</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
              </div>
          </div>
  <!-- </main> -->
<div class="modal fade" id="paid_Invoice" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">Paid invoice</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="invo-notice mb-4">
                    <div class="inv-left"><b id="invoiceDate"></b></div>
                    <div class="inv-number">Invoice number: <span id="invoiceNumber"></span></div>
                </div>
                <div class="table-responsive mb-2">
                    <!-- Product table -->
                    <table class="table all-db-table align-middle mb-4" id="productTable">
                        <!-- Table header -->
                        <thead>
                            <tr>
                                <th class="mine-shaft" width="55%">Items</th>
                                <th class="mine-shaft" width="20%">Quantity</th>
                                <th class="mine-shaft" width="25%">Price</th>
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody id="productTableBody">
                            <!-- Product rows will be dynamically added here -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"><b>Subtotal</b></td>
                                <td id="subtotalProductPrice">
                                    <span class="blue-bold">$2,217.00 </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><b class="prd_dis">Discount</b></td>
                                <td id="discountProductPrice">
                                    <span class="blue-bold">$2,217.00 </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>Total</b></td>
                                <td id="totalProductPrice">
                                    <span class="blue-bold">$2,217.00 </span><br>
                                    <span class="d-grey font-13" id="totalProductPriceGST">Includes GST of $20.55</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- Payment table -->
                <div class="table-responsive mb-2">
                    <table class="table all-db-table align-middle mb-4" id="paymentTable">
                        <!-- Table header -->
                        <thead>
                            <tr>
                                <th class="mine-shaft" width="55%">Payments</th>
                                <th class="mine-shaft" width="20%">Date</th>
                                <th class="mine-shaft" width="25%">Price</th>
                            </tr>
                        </thead>
                        <!-- Table body -->
                        <tbody>
                            <!-- Payment rows will be dynamically added here -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"><b>Total paid</b></td>
                                <td id="totalPaid">
                                    <span class="blue-bold">$2,217.00 </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- Receipt form -->
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Send receipt by email</strong></label>
                    <div class="row">
                        <div class="col-lg-10">
                            <input type="text" class="form-control send_email_receipt" placeholder="admin@tenderresponse.com.au (use comma for multiple email)">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary btn-md send_receipt_payment_mail">Send</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-md delete_invoice" delete_id="">Delete</button>   
                <button type="button" class="btn btn-light btn-md edit_invoice" edit_id="">Edit</button>   
                <button type="button" class="btn btn-light btn-md cancel_invoice">Cancel</button>
                <button type="button" class="btn btn-primary btn-md print_invoice" ids="">Print</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Walkin_Retail" tabindex="-1">
    <input type="hidden" id="customer_type" value="casual">
    <input type="hidden" class="edited_total" value="0">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content main_walk_in">
            <div class="modal-header">
                <h4 class="modal-title">Walk-in retail sale @ <span class="walkin_loc_name">Hope Island</span></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <ul class="nav nav-pills nav-fill nav-group mb-3 main_walkin" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active casual_cus" data-bs-toggle="tab" href="#casual_customer" aria-selected="true" role="tab">Casual Customer <i class="ico-tick ms-1"></i></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link new_cus" data-bs-toggle="tab" href="#new_customer" aria-selected="true" role="tab">New Customer <i class="ico-tick ms-1"></i></a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link existing_cus" data-bs-toggle="tab" href="#exist_customer" aria-selected="true" role="tab">Existing Customer <i class="ico-tick ms-1"></i></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <form id="create_walkin_casual" name="create_walkin_casual" class="form casual_tab" method="post">
                        @csrf
                        <input type="hidden" id="invoice_id" name="invoice_id" value="" class="invoice_id">
                        <input type="hidden" name="total_selected_product" id="total_selected_product" value="0" class="total_selected_product">
                        <input type="hidden" name="walk_in_location_id" id="walk_in_location_id" class="walk_in_location_id">
                        <input type="hidden" name="walk_in_client_id" id="walk_in_client_id" class="walk_in_client_id">
                        <input type="hidden" name="hdn_customer_type" id="hdn_customer_type" value="casual">
                        <input type='hidden' id="hdn_subtotal" name='hdn_subtotal' value='0' class="hdn_subtotal">
                        <input type='hidden' id="hdn_total" name='hdn_total' value='0' class="hdn_total">
                        <input type='hidden' id="hdn_gst" name='hdn_gst' value='0' class="hdn_gst">
                        <input type='hidden' id="hdn_discount" name='hdn_discount' value='0' class="hdn_discount">

                        <!--discount hidden fields-->
                        <input type='hidden' id="hdn_main_discount_surcharge" name='hdn_main_discount_surcharge' class="hdn_main_discount_surcharge" value='No Discount'>
                        <input type='hidden' id="hdn_main_discount_type" name='hdn_main_discount_type' class="hdn_main_discount_type" value='amount'>
                        <input type='hidden' id="hdn_main_discount_amount" name='hdn_main_discount_amount' class="hdn_main_discount_amount" value='0'>
                        <input type='hidden' id="hdn_main_discount_reason" name='hdn_main_discount_reason' value='' class="hdn_main_discount_reason">
                        <div class="tab-pane fade show active" id="casual_customer" role="tabpanel">
                            @include('calender.partials.walk-in')
                        </div>
                    </form>
                    <form id="create_walkin_new" name="create_walkin_new" class="form new_tab" method="post" style="display:none;">
                        @csrf
                        <input type="hidden" id="invoice_id" name="invoice_id" value="" class="invoice_id">
                        <input type="hidden" name="total_selected_product" id="total_selected_product" value="0" class="total_selected_product">
                        <input type="hidden" name="walk_in_location_id" id="walk_in_location_id" class="walk_in_location_id">
                        <input type="hidden" name="walk_in_client_id" id="walk_in_client_id" class="walk_in_client_id">
                        <input type="hidden" name="hdn_customer_type" id="hdn_customer_type" value="new">
                        <input type='hidden' id="hdn_subtotal" name='hdn_subtotal' value='0' class="hdn_subtotal">
                        <input type='hidden' id="hdn_total" name='hdn_total' value='0' class="hdn_total">
                        <input type='hidden' id="hdn_gst" name='hdn_gst' value='0' class="hdn_gst">
                        <input type='hidden' id="hdn_discount" name='hdn_discount' value='0' class="hdn_discount">

                        <!--discount hidden fields-->
                        <input type='hidden' id="hdn_main_discount_surcharge" name='hdn_main_discount_surcharge' class="hdn_main_discount_surcharge" value='No Discount'>
                        <input type='hidden' id="hdn_main_discount_type" name='hdn_main_discount_type' value='amount' class="hdn_main_discount_type">
                        <input type='hidden' id="hdn_main_discount_amount" name='hdn_main_discount_amount' value='0' class="hdn_main_discount_amount">
                        <input type='hidden' id="hdn_main_discount_reason" name='hdn_main_discount_reason' value='' class="hdn_main_discount_reason">
                        <div class="tab-pane fade show" id="new_customer" role="tabpanel">
                            <div class="row">
                                <div class="form-group icon col-lg-4">
                                    <label>First Name</label>
                                    <input type="text" id="walkin_first_name" name="walkin_first_name" class="form-control" placeholder="First">
                                </div>
                                <div class="form-group icon col-lg-4">
                                    <label>Last Name</label>
                                    <input type="text" id="walkin_last_name" name="walkin_last_name" class="form-control" placeholder="Last">
                                </div>
                                <div class="form-group icon col-lg-4">
                                    <label>Email</label>
                                    <input type="text" id="walkin_email" name="walkin_email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group icon col-lg-4">
                                    <label>Phone</label>
                                        <select class="form-select form-control" name="walkin_phone_type" id="walkin_phone_type">
                                            <option selected="" value=""> -- select an option -- </option>
                                            <option>Mobile</option>
                                            <option>Home</option>
                                            <option>Work</option>
                                        </select>
                                </div>
                                <div class="form-group icon col-lg-4">
                                    <label></label>
                                    <input type="text" id="walkin_phone_no" name="walkin_phone_no" class="form-control">
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Gender</label>
                                    <div class="toggle form-group">
                                        <input type="radio" name="walkin_gender" value="Male" id="males" checked="checked" />
                                        <label for="males">Male <i class="ico-tick"></i></label>
                                        <input type="radio" name="walkin_gender" value="Female" id="females" />
                                        <label for="females">Female <i class="ico-tick"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="form-label">Preferred contact method</label>
                                        <select class="form-select form-control" name="walkin_contact_method" id="walkin_contact_method">
                                            <option selected="" value=""> -- select an option -- </option>
                                            <option>Text message (SMS)</option>
                                            <option>Email</option>
                                            <option>Phone call</option>
                                            <option>Post</option>
                                            <option>No preference</option>
                                            <option>Don't send reminders</option>
                                        </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Send promotions</label>
                                    <div class="toggle mb-0">
                                        <input type="radio" name="walkin_send_promotions" value="1" id="walkin_yes" checked="checked">
                                        <label for="walkin_yes">Yes <i class="ico-tick"></i></label>
                                        <input type="radio" name="walkin_send_promotions" value="0" id="walkin_no">
                                        <label for="walkin_no">No <i class="ico-tick"></i></label>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            @include('calender.partials.walk-in')
                        </div>
                    </form>
                    <form id="create_walkin_existing" name="create_walkin_existing" class="form existing_tab" method="post" style="display:none;">
                        @csrf
                        <input type="hidden" id="invoice_id" name="invoice_id" value="" class="invoice_id">
                        <input type="hidden" name="total_selected_product" id="total_selected_product" value="0" class="total_selected_product">
                        <input type="hidden" name="walk_in_location_id" id="walk_in_location_id" class="walk_in_location_id">
                        <input type="hidden" name="walk_in_client_id" id="walk_in_client_id" class="walk_in_client_id">
                        <input type="hidden" name="hdn_customer_type" id="hdn_customer_type" value="existing">
                        <input type='hidden' id="hdn_subtotal" name='hdn_subtotal' value='0' class="hdn_subtotal">
                        <input type='hidden' id="hdn_total" name='hdn_total' value='0' class="hdn_total">
                        <input type='hidden' id="hdn_gst" name='hdn_gst' value='0' class="hdn_gst">
                        <input type='hidden' id="hdn_discount" name='hdn_discount' value='0' class="hdn_discount">

                        <!--discount hidden fields-->
                        <input type='hidden' id="hdn_main_discount_surcharge" name='hdn_main_discount_surcharge' class="hdn_main_discount_surcharge" value='No Discount'>
                        <input type='hidden' id="hdn_main_discount_type" name='hdn_main_discount_type' value='amount' class="hdn_main_discount_type">
                        <input type='hidden' id="hdn_main_discount_amount" name='hdn_main_discount_amount' value='0' class="hdn_main_discount_amount">
                        <input type='hidden' id="hdn_main_discount_reason" name='hdn_main_discount_reason' value='' class="hdn_main_discount_reason">
                        <div class="tab-pane fade show" id="exist_customer" role="tabpanel">
                            <div class="form-group icon client_search_bar">
                                <input type="text" id="search_exist_customer" class="form-control " autocomplete="off" placeholder="Search for a client" onkeyup="changeExistingCutomerInput(this.value)">
                                <i class="ico-search"></i>
                                <div id="result1" class="list-group"></div>
                            </div>
                            <div class="existing_client_list_box" style="display:none;">
                                <ul class="drop-list" id="resultexistingmodal"></ul>
                            </div>
                            <div class="mb-5" id="existingclientmodal"  style="display:none;">
                                <div class="one-inline align-items-center mb-2">
                                    <span class="custname me-3" id="existingclientDetailsModal"> </span>
                                    <input type="hidden" name="clientname" id="clientName">
                                    <button type="button" class="btn btn-primary btn-md existing_client_change">Change</button>
                                </div>
                                <em class="d-grey font-12 btn-light">No recent appointments found</em>
                            </div>
                            @include('calender.partials.walk-in')
                            </div>
                        </div>
                    </form>
                </div>
            
                <div class="modal-footer justify-content-between">
                    <div class="mod-ft-left d-flex gap-2">
                        <button type="button" class="btn btn-light-outline-grey btn-md icon-btn-left print_quote"><i class="ico-print3 me-2 fs-6"></i> Print Quote</button>
                        <!-- <button type="button" class="btn btn-light-outline-grey btn-md icon-btn-left"><i class="ico-draft me-2 fs-6"></i> Save sale as a draft</button> -->
                    </div>
                    <div class="mod-ft-right">
                        <button type="button" class="btn btn-light btn-md cancel_payment">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-md take_payment" main_total="" main_remain="">Take Payment</button>
                    </div>
                </div>
            </div>
            <div class="modal-content edit_product" style="display:none;">
                <div class="modal-header" id="edit_product">
                    <h4 class="modal-title">Edit Product</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="invo-notice mb-4">
                        <input type="hidden" name="edit_product_id" id="edit_product_id">
                        <div class="inv-left"><b class="edit_product_name">VIP Skin treatment</b><div id="dynamic_discount"></div></div>
                        <div class="inv-number edit_product_quantity"><b>1</b></div>
                        <div class="inv-number edit_product_price"><b>$60.00</b>
                            <div class="main_detail_price" style="display:none;">($60.00)</div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Price per unit</label>
                                <div class="input-group">
                                    <input type="text" class="form-control edit_price_per_unit" placeholder="0">
                                    <span class="input-group-text"><i class="ico-percentage fs-4"></i></span>
                                    </div>
                                </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <div class="number-input safari_only">
                                    <button class="minus edit_minus"></button>
                                    <input  type="number" class="quantity form-control edit_quantity" min="0" name="quantity">
                                    <button class="plus edit_plus"></button>
                                </div>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Who did work</label>
                                <select class="form-select form-control" name="edit_sale_staff_id" id="edit_sale_staff_id">
                                    <option>Please select</option>
                                    @foreach($staffs as $staff)
                                        <option value="{{$staff->id}}">{{$staff->first_name.' '.$staff->last_name}}</option>
                                    @endforeach
                                </select>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Select discount / surcharge</label>
                                <select class="form-select form-control" id="edit_discount_surcharge" name="edit_discount_surcharge">
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <div class="form-group">
                                <label class="form-label mb-3">Discount type </label><br>
                                <label class="cst-radio me-3"><input type="radio" checked="" name="edit_discount_type" id="edit_discount_type" value="amount"><span class="checkmark me-2"></span>Amount</label>
                                <label class="cst-radio"><input type="radio" name="edit_discount_type" id="edit_discount_type" value="percent"><span class="checkmark me-2"></span>Percent</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Amount</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="edit_amount" placeholder="0" min="0">
                                    <span class="input-group-text"><i class="ico-percentage fs-4"></i></span>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Reason</label>
                        <textarea class="form-control" rows="3" placeholder="Add a reason" id="edit_reason"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="mod-ft-left"><button type="button" class="btn btn-light-outline-red btn-md remove_edit_product">Remove</button></div>
                    <div class="mod-ft-right">
                        <button type="button" class="btn btn-light btn-md cancel_product">Cancel</button>
                        <button type="button" class="btn btn-primary btn-md update_product">Update</button>
                    </div>
                </div>
            </div>
            <div class="modal-content main_discount" style="display:none;">
                <input type="hidden" id="discount_customer_type" value="casual">
                <input type="hidden" id="hdn_amt">
                <input type="hidden" id="hdn_dis_type">
                <input type="hidden" id="hdn_discount_surcharge">
                <div class="modal-header" id="main_discount">
                    <h4 class="modal-title">Add discount / surcharge</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Select discount / surcharge</label>
                                <select class="form-select form-control" id="discount_surcharge" name="discount_surcharge">
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-auto">
                        <div class="form-group">
                            <label class="form-label mb-3">Discount type </label><br>
                            <label class="cst-radio me-3"><input type="radio" checked="" name="discount_type" id="discount_type" value="amount"><span class="checkmark me-2"></span>Amount</label>
                            <label class="cst-radio"><input type="radio" name="discount_type" id="discount_type" value="percent"><span class="checkmark me-2"></span>Percent</label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Amount</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="amount" placeholder="0" min="0">
                                <span class="input-group-text"><i class="ico-percentage fs-4"></i></span>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Reason</label>
                        <textarea class="form-control" rows="7" placeholder="Add a reason" id="reason"></textarea>
                    </div>
                    <table width="100%" class="add_dis">
                        <tr>
                            <td>Subtotal</td>
                            <td class="text-end subtotal dis_subtotal">$0.00</td>
                        </tr>
                        <tr class="discount-row">
                            <td>Discount</td>
                            <td class="text-end discount dis_discount">$0.00</td>
                        </tr>
                        <tr>
                            <td><b>Total</b></td>
                            <td class="text-end total dis_total"><b>$0.00</b></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-end d-grey font-13 gst_total">(Includes GST of $0.00)</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-md cancel_discount">Cancel</button>
                    <button type="button" class="btn btn-primary btn-md update_discount">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="take_payment" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Take Payment</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body main_payment_details">
                <div class="row payment_details payment_details_single closed-stip">
                    <div class="col-lg-4 make_sale_payment" style="display:none;">
                        <div class="form-group">
                            <label class="form-label">Payment</label>
                            <select class="form-select form-control" name="payment_type[]" id="payment_type">
                                <option>Card</option>
                                <option>Afterpay</option>
                                <option>Bank Transfer</option>
                                <option>Cash</option>
                                <option>Humm payment</option>
                                <option>Zip Pay</option>
                            </select>
                            </div>
                    </div>
                    <div class="col-lg-4 make_sale_payment"  style="display:none;">
                        <div class="form-group">
                            <label class="form-label">Amount</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ico-dollar fs-4"></i></span>
                                <input type="number" class="form-control payment_amount" name="payment_amount[]" placeholder="0">
                                
                                </div>
                            </div>
                    </div>
                    <div class="col-lg-4 make_sale_payment"  style="display:none;">
                        <div class="form-group">
                            <label class="form-label">Date</label>
                            <input type="date" id="datePicker4" name="payment_date[]" class="form-control" id="payment_date" placeholder="date" value="<?php echo date('Y-m-d'); ?>" readonly>
                        </div>
                    </div>
                    <div class="remove_payment cross make_sale_payment"  style="display:none;">
                        <a href="#" class="remove_payment_btn"><button class="btn-close close_waitlist"></button></a>
                    </div>
                </div>
                
                <div class="mb-3 payment_data">
                    <a href="#" class="btn btn-dashed w-100 btn-blue icon-btn-center mb-2 add_another_payment"><i class="ico-ticket-discount me-2 fs-5"></i> Add another payment</a>
                    <div class="form-text d-flex align-items-center"><span class="ico-danger fs-5 me-2"></span> Not all payment type supported</div>
                </div>

                <hr class="my-4">

                <table width="100%">
                    <tbody>
                        <tr>
                            <td><b>Total</b></td>
                            <td class="text-end blue-bold payment_total"><b>$250.00</b></td>
                        </tr>
                        <tr>
                            <td>Remaining balance</td>
                            <td class="text-end remaining_balance">$0.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-md back_to_sale">Back to Sale</button>
                <button type="button" class="btn btn-primary btn-md complete_sale">Complete Sale</button>                                    
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="payment_completed" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Sale Complete</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="success-pop p-5 mb-4" style="
                text-align: center;">
                    <img src="{{ asset('img/success-icon.png') }}" alt="" class="mb-3" style="
                max-width: 12%;">
                <span id="paymentMessage"></span>
            </div>
                <div class="form-group mb-3">
                    <label class="form-label"><strong>Send receipt by email</strong></label>
                    <div class="row">
                        <div class="col-lg-10">
                            <input type="text" class="form-control send_email" placeholder="admin@tenderresponse.com.au (use comma for multiple email)">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary btn-md send_payment_mail">Send</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-light btn-md close_payment">Close</button>
            <button type="button" class="btn btn-primary btn-md print_invoice" ids="">Print</button>
            <button type="button" class="btn btn-primary btn-md view_invoice" walk_in_ids="">View Invoice</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<script>
  $(function() {
      
      var loc_name = [];

      $.ajax({
          url: "get-all-locations",
          cache: false,
          type: "POST",
          success: function(res) {
              
              for (var i = 0; i < res.length; ++i) {
                  $("#results").append(res[i].location_name);
                  loc_name.push(res[i].location_name); // Push the location_name to the array
              }

              // Move the map function inside the success callback
              $.map(loc_name, function(x) {
                  return $('.location').append("<option>" + x + "</option>");
              });

              // Initialize the multiselect after appending options
              $('.location')
              .multiselect({
                  allSelectedText: 'Select Location',
                  maxHeight: 200,
                  includeSelectAllOption: true
              })
              .multiselect('selectAll', false)
              .multiselect('updateButtonText');
          }
      });
  });
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$(document).ready(function() {

    // Define validation rules
    var validationRules = {
        casual_staff: {
            required: true
        },
        new_staff: {
            required: true
        },
        existing_staff: {
            required: true
        },
        walkin_first_name: {
            required:true
        },
        walkin_last_name: {
            required:true
        },
        walkin_email: {
            required:true,
            email: true,
                remote: {
                    url: "../clients/checkClientEmail",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        email: function () {
                            return $("#walkin_email").val();
                        }
                    },
                    dataFilter: function (data) {
                        var json = $.parseJSON(data);
                        return json.exists ? '"Email already exists!"' : '"true"';
                    }
                }
        },
        walkin_phone_type: {
            required:true
        },
        walkin_phone_no: {
            required:true
        },
        walkin_contact_method: {
            required:true
        }
    };

    $("#create_walkin_casual").validate({
        rules: validationRules,
        messages: {
            casual_staff: {
                required: "Please select credit sale."
            }
        },
        errorPlacement: function(error, element) {
            // Custom error placement
            error.insertAfter(element); // Display error message after the element
        }
    });
    $("#create_walkin_new").validate({
        rules: validationRules,
        messages: {
            new_staff: {
                required: "Please select credit sale."
            }
        },
        errorPlacement: function(error, element) {
            // Custom error placement
            error.insertAfter(element); // Display error message after the element
        }
    });
    $("#create_walkin_existing").validate({
        rules: validationRules,
        messages: {
            existing_staff: {
                required: "Please select credit sale."
            }
        },
        errorPlacement: function(error, element) {
            // Custom error placement
            error.insertAfter(element); // Display error message after the element
        }
    });
    document.title='Finance';
    var table = $('.data-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ route('finance.table') }}",
        type: 'post',
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
        data: function(d) {
            d.location_id = $('#locations').val(); // Include the selected location ID in the AJAX request data
        }
    },
    columns: [
        {
            data: 'id', 
            name: 'id',
            render: function (data, type, row) {
                var link = '<a class="blue-bold paid_invoice" inv_id="'+row.id+'" href="javascript:void(0)">INV' + data + '</a>';
                return link;
            }
        },
        {
            data: 'client_name', 
            name: 'client_name',
            render: function (data, type, row) {
                var link = '<a class="blue-bold" href="clients/' + row.client_id + '">' + data + '</a>';
                return link;
            }
        },
        {data: 'location_name', name: 'location_name'},
        {
            data: 'product_names',
            name: 'product_names',
            render: function(data, type, full, meta) {
                // Split the product names by comma
                var productNames = data.split(',');
                
                // Get the first product name
                var firstProductName = productNames[0].trim();
                
                // If the first product name is longer than 10 characters, truncate it and add ellipsis
                if (firstProductName.length > 10) {
                    firstProductName = firstProductName.substring(0, 10) + '...';
                }
                
                // Count the remaining product names
                var remainingCount = productNames.length - 1;
                
                // If there are remaining product names, add the count
                if (remainingCount > 0) {
                    firstProductName += ' (+' + remainingCount + ')';
                }
                
                return firstProductName;
            }
        },
        { 
            data: "walk_in_type", 
            name: "walk_in_type",
            defaultContent: '' // Set the default content to an empty string
        },
        {
            data: 'payment',
            name: 'payment',
            render: function(data, type, full, meta) {
                // Split the product names by comma
                var paymentNames = data.split(',');
                
                // Get the first product name
                var firstPaymentName = paymentNames[0].trim();
                
                // If the first product name is longer than 10 characters, truncate it and add ellipsis
                if (firstPaymentName.length > 10) {
                    firstPaymentName = firstPaymentName.substring(0, 10) + '...';
                }
                
                // Count the remaining product names
                var remainingCount = paymentNames.length - 1;
                
                // If there are remaining product names, add the count
                if (remainingCount > 0) {
                    firstPaymentName += ' (+' + remainingCount + ')';
                }
                
                return firstPaymentName;
            }
        },
        { 
            data:  null, 
            name:  null, 
            render: function(data, type, row, meta) {
                return '<span class="badge text-bg-green badge-md">PAID</span>';
            }
        },
        { 
            data: "updated_at", 
            name: "updated_at",
            render: function(data, type, row, meta) {
                // Format the date using moment.js to display only the time part
                return moment(data).format("hh:mm A");
            }
        },
        { 
            data: 'total', 
            name: 'total',
            render: function(data, type, row, meta) {
                // Add a dollar sign ($) before the value
                return '$' + data;
            }
        },
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ],
    "dom": 'Blrftip',
    "language": {
            "search": '<i class="fa fa-search"></i>',
            "searchPlaceholder": "search...",
    },
    "paging": true,
    "pageLength": 10,
    "autoWidth": true,
    buttons: [
        {
            extend: 'collection',
            text: 'Export',
            buttons: [
                { 
                    text: "Excel",
                    exportOptions: { 
                        columns: [1,2,3,4,5,6,7,8],
                        format: {
                            body: function (data, row, column, node) {
                                // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                if (column === 1) {
                                    return node.textContent;
                                }
                                else if (column === 6) {
                                    return node.textContent === 'checked' ? 'Active' : 'Deactive';
                                }
                                return data;
                            }
                        }
                    },
                    extend: 'excelHtml5'
                },
                { 
                    text: "CSV",
                    exportOptions: { 
                        columns: [1,2,3,4,5,6,7,8],
                        format: {
                            body: function (data, row, column, node) {
                                // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                if (column === 1) {
                                    return node.textContent;
                                }
                                else if (column === 6) {
                                    return node.textContent === 'checked' ? 'Active' : 'Deactive';
                                }
                                return data;
                            }
                        }
                    },
                    extend: 'csvHtml5'
                },
                { 
                    text: "PDF",
                    exportOptions: { 
                        columns: [1,2,3,4,5,6,7,8],
                        format: {
                            body: function (data, row, column, node) {
                                // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                if (column === 1) {
                                    return node.textContent;
                                }
                                else if (column === 6) {
                                    return node.textContent === 'checked' ? 'Active' : 'Deactive';
                                }
                                return data;
                            }
                        }
                    },
                    extend: 'pdfHtml5'
                },
                { 
                    text: "PRINT",
                    exportOptions: { 
                        columns: [1,2,3,4,5,6,7,8],
                        format: {
                            body: function (data, row, column, node) {
                                // For the 7th column, replace 'checked' with 'Active' and 'unchecked' with 'Deactive'
                                if (column === 1) {
                                    return node.textContent;
                                }
                                else if (column === 6) {
                                    return node.textContent === 'checked' ? 'Active' : 'Deactive';
                                }
                                return data;
                            }
                        }
                    },
                    extend: 'print'
                },
            ]
        }
    ],
    select: {
      style : "multi",
    },
    'order': [[0, 'desc']],
    initComplete: function () {
        var btns = $('.dt-buttons'),
            dtFilter = $('.dataTables_filter'),
            dtInfo  = $('.dataTables_info'),
            api     = this.api(),
            page_info = api.rows( {page:'current'} ).data().page.info(),
            length = page_info.length,
            start = 0;
            

        var pageInfoHtml = `
            <div class="dt-page-jump">
                <select name="pagelist" id="pagelist" class="pagelist">
        `;
        
        for(var count = 1; count <= page_info.pages; count++)
        {
            var page_number = count - 1;

            pageInfoHtml += `<option value="${page_number}" data-start="${start}" data-length="${length}">${count}</option>`;

            start = start + page_info.length;
        }
        
        pageInfoHtml += `</select></div>`;
            
        dtFilter.find('label').remove();
        
        dtFilter.html(
        `
        <label>
            <div class="input-group search">
                <span class="input-group-addon">
                    <span class="ico-mini-search"></span>
                </span>
                <input type="search" class="form-control input-sm dt-search" name="search_data" placeholder="Search..." aria-controls="example">
            </div>
        </label>
        `);
        
        $(pageInfoHtml).insertAfter(dtInfo);

        btns.addClass('btn-group');
        btns.find('button').removeAttr('class');
        btns.find('button').addClass('btn btn-default buttons-collection');
    },
    "drawCallback": function( settings ) {
        var   api     = this.api(),
        dtInfo  = $('.dataTables_info');
        var page_info = api.rows( {page:'current'} ).data().page.info();
        $('#totalpages').text(page_info.pages);
        var html = '';

        var start = 0;

        var length = page_info.length;

        for(var count = 1; count <= page_info.pages; count++)
        {
          var page_number = count - 1;

          html += '<option value="'+page_number+'" data-start="'+start+'" data-length="'+length+'">'+count+'</option>';

          start = start + page_info.length;
        }

        $('#pagelist').html(html);

        $('#pagelist').val(page_info.page);
    }
});
table.select.info( false);
$(document).on('change', '#locations', function() {
    var searchText = $(this).find(':selected').text(); // Get the text of the selected option
    table.columns(2).search(searchText).draw(); // Perform search based on the text and redraw the table
});

// $(document).on('input', '.dt-search', function() {
//     var searchTerm = this.value.trim(); // Trim whitespace from search term

//     // Check if the search term starts with "INV" (for the first column)
//     if (searchTerm.startsWith("INV") || searchTerm.startsWith("inv")) {
//         var digitsOnly = searchTerm.replace(/\D/g, '');
//         table.column(0).search(digitsOnly).draw();
//     } else {
//         // If search term is empty, filter all records; otherwise, filter the second and third columns
//         if ($(this).val() == '') {
//             table.columns([0, 1]).search('').draw();
//         } else {
//             table.columns([1, 2]).search(searchTerm).draw(); // Search in both second and third columns
//         }
//     }
// });

$(document).on('input', '.dt-search', function()
{
    table.search($(this).val()).draw() ;
});
$(document).on('change', '#pagelist', function()
{
    var page_no = $('#pagelist').find(":selected").text();
    var table = $('.data-table').dataTable();
    table.fnPageChange(page_no - 1,true);
});
    // var  product_details=[];
    $.ajax({
        url: "{{ route('calendar.get-selected-location') }}",
        type: 'POST',
        data: { loc_id: $('#locations').val() },
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            product_details = response.mergedProductService;
            // product_details.push(product_details);
            // var prd_details = [];
            // a.push(JSON.parse(localStorage.getItem('session')));
            localStorage.setItem('product_details', JSON.stringify(product_details));


            discount_types_details = response.loc_dis;
            surcharge_types_details = response.loc_sur;
            console.log('discount_types_details1',discount_types_details);
            console.log('surcharge_types_details',surcharge_types_details);
            
            // Clear existing options
                $('#discount_surcharge').empty();

                // Add default options
                $('#discount_surcharge').append($('<option>', { value: '', text: 'No Discount' }));
                $('#discount_surcharge').append($('<optgroup label="Discount"><option>Manual Discount</option></optgroup>'));
                $('#discount_surcharge').append($('<optgroup label="Surcharge"><option>Manual Surcharge</option></optgroup>'));

                // Add options based on the received arrays
                if (discount_types_details && discount_types_details.length > 0) {
                    // Add discount options
                    var discountOptgroup = $('#discount_surcharge optgroup[label="Discount"]');
                    discount_types_details.forEach(function (discount) {
                        discountOptgroup.append($('<option>', { value: discount.discount_percentage, text: discount.discount_type }));
                    });
                }

                if (surcharge_types_details && surcharge_types_details.length > 0) {
                    // Add surcharge options
                    var surchargeOptgroup = $('#discount_surcharge optgroup[label="Surcharge"]');
                    surcharge_types_details.forEach(function (surcharge) {
                        surchargeOptgroup.append($('<option>', { value: surcharge.surcharge_percentage, text: surcharge.surcharge_type }));
                    });
                }

                // Clear existing options
                $('#edit_discount_surcharge').empty();

                // Add default options
                $('#edit_discount_surcharge').append($('<option>', { value: '', text: 'No Discount' }));
                $('#edit_discount_surcharge').append($('<optgroup label="Discount"><option value="0">Manual Discount</option></optgroup>'));
                $('#edit_discount_surcharge').append($('<optgroup label="Surcharge"><option value="0">Manual Surcharge</option></optgroup>'));

                // Add options based on the received arrays
                if (discount_types_details && discount_types_details.length > 0) {
                    // Add discount options
                    var discountOptgroup = $('#edit_discount_surcharge optgroup[label="Discount"]');
                    discount_types_details.forEach(function (discount) {
                        discountOptgroup.append($('<option>', { value: discount.discount_percentage, text: discount.discount_type }));
                    });
                }

                if (surcharge_types_details && surcharge_types_details.length > 0) {
                    // Add surcharge options
                    var surchargeOptgroup = $('#edit_discount_surcharge optgroup[label="Surcharge"]');
                    surcharge_types_details.forEach(function (surcharge) {
                        surchargeOptgroup.append($('<option>', { value: surcharge.surcharge_percentage, text: surcharge.surcharge_type }));
                    });
                }
        },
        error: function (error) {
            console.error('Error storing location ID:', error);
        }
    });

});
$(document).on('click', '.dt-edit', function(e) {
    e.preventDefault();
    
    var ids = $(this).attr('ids');
    window.location = 'users/' + ids;
  });
$(document).on('click', '.dt-delete', function(e) {
  e.preventDefault();
    $this = $(this);
    var dtRow = $this.parents('tr');
    if(confirm("Are you sure to delete this row?")){
      $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "users/"+$(this).attr('ids'),
        type: 'DELETE',
        data: {
            "id": $(this).attr('ids'),
        },
        success: function(response) {
          // Show a Sweet Alert message after the form is submitted.
          if (response.success) {
            Swal.fire({
              title: "Users!",
              text: "Your Users deleted successfully.",
              type: "success",
            }).then((result) => {
                          window.location = "{{url('users')}}"//'/player_detail?username=' + name;
                      });
          } else {
            Swal.fire({
              title: "Error!",
              text: response.message,
              type: "error",
            });
          }
        },
      });
      var table = $('#example').DataTable();
      table.row(dtRow[0].rowIndex-1).remove().draw( false );
    }
});
$(document).on('click', '.print_invoice', function() {
    var walk_ids = $(this).attr('ids');
    // var formattedDates = $('#datePicker1').val().split('-').reverse().join('-'); // Reformatting the date

    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ route('calendar.paid-invoice') }}",
        type: "POST",
        data: {'walk_ids': walk_ids},
        success: function (response) {
            if (response.success) {
                // Call a function to handle printing
                printInvoice(response.invoice);
            }
        }
    });
});
$(document).on('click','.paid_invoice',function(){
    $('#paid_Invoice').modal('show');
    $('#existingclientmodal').hide();
    var walk_ids = $(this).attr('inv_id');
    $('.delete_invoice').attr('delete_id',walk_ids);
    $('.print_invoice').attr('ids',walk_ids);
    $('.edit_invoice').attr('edit_id',walk_ids);
    // $('.print_completed_invoice').attr('edit_id',walk_ids);
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ route('calendar.paid-invoice') }}",
        type: "POST",
        data: {'walk_ids': walk_ids},
        success: function (response) {
            if (response.success) {
                console.log('data',response.invoice)
                // response.invoice.invoice_date;
                // populateInvoiceModal(response.invoice);
                populateInvoiceModal(response.invoice, response.invoice.subtotal, response.invoice.discount, response.invoice.total);
            }
        }
    });
})
$(document).on('click', '.edit_invoice', function(e) {
    var id = $(this).attr('edit_id');
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ route('calendar.edit-invoice') }}",
        type: "POST",
        data: {'walk_ids': id},
        success: function (response) {
            if (response.success) {
                console.log('data', response.invoice);
                $('#paid_Invoice').modal('hide');
                $('#Walkin_Retail').modal('show');
                var type_cus = response.invoice.customer_type;
                if(type_cus =='new')
                {
                    $('.existing_cus').click();
                    $('.nav-link').removeClass('active');
                    $('.existing_cus').addClass('active');
                    $('#existingclientmodal').show();
                    $('.walk_in_client_id').val(response.invoice.client_id);
                    $('#existingclientDetailsModal').html('<i class="ico-user2 me-2 fs-6"></i>' + response.invoice.client_name);
                }
                // $('.main_walkin').hide();
                
                $('.invoice_id').val(response.invoice.id);
                $('.invoice_date').hide();
                var invoiceDate = new Date(response.invoice.invoice_date);

                // Get day, month, and year
                var day = invoiceDate.getDate();
                var month = invoiceDate.getMonth() + 1; // Month is zero-based, so add 1
                var year = invoiceDate.getFullYear();

                // Ensure day and month are displayed with leading zeros if needed
                var formattedInvoiceDate = `${day < 10 ? '0' + day : day}-${month < 10 ? '0' + month : month}-${year}`;

                $('.edit_invoice_date').text(formattedInvoiceDate);

                $('.edit_invoice_number').text('Invoice number: ' + 'INV' + response.invoice.id);
                $('.edited_total').val(response.invoice.total);
                $('.productDetails').empty();
                // Iterate over each product in the response
                $.each(response.invoice.products, function(index, product) {
                    $('.productDetails').append(
                        `<div class="invo-notice mb-4 closed product-info1" prod_id='${product.id}'>
                            <a href="#" class="btn cross remove_product"><i class="ico-close"></i></a>
                            <input type='hidden' name='casual_product_name[]' value='${product.product_name}'>
                            <input type='hidden' id="product_id" name='casual_product_id[]' value='${product.product_id}'>
                            <input type='hidden' id="product_price" name='casual_product_price[]' value='${product.product_price}'>
                            <input type='hidden' id="product_gst" name='product_gst' value='${response.invoice.gst}'>
                            <input type='hidden' id="discount_types" name='casual_discount_types[]' value='${product.discount_type}'>
                            <input type='hidden' id="hdn_discount_surcharge" name='casual_discount_surcharge[]' value='${product.product_discount_surcharge}'>
                            <input type='hidden' id="hdn_discount_surcharge_type" name='hdn_discount_surcharge_type[]' value='${product.type}'>
                            <input type='hidden' id="hdn_discount_amount" name='casual_discount_amount[]' value='${product.discount_amount}'>
                            <input type='hidden' id="hdn_discount_text" name='casual_discount_text[]' value='${product.discount_value}'>
                            <input type='hidden' id="hdn_reason" name='casual_reason[]' value='${product.discount_reason}'>
                            <input type="hidden" id="hdn_who_did_work" name="casual_who_did_work[]" value="${product.who_did_work === null ? '' : product.who_did_work}">
                            <input type='hidden' id="hdn_edit_amount" name='casual_edit_amount[]' value='0'>
                            <input type='hidden' id="product_type" name='product_type[]' value='${product.product_type}'>
                            <div class="inv-left">
                                <div>
                                    <b>${product.product_name}</b>
                                    <div class="who_did_work">Sold by ${product.user_full_name}</div>
                                    <span class="dis">Discount: $${product.discount_value}</span>
                                </div>
                            </div>
                            <div class="inv-center">
                                <div class="number-input walk_number_input safari_only form-group mb-0 number">
                                    <button class="c_minus minus"></button>
                                    <input type="number" class="casual_quantity quantity form-control" min="0" name="casual_product_quanitity[]" value="${product.product_quantity}">
                                    <button class="c_plus plus"></button>
                                </div>
                            </div>
                            <div class="inv-number go price">
                                <div>
                                <div class="m_p">${'$' + ((product.product_price * product.product_quantity) - (product.discount_value * product.product_quantity)).toFixed(2)}</div>
                                    ${product.product_quantity > 1 ?
                                        `<div class="main_p_price">
                                            ${('$' + (product.product_price - product.discount_value).toFixed(2) + ' ea')}
                                        </div>` :
                                        `<div class="main_p_price" style="display:none;">
                                            ${('$' + (product.product_price - product.discount_value).toFixed(2) + ' ea')}
                                        </div>`
                                    }
                                </div>
                                <a href="#" class="btn btn-sm px-0 product-name clickable" product_id="${product.id}" product_name="${product.product_name}" product_price="${product.product_price}"><i class="ico-right-arrow fs-2 ms-3"></i></a>
                            </div>
                        </div>`
                    );
                });

                //subtotal
                $('.subtotal').text('$'+ response.invoice.subtotal);
                $('.discount').text('$'+ response.invoice.discount);
                $('.total').text('$'+ response.invoice.total);
                $('.gst_total').text("(Includes GST of $" + response.invoice.gst + ")");

                // $('#discount_surcharge').val(response.invoice.discount_surcharges[0].discount_surcharge);
                // $('#discount_type').val(response.invoice.discount_surcharges[0].discount_type);
                // $('#amount').val(response.invoice.discount_surcharges[0].discount_amount);
                // $('#reason').val(response.invoice.discount_surcharges[0].discount_reason);

                $('#sale_staff_id').val(response.invoice.user_id);
                $('#notes').text(response.invoice.note)

                // // Clear previous payment details
                // $('.payment_details').empty();

                // // Append payment details from response
                // $.each(response.invoice.payments, function(index, payment) {
                //     $('.payment_details').append(
                //         `<div class="row payment_details closed-stip">
                //             <div class="col-lg-4">
                //                 <div class="form-group">
                //                     <label class="form-label">Payment</label>
                //                     <select class="form-select form-control payment_type" name="payment_type[]" id="payment_type_${index}">
                //                         <option ${payment.payment_type === 'Card' ? 'selected' : ''}>Card</option>
                //                         <option ${payment.payment_type === 'Afterpay' ? 'selected' : ''}>Afterpay</option>
                //                         <option ${payment.payment_type === 'Bank Transfer' ? 'selected' : ''}>Bank Transfer</option>
                //                         <option ${payment.payment_type === 'Cash' ? 'selected' : ''}>Cash</option>
                //                         <option ${payment.payment_type === 'Humm payment' ? 'selected' : ''}>Humm payment</option>
                //                         <!-- <option ${payment.payment_type === 'Voucher' ? 'selected' : ''}>Voucher</option> -->
                //                         <option ${payment.payment_type === 'Zip Pay' ? 'selected' : ''}>Zip Pay</option>
                //                     </select>
                //                 </div>
                //             </div>
                //             <div class="col-lg-4">
                //                 <div class="form-group">
                //                     <label class="form-label">Amount</label>
                //                     <div class="input-group">
                //                         <span class="input-group-text"><i class="ico-dollar fs-4"></i></span>
                //                         <input type="number" class="form-control payment_amount" name="payment_amount[]" placeholder="0" value="${payment.amount}">
                //                     </div>
                //                 </div>
                //             </div>
                //             <div class="col-lg-4">
                //                 <div class="form-group">
                //                     <label class="form-label">Date</label>
                //                     <input type="date" name="payment_date[]" class="form-control payment_date" placeholder="date" value="${payment.date}" readonly>
                //                 </div>
                //             </div>
                //             <div class="remove_payment cross">
                //                 <a href="#" class="remove_payment_btn"><button class="btn-close close_waitlist"></button></a>
                //             </div>
                //         </div>`
                //     );
                // });

                $('.take_payment').attr('main_total',response.invoice.total);
                $('.take_payment').attr('main_remain',response.invoice.remaining_balance);

                //discount
                $('#discount_surcharge').val(response.invoice.discount_surcharges[0].discount_surcharge);
                $('input[name="discount_type"][value="' + response.invoice.discount_surcharges[0].discount_type + '"]').prop('checked', true);
                $('#amount').val(response.invoice.discount_surcharges[0].discount_amount);
                $('#reason').text(response.invoice.discount_surcharges[0].discount_reason);
                if(response.invoice.discount_surcharges[0].discount_surcharge == 'Manual Discount')
                {
                    $('#amount').prop('disabled', false);
                    $('#discount_type').prop('disabled', false);
                    $('#percent_type').prop('disabled', false);
                    $('#reason').prop('disabled', false);
                    $('.discount-row').show();
                }else if(response.invoice.discount_surcharges[0].discount_surcharge == 'Manual Surcharge')
                {
                    $('#amount').prop('disabled', false);
                    $('#discount_type').prop('disabled', false);
                    $('#percent_type').prop('disabled', false);
                    $('#reason').prop('disabled', false);
                    $('.discount-row').show();
                }
                else{
                    $('#amount').prop('disabled', true);
                    $('#discount_type').prop('disabled', true);
                    $('#percent_type').prop('disabled', true);
                    $('#reason').prop('disabled', true);
                    $('.discount-row').show();
                    $('#reason').val('');
                }
                $('.walk_in_location_id').val(response.invoice.location_id);
                //
                $('.hdn_main_discount_surcharge').val(response.invoice.discount_surcharges[0].discount_surcharge);
                $('.hdn_main_discount_type').val(response.invoice.discount_surcharges[0].discount_type);
                $('.hdn_main_discount_amount').val(response.invoice.discount_surcharges[0].discount_amount);
                $('.hdn_main_discount_reason').val(response.invoice.discount_surcharges[0].discount_reason);

                //subtotal
                $('#hdn_subtotal').val(response.invoice.subtotal);
                $('#hdn_discount').val(response.invoice.discount);
                $('#hdn_gst').val(response.invoice.gst);
                $('#hdn_total').val(response.invoice.total);
            }
        }
    });
});
$(document).on('click', '.delete_invoice', function(e) {
    var id = $(this).attr('delete_id');
    var url = 'calender/delete-walk-in/' + id; // Corrected the URL construction

    if (confirm("Are you sure to delete this walk-in?")) {
        $.ajax({
            url: url,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (data.success) {
                    Swal.fire({
                        title: "Walk-In Sale!",
                        text: data.message,
                        icon: "success", // Changed 'info' to 'icon'
                    });
                    location.reload();
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: data.message,
                        icon: "error", // Changed 'info' to 'icon'
                    });
                }
            },
            error: function (error) {
                console.error('Error fetching resources:', error);
            }
        });
    }
})
// $(document).on('click', '.print_completed_invoice', function() {
//     // Create a hidden container element
//     var printContainer = document.createElement('div');
//     printContainer.setAttribute('id', 'print-container');

//     // Get necessary data from the modal fields
//     var invoiceDate = $('#invoiceDate').text();
//     var invoiceNumber = $('#invoiceNumber').text();
//     var products = [];
//     $('#productTableBody').find('tr').each(function() {
//         var productName = $(this).find('td:first-child').text();
//         var productQuantity = $(this).find('td:nth-child(2)').text();
//         var productPrice = $(this).find('td:nth-child(3)').text();
//         products.push({
//             name: productName,
//             quantity: productQuantity,
//             price: productPrice
//         });
//     });

//     var payments = [];
//     $('#paymentTable tbody tr').each(function() {
//         var paymentMethod = $(this).find('td:nth-child(1)').text();
//         var paymentDate = $(this).find('td:nth-child(2)').text();
//         var paymentAmount = $(this).find('td:nth-child(3)').text();
//         payments.push({
//             method: paymentMethod,
//             date: paymentDate,
//             amount: paymentAmount
//         });
//     });
    
//     var totalPaid = $('#totalPaid').text();

//     // Define and populate cardDetails array
//     var cardDetails = [];
//     var totalCardPayments = 0; // Initialize total card payments
//     $('.main_payment_details').find('.payment_details').each(function(){
//         var cardType = $(this).find('#payment_type').val();
//         var cardAmount = $(this).find('.payment_amount').val();
//         var dateValue1 = $('#datePicker4').val();
        
//         var dateParts1 = dateValue1.split('-');
//         var cardDate = dateParts1[2] + '-' + dateParts1[1] + '-' + dateParts1[0];

//         var c_details = {
//             card: cardType,
//             amount: cardAmount,
//             date: cardDate
//         };
//         cardDetails.push(c_details);
//         totalCardPayments += parseFloat(cardAmount); // Add current card amount to total
//     });

//     // Create printable content
//     var printableContent = `
//     <html lang="en">
//         <head>
//             <meta charset="UTF-8">
//             <meta name="viewport" content="width=device-width, initial-scale=1.0">
//             <title>Document</title>
//             <style>
//                 @media print {
//                     body * {
//                         visibility: hidden;
//                     }
//                     #printable-content, #printable-content * {
//                         visibility: visible;
//                     }
//                     #printable-content {
//                         position: absolute;
//                         left: 0;
//                         right:0;
//                         top: 0;
//                         bottom:0;
//                     }
//                 }
//             </style>
//         </head>
//         <body>
//             <div id="printable-content">
//                 <table style="width: 100%; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em;">
//                     <tr>
//                         <td style="text-align: right;">
//                             <b>Dr Umed Cosmetics</b><br>
//                             0407194519<br>
//                             <a href="mailto:info@drumedcosmetics.com.au">info@drumedcosmetics.com.au</a><br>
//                             ABN # xx-xxx-xxx
//                         </td>
//                     </tr>
//                 </table>
//                 <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">TAX INVOICE / RECEIPT</h3>
//                 <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">CUSTOMER</p>
//                 <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">DATE OF ISSUE<br> <b>${invoiceDate}</b></p>
//                 <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em; text-align: right;">INVOICE NUMBER: <b>#INV${invoiceNumber}</b></p>
//                 <br>
//                 <table style="width: 100%; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em;">
//                     <tr>
//                         <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: left;" >Quantity</th>
//                         <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: left;">Service</th>
//                         <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: right;" >Price</th>
//                     </tr>
//                     ${products.map(product => `
//                     <tr>
//                         <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;">${product.quantity}</td>
//                         <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;">${product.name}</td>
//                         <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">${product.price}</td>
//                     </tr>
//                     `).join('')}
//                     <tr>
//                         <td colspan="3" style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">
//                             Subtotal ${$('#subtotalProductPrice').find('span').text()}<br>
//                             Total: <strong style="font-size: 20px;">${$('#totalProductPrice').find('.blue-bold').text()}</strong><br>
//                             ${$('#totalProductPriceGST').text()}
//                         </td>
//                     </tr>
//                     ${payments.length > 0 ? `
//                     <tr>
//                         <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;" colspan="2">PAYMENTS</td>
//                         <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;"></td>
//                     </tr>
//                     ${payments.map(cards => `
//                     <tr>
//                         <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;"><b>${cards.date} ${cards.method}</b></td>
//                         <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;"></td>
//                         <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">${cards.amount}</td>
//                     </tr>
//                     `).join('')}
//                     ` : ''}
//                     <tr>
//                         <td colspan="3" style="padding: 0.9rem; text-align: right;">
//                             Total Paid: <strong style="font-size: 20px;">${totalPaid}</strong><br>
//                         </td>
//                     </tr>
//                 </table>
//             </div>
//         </body>
//     </html>
//     `;

//     // Set printable content to the container
//     printContainer.innerHTML = printableContent;

//     // Append container to document body
//     document.body.appendChild(printContainer);

//     // Print the page
//     window.print();

//     // Remove the container from the document body
//     document.body.removeChild(printContainer);
// });


$(document).on('click','.add_discount',function(e){
    var p_details=JSON.parse(localStorage.getItem('product_details'));
    var inv_id = $('#invoice_id').val();
    
    $('.main_walkin .nav-item:visible').each(function() {
        // Check if the current nav-item is active (visible)
        if ($(this).find('a.nav-link').hasClass('active')) {
            var link = $(this).find('a.nav-link');
            if (link.hasClass('casual_cus')) {
                $('#discount_customer_type').val('casual');
            } else if (link.hasClass('new_cus')) {
                $('#discount_customer_type').val('new');
            } else {
                $('#discount_customer_type').val('existing');
            }
            return false; // Exit the loop once we find the active nav-item
        }
    });
    
    $('.main_discount').show();
    $('.main_walk_in').hide();
    var searchText = 'Manual Discount';
    // $('#discount_surcharge').val($('#discount_surcharge option').filter(function() {
    //     return $(this).text() === searchText;
    // }).val());
    // if($(this).text() == 'Edit discount / surcharge')
    // {
        $('#main_discount').find('h4').text('Edit discount / surcharge')
        $('#hdn_amt').val($('#amount').val());
        $('#hdn_dis_type').val($('input[name="discount_type"]:checked').val());

        // $('#discount_surcharge').val($('.hdn_main_discount_surcharge').val());
    // }
    // var id = $('#invoice_id').val();
    // $.ajax({
    //     headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    //     url: "{{ route('calendar.edit-invoice') }}",
    //     type: "POST",
    //     data: {'walk_ids': id},
    //     success: function (response) {
    //         if (response.success) {
    //             console.log('data', response.invoice);
    //             $('#discount_surcharge').val(response.invoice.discount_surcharges[0].discount_surcharge);
    //             $('input[name="discount_type"][value="' + response.invoice.discount_surcharges[0].discount_type + '"]').prop('checked', true);
    //             $('#amount').val(response.invoice.discount_surcharges[0].discount_amount);
    //             $('#reason').text(response.invoice.discount_surcharges[0].discount_reason);
    //             if(response.invoice.discount_surcharges[0].discount_surcharge == 'Manual Discount')
    //             {
    //                 $('#amount').prop('disabled', false);
    //                 $('#discount_type').prop('disabled', false);
    //                 $('#percent_type').prop('disabled', false);
    //                 $('#reason').prop('disabled', false);
    //                 $('.discount-row').show();
    //             }else if(response.invoice.discount_surcharges[0].discount_surcharge == 'Manual Surcharge')
    //             {
    //                 $('#amount').prop('disabled', false);
    //                 $('#discount_type').prop('disabled', false);
    //                 $('#percent_type').prop('disabled', false);
    //                 $('#reason').prop('disabled', false);
    //                 $('.discount-row').show();
    //             }
    //             else{
    //                 $('#amount').prop('disabled', true);
    //                 $('#discount_type').prop('disabled', true);
    //                 $('#percent_type').prop('disabled', true);
    //                 $('#reason').prop('disabled', true);
    //                 $('.discount-row').show();
    //                 $('#reason').val('');
    //             }
    //         }
    //     }
    // });
});
$(document).on('click','.cancel_discount',function(e){
    $('.main_discount').hide();
    $('.main_walk_in').show();
    // $('#discount_surcharge').val($('#hdn_discount_surcharge').val());
    // $('#discount_surcharge').val($('#discount_surcharge').val());
    $('#amount').prop('disabled', false);
    $('#discount_type').prop('disabled', false);
    $('#percent_type').prop('disabled', false);
    $('#reason').prop('disabled', false);
    $('.discount-row').show();
    $('#reason').val('');
    var type = $('#discount_customer_type').val();

    //cancel 
    if($('#main_discount').find('h4').text() != 'Edit discount / surcharge')
    {
        // $('#amount').val(0);
    }
    else
    {
        $('#amount').val($('#hdn_amt').val());
        var hd = $('#hdn_dis_type').val();
        $('input[name="discount_type"][value="' + hd + '"]').prop('checked', true);
    }
    updateSubtotalAndTotal(type);
})
$(document).on('click','.cancel_product',function(e){
    // $('.main_product').hide();
    $('.edit_product').hide();
    $('.main_walk_in').show();
})
$(document).on('click','.update_product',function(e){
    // $('.main_product').hide();
    $('.edit_product').hide();
    $('.main_walk_in').show();
    
    // Retrieve the product details
    var productInfo = $('.modal-body');

    // Update the product price in the productDetail div
    var pricePerUnit = parseFloat(productInfo.find('.edit_price_per_unit').val());
    var quantity = parseInt(productInfo.find('.edit_quantity').val());
    var productPrice = pricePerUnit * quantity;
    $('.productDetail .edit_product_price').find('b').text('$' + productPrice.toFixed(2));
    $('.productDetail .main_detail_price').text('$' + productPrice.toFixed(2) + 'ea');
    var cus_type = $('#customer_type').val();
    var edit_prod_id = $('#edit_product_id').val();
    $('.invo-notice').each(function(index, element) {
        if($(this).attr('prod_id') == edit_prod_id)
        {
            $(this).find('.inv-number').find('.m_p').text($('.edit_product_price').find('b').text());
            // $(this).find('.inv-number').find('b').text($('.main_detail_price').text());
            $(this).find('.inv-number').find('.m_p').next().text($('.main_detail_price').text());
            $(this).find('.inv-left').find('.dis').text($('#dynamic_discount').text());
            $(this).find('.quantity').val($('.edit_product_quantity').text());

            if($('.edit_product_quantity').text() > 1)
            {
                $(this).find('.main_p_price').show();
            }else{
                $(this).find('.main_p_price').hide();
            }
            $(this).find('#product_price').val($('.edit_price_per_unit').val()); 
            var productPrice = $(this).find('#product_price').val() // Get the text content of edit_product_price
            var priceWithoutDollar = productPrice.replace('$', ''); // Remove the dollar sign
            $(this).find('.product-name').attr('product_price', priceWithoutDollar); // Set the product_price attribute
            $(this).find('#hdn_discount_surcharge_type').val($('#edit_discount_surcharge').find(':selected').parent().attr('label'));
            $(this).find('#hdn_discount_surcharge').val($('#edit_discount_surcharge').find('option:selected').text());
                
            var discountText = $('#dynamic_discount').text();

            // Extract the amount part
            var amountString = discountText.split('$')[1];

            // Convert the extracted string to a float number
            var amount = parseFloat(amountString);

            // Check if the amount is a valid number
            if (!isNaN(amount)) {
                // Now 'amount' contains the extracted amount
                console.log(amount);
            } else {
                // console.log('Invalid amount');
                var amount = 0;
            }
            $(this).find('#hdn_discount_amount').val($('#edit_amount').val());
            $(this).find('#hdn_discount_text').val(amount);
            $(this).find('#discount_types').val($('input[name="edit_discount_type"]:checked').val());
            $(this).find('#hdn_reason').val($('#edit_reason').val());
            $(this).find('.who_did_work').text('Sold by '+ $('#edit_sale_staff_id option:selected').text());
            $(this).find('#hdn_who_did_work').val($('#edit_sale_staff_id').val());
            $(this).find('#hdn_edit_amount').val($('#edit_amount').val());
            
            updateSubtotalAndTotal(cus_type); // Update Subtotal and Total
        }
    });
    $('#notes').append('\n' + $('#edit_reason').val() + ' - ' + '$'+$('#edit_amount').val() + ' on ' + $('.edit_product_name').text() + '\n');
})
$(document).on('click','.update_discount',function(e){

    $('.main_discount').hide();
    $('.main_walk_in').show();

    // $('#hdn_discount_surcharge').val($('#discount_surcharge').val());
    $('.main_walk_in').find('.add_discount').each(function() {
        // Update the HTML content of the element
        $(this).html('<i class="ico-percentage me-2 fs-5"></i>Edit discount / surcharge');

        // Your additional code logic here for each element with the class 'add_discount'
    });

    var amt_type_note = $('input[name="discount_type"]:checked').val();
    if(amt_type_note == 'amount')
    {
        $('#notes').text($('#reason').val() + ' - ' + '$'+$('#amount').val() + ' applied to invoice.' );
    }else{
        $('#notes').text($('#reason').val() + ' - ' +$('#amount').val()+'%' + ' applied to invoice.');
    }
    $('.hdn_main_discount_surcharge').val($('#discount_surcharge').val());
    $('.hdn_main_discount_type').val($('input[name="discount_type"]:checked').val());
    $('.hdn_main_discount_amount').val($('#amount').val());
    $('.hdn_main_discount_reason').val($('#reason').val());
})
$(document).on('click', '.c_minus', function(e) {
    var type = "casual";
    var $currentDiv = $(this).closest('.product-info1');
    var chk_dis_type = $currentDiv.find('#discount_types').val();

    var main_price = parseFloat($currentDiv.find('#product_price').val());
    var price_amt;

    // Calculate price based on discount type
    if (chk_dis_type == 'percent') {
        var discount = parseFloat($currentDiv.find('#hdn_discount_amount').val() || 0);
        if ($currentDiv.find('.inv-left .dis').text() == '') {
            price_amt = main_price;
        } else {
            if ($currentDiv.find('#hdn_discount_surcharge_type').val() == 'Surcharge') {
                price_amt = main_price + (main_price * (discount / 100));
            } else {
                price_amt = main_price - (main_price * (discount / 100));
            }
        }
    } else {
        var discount = parseFloat($currentDiv.find('#hdn_discount_amount').val() || 0);
        if ($currentDiv.find('.inv-left .dis').text() == '') {
            price_amt = parseFloat(main_price);
        } else {
            if ($currentDiv.find('#hdn_discount_surcharge_type').val() == 'Surcharge') {
                price_amt = parseFloat(main_price) + discount;
            } else {
                price_amt = parseFloat(main_price) - discount;
            }
        }
    }

    // Update quantity for the current product
    var $input = $currentDiv.find('input.quantity');
    var newQuantity = parseInt($input.val()) - 1;
    newQuantity = newQuantity < 1 ? 1 : newQuantity; // Ensure quantity doesn't go below 1
    $input.val(newQuantity);

    // Update price for the current product
    var newPrice = price_amt * newQuantity;
    $currentDiv.find('.m_p').text('$' + newPrice);

    // Show the main_p_price if quantity is greater than or equal to 1
    if (newQuantity == 1) {
        $currentDiv.find('.main_p_price').hide();
    }else{
        $currentDiv.find('.main_p_price').show();
    }
    

    // Update quantity and price in other tabs
    $('.tab-pane').not($currentDiv.closest('.tab-pane')).each(function() {
        var $otherTab = $(this);
        $otherTab.find('.product-info1').each(function() {
            var $otherProduct = $(this);
            var productId = $otherProduct.attr('prod_id');

            if ($currentDiv.attr('prod_id') === productId) {
                var $quantity = $otherProduct.find('.quantity');
                var $price = $otherProduct.find('.m_p');

                if ($quantity.length > 0) {
                    var newQuantity = parseInt($quantity.val()) - 1;
                    newQuantity = newQuantity < 1 ? 1 : newQuantity; // Ensure quantity doesn't go below 1
                    $quantity.val(newQuantity);

                    var nPrice = price_amt;
                    $price.text('$' + nPrice * newQuantity);
                }
                // Exit the loop once the product is found
                return false;
            }
        });
    });

    // Update discount display
    var textValue = $currentDiv.find('.dis').text();
    var regex = /\$([\d.]+)/;
    var match = textValue.match(regex);

    if (match && match.length > 1) {
        var discountAmount = parseFloat(match[1]);

        // Calculate new discount amount based on discount type
        var newDiscountAmount = discountAmount;
        if (chk_dis_type == 'percent') {
            var editAmountValue = $currentDiv.find('#hdn_discount_amount').val();
            var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

            var discount = (parseFloat(main_price) * parsedEditAmount) / 100;
            // newDiscountAmount = discountAmount - discount;
        } else {
            var editAmountValue = $currentDiv.find('#hdn_discount_amount').val();
            var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

            // newDiscountAmount = discountAmount - parsedEditAmount;
        }
        newDiscountAmount = Math.max(newDiscountAmount, 0);

        // Update displayed discount value
        if ($currentDiv.find('#hdn_discount_surcharge_type').val() == 'Surcharge') {
            $currentDiv.find('.dis').text("( Surcharge: $" + newDiscountAmount.toFixed(2) + ")");
            $('#dynamic_discount').text(' Surcharge: $' + newDiscountAmount.toFixed(2));
        } else {
            $currentDiv.find('.dis').text("( Discount: $" + newDiscountAmount.toFixed(2) + ")");
            $('#dynamic_discount').text(' Discount: $' + newDiscountAmount.toFixed(2));
        }
    }

    updateSubtotalAndTotal(type);
    return false;
});

$(document).on('click', '.c_plus', function(e) {
    var type = "casual";
    var $currentDiv = $(this).closest('.product-info1');
    var chk_dis_type = $currentDiv.find('#discount_types').val();

    var main_price = parseFloat($currentDiv.find('#product_price').val());
    var price_amt;

    // Calculate price based on discount type
    if (chk_dis_type == 'percent') {
        var discount = parseFloat($currentDiv.find('#hdn_discount_amount').val() || 0);
        if ($currentDiv.find('.inv-left .dis').text() == '') {
            price_amt = main_price;
        } else {
            if ($currentDiv.find('#hdn_discount_surcharge_type').val() == 'Surcharge') {
                price_amt = main_price + (main_price * (discount / 100));
            } else {
                price_amt = main_price - (main_price * (discount / 100));
            }
        }
    } else {
        var discount = parseFloat($currentDiv.find('#hdn_discount_amount').val() || 0);
        if ($currentDiv.find('.inv-left .dis').text() == '') {
            price_amt = parseFloat(main_price);
        } else {
            if ($currentDiv.find('#hdn_discount_surcharge_type').val() == 'Surcharge') {
                price_amt = parseFloat(main_price) + discount;
            } else {
                price_amt = parseFloat(main_price) - discount;
            }
        }
    }

    // Update quantity for the current product
    var $input = $currentDiv.find('input.quantity');
    var newQuantity = parseInt($input.val()) + 1;
    $input.val(newQuantity);

    // Update price for the current product
    var newPrice = price_amt * newQuantity;
    $currentDiv.find('.m_p').text('$' + newPrice);

    // Show the main_p_price if quantity is greater than or equal to 1
    if (newQuantity >= 1) {
        $currentDiv.find('.main_p_price').show();
    }

    // Update quantity and price in other tabs
    // $('.tab-pane').not($currentDiv.closest('.tab-pane')).each(function() {
    //     var $otherTab = $(this);
    //     $otherTab.find('.product-info1').each(function() {
    //         var $otherProduct = $(this);
    //         var productId = $otherProduct.attr('prod_id');

    //         if ($currentDiv.attr('prod_id') === productId) {
    //             var $quantity = $otherProduct.find('.quantity');
    //             var $price = $otherProduct.find('.m_p');

    //             if ($quantity.length > 0) {
    //                 var newQuantity = parseInt($quantity.val()) + 1;
    //                 $quantity.val(newQuantity);

    //                 var nPrice = price_amt;
    //                 $price.text('$' + nPrice * newQuantity);

    //                 if (newQuantity === 1) {
    //                     $currentDiv.find('.main_p_price').hide();
    //                 } else {
    //                     $currentDiv.find('.main_p_price').show();
    //                 }
    //             }
    //             // Exit the loop once the product is found
    //             return false;
    //         }
    //     });
    // });

    // Update discount display
    var textValue = $currentDiv.find('.dis').text();
    var regex = /\$([\d.]+)/;
    var match = textValue.match(regex);

    if (match && match.length > 1) {
        var discountAmount = parseFloat(match[1]);

        // Calculate new discount amount based on discount type
        var newDiscountAmount = discountAmount;
        if (chk_dis_type == 'percent') {
            var editAmountValue = $currentDiv.find('#hdn_discount_amount').val();
            var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

            var discount = (parseFloat(main_price) * parsedEditAmount) / 100;
            // newDiscountAmount = discountAmount + discount;
        } else {
            var editAmountValue = $currentDiv.find('#hdn_discount_amount').val();
            var parsedEditAmount = editAmountValue !== "" ? parseFloat(editAmountValue) : 0;

            // newDiscountAmount = discountAmount + parsedEditAmount;
        }
        newDiscountAmount = Math.max(newDiscountAmount, 0);

        // Update displayed discount value
        if ($currentDiv.find('#hdn_discount_surcharge_type').val() == 'Surcharge') {
            $currentDiv.find('.dis').text("( Surcharge: $" + newDiscountAmount.toFixed(2) + ")");
            $('#dynamic_discount').text(' Surcharge: $' + newDiscountAmount.toFixed(2));
        } else {
            $currentDiv.find('.dis').text("( Discount: $" + newDiscountAmount.toFixed(2) + ")");
            $('#dynamic_discount').text(' Discount: $' + newDiscountAmount.toFixed(2));
        }
    }

    updateSubtotalAndTotal(type);
    return false;
});
$(document).on('click', '.product-name.clickable', function() {
    var id = $(this).attr('product_id');
    var name = $(this).attr('product_name');
    var price = $(this).attr('product_price');//$('#product_price').val();
    var product_price = $(this).attr('product_price');
    var quanitity = $(this).parent().parent().find('.quantity').val();

    // var discountText = $('#dynamic_discount').text();
    // var dis_price = discountText.replace('Discount: $', '');
    var discountText = $(this).parent().parent().find('#hdn_discount_text').val();
    var dis_price = 'Discount: $' + discountText;

    dis_price = $.trim(dis_price);
    
    if (dis_price === '') {
        dis_price = 0;
    }

    $('.edit_product').show();
    $('.main_walk_in').hide();
    if(quanitity > 1)
    {
        $('.main_detail_price').show();
    }else{
        $('.main_detail_price').hide();
    }
    $('#edit_product_id').val(id);
    $('.edit_product_name').text(name);
    $('.edit_product_quantity').text(quanitity);
    // $('.edit_product_price').text('$' + (price * quanitity - dis_price));
    $('.edit_product_price').find('b').text($(this).parent().find('.m_p').text());
    $('.main_detail_price').text('($' + (price  - discountText)+ ' ea)');
    $('.edit_price_per_unit').val((price));
    $('.edit_quantity').val(quanitity);
    // $('#edit_sale_staff_id').val($(this).parent().parent().parent().parent().find('.credit_sale').find('#sale_staff_id').val());

    //by default this field is disabled bcs of no discount selected
    // $('#edit_discount_type, #edit_amount, #edit_reason').prop('disabled', true);
    var dynamicValue = $(this).parent().parent().find('#discount_types').val();
    $('input[name="edit_discount_type"][value="' + dynamicValue + '"]').prop('checked', true);
    // if(dynamicValue == 'amount')
    // {

    // }
    var ck_sur = $(this).parent().parent().find('#hdn_discount_surcharge').val();
    if(ck_sur == 'No Discount')
    {
        $('#edit_discount_surcharge').val("No Discount");
        $('#edit_amount').val(0);
        $('#dynamic_discount').text()
        $('#edit_discount_type, #edit_amount, #edit_reason').prop('disabled', true);
        // $('#dynamic_discount').text('')
        $('#dynamic_discount').text('');
        $('#edit_reason').val('');
        $('#edit_sale_staff_id').val($(this).parent().parent().find('#hdn_who_did_work').val())
        
    }else if(ck_sur == 'Manual Discount'){
        $('#edit_discount_type, #edit_amount, #edit_reason').prop('disabled', false);
        var searchText = 'Manual Discount';
        $('#edit_discount_surcharge').val($('#edit_discount_surcharge option').filter(function() {
            return $(this).text() === searchText;
        }).val());
        $('#dynamic_discount').text('Discount: $' + $(this).parent().parent().find('#hdn_discount_text').val());
        $('#edit_amount').val($(this).parent().parent().find('#hdn_discount_amount').val());
        $('#edit_reason').val($(this).parent().parent().find('#hdn_reason').val());
        $('#edit_sale_staff_id').val($(this).parent().parent().find('#hdn_who_did_work').val())
    }else if(ck_sur == 'Manual Surcharge'){
        $('#edit_discount_type, #edit_amount, #edit_reason').prop('disabled', false);
        var searchText = 'Manual Surcharge';
        $('#edit_discount_surcharge').val($('#edit_discount_surcharge option').filter(function() {
            return $(this).text() === searchText;
        }).val());
        $('#dynamic_discount').text('Surcharge: $' + $(this).parent().parent().find('#hdn_discount_text').val());
        $('#edit_amount').val($(this).parent().parent().find('#hdn_discount_amount').val());
        $('#edit_reason').val($(this).parent().parent().find('#hdn_reason').val());
        $('#edit_sale_staff_id').val($(this).parent().parent().find('#hdn_who_did_work').val())
    }
    else{
        var searchText = $(this).parent().parent().find('#hdn_discount_surcharge').val();
        $('#edit_discount_surcharge').val($('#edit_discount_surcharge option').filter(function() {
            return $(this).text() === searchText;
        }).val());
        // $('#edit_discount_surcharge').val($(this).parent().parent().find('#hdn_discount_surcharge').val());
        var totalPrice = parseFloat(price) * quanitity;
        $('#dynamic_discount').text('Discount: $' + $(this).parent().parent().find('#hdn_discount_text').val());
        $('#edit_amount, #edit_reason').prop('disabled', true);
        $('input[name="edit_discount_type"][value="percent"]').prop('checked', true).prop('disabled', true);
        $('#edit_amount').val($(this).parent().parent().find('#hdn_discount_amount').val());
        $('#edit_reason').val($(this).parent().parent().find('#hdn_reason').val());
        $('#edit_sale_staff_id').val($(this).parent().parent().find('#hdn_who_did_work').val())
    }
});
$(document).on('keyup', '.casual_quantity', function(e) {
    var type = 'casual';
    var $currentDiv = $(this).closest('.product-info1'); // Reference to the current div
    var quantity = parseInt($(this).val());
    var mainPrice = parseFloat($currentDiv.find('#product_price').val());
    var discountAmount = parseFloat($currentDiv.find('.dis').text().replace(/[^\d.]/g, '')) || 0;

    // Calculate the total price based on quantity and discounts
    var totalPrice = (mainPrice * quantity) - (discountAmount * quantity);

    // Update the displayed price
    $currentDiv.find('.inv-number .m_p').text('$' + totalPrice.toFixed(2));

    // Trigger subtotal update
    updateSubtotalAndTotal(type);
});
$(document).on('click', '.edit_minus', function() {
    // Decrement quantity if greater than 1
    var quantityInput = $('.edit_quantity');
    var currentQuantity = parseInt(quantityInput.val());
    if (currentQuantity > 1) {
        quantityInput.val(currentQuantity - 1);
        $('.edit_product_quantity').text(currentQuantity - 1);
        if(currentQuantity - 1 == 1)
        {
            $('.main_detail_price').hide();
        }
        calculateAndUpdate(); // Update total and recalculate
    }
});
$(document).on('click', '.edit_plus', function() {
    // Increment quantity
    var quantityInput = $('.edit_quantity');
    var currentQuantity = parseInt(quantityInput.val());
    quantityInput.val(currentQuantity + 1);
    $('.edit_product_quantity').text(currentQuantity + 1);
    if(currentQuantity + 1 >= 1)
    {
        var text = $('#dynamic_discount').text();
        // Use a regular expression to extract the number
        var text = $('#dynamic_discount').text();
        var number = 0; // Default value is 0
        // Check if text is not null and matches the regular expression
        if (text !== null) {
            var match = text.match(/\d+\.\d+/);
            // If the match is found, parse the number
            if (match !== null) {
                number = parseFloat(match[0]);
            }
        }

        var pricePerUnit = parseFloat($('.edit_price_per_unit').val());
        var discountedPrice = pricePerUnit - number;
        $('.main_detail_price').text('$' + discountedPrice.toFixed(2) + 'ea');
        $('.main_detail_price').show();
    }
    calculateAndUpdate(); // Update total and recalculate
});
$(document).on('change', '#edit_discount_surcharge', function() {
    var selectedOption = $(this).val();
    var $discountType = $('#edit_discount_type');
    var $amount = $('#edit_amount');
    var $reason = $('#edit_reason');
    var $dynamicDiscount = $('#dynamic_discount');

    var selectedOption = $(this).find('option:selected');
    var optgroupLabel = selectedOption.parent().attr('label');
    
    if(optgroupLabel == 'Discount')
    {
        $('input[name="edit_discount_type"][value="percent"]').prop('checked', true);

        // Set the discount amount dynamically based on the selected dropdown value
        var discountValue = parseFloat($(this).val());
        if (isNaN(discountValue)) {
            discountValue = 0;
        }
        var pricePerUnit = parseFloat($('.edit_price_per_unit').val());//today
        var quantity = parseInt($('.edit_quantity').val());
        var totalAmount = pricePerUnit;
        var discountAmount = totalAmount * (discountValue / 100); // Calculate discount based on selected dropdown value

        // Update dynamic discount display
        $dynamicDiscount.text(' Discount: $' + discountAmount.toFixed(2));

        $amount.val(discountValue).prop('disabled', true); // Set the dropdown value to the discount field
        // $reason.val('Credit Card Surcharge').prop('disabled', true);

        // Recalculate edit_product_price with the discounted amount
        var newPrice = (totalAmount * quantity)- (discountAmount * quantity);

        // Update edit_product_price
        $('.edit_product_price').find('b').text('$' + newPrice.toFixed(2));
        var text = $('#dynamic_discount').text();
        // Use a regular expression to extract the number
        var text = $('#dynamic_discount').text();
        var number = 0; // Default value is 0
        // Check if text is not null and matches the regular expression
        if (text !== null) {
            var match = text.match(/\d+\.\d+/);
            // If the match is found, parse the number
            if (match !== null) {
                number = parseFloat(match[0]);
            }
        }

        $('.main_detail_price').text('$' + (pricePerUnit - number).toFixed(2) + 'ea');

        // Re-enable disabled fields
        // $amount.prop('disabled', false);
        $reason.prop('disabled', true);
        if($(this).find('option:selected').text() == 'Manual Discount')
        {
            $discountType.prop('disabled', false);
            $reason.val('');
            $amount.prop('disabled', false);
            $reason.prop('disabled', false);
        }else{
            $discountType.prop('disabled', true);
            $reason.val($('#edit_discount_surcharge').find('option:selected').text());
            $amount.prop('disabled', true);
        }
    }
    else if(optgroupLabel == 'Surcharge'){
        // Set the discount amount dynamically based on the selected dropdown value
        var discountValue = parseFloat($(this).val());
        if (isNaN(discountValue)) {
            discountValue = 0;
        }
        var pricePerUnit = parseFloat($('.edit_price_per_unit').val());
        var quantity = parseInt($('.edit_quantity').val());
        var totalAmount = pricePerUnit * quantity;
        var discountAmount = totalAmount * (discountValue / 100); // Calculate discount based on selected dropdown value

        // Update dynamic discount display
        $dynamicDiscount.text(' Surcharge: $' + discountAmount.toFixed(2));

        $amount.val(discountValue).prop('disabled', true); // Set the dropdown value to the discount field
        // $reason.val('Credit Card Surcharge').prop('disabled', true);

        // Recalculate edit_product_price with the discounted amount
        var newPrice = totalAmount + discountAmount;

        // Update edit_product_price
        $('.edit_product_price').find('b').text('$' + newPrice.toFixed(2));

        var text = $('#dynamic_discount').text();
        // Use a regular expression to extract the number
        var text = $('#dynamic_discount').text();
        var number = 0; // Default value is 0
        // Check if text is not null and matches the regular expression
        if (text !== null) {
            var match = text.match(/\d+\.\d+/);
            // If the match is found, parse the number
            if (match !== null) {
                number = parseFloat(match[0]);
            }
        }

        $('.main_detail_price').text('$' + (pricePerUnit + number).toFixed(2) + 'ea');
        

        // Re-enable disabled fields
        // $amount.prop('disabled', false);
        $reason.prop('disabled', true);
        if($(this).find('option:selected').text() == 'Manual Surcharge')
        {
            // $discountType.prop('disabled', false);
            $('input[name="edit_discount_type"]').prop('disabled', false);
            $reason.val('');
            $amount.prop('disabled', false);
            $reason.prop('disabled', false);
        }else{
            $discountType.prop('disabled', true);
            $reason.val($('#edit_discount_surcharge').find('option:selected').text());
            $('input[name="edit_discount_type"][value="percent"]').prop('checked', true).prop('disabled', true);
            $amount.prop('disabled', true);
        }
    }
    else{
        $discountType.prop('disabled', true);
        $amount.prop('disabled', true);
        $reason.prop('disabled', true);
        $amount.val('');
        $reason.val('');
        
        // Remove dynamic discount
        $dynamicDiscount.text('');
        
        // Recalculate edit_product_price
        calculatePrice();
    }
});
$(document).on('change', '#edit_discount_type, #edit_amount, .edit_price_per_unit, .edit_quantity', function() {
    var quantityInput = $('.edit_quantity');
    var currentQuantity = parseInt(quantityInput.val());
    quantityInput.val(currentQuantity);
    $('.edit_product_quantity').text(currentQuantity);
    
    calculateAndUpdate();
});
$(document).on('change', '#discount_surcharge', function() {
    var type =$('#discount_customer_type').val();
    checkDiscountSelection();
    updateSubtotalAndTotal(type);
});
$(document).on('click', '.cancel_invoice', function(e) {
    $('#paid_Invoice').modal('hide');
    $('.productDetails').empty();
    $('.NewproductDetails').empty();
    $('.ExistingproductDetails').empty();
    $('#existingclientmodal').hide();
    $('.subtotal').text('$0.00');
    $('.discount').text('$0.00');
    $('.total').text('$0.00');
    $('.gst_total').text('(Includes GST of $0.00)');
    $('#create_walkin_casual')[0].reset();
    $('#create_walkin_new')[0].reset();
    $('#create_walkin_existing')[0].reset();
    $('.main_walk_in').find('.add_discount').each(function() {
        // Update the HTML content of the element
        $(this).html('<i class="ico-percentage me-2 fs-5"></i>Add discount / surcharge');

        // Your additional code logic here for each element with the class 'add_discount'
    });
    $('input[name="discount_type"]').prop('disabled', false);
    $('#amount').prop('disabled', false);
    $('#amount').val(0);
    $('#reason').prop('disabled',false);
    $('#reason').val('');
    $('.discount').each(function() {
        var parentTd = $(this).parent().find('td');
        parentTd.text('Discount');

        var parentTds = $(this).parent().find('.discount');
        parentTds.text('$0.00');
    });
    $('#notes').text('');
    //payment
    $('#payment_type option:first').prop('selected',true);
    $('.send_email').val('');
})
$(document).on('click','.remove_product',function() {
    $(this).parent().remove();
    var type=$('#customer_type').val();
    $('.total_selected_product').val($('.total_selected_product').val() - 1);
    if($('.total_selected_product').val() == 0)
    {
        $('.take_payment').prop('disabled', true);
    }
    updateSubtotalAndTotal(type); // Update Subtotal and Total
})
$(document).on('click','.remove_edit_product',function() {
    $('.edit_product').hide();
    $('.main_walk_in').show();

    var edit_prod_id = $('#edit_product_id').val();
    var type=$('#customer_type').val();

    $('.invo-notice').each(function(index, element) {
        if($(this).attr('prod_id') == edit_prod_id)
        {
            $(this).remove();
            updateSubtotalAndTotal(type); // Update Subtotal and Total
        }
    });
})
$(document).on('change input', 'input[name="discount_type"], #amount', function() {
    var type =$('#discount_customer_type').val();
    updateSubtotalAndTotal(type);
});
$(document).on('click', '.take_payment', function(e) {
    e.preventDefault();
    
    // Check if the form is valid based on the active tab
    var activeTabId = $('.tab-pane.show.active').attr('id');
    var formIsValid = false;
    var formElement;

    if (activeTabId === 'casual_customer') {
        formIsValid = $("#create_walkin_casual").valid();
        formElement = document.getElementById("create_walkin_casual");
    } else if (activeTabId === 'new_customer') {
        formIsValid = $("#create_walkin_new").valid();
        formElement = document.getElementById("create_walkin_new");
    } else if (activeTabId === 'exist_customer') {
        formIsValid = $("#create_walkin_existing").valid();
        formElement = document.getElementById("create_walkin_existing");
    }
    
    if (formIsValid) {
        var data = new FormData(formElement); // Pass the correct form element
        $('#Walkin_Retail').modal('hide');
        $('#take_payment').modal('show');
        $('.make_sale_payment').show();
        if($('.edit_invoice_number:first').text()=='')
        {
            $('.payment_total').text('$' + $('.take_payment').attr('main_total'));
        }
        else
        {
            $('.payment_total').text('$' + $('.hdn_total').val());
        }
        $('.payment_amount').val($('.take_payment').attr('main_total'));
        
        // SubmitWalkIn(data);
        
        var id = $('#invoice_id').val();
        if (id != '') {
            $('.make_sale_payment').hide();
            $.ajax({
                headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ route('calendar.edit-invoice') }}",
                type: "POST",
                data: {'walk_ids': id},
                success: function (response) {
                    if (response.success) {
                        $('.make_sale_payment').show();
                        $('.payment_details').remove();
                        var totalPaymentAmount = 0; 
                        var paymentRow = $('<div class="row payment_details closed-stip"></div>');
                        // Append payment details from response
                        $.each(response.invoice.payments.reverse(), function(index, payment) {
                            var clonedRow = paymentRow.clone();

                            clonedRow.append(`
                                <input type="hidden" class="payment_id" name="payment_id[]" value="${payment.id}">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Payment</label>
                                            <select class="form-select form-control payment_type" name="payment_type[]" id="payment_type_${index}">
                                                <option ${payment.payment_type === 'Card' ? 'selected' : ''}>Card</option>
                                                <option ${payment.payment_type === 'Afterpay' ? 'selected' : ''}>Afterpay</option>
                                                <option ${payment.payment_type === 'Bank Transfer' ? 'selected' : ''}>Bank Transfer</option>
                                                <option ${payment.payment_type === 'Cash' ? 'selected' : ''}>Cash</option>
                                                <option ${payment.payment_type === 'Humm payment' ? 'selected' : ''}>Humm payment</option>
                                                <!-- <option ${payment.payment_type === 'Voucher' ? 'selected' : ''}>Voucher</option> -->
                                                <option ${payment.payment_type === 'Zip Pay' ? 'selected' : ''}>Zip Pay</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Amount</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ico-dollar fs-4"></i></span>
                                                <input type="number" class="form-control payment_amount" name="payment_amount[]" placeholder="0" value="${payment.amount}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Date</label>
                                            <input type="date" name="payment_date[]" class="form-control payment_date" placeholder="date" value="${payment.date}" readonly>
                                        </div>
                                    </div>
                                    <div class="remove_payment cross">
                                        <a href="#" class="remove_payment_btn"><button class="btn-close close_waitlist"></button></a>
                                    </div>
                                </div>`
                            );
                            // Add the payment amount to the total payment amount
                            $('.payment_data').prepend(clonedRow);
                            totalPaymentAmount += parseFloat(payment.amount);
                        });

                        $('.payment_total').text('$' + $('.take_payment').attr('main_total'));
                        $('.remaining_balance').text('$' + $('.take_payment').attr('main_remain'));
                    }
                }
            });
        }
        
        // Clear previous payment details
        // $('.payment_details').empty();

        // Append payment details from response
        
    }
});
$(document).on('click','.back_to_sale',function(){
    $('#take_payment').modal('hide');
    $('#Walkin_Retail').modal('show');
})
$(document).on('click','.add_another_payment',function(){
    var paymentDetailsClone = $('.payment_details').first().clone(); // Clone the first .payment_details div
    console.log('paymentDetailsClone',paymentDetailsClone);
    paymentDetailsClone.find('.payment_amount').val('0');
    paymentDetailsClone.find('.payment_id').val('0');
    $('.payment_details:last').after(paymentDetailsClone); // Append the cloned div after the last .payment_details div
    
    updateRemoveIconVisibility(); // Update remove icon visibility
    updateRemainingBalance(); // Update remaining balance
})
$(document).on('input', '.payment_amount', function() {
    updateRemainingBalance(); // Update remaining balance when payment amount changes
});
$(document).on('click', '.complete_sale', function() {
    var payment_total = $('.payment_total').text();
    var remaining_balance = $('.remaining_balance').text();

    var paymentIds = []; // Array to store selected payment types
    $('.payment_id').each(function() {
        paymentIds.push($(this).val()); // Push each payment amount into the array
    });
    
    var paymentTypes = []; // Array to store selected payment types
    $('select[name="payment_type[]"] option:selected').each(function() {
        paymentTypes.push($(this).val()); // Push each selected payment type into the array
    });

    var paymentAmounts = []; // Array to store payment amounts
    $('.payment_amount').each(function() {
        paymentAmounts.push($(this).val()); // Push each payment amount into the array
    });

    var paymentDates = [];
    $('input[name="payment_date[]"]').each(function() {
        paymentDates.push($(this).val());
    });

    // var formData = new FormData($('#create_walkin_casual')[0]);
    var activeTabId = $('.tab-pane.show.active').attr('id');
    var formIsValid = false;
    var formElement;

    if (activeTabId === 'casual_customer') {
        var formData = new FormData($('#create_walkin_casual')[0]);
        formData.append('hdn_customer_type', 'casual');

    } else if (activeTabId === 'new_customer') {
        var formData = new FormData($('#create_walkin_new')[0]);
        formData.append('hdn_customer_type', 'new');
    } else if (activeTabId === 'exist_customer') {
        var formData = new FormData($('#create_walkin_existing')[0]);
        formData.append('hdn_customer_type', 'existing');
    }
    
    // Append each payment type separately to FormData
    paymentIds.forEach(function(paymentIds) {
        formData.append('payment_ids[]', paymentIds);
    });
    
    // Append each payment type separately to FormData
    paymentTypes.forEach(function(paymentType) {
        formData.append('payment_types[]', paymentType);
    });

    paymentAmounts.forEach(function(paymentAmount) {
        formData.append('payment_amounts[]', paymentAmount);
    });

    paymentDates.forEach(function(paymentDate) {
        formData.append('payment_dates[]', paymentDate);
    });

    // formData.append('payment_amounts[]', paymentAmounts);
    // formData.append('payment_dates[]', paymentDates);
    formData.append('payment_total', payment_total);
    formData.append('remaining_balance', remaining_balance);

    SubmitWalkIn(formData);
});
$(document).on('click', '.remove_payment_btn', function() {
    $(this).closest('.payment_details').remove(); // Remove the closest .payment_details div
    updateRemoveIconVisibility(); // Update remove icon visibility
    updateRemainingBalance(); // Update remaining balance
});
$(document).on('click', '.view_invoice', function() {
    $('.error').remove();
    $('#payment_completed').modal('hide');
    $('#paid_Invoice').modal('show');
    var walk_ids = $(this).attr('walk_in_ids');
    $('.delete_invoice').attr('delete_id',walk_ids);
    $('.print_invoice').attr('ids',walk_ids);
    $('.edit_invoice').attr('edit_id',walk_ids);
    //ajax for invoice data
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ route('calendar.paid-invoice') }}",
        type: "POST",
        data: {'walk_ids': walk_ids},
        success: function (response) {
            if (response.success) {
                console.log('data',response.invoice)
                // response.invoice.invoice_date;
                // populateInvoiceModal(response.invoice);
                populateInvoiceModal(response.invoice, response.invoice.subtotal, response.invoice.discount, response.invoice.total);
            }
        }
    });
});
$(document).on('click','.send_receipt_payment_mail',function() {
    var email = $('.send_email_receipt').val();
    var walk_in_id = $('.edit_invoice').attr('edit_id');//$('.view_invoice').attr('walk_in_ids');

    // Regular expression for email validation
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    $('.error').remove();
    // Check if email is blank or doesn't match the email format
    if (!email) {
        // Show validation message for required field
        $('.send_email_receipt').after('<label for="email" class="error">Email is required.</label>');
        return; // Exit function
    } else if (!emailRegex.test(email)) {
        // Show validation message for invalid email format
        $('.send_email_receipt').after('<label for="email" class="error">Please enter a valid email.</label>');
        return; // Exit function
    }

    
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ route('calendar.send-payment-mail') }}",
        type: "POST",
        data: {'email': email,'walk_in_id':walk_in_id},
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    title: "Payment!",
                    text: "Payment Mail send successfully.",
                    type: "success",
                }).then((result) => {
                    // window.location = "{{url('calender')}}/"
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    type: "error",
                });
            }
        }
    });
})
$(document).on('click','.send_payment_mail',function() {
    var email = $('.send_email').val();
    var walk_in_id = $('.view_invoice').attr('walk_in_ids');

    // Regular expression for email validation
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    $('.error').remove();
    // Check if email is blank or doesn't match the email format
    if (!email) {
        // Show validation message for required field
        $('.send_email').after('<label for="email" class="error">Email is required.</label>');
        return; // Exit function
    } else if (!emailRegex.test(email)) {
        // Show validation message for invalid email format
        $('.send_email').after('<label for="email" class="error">Please enter a valid email.</label>');
        return; // Exit function
    }

    
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ route('calendar.send-payment-mail') }}",
        type: "POST",
        data: {'email': email,'walk_in_id':walk_in_id},
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    title: "Payment!",
                    text: "Payment Mail send successfully.",
                    type: "success",
                }).then((result) => {
                    // window.location = "{{url('calender')}}/"
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    type: "error",
                });
            }
        }
    });
})
$(document).on('click', '.print_quote', function() {
    // Create a hidden container element
    var dateValue = $('#datePicker1').val();
    var dateParts = dateValue.split('-'); // Assuming the date is in the format yyyy-mm-dd
    var formattedDates = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0]; // Rearranging the parts to dd-mm-yyyy format
    // Define an array to store product details
    var products = [];
    var activeTab = $('.tab-pane.active').find('.productDetails');
    // Iterate over each .productDetails element
    activeTab.find('.product-info1').each(function() {
        // Extract product information from the current .productDetails element
        var productName = $(this).find('[name="casual_product_name[]"]').val();
        var productQuanitity = $(this).find('[name="casual_product_quanitity[]"]').val();
        var productPrice = $(this).find('.m_p').text();

        // Create an object for the current product and push it to the products array
        var product = {
            name: productName,
            quantity: productQuanitity,
            price: productPrice
        };
        products.push(product);
    });
    console.log('products',products);
    var printContainer = document.createElement('div');
    printContainer.setAttribute('id', 'print-container');

    // Create printable content
    var printableContent = `
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            <style>
                @media print {
                    body * {
                        visibility: hidden;
                    }
                    #printable-content, #printable-content * {
                        visibility: visible;
                    }
                    #printable-content {
                        position: absolute;
                        left: 0;
                        right:0;
                        top: 0;
                        bottom:0;
                    }
                }
            </style>
        </head>
        <body>
            <div id="printable-content">
                <table style="width: 100%; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em;">
                    <tr>
                        <td style="text-align: right;">
                            <b>Dr Umed Cosmetics</b><br>
                            0407194519<br>
                            <a href="mailto:info@drumedcosmetics.com.au">info@drumedcosmetics.com.au</a><br>
                            ABN # xx-xxx-xxx
                        </td>
                    </tr>
                </table>
                <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">QUOTE</h3>
                <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">CUSTOMER</p>
                <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">DATE OF ISSUE<br> <b>${formattedDates}</b></p>
                <br>
                <table style="width: 100%; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em;">
                    <tr>
                        <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: left;" >Quantity</th>
                        <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: left;">Service</th>
                        <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: right;" >Price</th>
                    </tr>
                    ${products.map(product => `
                    <tr>
                        <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;">${product.quantity}</td>
                        <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;">${product.name}</td>
                        <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">${product.price}</td>
                    </tr>
                    `).join('')}
                    <tr>
                        <td colspan="3" style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">
                            Subtotal ${$('.tab-pane.active').find('.subtotal').text()}<br>
                            Total: <strong style="font-size: 20px;">${$('.tab-pane.active').find('.total').text()}</strong><br>
                            ${$('.tab-pane.active').find('.gst_total').text()}
                        </td>
                    </tr>
                </table>
            </div>
        </body>
    </html>
    `;

    // Set printable content to the container
    printContainer.innerHTML = printableContent;

    // Append container to document body
    document.body.appendChild(printContainer);

    // Print the page
    window.print();

    // Remove the container from the document body
    document.body.removeChild(printContainer);
});
$(document).on('click','.cancel_payment',function(){
    $('#Walkin_Retail').modal('hide');
    $('.productDetails').empty();
    $('.NewproductDetails').empty();
    $('.ExistingproductDetails').empty();
    $('#existingclientmodal').hide();
    $('.subtotal').text('$0.00');
    $('.discount').text('$0.00');
    $('.total').text('$0.00');
    $('.gst_total').text('(Includes GST of $0.00)');
    $('#create_walkin_casual')[0].reset();
    $('#create_walkin_new')[0].reset();
    $('#create_walkin_existing')[0].reset();
    $('.main_walk_in').find('.add_discount').each(function() {
        // Update the HTML content of the element
        $(this).html('<i class="ico-percentage me-2 fs-5"></i>Add discount / surcharge');

        // Your additional code logic here for each element with the class 'add_discount'
    });
    $('input[name="discount_type"]').prop('disabled', false);
    $('#amount').prop('disabled', false);
    $('#amount').val(0);
    $('#reason').prop('disabled',false);
    $('#reason').val('');
    $('.discount').each(function() {
        var parentTd = $(this).parent().find('td');
        parentTd.text('Discount');

        var parentTds = $(this).parent().find('.discount');
        parentTds.text('$0.00');
    });
    $('#notes').text('');
    //payment
    $('#payment_type option:first').prop('selected',true);
})
// var initialModalContent = $('#Walkin_Retail .modal-content').html();
$(document).on('click','.make_sale',function(){
    $('#Walkin_Retail').modal('show');
    $('.main_walkin').show();
    $('.walkin_loc_name').text($('#locations option:selected').text());
    $('.walk_in_location_id').val($('#locations').val());
    // Reset the modal content to its initial state
    // $('#Walkin_Retail .modal-content').html(initialModalContent);
    //clear all data
    $('.productDetails').empty();
    $('.NewproductDetails').empty();
    $('.ExistingproductDetails').empty();
    $('#existingclientmodal').hide();
    $('.subtotal').text('$0.00');
    $('.discount').text('$0.00');
    $('.total').text('$0.00');
    $('.gst_total').text('(Includes GST of $0.00)');
    $('#create_walkin_casual')[0].reset();
    $('#create_walkin_new')[0].reset();
    $('#create_walkin_existing')[0].reset();
    $('.main_walk_in').find('.add_discount').each(function() {
        // Update the HTML content of the element
        $(this).html('<i class="ico-percentage me-2 fs-5"></i>Add discount / surcharge');

        // Your additional code logic here for each element with the class 'add_discount'
    });
    $('input[name="discount_type"]').prop('disabled', false);
    $('#amount').prop('disabled', false);
    $('#amount').val(0);
    $('#reason').prop('disabled',false);
    $('#reason').val('');
    $('.discount').each(function() {
        var parentTd = $(this).parent().find('td');
        parentTd.text('Discount');

        var parentTds = $(this).parent().find('.discount');
        parentTds.text('$0.00');
    });
    $('#notes').text('');
    //payment
    $('#payment_type option:first').prop('selected',true);
    $('.edit_invoice_date').remove();
    $('.edit_invoice_number').remove();
    if($('.total_selected_product').val() == 0)
    {
        $('.take_payment').prop('disabled', true);
    }
    $('.remaining_balance').val(0);
    $('.take_payment').attr('main_total','');
    $('.take_payment').attr('main_remain',0);
    $('.edited_total').val(0);
    $('.invoice_id').val('');
})
$(document).on('click', '.casual_cus', function(e) {
    e.preventDefault(); // Prevent default link behavior
    var activeTab = $('.tab-pane.active').find('.productDetails');
    // Iterate over each .productDetails element
    activeTab.find('.product-info1').each(function() {
        if($(this).find('.casual_quantity').val() == 1)
        {
            $(this).find('.main_p_price').hide();
        }else{
            $(this).find('.main_p_price').show();
        }
    });
    $('#new_customer').hide();
    $('#casual_customer').show();
    $('#exist_customer').hide();
    // $('.total_selected_product').val('0');
    if($('.total_selected_product').val() == 0)
    {
        $('.take_payment').prop('disabled', true);
    }
    // if($('.casual_quantity').val() > 1)
    // {
    //     $('.main_p_price').show();
    // }else{
    //     $('.main_p_price').hide();
    // }
    $('#hdn_customer_type').val('casual');
    $('#customer_type').val('casual');
    // $("#casual_customer").load(location.href + " #casual_customer");
    // $('.add_dis').find('.subtotal').text('$0.00');
    // $('.add_dis').find('.discount').text('$0.00');
    // $('.add_dis').find('.total').text('$0.00');
    // $('#amount').val(0);
    $('#discount_surcharge').val('Manual Discount');
    $('#amount').prop('disabled', false);
    $('#discount_type').prop('disabled', false);
    $('#percent_type').prop('disabled', false);
    $('#reason').prop('disabled', false);
    $('.discount-row').show();
    $('#reason').val('');
});
$(document).on('click', '.new_cus', function(e) {
    var activeTab = $('.tab-pane.active').find('.productDetails');
    // Iterate over each .productDetails element
    activeTab.find('.product-info1').each(function() {
        if($(this).find('.casual_quantity').val() == 1)
        {
            $(this).find('.main_p_price').hide();
        }else{
            $(this).find('.main_p_price').show();
        }
    });
    e.preventDefault(); // Prevent default link behavior
    $('#casual_customer').hide();
    $('#exist_customer').hide();
    $('#new_customer').show();
    $('.new_tab').show();
    // $('.total_selected_product').val('0');
    if($('.total_selected_product').val() == 0)
    {
        $('.take_payment').prop('disabled', true);
    }
    // if($('.casual_quantity').val() > 1)
    // {
    //     $('.main_p_price').show();
    // }else{
    //     $('.main_p_price').hide();
    // }
    $('#hdn_customer_type').val('new');
    $('#customer_type').val('new');
    // $("#new_customer").load(location.href + " #new_customer");
    // $('.add_dis').find('.subtotal').text('$0.00');
    // $('.add_dis').find('.discount').text('$0.00');
    // $('.add_dis').find('.total').text('$0.00');
    // $('#amount').val(0);
    $('#discount_surcharge').val('Manual Discount');
    $('#amount').prop('disabled', false);
    $('#discount_type').prop('disabled', false);
    $('#percent_type').prop('disabled', false);
    $('#reason').prop('disabled', false);
    $('.discount-row').show();
    $('#reason').val('');
});
$(document).on('click', '.existing_cus', function(e) {
    e.preventDefault(); // Prevent default link behavior
    var activeTab = $('.tab-pane.active').find('.productDetails');
    // Iterate over each .productDetails element
    activeTab.find('.product-info1').each(function() {
        if($(this).find('.casual_quantity').val() == 1)
        {
            $(this).find('.main_p_price').hide();
        }else{
            $(this).find('.main_p_price').show();
        }
    });
    $('#casual_customer').hide();
    $('.existing_tab').show();
    $('#exist_customer').show();
    $('#new_customer').hide();
    // $('.total_selected_product').val('0');
    if($('.total_selected_product').val() == 0)
    {
        $('.take_payment').prop('disabled', true);
    }
    // if($('.casual_quantity').val() > 1)
    // {
    //     $('.main_p_price').show();
    // }else{
    //     $('.main_p_price').hide();
    // }
    $('#hdn_customer_type').val('existing');
    $('#customer_type').val('existing');
    // $("#exist_customer").load(location.href + " #exist_customer");
    // $('.add_dis').find('.subtotal').text('$0.00');
    // $('.add_dis').find('.discount').text('$0.00');
    // $('.add_dis').find('.total').text('$0.00');
    // $('#amount').val(0);
    $('#discount_surcharge').val('Manual Discount');
    $('#amount').prop('disabled', false);
    $('#discount_type').prop('disabled', false);
    $('#percent_type').prop('disabled', false);
    $('#reason').prop('disabled', false);
    $('.discount-row').show();
    $('#reason').val('');
});
$(document).on('click', '.existing_client_change', function() {
    $('.client_search_bar').show();
    $('#existingclientmodal').hide();
})
const changeProductInput = debounce((val) => {
    var results = matchProducts(val);
    if (results && results.length > 0) {
        updateSearchResults(results); // Update UI with search results
    } else {
        $('.resultproductmodal').empty(); // Clear search results if no data
        $('.products_box').hide(); // Hide the product search results box
    }
}, 300);
var client_details = [];
//change input event
const changeExistingCutomerInput = debounce((val) =>
{
    $('#clientDetails').empty();
    // $('.upcoming_appointments').empty();
    // $('.history_appointments').empty();

    // ajax call
    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{route('calendar.get-all-clients')}}",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            name: $('#search_exist_customer').val(),
        },
        dataType: "json",
        success: function(res) {
            if (res.length > 0) {
                $('.existing_client_list_box').show();
                for (var i = 0; i < res.length; ++i) {
                    // Check if the record with the same id already exists in the array
                    var existingRecordIndex = client_details.findIndex(record => record.id === res[i].id);

                    // If the record doesn't exist in the array, add it
                    if (existingRecordIndex === -1) {
                        // Push client details to the client_details array
                        client_details.push({
                            id: res[i].id,
                            name: res[i].first_name,
                            lastname: res[i].last_name,
                            email: res[i].email,
                            mobile_number: res[i].mobile_no,
                            date_of_birth: res[i].date_of_birth,
                            gender: res[i].gender,
                            home_phone: res[i].home_phone,
                            work_phone: res[i].work_phone,
                            contact_method: res[i].contact_method,
                            send_promotions: res[i].send_promotions,
                            street_address: res[i].street_address,
                            suburb: res[i].suburb,
                            city: res[i].city,
                            postcode: res[i].postcode,
                            client_photos:res[i].client_photos,
                            client_documents: [], // Initialize an empty array for client documents
                            service_name: res[i].last_appointment.service_name,
                            staff_name: res[i].last_appointment.staff_name,
                            start_date: res[i].last_appointment.appointment_date,
                            status: res[i].last_appointment.status,
                            location_name: res[i].last_appointment.location_name
                        });
                    }
                    // Iterate over client documents and push only doc_name and created_at
                    if (res[i].documents && res[i].documents.length > 0) {
                        for (var j = 0; j < res[i].documents.length; j++) {
                            // If the record with the same doc_id already exists in the array, skip
                            if (existingRecordIndex !== -1 && client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].doc_id)) {
                                continue;
                            }
                            // If the record doesn't exist in the array or the doc_id doesn't exist in the documents array, add it
                            if (existingRecordIndex === -1 || !client_details[existingRecordIndex].client_documents.some(doc => doc.doc_id === res[i].documents[j].doc_id)) {
                                client_details[existingRecordIndex !== -1 ? existingRecordIndex : i].client_documents.push({
                                    doc_id: res[i].documents[j].doc_id,
                                    doc_name: res[i].documents[j].doc_name,
                                    created_at: res[i].documents[j].created_at
                                });
                            }
                        }
                    }
                }
            } else {
                $('.table-responsive').empty();
            }
        },
        error: function(jqXHR, exception) {
            // Handle error
        }
    });

    var autoCompleteResult = matchClient(val);
    var resultElement = document.getElementById("resultexistingmodal"); 
    if (val.trim() === "") {
        resultElement.innerHTML = ""; // Clear the result if search box is empty
    } else {
        if (autoCompleteResult.length === 0) {
            resultElement.innerHTML = "<p>No records found</p>";
        } else {
            resultElement.innerHTML = ""; // Clear previous message if records are found
            for (var i = 0, limit = 10, len = autoCompleteResult.length; i < len && i < limit; i++) {
                var person = autoCompleteResult[i];
                var firstCharacter = person.name.charAt(0).toUpperCase();
                if(person.service_name == null)
                {
                    var appointment = `No Visit history`;
                }
                else
                {
                    var appointment = `<p>last appt at ${person.location_name} on ${person.start_date} </p>
                            <p> ${person.service_name} with ${person.staff_name}(${person.status})</p>`;
                }
                resultElement.innerHTML = `<li onclick='setSearchExistingModal("${person.name}")'>
                        <div class='client-name'>
                            <div class='drop-cap' style='background: #D0D0D0; color: #000;'>${firstCharacter}</div>
                            <div class="client-info">
                                <h4 class="blue-bold">${person.name} ${person.lastname}</h4>
                            </div>
                        </div>
                        <div class="mb-2">
                            <a href="#" class="river-bed"><b> ${person.mobile_number} </b></a><br>
                            <a href="#" class="river-bed"><b> ${person.email} </b></a>
                        </div>
                        ${appointment}
                    </li>`;
            }
        }
    }
});
function updateRemoveIconVisibility() {
    var paymentDetailsCount = $('.payment_details').length;
    if (paymentDetailsCount === 1) {
        $('.remove_payment_btn').hide();
    } else {
        $('.remove_payment_btn').show();
    }
}
function updateRemainingBalance() {
    
    var total = parseFloat($('.payment_total').text().replace('$', '')); // Get the total amount
    var totalPayments = 0;

    // Sum up all payment amounts
    $('.payment_amount').each(function() {
        var paymentAmount = parseFloat($(this).val());
        if (!isNaN(paymentAmount)) {
            totalPayments += paymentAmount;
        }
    });
    var remainingBalance = total - totalPayments; // Calculate the remaining balance
    $('.remaining_balance').text('$' + remainingBalance.toFixed(2)); // Update the remaining balance
}
function debounce(func, timeout = 300){
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => { func.apply(this, args); }, timeout);
    };
}
function checkDiscountSelection() {
    var selectedOption = $('#discount_surcharge').find('option:selected');
    var optgroupLabel = selectedOption.parent().attr('label');
    
    var selectedOption = $('#discount_surcharge');
    var $discountType = $('#discount_type');
    var $amount = $('#amount');
    var $reason = $('#reason');
    var $dynamicDiscount = $('#dynamic_discount');

    if(optgroupLabel == 'Discount')
    {
        $('input[name="discount_type"][value="percent"]').prop('checked', true);

        // Set the discount amount dynamically based on the selected dropdown value
        var discountValue = parseFloat($('#discount_surcharge').val());
        if (isNaN(discountValue)) {
            discountValue = 0;
        }
        var pricePerUnit = parseFloat($('#hdn_total').val());
        var quantity = parseInt($('.quantity').val());
        var totalAmount = pricePerUnit * quantity;
        var discountAmount = totalAmount * (discountValue / 100); // Calculate discount based on selected dropdown value

        // Update dynamic discount display
        // $dynamicDiscount.text(' Discount: $' + discountAmount.toFixed(2));

        $amount.val(discountValue).prop('disabled', true); // Set the dropdown value to the discount field
        // $reason.val('Credit Card Surcharge').prop('disabled', true);

        // Recalculate edit_product_price with the discounted amount
        var newPrice = totalAmount - discountAmount;

        // Update edit_product_price
        $('.edit_product_price').find('b').text('$' + newPrice.toFixed(2));
        $('.main_detail_price').text('($' + newPrice + ' ea)');

        // Re-enable disabled fields
        $amount.prop('disabled', false);
        $reason.prop('disabled', true);
        if($('#discount_surcharge').find('option:selected').text() == 'Manual Discount')
        {
            $('input[name="discount_type"]').prop('disabled', false);
            $reason.val('');
            $amount.prop('disabled', false);
            $reason.prop('disabled', false);
        }else{
            $discountType.prop('disabled', true);
            $reason.val($('#discount_surcharge').find('option:selected').text());
            $('input[name="discount_type"][value="percent"]').prop('checked', true).prop('disabled', true);
            $amount.prop('disabled', true);
        }
    }else if(optgroupLabel == 'Surcharge'){
        // Set the discount amount dynamically based on the selected dropdown value
        var discountValue = parseFloat($('#discount_surcharge').val());
        if (isNaN(discountValue)) {
            discountValue = 0;
        }
        var pricePerUnit = parseFloat($('#hdn_total').val());
        var quantity = parseInt($('.quantity').val());
        var totalAmount = pricePerUnit * quantity;
        var discountAmount = totalAmount * (discountValue / 100); // Calculate discount based on selected dropdown value

        // Update dynamic discount display
        // $dynamicDiscount.text(' Discount: $' + discountAmount.toFixed(2));

        $amount.val(discountValue).prop('disabled', true); // Set the dropdown value to the discount field
        // $reason.val('Credit Card Surcharge').prop('disabled', true);

        // Recalculate edit_product_price with the discounted amount
        var newPrice = totalAmount + discountAmount;

        // Update edit_product_price
        $('.product_price').text('$' + newPrice.toFixed(2));

        // Re-enable disabled fields
        $amount.prop('disabled', false);
        $reason.prop('disabled', true);
        if($('#discount_surcharge').find('option:selected').text() == 'Manual Surcharge')
        {
            $('input[name="discount_type"]').prop('disabled', false);
            $reason.val('');
            $amount.prop('disabled', false);
            $reason.prop('disabled', false);
        }else{
            $discountType.prop('disabled', true);
            $reason.val($('#discount_surcharge').find('option:selected').text());
            $('input[name="discount_type"][value="percent"]').prop('checked', true).prop('disabled', true);
            $amount.prop('disabled', true);
        }
    }
    else{
        $discountType.prop('disabled', true);
        $amount.prop('disabled', true);
        $reason.prop('disabled', true);
        $amount.val('');
        $reason.val('');
        
        // Remove dynamic discount
        $dynamicDiscount.text('');
        
        // Recalculate edit_product_price
        calculatePrice();
    }
}

function calculatePrice() {
    var pricePerUnit = parseFloat($('.edit_price_per_unit').val());
    var quantity = parseInt($('.edit_quantity').val());

    // Calculate new price without discount
    var newPrice = pricePerUnit * quantity;

    // Update edit_product_price
    $('.edit_product_price').find('b').text('$' + newPrice.toFixed(2));
    $('.main_detail_price').text('($' + pricePerUnit + ' ea)');
}

function calculateAndUpdate() {
    var pricePerUnit = parseFloat($('.edit_price_per_unit').val()) || 0;
    var quantity = parseInt($('.edit_quantity').val()) || 0;
    var discountType = $('input[name="edit_discount_type"]:checked').val();
    var amount = parseFloat($('#edit_amount').val());
    var discountAmount = 0;
    var edit_dis_sur = $('#edit_discount_surcharge').val();
    if (discountType === "amount" && !isNaN(amount)) {
        var selectedOption = $('#edit_discount_surcharge').find('option:selected');
        var optgroupLabel = selectedOption.parent().attr('label');
        if(optgroupLabel == 'Surcharge')
        {
            discountAmount = amount * 1;//quantity;

            var productPrice = pricePerUnit * quantity;
            var newTotal = productPrice + (discountAmount * quantity);
            // Update dynamic discount display
            $('#dynamic_discount').text(' Surcharge: $' + discountAmount.toFixed(2));
        }else if(optgroupLabel == 'Discount'){
            discountAmount = amount * 1;//quantity;

            var productPrice = pricePerUnit * quantity;
            var newTotal = productPrice - (discountAmount * quantity);
            $('input[name="edit_discount_type"][value="percent"]').prop('disabled', false);
            $('#dynamic_discount').text(' Discount: $' + discountAmount.toFixed(2));
        }else{
            var productPrice = pricePerUnit * quantity;
            var newTotal = productPrice + discountAmount;
        }

    } else if (discountType === "percent" && !isNaN(amount)) {
            var selectedOption = $('#edit_discount_surcharge').find('option:selected');
            var optgroupLabel = selectedOption.parent().attr('label');
            if(optgroupLabel == 'Surcharge'){
                var discountPercent = amount / 100;
                discountAmount = (pricePerUnit * 1) * discountPercent;
                // discountAmount = (pricePerUnit * quantity) * discountPercent;
                var newPrice = (pricePerUnit * quantity) - discountAmount;
                var productPrice = pricePerUnit * quantity;
                var newTotal = productPrice + (discountAmount * quantity);
                $('#dynamic_discount').text(' Surcharge: $' + discountAmount.toFixed(2));
            }
            else if(optgroupLabel == 'Discount'){
                var discountPercent = amount / 100;
                discountAmount = (pricePerUnit * 1) * discountPercent;
                // discountAmount = (pricePerUnit * quantity) * discountPercent;
                var newPrice = (pricePerUnit * quantity) - discountAmount;
                var productPrice = pricePerUnit * quantity;
                var newTotal = productPrice - (discountAmount * quantity);
                $('#dynamic_discount').text(' Discount: $' + discountAmount.toFixed(2));
            }else{
                var discountPercent = amount / 100;
                discountAmount = (pricePerUnit * quantity) * discountPercent;
                var newPrice = (pricePerUnit * quantity) - discountAmount;
                var productPrice = pricePerUnit * quantity;
                var newTotal = productPrice - discountAmount;
            }
    }else{
        var productPrice = pricePerUnit * quantity;
        var newTotal = productPrice + discountAmount;
    }

    // Calculate new price after discount
    

    // Update edit_product_price
    // $('.edit_product_price').text('$' + newPrice.toFixed(2));

    

    // Calculate new total after discount
    

    // Update edit_product_price
    $('.edit_product_price').find('b').text('$' + newTotal.toFixed(2));

    var text = $('#dynamic_discount').text();
    // Use a regular expression to extract the number
    var text = $('#dynamic_discount').text();
    var number = 0; // Default value is 0
    // Check if text is not null and matches the regular expression
    if (text !== null) {
        var match = text.match(/\d+\.\d+/);
        // If the match is found, parse the number
        if (match !== null) {
            number = parseFloat(match[0]);
        }
    }
    if(optgroupLabel == 'Surcharge'){
        $('.main_detail_price').text('$' + (pricePerUnit + number).toFixed(2) + 'ea');
    }else if(optgroupLabel == 'Discount'){
        $('.main_detail_price').text('$' + (pricePerUnit - number).toFixed(2) + 'ea');
    }else{
        $('.main_detail_price').text('$' + (pricePerUnit).toFixed(2) + 'ea');
    }
    // $('.main_detail_price').text('($' + pricePerUnit + ' ea)');
}
function updateRemainingBalance() {
        
    var total = parseFloat($('.payment_total').text().replace('$', '')); // Get the total amount
    var totalPayments = 0;

    // Sum up all payment amounts
    $('.payment_amount').each(function() {
        var paymentAmount = parseFloat($(this).val());
        if (!isNaN(paymentAmount)) {
            totalPayments += paymentAmount;
        }
    });
    var remainingBalance = total - totalPayments; // Calculate the remaining balance
    $('.remaining_balance').text('$' + remainingBalance.toFixed(2)); // Update the remaining balance
}
function updateQuantity() {
    var newQuantity = parseInt($('.edit_quantity').val());
    // $('.edit_product_quantity').text(newQuantity);
}
function updatePrice() {
    var pricePerUnit = parseFloat($('.edit_price_per_unit').val());
    var quantity = parseInt($('.edit_quantity').val());
    var totalPrice = pricePerUnit * quantity;
    $('.edit_product_price').find('b').text('$' + totalPrice.toFixed(2));
    $('.main_detail_price').text('($' + totalPrice + ' ea)');
}
function matchClient(input) {
    var reg = new RegExp(input.trim(), "i");
    var res = [];
    if (input.trim().length === 0) {
        return res;
    }
    for (var i = 0, len = client_details.length; i < len; i++) {
        var person = client_details[i];
        // Check specifically for the mobile_number number field
        if (person.mobile_number && person.mobile_number.match(reg)) {
            res.push(person);
        } else {
            // If mobile_number number didn't match, check other fields
            for (var key in person) {
                if (person.hasOwnProperty(key) && typeof person[key] === 'string' && person[key].match(reg)) {
                    res.push(person);
                    break; // Break loop if any field matches
                }
            }
        }
    }
    return res;
}
function matchProducts(input) {
    var reg = new RegExp(input.trim(), "i");
    var p_details=JSON.parse(localStorage.getItem('product_details'));
    
    var res = [];
    if (input.trim().length === 0) {
        return res;
    }
    for (var i = 0, len = p_details.length; i < len; i++) {

        var product = p_details[i];
        if (product.name && product.name.match(reg)) {
            res.push(product);
        }
    }
    return res;
}
function updateSearchResults(results) {
    var resultList = $('.resultproductmodal');
    resultList.empty(); // Clear previous search results
    for (var i = 0; i < results.length; i++) {
        // resultList.append(`<li>${results[i].name}</li>`); // Update HTML with search results

        resultList.append(`<li class="selectedProduct" prods_id="${results[i].id}" prods_type="${results[i].product_type}" prods_name="${results[i].name}" onclick='setProductSearchModal("${results[i].name}", "${results[i].id}", "${results[i].product_type}")'>
            <aside>${results[i].name}</aside> <aside>${'$'+results[i].price}</aside>
        </li>`);

    }
    $('.products_box').show(); // Show the product search results box
}

function setProductSearchModal(value,id,type) {
    // Retrieve the selected value from the clicked element
    $('.products_box').hide();

    var activeTabContainer = $('.productDetails');

    // Get existing product elements associated with the active tab
    var activeTabProducts = activeTabContainer.find('.product-info1');

    // Iterate over existing products to check if the selected product already exists
    var productExists = false;
    activeTabProducts.each(function() {
        var prodName = $(this).find('.inv-left b').text();
        var prodId = $(this).find('#product_id').val();
        var prodType = $(this).find('#product_type').val();
        // If the product already exists, update its quantity
        if (prodName === value && prodId === id && prodType === type) {
            var quantityInput = $(this).find('.casual_quantity');
            var quantity = parseInt(quantityInput.val()) + 1;
            quantityInput.val(quantity);

            productExists = true;
            
            //update total start
            var newPrice = ($(this).find('#product_price').val() * quantity) - (parseFloat($('#hdn_discount_text').val()) * quantity);
            // $currentDiv.find('.m_p').text('$' + newPrice);
            $(this).find('.m_p').text(parseFloat(newPrice).toFixed(2));

            // Show the main_p_price if quantity is greater than or equal to 1
            if (quantity >= 1) {
                // $currentDiv.find('.main_p_price').show();
                $(this).find('.main_p_price').show();
            }
            
            //update total end
            updateSubtotalAndTotal(type); // Update Subtotal and Total

            // document.getElementsByClassName('search_products').value = '';
            $('.search_products').val('');
            // return false; // Exit the loop
        }
    });

    // If the product does not exist, add a new entry
    if (!productExists) {
        var p_details=JSON.parse(localStorage.getItem('product_details'));
        for (const key in p_details) {
            console.log(p_details);
            if (p_details.hasOwnProperty(key)) {
                const product = p_details[key];
                // Check if value matches any field in the product object
                if (product.name === value) {
                    console.log(product);
                    // If a match is found, dynamically bind HTML to productDetails element
                    $('.productDetails').append(
                        `<div class="invo-notice mb-4 closed product-info1" prod_id='${product.id}'>
                            <a href="#" class="btn cross remove_product"><i class="ico-close"></i></a>
                            <input type='hidden' name='casual_product_name[]' value='${product.name}'>
                            <input type='hidden' id="product_id" name='casual_product_id[]' value='${product.id}'>
                            <input type='hidden' id="product_price" name='casual_product_price[]' value='${product.price}'>
                            <input type='hidden' id="product_gst" name='product_gst' value='${product.gst}'>
                            <input type='hidden' id="discount_types" name='casual_discount_types[]' value='amount'>
                            <input type='hidden' id="hdn_discount_surcharge" name='casual_discount_surcharge[]' value='No Discount'>
                            <input type='hidden' id="hdn_discount_surcharge_type" name='hdn_discount_surcharge_type[]' value=''>
                            <input type='hidden' id="hdn_discount_amount" name='casual_discount_amount[]' value='0'>
                            <input type='hidden' id="hdn_discount_text" name='casual_discount_text[]' value='0'>
                            <input type='hidden' id="hdn_reason" name='casual_reason[]' value=''>
                            <input type='hidden' id="hdn_who_did_work" name='casual_who_did_work[]' value='no one'>
                            <input type='hidden' id="hdn_edit_amount" name='casual_edit_amount[]' value='0'>
                            <input type='hidden' id="product_type" name='product_type[]' value='${product.product_type}'>
                            <div class="inv-left"><div><b>${product.name}</b><div class="who_did_work"></div><span class="dis"></div></span></div>
                            <div class="inv-center">
                                <div class="number-input walk_number_input safari_only form-group mb-0 number">
                                    <button class="c_minus minus"></button>
                                    <input type="number" class="casual_quantity quantity form-control" min="0" name="casual_product_quanitity[]" value="1">
                                    <button class="c_plus plus"></button>
                                </div>
                            </div>
                            <div class="inv-number go price">
                                <div>
                                    <div class="m_p">${'$'+product.price}</div>
                                        <div class="main_p_price" style="display:none;">(${'$'+product.price} ea)
                                    </div>
                                </div>
                                <a href="#" class="btn btn-sm px-0 product-name clickable" product_id="${product.id}" product_name="${product.name}" product_price="${product.price}"><i class="ico-right-arrow fs-2 ms-3"></i></a>
                            </div>
                        </div>`
                    );
                    var type='casual';
                    $('.total_selected_product').val(parseFloat($('.total_selected_product').val()) + 1);
                    if($('.total_selected_product').val() > 0)
                    {
                        $('.take_payment').prop('disabled', false);
                    }
                    updateSubtotalAndTotal(type); // Update Subtotal and Total

                    // document.getElementsByClassName('search_products').value = '';
                    $('.search_products').val('');
                    break; // Stop iterating once a match is found
                }
            }
        }
    }
}
function SubmitWalkIn(formData){
    $.ajax({
        headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: "{{ route('calendar.store-walk-in') }}",
        type: "post",
        data: formData,
        contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
        processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
        cache: false, // To unable request pages to be cached
        success: function(response) {
            
            // Show a Sweet Alert message after the form is submitted.
            if (response.success) {
                console.log("res",response);
                var amount = response.amount;
                var walk_in_id = response.walk_in_id;
                var username = response.username;
                var client_email = response.client_email;
                $('.send_email').val(client_email);
                $('#take_payment').modal('hide');
                $("#payment_completed").modal('show');
                $('.view_invoice').attr('walk_in_ids',walk_in_id);
                $('.print_invoice').attr('ids',walk_in_id);
                // Get today's date
                var today = new Date();
                // Define month names
                var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                // Format the date
                var formattedDate = today.getDate() + ' ' + monthNames[today.getMonth()] + ' ' + today.getFullYear();

                // var message = 'Payment of $' + amount + ' has been processed by Praharsh test on ' + formattedDate;
                // var message = '<h4>Payment Completed</h4>Payment of $' + amount + ' has been processed by Praharsh test on ' + formattedDate;
                // $('.payment_complete_message').text(message);

                var message = '<h4>Payment Completed</h4>Payment of $' + amount + ' has been processed by '+ username +' on ' + formattedDate;

                // Assuming you're using jQuery to update an element with id "paymentMessage"
                $('#paymentMessage').html(message);
                $('#create_walkin_new')[0].reset();


            } else {
                
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    type: "error",
                });
            }
        },
    });
}
function updateSubtotalAndTotal(type) {
    if(type === 'casual') {
        
        var subtotal = 0;
        var discount = 0;
        var discount_type = $('input[name="discount_type"]:checked').val();
        var amountInput = $('#amount').val();
        var amount = parseFloat(amountInput.trim() !== '' ? amountInput : 0);
        var gst = 0;
        $('.tab-pane.active .product-info1').each(function() {
            if($(this).find('.dis').text() == '')
            {
                var price = parseFloat($(this).find('#product_price').val()); //parseFloat($(this).find('.price').text().replace('$', ''));
            }
            else
            {
                var chk_dis_type = $(this).find('#discount_types').val();
                if(chk_dis_type == 'amount')
                {
                    if($(this).find('#hdn_discount_surcharge_type').val() == 'Surcharge')
                    {
                        var price = parseFloat($(this).find('#product_price').val()) + parseFloat($(this).find('#hdn_discount_amount').val());    
                    }else{
                        var price = parseFloat($(this).find('#product_price').val()) - parseFloat($(this).find('#hdn_discount_amount').val());    
                    }
                }
                else
                {
                    if($(this).find('#hdn_discount_surcharge_type').val() == 'Surcharge')
                    {
                        var price = parseFloat($(this).find('#product_price').val()) + (parseFloat($(this).find('#product_price').val()) * ($(this).find('#hdn_discount_amount').val() / 100));    
                    }
                    else{
                        var price = parseFloat($(this).find('#product_price').val()) - (parseFloat($(this).find('#product_price').val()) * ($(this).find('#hdn_discount_amount').val() / 100));
                    }
                }                    
            }
            var quantity = parseInt($(this).find('.quantity').val());
            // subtotal += (price * quantity) + (parseFloat($(this).find('#hdn_discount_amount').val()));
            subtotal += (price * quantity);

            var text = $(this).find('.dis').text();

            // Regular expression to extract the numerical value
            var regex = /(\$[\d,]+\.\d{2})/;

            // Match the regular expression against the text
            var match = regex.exec(text);

            var discount = 0;

            if (match) {
                // Extract the numerical value from the matched result
                discount = match[0].replace(/\$/, ''); // Remove '$' sign
            }

            // if($(this).find('#discount_types').val() == 'percent')
            // {
            //     subtotal = subtotal + parseFloat(discount);
            // }

            // if($(this).find('#product_gst').val() == 'yes'){
                gst += price / 11; // Assuming GST is 11% of total
            // } else {
            //     gst += 0; // GST is 0 when the condition is not met
            // }
        });

        // Calculate discount based on discount type
        if (discount_type === 'percent') {
            // add condition
            if($('#discount_surcharge').val() != '')
            {
                //add condition here
                discount = (subtotal * amount) / 100; // Calculate percentage discount
            }else{
                discount = (subtotal * amount) / 100; // Calculate percentage discount
            }
            
        } else if (discount_type === 'amount') {
            discount = amount; // Use the entered amount as the discount
        }

        var dis_sur = $('#discount_surcharge option:selected').closest('optgroup').attr('label');
        if(dis_sur == 'Surcharge')
        {
            var total = subtotal + discount; // Calculate total after discount
        }else{
            var total = subtotal - discount; // Calculate total after discount
        }
        
        
        
        var grandTotal = total + gst; // Calculate total including GST
        $('.hdn_subtotal').val(subtotal.toFixed(2));
        $('.hdn_discount').val(discount.toFixed(2));
        $('.hdn_total').val(total.toFixed(2));
        $('.hdn_gst').val(gst.toFixed(2));
        // if($('.edit_invoice_number:first').text()=='')
        // {
        //     $('.take_payment').attr('main_total',total.toFixed(2));
        // }
        // else
        // {
            var edit_total = $('.edited_total').val();
            $('.take_payment').attr('main_total',total.toFixed(2));
            // parseFloat($('.take_payment').attr('main_remain'))
            if(parseFloat($('.take_payment').attr('main_remain')) == 0)
            {
                $('.take_payment').attr('main_remain',parseFloat((total.toFixed(2) - edit_total)).toFixed(2));    
            }else{
                $('.take_payment').attr('main_remain',parseFloat((total.toFixed(2) - parseFloat($('.take_payment').attr('main_remain')))).toFixed(2));
            }
            // $('.remaining_balance').text('$' + (total.toFixed(2) - edit_total));
            $('.payment_total').text('$' + (total.toFixed(2)));
        // }

        // Update the displayed values on the page
        $('.subtotal').text('$' + subtotal.toFixed(2));

        $('.discount').each(function() {
            var parentTd = $(this).parent().find('td');
            parentTd.text($('#discount_surcharge option:selected').closest('optgroup').attr('label'));
        });


        $('.discount').text('$' + discount.toFixed(2));
        $('.total').html('<b>$' + total.toFixed(2) + '</b>');
        $('.gst_total').text('(Includes GST of $' + gst.toFixed(2) + ')');
        // $('.grand-total').text('$' + grandTotal.toFixed(2));
    }
    else if(type === 'new') {
        
        var subtotal = 0;
        var discount = 0;
        var discount_type = $('input[name="discount_type"]:checked').val();
        var amountInput = $('#amount').val();
        var amount = parseFloat(amountInput.trim() !== '' ? amountInput : 0);
        var gst = 0;
        $('.tab-pane.active .product-info1').each(function() {
            if($(this).find('.dis').text() == '')
            {
                var price = parseFloat($(this).find('#product_price').val()); //parseFloat($(this).find('.price').text().replace('$', ''));
            }
            else
            {
                var chk_dis_type = $(this).find('#discount_types').val();
                if(chk_dis_type == 'amount')
                {
                    if($(this).find('#hdn_discount_surcharge_type').val() == 'Surcharge')
                    {
                        var price = parseFloat($(this).find('#product_price').val()) + parseFloat($(this).find('#hdn_discount_amount').val());    
                    }else{
                        var price = parseFloat($(this).find('#product_price').val()) - parseFloat($(this).find('#hdn_discount_amount').val());    
                    }
                }
                else
                {
                    if($(this).find('#hdn_discount_surcharge_type').val() == 'Surcharge')
                    {
                        var price = parseFloat($(this).find('#product_price').val()) + (parseFloat($(this).find('#product_price').val()) * ($(this).find('#hdn_discount_amount').val() / 100));    
                    }
                    else{
                        var price = parseFloat($(this).find('#product_price').val()) - (parseFloat($(this).find('#product_price').val()) * ($(this).find('#hdn_discount_amount').val() / 100));
                    }
                }
            }
            var quantity = parseInt($(this).find('.quantity').val());
            subtotal += price * quantity;

            var text = $(this).find('.dis').text();

            // Regular expression to extract the numerical value
            var regex = /(\$[\d,]+\.\d{2})/;

            // Match the regular expression against the text
            var match = regex.exec(text);

            var discount = 0;

            if (match) {
                // Extract the numerical value from the matched result
                discount = match[0].replace(/\$/, ''); // Remove '$' sign
            }

            // if($(this).find('#discount_types').val() == 'percent')
            // {
            //     subtotal = subtotal + parseFloat(discount);
            // }

            // if($(this).find('#product_gst').val() == 'yes'){
                gst += price / 11; // Assuming GST is 11% of total
            // } else {
            //     gst += 0; // GST is 0 when the condition is not met
            // }
        });

        // Calculate discount based on discount type
        if (discount_type === 'percent') {
            discount = (subtotal * amount) / 100; // Calculate percentage discount
        } else if (discount_type === 'amount') {
            discount = amount; // Use the entered amount as the discount
        }

        var dis_sur = $('#discount_surcharge option:selected').closest('optgroup').attr('label');
        if(dis_sur == 'Surcharge')
        {
            var total = subtotal + discount; // Calculate total after discount
        }else{
            var total = subtotal - discount; // Calculate total after discount
        }
        // var total = subtotal - discount; // Calculate total after discount
        // var gst = total * 0.05; // Assuming GST is 5% of total
        // var grandTotal = total + gst; // Calculate total including GST

        // Update the displayed values on the page
        $('.hdn_subtotal').val(subtotal.toFixed(2));
        $('.hdn_discount').val(discount.toFixed(2));
        $('.hdn_total').val(total.toFixed(2));
        $('.hdn_gst').val(gst.toFixed(2));
        // if($('.edit_invoice_number:first').text()=='')
        // {
        //     $('.take_payment').attr('main_total',total.toFixed(2));
        // }
        // else
        // {
            var edit_total = $('.edited_total').val();
            $('.take_payment').attr('main_total',total.toFixed(2));
            // $('.take_payment').attr('main_remain',(total.toFixed(2) - edit_total));
            if(parseFloat($('.take_payment').attr('main_remain')) == 0)
            {
                $('.take_payment').attr('main_remain',parseFloat((total.toFixed(2) - edit_total)).toFixed(2));    
            }else{
                $('.take_payment').attr('main_remain',parseFloat((total.toFixed(2) - parseFloat($('.take_payment').attr('main_remain')))).toFixed(2));
            }
            // $('.remaining_balance').text('$' + (total.toFixed(2) - edit_total));
            $('.payment_total').text('$' + (total.toFixed(2)));
        // }

        $('.subtotal').text('$' + subtotal.toFixed(2));
        
        $('.discount').each(function() {
            var parentTd = $(this).parent().find('td');
            parentTd.text($('#discount_surcharge option:selected').closest('optgroup').attr('label'));
        });

        $('.discount').text('$' + discount.toFixed(2));
        $('.total').html('<b>$' + total.toFixed(2) + '</b>');
        $('.gst_total').text('(Includes GST of $' + gst.toFixed(2) + ')');
        // $('.grand-total').text('$' + grandTotal.toFixed(2));
    }
    else {
        var subtotal = 0;
        var discount = 0;
        var discount_type = $('input[name="discount_type"]:checked').val();
        var amountInput = $('#amount').val();
        var amount = parseFloat(amountInput.trim() !== '' ? amountInput : 0);
        var gst = 0;
        $('.tab-pane.active .product-info1').each(function() {
            if($(this).find('.dis').text() == '')
            {
                var price = parseFloat($(this).find('#product_price').val()); //parseFloat($(this).find('.price').text().replace('$', ''));
            }
            else
            {
                var chk_dis_type = $(this).find('#discount_types').val();
                if(chk_dis_type == 'amount')
                {
                    if($(this).find('#hdn_discount_surcharge_type').val() == 'Surcharge')
                    {
                        var price = parseFloat($(this).find('#product_price').val()) + parseFloat($(this).find('#hdn_discount_amount').val());    
                    }else{
                        var price = parseFloat($(this).find('#product_price').val()) - parseFloat($(this).find('#hdn_discount_amount').val());    
                    }
                }
                else
                {
                    if($(this).find('#hdn_discount_surcharge_type').val() == 'Surcharge')
                    {
                        var price = parseFloat($(this).find('#product_price').val()) + (parseFloat($(this).find('#product_price').val()) * ($(this).find('#hdn_discount_amount').val() / 100));    
                    }
                    else{
                        var price = parseFloat($(this).find('#product_price').val()) - (parseFloat($(this).find('#product_price').val()) * ($(this).find('#hdn_discount_amount').val() / 100));
                    }
                }
            }
            // var price = parseFloat($(this).find('.price').text().replace('$', ''));
            var quantity = parseInt($(this).find('.quantity').val());
            subtotal += price * quantity;

            var text = $(this).find('.dis').text();

            // Regular expression to extract the numerical value
            var regex = /(\$[\d,]+\.\d{2})/;

            // Match the regular expression against the text
            var match = regex.exec(text);

            var discount = 0;

            if (match) {
                // Extract the numerical value from the matched result
                discount = match[0].replace(/\$/, ''); // Remove '$' sign
            }

            // if($(this).find('#product_gst').val() == 'yes'){
                gst += price / 11; // Assuming GST is 11% of total
            // } else {
            //     gst += 0; // GST is 0 when the condition is not met
            // }
        });

        // Calculate discount based on discount type
        if (discount_type === 'percent') {
            discount = (subtotal * amount) / 100; // Calculate percentage discount
        } else if (discount_type === 'amount') {
            discount = amount; // Use the entered amount as the discount
        }
        var dis_sur = $('#discount_surcharge option:selected').closest('optgroup').attr('label');
        if(dis_sur == 'Surcharge')
        {
            var total = subtotal + discount; // Calculate total after discount
        }else{
            var total = subtotal - discount; // Calculate total after discount
        }
        // var total = subtotal - discount; // Calculate total after discount
        // var gst = total * 0.05; // Assuming GST is 5% of total
        // var grandTotal = total + gst; // Calculate total including GST

        // Update the displayed values on the page
        $('.hdn_subtotal').val(subtotal.toFixed(2));
        $('.hdn_discount').val(discount.toFixed(2));
        $('.hdn_total').val(total.toFixed(2));
        $('.hdn_gst').val(gst.toFixed(2));
        
        // if($('.edit_invoice_number:first').text()=='')
        // {
        //     $('.take_payment').attr('main_total',total.toFixed(2));
        // }
        // else
        // {
            var edit_total = $('.edited_total').val();
            $('.take_payment').attr('main_total',total.toFixed(2));
            // $('.take_payment').attr('main_remain',(total.toFixed(2) - edit_total));
            if(parseFloat($('.take_payment').attr('main_remain')) == 0)
            {
                $('.take_payment').attr('main_remain',parseFloat((total.toFixed(2) - edit_total)).toFixed(2));    
            }else{
                $('.take_payment').attr('main_remain',parseFloat((total.toFixed(2) - parseFloat($('.take_payment').attr('main_remain')))).toFixed(2));
            }
            // $('.remaining_balance').text('$' + (total.toFixed(2) - edit_total)); 
            $('.payment_total').text('$' + (total.toFixed(2)));
        // }
        
        $('.subtotal').text('$' + subtotal.toFixed(2));
        
        $('.discount').each(function() {
            var parentTd = $(this).parent().find('td');
            parentTd.text($('#discount_surcharge option:selected').closest('optgroup').attr('label'));
        });

        $('.discount').text('$' + discount.toFixed(2));
        $('.total').html('<b>$' + total.toFixed(2) + '</b>');
        $('.gst_total').text('(Includes GST of $' + gst.toFixed(2) + ')');
        // $('.grand-total').text('$' + grandTotal.toFixed(2));
    }
}


function calculateTotalPaid(payments) {
    return payments.reduce((total, payment) => total + parseFloat(payment.amount), 0).toFixed(2);
}

function printInvoice(invoiceData) {
    var date = invoiceData.invoice_date;
    var d = new Date(date.split("/").reverse().join("-"));
    var dd = String(d.getDate()).padStart(2, '0'); // Ensure two digits for day
    var mm = String(d.getMonth() + 1).padStart(2, '0'); // Ensure two digits for month
    var yy = d.getFullYear();
    var formattedDate = dd + "-" + mm + "-" + yy;
    console.log(formattedDate); // Output: "29-04-2024"

    var productsHTML = invoiceData.products.map(product => `
        <tr>
            <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;">${product.product_quantity}</td>
            <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;">${product.product_name}</td>
            <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">${product.product_price}</td>
        </tr>
    `).join('');

    var cardDetailsHTML = invoiceData.payments.map(cards => {
        // Convert the date string to a Date object
        var date = new Date(cards.date);

        // Get the day, month, and year
        var day = date.getDate();
        var month = date.getMonth() + 1; // Month is zero-based, so we add 1
        var year = date.getFullYear();

        // Pad single-digit day and month with leading zeros if necessary
        day = day < 10 ? '0' + day : day;
        month = month < 10 ? '0' + month : month;

        // Format the date as dd-mm-yyyy
        var formattedDate = `${day}-${month}-${year}`;

        // Construct the HTML for the table row
        return `
            <tr>
                <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;"><b>${formattedDate} ${cards.payment_type}</b></td>
                <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;"></td>
                <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">$${cards.amount}</td>
            </tr>
        `;
    }).join('');


    var printableContent = `
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            <style>
                @media print {
                    body * {
                        visibility: hidden;
                    }
                    #printable-content, #printable-content * {
                        visibility: visible;
                    }
                    #printable-content {
                        position: absolute;
                        left: 0;
                        right:0;
                        top: 0;
                        bottom:0;
                    }
                }
            </style>
        </head>
        <body>
        <div id="printable-content">
            <table style="width: 100%; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em;">
                <tr>
                    <td style="text-align: right;">
                        <b>Dr Umed Cosmetics</b><br>
                        0407194519<br>
                        <a href="mailto:info@drumedcosmetics.com.au">info@drumedcosmetics.com.au</a><br>
                        ABN # xx-xxx-xxx
                    </td>
                </tr>
            </table>
            <h3 style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">TAX INVOICE / RECEIPT</h3>
            <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">CUSTOMER</p>
            <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em;">
                DATE OF ISSUE<br> 
                <b>${formattedDate}</b>
            </p>

            <p style="font-family: Verdana, Geneva, Tahoma, sans-serif; line-height: 1.5em; text-align: right;">INVOICE NUMBER: <b>#INV${invoiceData.id}</b></p>
            <br>
            <table style="width: 100%; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: 400; vertical-align: middle; line-height: 1.5em;">
                <tr>
                    <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: left;" >Quantity</th>
                    <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: left;">Service</th>
                    <th style="background-color: #F6F8FA; padding: 0.9rem; border-bottom: 1px solid #EBF5FF; text-align: right;" >Price</th>
                </tr>
                ${productsHTML} <!-- Insert productsHTML here -->
                <tr>
                    <td colspan="3" style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;">
                        Subtotal ${invoiceData.subtotal}<br>
                        Total: <strong style="font-size: 20px;">${invoiceData.total}</strong><br>
                        GST: ${invoiceData.gst}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: left;" colspan="2">PAYMENTS</td>
                    <td style="padding: 0.9rem; border-bottom: 1px solid #d5dce2; text-align: right;"></td>
                </tr>
                ${cardDetailsHTML} <!-- Insert cardDetailsHTML here -->
                <tr>
                    <td colspan="3" style="padding: 0.9rem; text-align: right;">
                        Total Paid: <strong style="font-size: 20px;">$${calculateTotalPaid(invoiceData.payments)}</strong><br>
                    </td>
                </tr>
            </table>
        </div>
        </body>
        </html>
    `;

    var printContainer = document.createElement('div');
    printContainer.setAttribute('id', 'print-container');
    printContainer.innerHTML = printableContent;
    document.body.appendChild(printContainer);

    // Print the page
    window.print();

    // Remove the container from the document body
    document.body.removeChild(printContainer);
}

function populateInvoiceModal(invoiceData, subtotal, discount, total) {
    debugger;
    // Update the modal content with the retrieved invoice data
    // $('#modalTitle').text('Paid invoice for ' + invoiceData.client_name);
    var invoiceDate = new Date(invoiceData.invoice_date);

    // Get day, month, and year
    var day = invoiceDate.getDate();
    var month = invoiceDate.getMonth() + 1; // Month is zero-based, so add 1
    var year = invoiceDate.getFullYear();

    // Ensure day and month are displayed with leading zeros if needed
    var formattedInvoiceDate = `${day < 10 ? '0' + day : day}-${month < 10 ? '0' + month : month}-${year}`;

    $('#invoiceDate').text(formattedInvoiceDate);
    $('#invoiceNumber').text('INV' + invoiceData.id);

    // Populate product table
    var productTableBody = $('#productTableBody');
    productTableBody.empty();
    invoiceData.products.forEach(function (product) {
        if(product.type == 'Surcharge')
        {
            var p_price = (parseFloat(product.product_price) + parseFloat(product.discount_value)).toFixed(2)
        }else if(product.type == 'Discount')
        {
            var p_price = (parseFloat(product.product_price) - parseFloat(product.discount_value)).toFixed(2)
        }else
        {
            var p_price = (parseFloat(product.product_price)).toFixed(2)
        }
        productTableBody.append('<tr><td><b>' + product.product_name + '</b><br><span class="d-grey">' + product.user_full_name + '</span></td><td><b>' + product.product_quantity + '</b></td><td><b>$' + p_price + '</b></td></tr>');
    });

    // Calculate GST
    var gst = invoiceData.gst;

    // Populate payment table
    var paymentTableBody = $('#paymentTable tbody');
    paymentTableBody.empty();
    invoiceData.payments.forEach(function (payment) {
        var paymentDate = new Date(payment.date);

        // Get day, month, and year
        var day = paymentDate.getDate();
        var month = paymentDate.getMonth() + 1; // Month is zero-based, so add 1
        var year = paymentDate.getFullYear();

        // Ensure day and month are displayed with leading zeros if needed
        var formattedPaymentDate = `${day < 10 ? '0' + day : day}-${month < 10 ? '0' + month : month}-${year}`;

        paymentTableBody.append('<tr><td><b>' + payment.payment_type + '</b></td><td class="d-grey">' + formattedPaymentDate + '</td><td><b>$' + payment.amount + '</b></td></tr>');
    });

    // Populate subtotal, discount, total, and total paid
    $('#subtotalProductPrice').html('<span class="blue-bold">$' + subtotal + '</span>');
    $('#discountProductPrice').html('<span class="blue-bold">$' + discount + '</span>');
    $('#totalProductPrice').html('<span class="blue-bold">$' + total + '</span><br><span class="d-grey font-13" id="totalProductPriceGST">Includes GST of $' + gst + '</span>');

    // Calculate total paid amount including payments
    var totalPaid = 0;
    invoiceData.payments.forEach(function (payment) {
        totalPaid += parseFloat(payment.amount);
    });

    // Populate total paid amount
    $('#totalPaid').html('$' + totalPaid.toFixed(2));
}
function setSearchExistingModal(value) {
    $('.existing_client_list_box').hide();
    document.getElementById('resultexistingmodal').value = value;
    document.getElementById("resultexistingmodal").innerHTML = "";

    // Iterate over client_details to find a matching value
    for (const key in client_details) {
        console.log(client_details);
        if (client_details.hasOwnProperty(key)) {
            const client = client_details[key];
            // Check if value matches any field in the client object
            if (client.email === value || client.mobile_number === value || client.name === value) {
                console.log(client);
                // If a match is found, dynamically bind HTML to clientDetails element
                $('#existingclientmodal').show();
                $('.existingclientmodal').hide();
                $("#clientName").val(client.name+client.lastname);
                $('.client_search_bar').hide();
                $("#existingclientDetailsModal").html(
                    `<i class='ico-user2 me-2 fs-6'></i>  ${client.name}  ${client.lastname}`);
                document.getElementById('search_exist_customer').value = '';
                $('.walk_in_client_id').val(client.id);
                // Trigger the click event of the history button
                // $('.history').click();
                break; // Stop iterating once a match is found
            }
        }
    }
}
</script>
</html>
@endsection