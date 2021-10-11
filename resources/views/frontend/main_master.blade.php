
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="description" content="">
{{-- js ajax cart --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="author" content="">
<meta name="keywords" content="MediaCenter, Template, eCommerce">
<meta name="robots" content="all">
<title>Shop Now</title>

<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css ') }}">

<!-- Customizable CSS -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/blue.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.carousel.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.transitions.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/rateit.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap-select.min.css') }}">

<!-- Icons/Glyphs -->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/font-awesome.css') }}">

<!-- Fonts -->
<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
</head>
<body class="cnt-home">
<!-- ============================================== HEADER ============================================== -->

   @include('frontend.body.header') 
<!-- ============================================== HEADER : END ============================================== -->


 @yield('content')

<!-- ============================================================= FOOTER ============================================================= -->
@include('frontend.body.footer')
<!-- ============================================================= FOOTER : END============================================================= --> 

<!-- For demo purposes – can be removed on production --> 

<!-- For demo purposes – can be removed on production : End --> 

<!-- JavaScripts placed at the end of the document so the pages load faster --> 
<script src="{{ asset('frontend/assets/js/jquery-1.11.1.min.js') }}"></script> 
<script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script> 
<script src="{{ asset('frontend/assets/js/bootstrap-hover-dropdown.min.js') }}"></script> 
<script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script> 
<script src="{{ asset('frontend/assets/js/echo.min.js') }}"></script> 
<script src="{{ asset('frontend/assets/js/jquery.easing-1.3.min.js') }}"></script> 
<script src="{{ asset('frontend/assets/js/bootstrap-slider.min.js') }}"></script> 
<script src="{{ asset('frontend/assets/js/jquery.rateit.min.js') }}"></script> 
<script src="{{ asset('frontend/assets/js/lightbox.min.js') }}"></script> 
<script src="{{ asset('frontend/assets/js/bootstrap-select.min.js') }}"></script> 
<script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script> 
<script src="{{ asset('frontend/assets/js/scripts.js') }}"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Add to card model -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel"><strong><span id="pname" ></span></strong></h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModel">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>

       <div class="modal-body">
       
            <div class="row">
               <div class="col-lg-4">
                  <div class="card" style="width: 18rem;">
                     <img src="" class="card-img-top" id="pimg" alt="productimg" height="200" width="180">
                    
                   </div>
               </div>
               <div class="col-lg-4">
                  
                  <ul class="list-group">
                     <li class="list-group-item">Product Price: <strong 
                       class="text-danger">$<span id="pprice"></span></strong>

                        <del id="oldprice">$</del>

                     </li>

                     <li class="list-group-item">Product Code: <strong id="pcode"></strong></li>
                     <li class="list-group-item">Category: <strong id="pcategory"></strong></li>
                     <li class="list-group-item">Brands: <strong id="pbrand"></strong></li>

                     <li class="list-group-item">Stock: <span class="badge badge-pill badge-success"
                         id="aviable" style="background: green; color:white;"></span>
                         <span class="badge badge-pill badge-success"
                         id="stockout" style="background: red; color:white;"></span>
                        
                     
                     </li>

                   
                  </ul>
               </div>
               <div class="col-lg-4">

                  <div class="form-group">
                     <label for="color">Choose Color</label>

                     <select class="form-control" name="color" id="color">
                       
                     
                     </select>
                   </div>

                   <div class="form-group"  id="sizeArea">
                     <label for="size">Choose Size</label>
                     <select class="form-control" name="size" id="size">
                    
                     </select>
                   </div>

                   <div class="form-group">
                     <label for="qty">Choose Quantity</label>

                    <input type="number" class="form-control" id="qty"  value="1" min="1">

                   </div>

                   <input type="hidden" id="product_id">
                   <button type="submit" class="btn btn-primary mb-2" onclick="addToCart()" >Add to Cart</button>

               </div>
            </div>
       </div> <!-- end row -->


     </div>
   </div>
 </div>


 
{{-- ajax  --}}
{{-- main problems is id in [is worng celo] --}}
         <script type="text/javascript">
            $.ajaxSetup({
               headers:{
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
         })

         // product view model function
         function productView(id){
            // alert(id)
            $.ajax({
               // problem is not use , in get
               type: 'GET',
               url: '/product/view/modal/'+id,
               dataType:'json',
               success:function(data){
                  // console.log(data)

                  $('#pname').text(data.product.product_name);

                  $('#price').text(data.product.selling_price);
                  $('#pcode').text(data.product.product_code);

                  $('#pcategory').text(data.product.category.category_name);                  
                  $('#pbrand').text(data.product.brand.brand_name_easy);
                  $('#pstock').text(data.product.product_qty);
                  // img 
                  $('#pimg').attr('src','/'+data.product.product_thambnail);

                  // product id for add to cart
                  $('#product_id').val(id);

                  // Qty 
                  $('#qty').val(1);


                  // Product Price
                  if (data.product.discount_price == null) {

                     /// for discount price is null then only show selling price
                     $('#pprice').text('');
                     $('#oldprice').text('');

                     $('#pprice').text(data.product.selling_price);
                     
                  }else{
                     $('#pprice').text(data.product.discount_price);
                     $('#oldprice').text(data.product.selling_price);
                  }

                  // in stock product
                  if (data.product.product_qty > 0 ) {

                     $('#aviable').text('');
                     $('#stockout').text('');

                     $('#aviable').text('Aviable');
                     
                  }else{

                     $('#aviable').text('');
                     $('#stockout').text('');

                     $('#stockout').text('Stockout');
                  }



                  // load product color 
                  $('select[name="color"]').empty();
                  $.each(data.color,function(key, value){
                     $('select[name="color"]').append('<option value=" '+value+' " > '+value+' </option>')
                  })


                      // load product size 
                      $('select[name="size"]').empty();
                  $.each(data.size,function(key, value){
                     $('select[name="size"]').append('<option value=" '+value+' " > '+value+' </option>')
                 
                     // product size =null then hide is option

                     if(data.size == ""){
                        $('#sizeArea').hide();

                     }else{
                        $('#sizeArea').show();
                     }
                 
                 
                  })

              }

            }) 

         } // end function 


         //   start add to cart product function

          function addToCart(){
            var product_name = $('#pname').text();
            var id = $('#product_id').val();
            var color = $('#color option:selected').text();
            var size = $('#size option:selected').text();            
            var quantity = $('#qty').val();

            // add to cart post
            $.ajax({
               type: "POST",
               dataType: 'json',
               data:{
                  color:color, size:size, quantity:quantity, product_name:product_name                  
               },
               url: "/cart/data/store/"+id,
               success:function(data){
                  // for auto update
                  miniCart();

                  // for cart auto close
                  $('#closeModel').click(); 

                  // for test data
                  // console.log(data)

                  //start message
                  const Toast = Swal.mixin({
                     toast:true,
                     position: 'top-end',
                     icon: 'success',                     
                     showConfirmButton: false,
                     timer: 3000,
                
                     })
                     if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                           type: 'success',
                           title: data.success
                        })
                     }else{
                        Toast.fire({
                           type: 'error',
                           title: data.error
                        })
                     }

                  // end message
                
               } // fun end
            })

          } // end function


         //   End add to cart product function

         </script>

   <script type="text/javascript">

     function miniCart(){
     $.ajax({
         type: 'GET',
         url: '/product/mini/cart',
         dataType:'json',
         success:function(response){
           //   console.log(response)
        var miniCart = ""

           $.each(response.carts, function(key,value){

              // sub total and qty
              $('span[id="cartSubTotal"]').text(response.cartTotal);

              $('#cartQty').text(response.cartQty);


              // end sub total and qty


              miniCart += `<div class="cart-item product-summary">
                 <div class="row">
                   <div class="col-xs-4">
                     <div class="image"> <a href="detail.html"><img src="/${value.options.image}" alt=""></a> </div>
                   </div>
                   <div class="col-xs-7">
                     <h3 class="name"><a href="index.php?page-detail">${value.name}</a></h3>
                     <div class="price"> ${value.price} $ *  Qty: ${value.qty}</div>
                   </div>

                   <div class="col-xs-1 action"> 

                    <button type="submit" id="${value.rowId}" onclick="miniCartRemove(this.id)"><i class="fa fa-trash"></i></button> </div>
                   
                    </div>

                 </div>
               </div>
               <!-- /.cart-item -->
               <div class="clearfix"></div>
               <hr>`

           });

           $('#miniCart').html(miniCart);

           }
       })
    }

    miniCart();

           /// mini cart remove Start 
           function miniCartRemove(rowId){
                 $.ajax({
                       type: 'GET',
                       url: '/minicart/product-remove/'+rowId,
                       dataType:'json',
                       success:function(data){
                       miniCart();

                       // Start Message 
                          const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                             })
                          if ($.isEmptyObject(data.error)) {
                             Toast.fire({
                                   type: 'success',
                                   title: data.success
                             })
                          }else{
                             Toast.fire({
                                   type: 'error',
                                   title: data.error
                             })
                          }
                          // End Message 

                       }
                 });
              }
           //  end mini cart remove 
  </script>

</body>
</html>