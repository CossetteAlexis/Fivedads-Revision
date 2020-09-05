<!DOCTYPE html>
<html lang="en-US">

<head>
	<title>Checkout</title>
	<meta charset="utf-8">

	<!-- Include bootstrap library -->
	<link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
	<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			/* Populate data to province dropdown */
			$('#country').on('change', function() {
				var countryID = $(this).val();
				if (countryID) {
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url('checkout/getProvinces'); ?>',
						data: 'country_id=' + countryID,
						success: function(data) {
							$('#province').html('<option value="">Select Province</option>');
							var dataObj = jQuery.parseJSON(data);
							if (dataObj) {
								$(dataObj).each(function() {
									var option = $('<option />');
									option.attr('value', this.id).text(this.name);
									$('#province').append(option);
								});
							} else {
								$('#province').html('<option value="">Province not available</option>');
							}
						}
					});
				} else {
					$('#province').html('<option value="">Select country first</option>');
					$('#city').html('<option value="">Select province first</option>');
				}
			});

			/* Populate data to city dropdown */
			$('#province').on('change', function() {
				var provinceID = $(this).val();
				if (provinceID) {
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url('checkout/getCities'); ?>',
						data: 'province_id=' + provinceID,
						success: function(data) {
							$('#city').html('<option value="">Select City</option>');
							var dataObj = jQuery.parseJSON(data);
							if (dataObj) {
								$(dataObj).each(function() {
									var option = $('<option />');
									option.attr('value', this.id).text(this.name);
									$('#city').append(option);
								});
								chk_cod();
							} else {
								$('#city').html('<option value="">City not available</option>');
							}
						}
					});
				} else {
					$('#city').html('<option value="">Select province first</option>');
				}
			});

			/* Populate data to barangay dropdown */
			$('#city').on('change', function() {
				var cityID = $(this).val();
				if (cityID) {
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url('dropdowns/getBarangays'); ?>',
						data: 'city_id=' + cityID,
						success: function(data) {
							$('#barangay').html('<option value="">Select Barangay</option>');
							var dataObj = jQuery.parseJSON(data);
							if (dataObj) {
								$(dataObj).each(function() {
									var option = $('<option />');
									option.attr('value', this.id).text(this.name);
									$('#barangay').append(option);
								});
								chk_cod();
							} else {
								$('#barangay').html('<option value="">Barangay not available</option>');
							}
						}
					});
				} else {
					$('#barangay').html('<option value="">Select city first</option>');
				}
			});
		});

		$(document).ready(function() {
			// $('.check_cod').hide();
			$('#country').change(function() {
				var country = $('#country option:selected').text();
				$('#cntry').val(country);
			});
			$('#province').change(function() {
				var province = $('#province option:selected').text();
				$('#prov').val(province);
			});
			$('#city').change(function() {
				var city = $('#city option:selected').text();
				$('#cty').val(city);
			});
			$('#barangay').change(function() {
				var barangay = $('#barangay option:selected').text();
				$('#brgy').val(barangay);
				// $('.check_cod').show();
			});
		});

		//check cod code
		function chk_cod() {
			if ($("#barangay").val() == 0) {
				$(".cod_available").hide();
				// $(".cod_not_available").show();
				return false;
			}
			var values = {
				'citymunid': $("#citymunid").val(),
				'brgyid': $("#barangay").val()
			};
			$.post(`<?= base_url() ?>checkout/chk_cod`, values, function(data) {
				$(".cod_available").show();
				if (data.cod == "Not COD.") {
					$(".cod_not_available").show();
					$(".cod_available").hide();
				} else {
					$(".cod_not_available").hide();
					$(".cod_available").show();
				}
				$(".chk_cod").text(data.cod);
			}, "json");
		}
	</script>
</head>

