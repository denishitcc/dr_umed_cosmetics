<div class="edit_invoice_date"></div>
<div class="edit_invoice_number"></div>
<div class="form-group invoice_date">
    <label>Invoice Date</label>
    <input type="date" id="datePicker1" name="casual_invoice_date" class="form-control" placeholder="date" value="<?php echo date('Y-m-d'); ?>">
</div>
<div class="form-group icon">
    <input type="text" id="search_products" class="form-control search_products" autocomplete="off" placeholder="Search for services or products" onkeyup="changeProductInput(this.value)">
    <i class="ico-search"></i>
    <div id="result1" class="list-group"></div>
    <div class="products_box" style="display:none;">
        <ul id="resultproductmodal" class="clinet-lists resultproductmodal"></ul>
    </div>
</div>
<div class="productDetails" class="detaild-theos pt-3"></div>

<div class="mb-3">
    <a href="#" class="btn btn-dashed w-100 btn-blue icon-btn-center add_discount"><i class="ico-percentage me-2 fs-5"></i> Add discount / surcharge</a>
</div>
<table width="100%" class="main_table">
    <tbody>
        <tr>
            <td>Subtotal</td>
            <td class="text-end subtotal">$0.00</td>
        </tr>
        <tr class="discount-row">
            <td>Discount</td>
            <td class="text-end discount">$0.00</td>
        </tr>
        <tr>
            <td><b>Total</b></td>
            <td class="text-end total"><b>$0.00</b></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-end d-grey font-13 gst_total">(Includes GST of $0.00)</td>
        </tr>
    </tbody>
</table>
<hr class="my-4">
<div class="form-group credit_sale">
    <label class="form-label">Credit Sale to <span class="d-grey font-13">(required)</span></label>
    <select class="form-select form-control" name="casual_staff" id="sale_staff_id">
        <option value="">Please select</option>
        @foreach($staffs as $staff)
            <option value="{{$staff->id}}">{{$staff->first_name.' '.$staff->last_name}}</option>
        @endforeach
    </select>
    </div>
    <div class="form-group mb-0">
    <label class="form-label">Note</label>
    <textarea class="form-control" rows="3" placeholder="Add a note" name="notes" id="notes"></textarea>
</div>