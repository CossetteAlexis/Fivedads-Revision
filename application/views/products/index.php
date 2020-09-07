<!DOCTYPE html>
<html lang="en-US">

<head>
	<title>Shopping Cart Integration in CodeIgniter by CodexWorld</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


	<!-- Include bootstrap library -->
	<link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">

	<!-- Include custom css -->
	<style>
		.card {
			border-radius: 0;
			width: 100px;
		}

		#cart-modal .modal-dialog {
			width: 350px;
			margin: 3% auto;
		}

		.close:focus {
			outline: none;
			color: red;
		}

		.box-quantity button {
			background-color: white;
			border: solid 0.1px rgb(220, 220, 220);
		}

		.box-quantity button:focus {
			background-color: black;
			color: white;
			outline: none;
		}

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

		.input-quantity {
			height: 20px;
			width: 30px;
			text-align: center;
			font-size: 16px;
			border: none;
			display: inline-block;
			vertical-align: middle;
			vertical-align: middle;
		}

		.input-quantity:focus {
			outline: solid 1px gray;
		}

		.thumbnail {
			height: 20%;
			width: 30%;
			display: block;
			padding: 2%;
		}

		.thumbnail img {
			height: 100%;
			width: 100%;
			border: solid 1px rgb(220, 220, 220);
			padding: 5% 10%;
		}

		.thumbnail img:focus {
			outline: solid 2px black;
		}

		.preview {
			width: 100%;
			display: inline-block;
		}

		.preview img {
			height: 100%;
			width: 100%;
			display: block;
		}

		.up,
		.down {
			background-color: rgb(220, 220, 220);
			text-decoration: none;
			cursor: pointer;
			border-radius: 50%;
			border: none;
		}

		.up:active,
		.down:active {
			background-color: gray;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			cursor: pointer;
			border-radius: 50%;
			outline: none;
		}
	</style>
</head>