<body>
	<div class="container">
		<!-- <h1>CHECKOUT</h1> -->
		<div class="col-12">
			<div class="checkout">
				<div class="row pt-5">
					<?php if (!empty($error_msg)) { ?>
						<div class="col-md-12">
							<div class="alert alert-danger"><?php echo $error_msg; ?></div>
						</div>
					<?php } ?>

					<div class="col-md-4 order-md-2 mb-4">
						<h4 class="d-flex justify-content-between align-items-center mb-3">
							<span class="text-muted">Your Cart</span>
							<span class="badge badge-secondary badge-pill"><?php echo $this->cart->total_items(); ?></span>
						</h4>
						<ul class="list-group mb-3">
							<?php if ($this->cart->total_items() > 0) {
								foreach ($cartItems as $item) { ?>
									<li class="list-group-item d-flex justify-content-between lh-condensed">
										<div>
											<?php $imageURL = !empty($item["image"]) ? base_url('uploads/product_images/' . $item["image"]) : base_url('assets/images/pro-demo-img.jpeg'); ?>
											<img src="<?php echo $imageURL; ?>" width="75" />
											<h6 class="my-0"><?php echo $item["name"]; ?></h6>
											<small class="text-muted"><?php echo '$' . $item["price"]; ?>(<?php echo $item["qty"]; ?>)</small>
										</div>
										<span class="text-muted"><?php echo '$' . $item["subtotal"]; ?></span>
									</li>
								<?php }
							} else { ?>
								<li class="list-group-item d-flex justify-content-between lh-condensed">
									<p>No items in your cart...</p>
								</li>
							<?php } ?>
							<li class="list-group-item d-flex justify-content-between">
								<span>Total (USD)</span>
								<strong><?php echo '$' . $this->cart->total(); ?></strong>
							</li>
						</ul>
						<a href="<?php echo base_url('products/'); ?>" class="btn btn-block btn-info">Add Items</a>
					</div>

					<!-- Contact Information -->
					<div class="col-md-8 order-md-1">
						<form method="post">
							<div class="row container">
								<div class="col-sm-4">
									<h6>Personal Information</h6>
								</div>
								<div class="col-sm-8">
									<div>
										<label for="">Firstname</label>
										<br>
										<input name="firstname" type="text" class="form-control" value="<?php echo !empty($custData['firstname']) ? $custData['firstname'] : ''; ?>" required>
										<?php echo form_error('firstname', '<p class="help-block error">', '</p>'); ?>
									</div>
									<div>
										<label for="">Lastname</label>
										<br>
										<input name="lastname" type="text" class="form-control" value="<?php echo !empty($custData['lastname']) ? $custData['lastname'] : ''; ?>" required>
										<?php echo form_error('lastname', '<p class="help-block error">', '</p>'); ?>
									</div>
								</div>
							</div>

							<hr>
							<!-- address -->
							<div class="row container">
								<div class="col-sm-4">
									<h6>Billing Address</h6>
								</div>
								<div class="col-sm-8">
									<div>
										<label for="">Address</label>
										<br>
										<input name="street" type="text" class="form-control" value="<?php echo !empty($custData['street']) ? $custData['street'] : ''; ?>" placeholder="Unit, Building, Street" required>
										<?php echo form_error('street', '<p class="help-block error">', '</p>'); ?>
									</div>
									<br>
									<div class="row">
										<div class="col-md-6">
											<label for="">Country</label>
											<select id="country" class="btn btn-secondary btn-block dropdown" aria-haspopup="true" aria-expanded="false" required>
												<option value="" hidden>Philippines</option>
												<?php
												if (!empty($countries)) {
													foreach ($countries as $row) {
														echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
													}
												} else {
													echo '<option value="">Country not available</option>';
												}
												?>
											</select>
											<input name="country" id="cntry" type="text" hidden value="<?php echo !empty($custData['country']) ? $custData['country'] : ''; ?>">
										</div>
										<div class="col-md-6">
											<label for="">Province</label>
											<select id="province" class="btn btn-secondary btn-block dropdown" aria-haspopup="true" aria-expanded="false" required>
												<option value="" selected disabled hidden>Select country first</option>
											</select>
											<input name="province" id="prov" type="text" hidden value="<?php echo !empty($custData['province']) ? $custData['province'] : ''; ?>">
										</div>
									</div>
									<div class="row pb-3">
										<div class="col-md-6">
											<label for="">City</label>
											<select id="city" class="btn btn-secondary btn-block dropdown" aria-haspopup="true" aria-expanded="false" required>
												<option value="" selected disabled hidden>Select province first</option>
											</select>
											<input name="city" id="cty" type="text" hidden value="<?php echo !empty($custData['city']) ? $custData['city'] : ''; ?>">
										</div>
										<div class="col-md-6">
											<label for="">Barangay</label>
											<select id="barangay" class="btn btn-secondary btn-block dropdown" aria-haspopup="true" aria-expanded="false" required>
												<option value="" selected disabled hidden>Select city first</option>
											</select>
											<input name="barangay" id="brgy" type="text" hidden value="<?php echo !empty($custData['barangay']) ? $custData['barangay'] : ''; ?>">
										</div>
									</div>
									<!-- show cod or cop -->
									<span class="help-block success cod_available" style="display:none;">
										<i class="fa fa-check"></i>
										<span class="chk_cod"></span>
									</span>

									<span class="help-block warning cod_not_available" style="display:none;">
										<i class="fa fa-times"></i>
										<span class="chk_cod"></span>
									</span>
								</div>
							</div>

							<hr>
							<!-- contact number -->
							<div class="row container">
								<div class="col-sm-4">
									<h6>Contact Information</h6>
								</div>
								<div class="col-sm-8">
									<div>
										<label for="">Contact Number</label>
										<br>
										<input name="phone" type="text" class="form-control" value="<?php echo !empty($custData['phone']) ? $custData['phone'] : ''; ?>" required>
										<?php echo form_error('phone', '<p class="help-block error">', '</p>'); ?>
									</div>
									<div>
										<label for="">Alternative Contact Number</label>
										<br>
										<input name="phone2" type="text" class="form-control" value="<?php echo !empty($custData['phone2']) ? $custData['phone2'] : ''; ?>" required>
										<?php echo form_error('phone2', '<p class="help-block error">', '</p>'); ?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
								</div>
								<div class="col-sm-4">
									<a href="">Return to cart</a>
								</div>
								<div class="col-sm-3">
									<input name="placeOrder" class="btn btn-primary btn-block" type="submit" value="Place Order">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>

</html>
