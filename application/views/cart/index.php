<!DOCTYPE html>
<html lang="en-US">

<head>
	<title>Cart - CodeIgniter Shopping Cart by CodexWorld</title>
	<meta charset="utf-8">

	<!-- Include bootstrap library -->
	<link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">

	<!-- Include custom css -->
	<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
	<style>
		.minus,
		.plus {
			display: inline-block;
			vertical-align: middle;
			text-align: center;
			background-color: white;
			border: none;
		}

		.minus:active,
		.plus:active {
			outline: solid 1px rgb(211, 211, 211);
		}

		input {
			height: 20px;
			width: 30px;
			text-align: center;
			font-size: 16px;
			border: none;
			display: inline-block;
			vertical-align: middle;
			vertical-align: middle;
		}

		input:focus {
			outline: solid 1px gray;
		}
	</style>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- Include jQuery library -->
	<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

	<script>
		// Update item quantity
		function updateCartItem(obj, rowid) {
			$.get("<?php echo base_url('cart/updateItemQty/'); ?>", {
				rowid: rowid,
				qty: obj.value
			}, function(resp) {
				if (resp == 'ok') {
					location.reload();
				} else {
					alert('Cart update failed, please try again.');
				}
			});
		}
	</script>


</head>

<body>
	<div class="container">
		<!-- <h1>SHOPPING CART</h1> -->
		<div class="row pt-5 px-5">
			<div class="cart">
				<div class="col-12">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th></th>
									<th>Product</th>
									<th>Price</th>
									<th>Quantity</th>
									<th class="text-right">Subtotal</th>
									<!-- <th></th> -->
								</tr>
							</thead>
							<tbody>
								<?php if ($this->cart->total_items() > 0) {
									foreach ($cartItems as $item) {	?>
										<tr>
											<td>
												<?php $imageURL = !empty($item["image"]) ? base_url('uploads/product_images/' . $item["image"]) : base_url('assets/images/pro-demo-img.jpeg'); ?>
												<img src="<?php echo $imageURL; ?>" width="50" />
											</td>
											<td>
												<span><?php echo $item["name"]; ?></span>
												<br><br>
												<button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure to delete item?')?window.location.href='<?php echo base_url('cart/removeItem/' . $item["rowid"]); ?>':false;">Remove </button></td>
											<td><?php echo '₱' . $item["price"]; ?></td>
											<td class="quantity">
												<div class="container">
													<button class="minus"><i class="fa fa-minus" aria-hidden="true"></i></button>
													<input type="text" value="<?php echo $item["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $item["rowid"]; ?>')" />
													<button class="plus"><i class="fa fa-plus" aria-hidden="true"></i></button>
												</div>
											</td>
											<td class="text-right"><?php echo '₱' . $item["subtotal"]; ?></td>
											<!-- <td class="text-right"> </td> -->
										</tr>
									<?php }
								} else { ?>
									<tr>
										<td colspan="6">
											<p>Your cart is empty.....</p>
										</td>
									<?php } ?>
									<?php if ($this->cart->total_items() > 0) { ?>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td><strong>Grand Total</strong></td>
										<td class="text-right text-primary"><strong><?php echo '₱' . $this->cart->total(); ?></strong></td>
										<!-- <td></td> -->
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col mb-2">
					<div class="row">
						<div class="col-sm-12  col-md-6">
							<a href="<?php echo base_url('products/'); ?>" type="button" class="btn btn-outline-dark ">CONTINUE SHOPPING</a>
						</div>
						<div class="col-sm-12 col-md-6 text-right">
							<?php if ($this->cart->total_items() > 0) { ?>
								<a href="<?php echo base_url('checkout/'); ?>" type="button" class="btn btn-primary "><i class="fa fa-check-circle pr-1" aria-hidden="true"></i>PROCEED TO CHECKOUT</a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('.minus').click(function() {
				var $input = $(this).parent().find('input');
				var count = parseInt($input.val()) - 1;
				count = count < 1 ? 1 : count;
				$input.val(count);
				$input.change();
				return false;
			});
			$('.plus').click(function() {
				var $input = $(this).parent().find('input');
				$input.val(parseInt($input.val()) + 1);
				$input.change();
				return false;
			});
		});

		$(document).ready(function() {
			$('.minus, .plus').focus(function() {
				this.blur();
			})
		});

		$(document).ready(function() {
			$(".remove").click(function() {
				$(".item").remove();
			});
		});
	</script>
</body>

</html>
