<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			/* Populate data to province dropdown */
			$('#country').on('change', function() {
				var countryID = $(this).val();
				if (countryID) {
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url('dropdowns/getProvinces'); ?>',
						data: 'country_id=' + countryID,
						success: function(data) {
							$('#province').html('<option value="">Select province</option>');
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
						url: '<?php echo base_url('dropdowns/getCities'); ?>',
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
	</script>
</head>

<body>

	<!-- Country dropdown -->
	<select id="country">
		<option value="">Select Country</option>
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

	<!-- province dropdown -->
	<select id="province">
		<option value="">Select country first</option>
	</select>

	<!-- City dropdown -->
	<select id="city">
		<option value="">Select province first</option>
	</select>

	<!-- City dropdown -->
	<select id="barangay">
		<option value="">Select city first</option>
	</select>



</body>

</html>