<body>
	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggler">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="navbar-brand">
				<a href="#" class="navbar-brand"></a>
			</div>
			<div class="navbar-header ">
				<ul class="nav">
					<li class="navbar-icon mr-3">
						<button class="btn cart-modal-toggler" data-toggle="modal" data-target="#cart-modal"><i class="fa fa-2x fa-shopping-cart"></i><span class="badge badge-danger"><?php echo ($this->cart->total_items() > 0) ? $this->cart->total_items() . ' ' : '0'; ?></span></button>
					</li>
					<li class="navbar-icon">
						<button class="btn user-modal-toggler" data-toggle="modal" data-target="#login-modal"><i class="fa fa-2x fa-user"></i></button>
					</li>
				</ul>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link text-dark" href="#">HOME</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-dark" href="#">CATALOG</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- End of Navbar -->
	<!-- Login Modal -->
	<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="user" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body py-0">
					<div class="row">
						<div class="col-md-8">
							<form method="POST" action="#">
								<p class="text-muted">Log in to your account</p>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fa fa-envelope"></i></span>
									</div>
									<input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus placeholder="Email Address">
								</div>

								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fa fa-lock"></i></span>
									</div>
									<input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="Password">
								</div>

								<div class="input-group mb-3">
									<div class="">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="remember" id="remember">

											<label class="form-check-label text-muted" for="remember">
												Remember Me
											</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-5 pb-3">
										<button type="submit" class="btn btn-primary float-left">Log in</button>
									</div>
									<div class="col-7 pb-3">
										<a class="btn btn-link" href="#">Forgot Your Password?</a>
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-4 bg-primary ">
							<div class="text-center">
								<p class="text-light pt-3">Don't have an account?</p>
								<a href="#" class="btn btn-outline-light" data-toggle="modal" data-target="#register-modal" data-dismiss="modal">Sign Up</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End of Login Modal -->
	<!-- Register Modal -->
	<div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="user" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body py-0">
					<div class="row">
						<div class="col-md-8">
							<form method="POST" action="#">
								<p class="text-muted">Create an account</p>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fa fa-envelope"></i></span>
									</div>
									<input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus placeholder="Email Address">
								</div>

								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fa fa-lock"></i></span>
									</div>
									<input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="Password">
								</div>

								<div class="input-group mb-3">
									<div class="">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="remember" id="remember">

											<label class="form-check-label text-muted" for="remember">
												Remember Me
											</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-5 pb-3">
										<button type="submit" class="btn btn-primary float-left">Sign up</button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-4 bg-primary">
							<div class="text-center">
								<p class="text-light pt-3">Already have an account?</p>
								<a href="#" class="btn btn-outline-light">Log In</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End of Register Modal -->
	<!-- Cart Modal -->
	<div class="modal fade" id="cart-modal" tabindex="-1" role="dialog" aria-labelledby="cart" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Jane Doe's Cart</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table class="table text-right table-borderless">
						<tbody>
							<tr class="item">
								<td><img src="http://localhost/fivedads_revision/images/new-normal-1-eva.jpg" alt="Product Image" height="100" width="100" class="pull-left">
									<span class="font-weight-bold">
										Lorem ipsum
									</span>
									<p>
										5boxes x ₱6,500.00
									</p>
								</td>
							</tr>
							<td><img src="http://localhost/fivedads_revision/images/new-normal-1-eva.jpg" alt="Product Image" height="100" width="100" class="pull-left">
								<span class="font-weight-bold">
									Lorem Ipsum
								</span>
								<p>
									5boxes x ₱6,500.00
								</p>
							</td>
						</tbody>
					</table>
				</div>
				<div class="modal-footer justify-content-center">
					<a href="<?php echo base_url('cart'); ?>" class="btn btn-primary">View Cart</a>
				</div>
			</div>
		</div>
	</div>
	<!-- End of Cart Modal -->

	<div class="container">
		<!-- List all products -->
		<div class="row">
			<div class="col-md-5 pt-5">
				<div class="d-flex">
					<div class="thumbnail">
						<div class="thumbnails">
							<div class="">
								<img class="autofocus-img tab" id="" onclick="preview(this.src)" src="http://localhost/fivedads_revision/images/new-combo-2box-eva-1box-tck.jpg" alt="Image 1" tabindex="1">
							</div>
							<div class="pt-2">
								<img class="tab" onclick="preview(this.src)" id="" src="http://localhost/fivedads_revision/images/new-normal-1-eva.jpg" alt="Image 2" tabindex="2">
							</div>
							<div class="pt-2">
								<img class="tab" onclick="preview(this.src)" id="" src="http://localhost/fivedads_revision/images/silver-eva-tck.jpg" alt="Image 3" tabindex="3">
							</div>
							<div class="pt-2">
								<img class="tab" onclick="preview(this.src)" id="" src="http://localhost/fivedads_revision/images/10 boxex-tck.jpg" alt="Image 4" tabindex="4">
							</div>
						</div>
					</div>
					<div class="preview mx-3">
						<div>
							<img class="preview-image" src="http://localhost/fivedads_revision/images/new-normal-1-eva.jpg" alt="Product Image">
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-7 pt-5 pl-5">
				<h1>EVA GLUTHATHIONE</h1>
				<hr style="border-top:solid 2px black;">
				<h4 class="price">₱ 985.00</h4>
				<div class="row">
					<?php if (!empty($products)) {
						foreach ($products as $row) { ?>
							<?php if (substr($row['item_code'], 0, 3) == 'EVA') { ?>
								<div class="card m-1 float-left">
									<button id="<?= $row['itemid']; ?>" class="btn btn-default  eva"><?= '<small><strong>' . $row['boxes'] . '</strong></small>'; ?></button>
									<input name="id" class="id" type="text" value="" hidden>
								</div>
							<?php } ?>
						<?php }
					} else { ?>
						<p>Product(s) not found...</p>
					<?php } ?>
				</div>
				<div class="row mt-5 ">
					<button class="buy btn btn-outline-primary">Buy now</button>
					<button class="add btn btn-primary mx-5" data-toggle="modal" data-target="#addmodal">Add to cart</button>
				</div>
			</div>
		</div>
	</div>



	<div class=" container pt-5">
		<!-- List all products -->
		<div class="row">
			<div class="col-md-5 pt-5">
				<div class="d-flex">
					<div class="thumbnail">
						<div class="thumbnails">
							<div class="">
								<img class="autofocus-img tab" id="" onclick="preview(this.src)" src="http://localhost/fivedads_revision/images/new-combo-2box-eva-1box-tck.jpg" alt="Image 1" tabindex="1">
							</div>
							<div class="pt-2">
								<img class="tab" onclick="preview(this.src)" id="" src="http://localhost/fivedads_revision/images/new-normal-1-eva.jpg" alt="Image 2" tabindex="2">
							</div>
							<div class="pt-2">
								<img class="tab" onclick="preview(this.src)" id="" src="http://localhost/fivedads_revision/images/silver-eva-tck.jpg" alt="Image 3" tabindex="3">
							</div>
							<div class="pt-2">
								<img class="tab" onclick="preview(this.src)" id="" src="http://localhost/fivedads_revision/images/10 boxex-tck.jpg" alt="Image 4" tabindex="4">
							</div>
						</div>
					</div>
					<div class="preview mx-3">
						<div>
							<img class="preview-image" src="http://localhost/fivedads_revision/images/10 boxex-tck.jpg" alt=" Product Image">
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-7 pl-5 pt-5">
				<h1>TCK</h1>
				<hr style="border-top:solid 2px black;">
				<h4 class="price2">₱ 885.00</h4>
				<div class="row">
					<?php if (!empty($products)) {
						foreach ($products as $row) { ?>
							<?php if (substr($row['item_code'], 0, 3) == 'TCK') { ?>
								<div class="card m-1 float-left">
									<button id="<?= $row['itemid']; ?>" class="btn btn-default  tck"><?= '<small><strong>' . $row['boxes'] . '</strong></small>'; ?></button>
									<input name="id2" class="id2" type="text" value="" hidden>
								</div>
							<?php } ?>
						<?php }
					} else { ?>
						<p>Product(s) not found...</p>
					<?php } ?>
				</div>
				<div class="row mt-5 ">
					<button class="btn btn-outline-primary ">Buy now</button>
					<button class="add btn btn-primary mx-5" data-toggle="modal" data-target="#addmodal">Add to cart</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<strong class="modal-name">Please select a product first.</strong>
					<p class="modal-price"></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">CONTINUE SHOPPING</button>
					<button type="button" class="addtocart btn btn-primary">ADD TO CART</button>
				</div>
			</div>
		</div>
	</div>


	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
	<script>
		$(document).ready(function() {
			if (window.matchMedia("(max-width: 767px)").matches) {
				$('.navbar-toggler').show();
			} else {
				$('.navbar-toggler').hide();
				$('.navbar-header').insertAfter($('.collapse'));
			}
		});

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

		$('.text').hide();
		// $(document).ready(function() {
		// 	$('.addtocart').on('click', function() {
		// 		var text = $('.addtocart').text();
		// 		if (text === "ADD TO CART") {
		// 			$(this).html('THANK YOU');
		// 			$('.text').show();
		// 			$('.addtocart').prop('disabled', true);
		// 			$('.buy').prop('disabled', true);

		// 		} else {
		// 			$(this).text('ADD TO CART');
		// 			$('.text').hide();
		// 		}
		// 	});
		// });

		$(document).ready(function() {
			$('.minus, .plus, .up, .down').focus(function() {
				this.blur();
			});
		});


		$(document).ready(function() {
			$('.autofocus-img').click();
		})

		$('.autofocus-img').focus();

		function preview(_src) {
			$source = _src;
			document.getElementsByClassName('preview-image')[0].src = $source;
		}

		$(document).ready(function() {
			$('.one').click(function() {
				source = document.getElementsByClassName('tab')[1].src
				document.getElementsByClassName('preview-image')[0].src = source;
			});
			$('.two').click(function() {
				source = document.getElementsByClassName('tab')[2].src
				document.getElementsByClassName('preview-image')[0].src = source;
			});
			$('.three').click(function() {
				source = document.getElementsByClassName('tab')[3].src
				document.getElementsByClassName('preview-image')[0].src = source;
			});
			$('.more').click(function() {
				source = document.getElementsByClassName('tab')[0].src
				document.getElementsByClassName('preview-image')[0].src = source;
			});
		});

		$(document).ready(function() {
			$('.eva').click(function() {
				var id = $(this).attr('id');
				$('.id').val(id);
				$.ajax({
					type: 'POST',
					url: '<?= base_url('products/get_price'); ?>',
					data: {
						id
					},
					success: function(result) {
						// console.log(result)
						$('.price').text('₱ ' + result);
					},
					error: function(result) {
						console.log(result);
					}
				})
			});
			$('.tck').click(function() {
				var id = $(this).attr('id');
				$('.id').val(id);
				$.ajax({
					type: 'POST',
					url: '<?= base_url('products/get_price'); ?>',
					data: {
						id
					},
					success: function(result) {
						// console.log(result)
						$('.price2').text('₱ ' + result);
					},
					error: function(result) {
						console.log(result);
					}
				})
			});
			$('.add').click(function() {
				var id = $('.id').val();
				$.ajax({
					type: 'POST',
					url: '<?= base_url('products/add'); ?>',
					data: {
						id
					},
					success: function(data) {
						// console.log(data)
						// $('.price').text('₱ ' + result);
						if (id != null) {
							var dataObj = jQuery.parseJSON(data);
							if (dataObj) {
								$(dataObj).each(function() {
									$('.modal-name').text(this.name);
									$('.modal-price').text(this.price);
								});
							} else {
								$('.modal-name').text('Please select a product first.');
							}
						} else {
							$('.modal-name').text('Please select a product first.');
						}
					},
					error: function(result) {
						// console.log(result);
					}
				})
			});
			$('.addtocart').click(function() {
				var id = $('.id').val();
				$.ajax({
					type: 'POST',
					url: '<?= base_url('products/addtocart'); ?>',
					data: {
						id
					},
					success: function(result) {
						window.open('<?= base_url('cart'); ?>', '_self');
					},
					error: function(result) {}
				})
			});
		});
	</script>
</body>

</html>
