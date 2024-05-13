@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="card">
    <div class="card-head">
        <div class="toolbar mb-5">
            <div class="tool-left"><h4 class="small-title mb-0">Edit Products</h4></div>
            <div class="tool-right"><a href="#" class="btn btn-primary btn-md" onclick="window.location='{{ url("products") }}'">Back to Products</a></div></div>
        
        <h5 class="bright-gray mb-0">Details</h5>
    </div>
    <form id="edit_product" name="edit_product" class="form">
    @csrf
    <input type="hidden" name="id" id="id" value="{{$product->id}}">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-7">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="product_name" id="product_name" maxlength="100" value="{{$product->product_name}}">
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Price</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="0"  name="price" id="price" maxlength="10" value="{{$product->price}}">
                                <span class="input-group-text"><span class="ico-dollar fs-4"></span></span>
                                </div>
                                <span class="form-text">incl. GST</span>
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Cost</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="0" name="cost" id="cost" maxlength="100" value="{{$product->cost}}">
                                <span class="input-group-text cost_validate"><span class="ico-dollar fs-4"></span></span>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Type </label><br>
                    <label class="cst-radio me-3"><input type="radio" name="type" value="Retail" {{$product->type == 'Retail'?'checked':''}}><span class="checkmark me-2"></span>Retail</label>
                    <label class="cst-radio"><input type="radio" name="type" value="Professional" {{$product->type == 'Professional'?'checked':''}}><span class="checkmark me-2"></span>Professional</label>
                </div>
                
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group mb-0">
                            <label class="form-label">GST code</label>
                            <select class="form-select form-control" name="gst_code" id="gst_code" value="{{$product->cost}}">
                                <option value=""> -- select an option -- </option>
                                <option value="Standard" {{$product->gst_code == 'Standard'?'selected':''}}>Standard</option>
                                <option value="Zero-rated" {{$product->gst_code == 'Zero-rated'?'selected':''}}>Zero-rated</option>
                            </select>
                            </div>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-5">
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="6"  name="description" id="description">{{$product->description}}</textarea>
                </div>
                
            </div>
        </div>                            
    </div>
    <div class="card-head">
        <h5 class="bright-gray mb-0">Category</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select class="form-select form-control" name="category_id" id="category_id">
                        <option selected="" value=""> -- select an option -- </option>
                        @if(count($product_category)>0)
                        @foreach($product_category as $cat)
                            <option value="{{ $cat->id }}" {{ ( $cat->id == $product->category_id) ? 'selected' : '' }}> {{$cat->category_name}} </option>
                        @endforeach
                        @endif
                    </select>
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Supplier</label>
                    <select class="form-select form-control" name="supplier_id" id="supplier_id">
                        <option selected="" value=""> -- select an option -- </option>
                        @if(count($suppliers)>0)
                        @foreach($suppliers as $supplier)
                            <option value="{{$supplier->id}}" {{$product->supplier_id==$supplier->id?'selected':''}}>{{$supplier->business_name}}</option>
                        @endforeach
                        @endif
                    </select>
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Supplier Code</label>
                    <input type="text" class="form-control" placeholder="SP001" name="supplier_code" id="supplier_code" maxlength="10"  value="{{$product->supplier_code}}">
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Barcode 1</label>
                    <input type="text" class="form-control" placeholder="-" name="barcode_1" id="barcode_1" maxlength="10"  value="{{$product->barcode_1}}">
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Barcode 2</label>
                    <input type="text" class="form-control" placeholder="-" name="barcode_2" id="barcode_2" maxlength="10"  value="{{$product->barcode_2}}">
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-1">
                <div class="form-group mb-0">
                    <label class="form-label">Order lot</label>
                    <input type="text" class="form-control" placeholder="-" name="order_lot" id="order_lot" maxlength="5"  value="{{$product->order_lot}}">
                    </div>
            </div>
            <!-- <div class="col-lg-1">
                <div class="form-group mb-0">
                    <label class="form-label">Min <i class="ico-help" data-toggle="tooltip" data-placement="top" title="The minimum amount of this item to have on-hand before you need to order more."></i></label>
                    <input type="text" class="form-control" placeholder="-" name="min" id="min" maxlength="5"  value="{{$product->min}}">
                    </div>
            </div>
            <div class="col-lg-1">
                <div class="form-group mb-0">
                    <label class="form-label">Max <i class="ico-help" data-toggle="tooltip" data-placement="top" title="When reordering, the maximum quantity you'd like to have on-hand."></i></label>
                    <input type="text" class="form-control" placeholder="-" name="max" id="max" maxlength="5"  value="{{$product->max}}">
                    </div>
            </div> -->
            
        </div>
    </div>
    <div class="card-head">
        <div class="row">
            <div class="col-lg-8">
                <div class="toolbar">
                    <div class="tool-left">
                        <h5 class="bright-gray mb-0">Availablity</h5>
                    </div>
                    <div class="tool-right">
                        <label class="form-label mb-0">Location overrides <i class="ico-help" data-toggle="tooltip" data-placement="top" title="Leave fields blank to use the chain-level settings."></i></label>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-8">
                <!-- <div class="d-flex justify-content-between mb-4">
                    <label class="form-label">Location</label>
                    <label class="form-label">Location overrides <i class="ico-help" data-toggle="tooltip" data-placement="top" title="Leave fields blank to use the chain-level settings."></i></label>
                    
                </div> -->
                <div class="small-tool">Select:   <a href="javascript:void(0)" class="me-2 ms-2 btn-link select_all">All</a>  |   <a href="javascript:void(0)" class="ms-2 btn-link select_none">None</a></div>
                <div class="table-responsive">
                    <table class="table table-relax align-middle table-hover form-group">
                        <tbody>
                            @if(count($locations) > 0)
                                @foreach($locations as $index => $loc)
                                @php 
                                    $ck_service = \App\Models\ProductAvailabilities::where([
                                        'product_id' => $product->id, // Use $loc->id instead of $services->id
                                        'location_name' => $loc->id,
                                        'availability' => 'Available'
                                    ])->first();
                                @endphp
                                    <tr>
                                        <td>
                                            <label class="cst-check">
                                                    <input type="checkbox" 
                                                    value="{{$loc->id}}" 
                                                    {{ ($ck_service && $ck_service->availability == 'Available') ? "checked" : "" }} 
                                                    name="locations[]" 
                                                    id="locations" 
                                                    class="locations">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td width="40%">{{$loc->location_name}}</td>
                                        <td>
                                            <div class="show-timing" 
                                                style="{{ $ck_service && $ck_service->availability == 'Available' ? '' : 'display:none;' }}">
                                                <div class="show-inner">
                                                    @foreach ($product->availability as $availability)
                                                        @if ($availability->location_name == $loc->id)
                                                             <div class="min-max loc_details">
                                                                <label class="form-label">Quantity <i class="ico-help" data-toggle="tooltip" data-placement="top" title="The minimum amount of this item to have on-hand before you need to order more."></i></label>
                                                                <input type="text" class="form-control" placeholder="-" id="availability_quantity" name="availability_quantity[]" maxlength="5" value="{{$availability->quantity}}">
                                                            </div>
                                                            <!--
                                                            <div class="min-max loc_details">
                                                                <label class="form-label">Max <i class="ico-help" data-toggle="tooltip" data-placement="top" title="When reordering, the maximum quantity you'd like to have on-hand."></i></label>
                                                                <input type="text" class="form-control" placeholder="-" id="availability_max" name="availability_max[]" maxlength="5" value="{{$availability->max}}">
                                                            </div> -->
                                                            <div class="col loc_details">
                                                                <label class="form-label">Price</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" placeholder="0" id="availability_min" name="availability_price[]" maxlength="10" value="{{$availability->price}}">
                                                                    <span class="input-group-text"><span class="ico-dollar fs-4"></span></span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12 text-lg-end mt-4">
            <button type="button" class="btn btn-light me-2" onclick="window.location='{{ url("products") }}'">Discard</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </div>
    </form>
</div>
@stop
@section('script')
<script>
$(document).ready(function() {
    $(document).on("input", "#price", function() {
        // Allow only numbers and the decimal point
        this.value = this.value.replace(/[^0-9.]/g, '');

        // Ensure there is only one decimal point
        let parts = this.value.split('.');
        if (parts.length > 2) {
            // More than one decimal point found, keep only the first part
            this.value = parts[0] + '.' + parts.slice(1).join('');
        }
    });
    $(document).on("input", "#cost", function() {
        // Allow only numbers and the decimal point
        this.value = this.value.replace(/[^0-9.]/g, '');

        // Ensure there is only one decimal point
        let parts = this.value.split('.');
        if (parts.length > 2) {
            // More than one decimal point found, keep only the first part
            this.value = parts[0] + '.' + parts.slice(1).join('');
        }
    });
    $(document).on("input", "#order_lot", function() {
        this.value = this.value.replace(/\D/g,'');
    });
    $(document).on("input", "#min", function() {
        this.value = this.value.replace(/\D/g,'');
    });
    $(document).on("input", "#max", function() {
        this.value = this.value.replace(/\D/g,'');
    });
    $(document).on("input", "#availability_quantity", function() {
        this.value = this.value.replace(/\D/g,'');
    });
    // $(document).on("input", "#availability_max", function() {
    //     this.value = this.value.replace(/\D/g,'');
    // });
    $(document).on("input", "#availability_price", function() {
        // Allow only numbers and the decimal point
        this.value = this.value.replace(/[^0-9.]/g, '');

        // Ensure there is only one decimal point
        let parts = this.value.split('.');
        if (parts.length > 2) {
            // More than one decimal point found, keep only the first part
            this.value = parts[0] + '.' + parts.slice(1).join('');
        }
    });
    $('.locations').click(function(){
        
        if (!$(this).is(':checked')) {
            $(this).parent().parent().parent().find('.show-timing').hide();
        }
        else{
            $(this).parent().parent().parent().find('.show-timing').show();
            $(this).parent().parent().parent().find('.show-timing').find('.loc_details').show();

            //if new location add and bind this min,max,price content
            if($.trim($(this).parent().parent().parent().find('.show-timing').find('.show-inner').text()) == '')
            {
                $(this).parent().parent().parent().find('.show-timing').find('.show-inner').html(`
                    
                    <div class="col loc_details">
                        <label class="form-label">Price</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="0" name="availability_price[]" maxlength="10">
                            <span class="input-group-text"><span class="ico-dollar fs-4"></span></span>
                        </div>
                    </div>
                `);
            }
        }
    })

    $('.select_none').click(function(){
        $("input[name='locations[]']:checkbox").prop('checked',false);
        $('.loc_details').hide();
    })
    $('.select_all').click(function () {
        
        $("input[name='locations[]']:checkbox").prop('checked', true);
        $('.loc_details').show();
        $('.show-timing').show();

        //if new location add and bind this min,max,price content
        $(this).parent().parent().parent().find('.show-timing').each(function (index, element) {
            
            if ($.trim($(element).find('.show-inner').text()) === '') {
                $(element).find('.show-inner').html(`
                    <div class="min-max loc_details">
                        <label class="form-label">Min <i class="ico-help" data-toggle="tooltip" data-placement="top" title="The minimum amount of this item to have on-hand before you need to order more."></i></label>
                        <input type="text" class="form-control" placeholder="-" name="availability_min[]" maxlength="5">
                    </div>
                    <div class="min-max loc_details">
                        <label class="form-label">Max <i class="ico-help" data-toggle="tooltip" data-placement="top" title="When reordering, the maximum quantity you'd like to have on-hand."></i></label>
                        <input type="text" class="form-control" placeholder="-" name="availability_max[]" maxlength="5">
                    </div>
                    <div class="col loc_details">
                        <label class="form-label">Price</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="0" name="availability_price[]" maxlength="10">
                            <span class="input-group-text"><span class="ico-dollar fs-4"></span></span>
                        </div>
                    </div>
                `);
            }
        });
    });


    $("#edit_product").validate({
        rules: {
            product_name: {
                required: true,
            },
            price:{
                required: true,
            },
            cost:{
                required: true,
                // costLessThanEqualPrice: true
            },
            gst_code:{
                required: true,
            },
            category_id:{
                required: true,
            },
            supplier_id:{
                required: true,
            },
            order_lot:{
                required: true,
            },
            min:{
                required: true,
            },
            max:{
                required: true,
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") === "price") {
                error.insertAfter('.form-text');
            }else if(element.attr("name") === "cost") {
                error.insertAfter('.cost_validate').addClass("w-100");
            }
            else {
                error.insertAfter(element);
            }
        },
        // Custom validation method to check if cost is less than or equal to price
        messages: {
            cost: {
                costLessThanEqualPrice: "Cost must be less than or equal to Price.",
            },
        },
    });
    // Custom validation method to check if cost is less than or equal to price
    $.validator.addMethod("costLessThanEqualPrice", function (value, element) {
        var cost = parseFloat(value);
        var price = parseFloat($("#price").val());
        return cost <= price;
    }, "Cost must be less than or equal to Price.");
    $(document).on('submit','#edit_product',function(e){
        e.preventDefault();
        var valid= $("#edit_product").validate();
        var id = $('#id').val();
            if(valid.errorList.length == 0){
            var data = $('#edit_product').serialize() ;
            submitEditProductForm(data,id);
        }
    });
    function submitEditProductForm(data,id){
        
        $.ajax({
            headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: id,
            type: "PUT",
            data: data,
            success: function(response) {
                
                // Show a Sweet Alert message after the form is submitted.
                if (response.success) {
                    
                    Swal.fire({
                        title: "Product!",
                        text: "Product Updated successfully.",
                        type: "success",
                    }).then((result) => {
                        window.location = "{{url('products')}}"//'/player_detail?username=' + name;
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
    }
});
</script>
@endsection