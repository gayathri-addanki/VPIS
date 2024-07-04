<?php

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT  v.*,s.id as state_id from `voter_list` v inner join city_list c on v.city_id = c.id inner join state_list s on c.state_id = s.id where v.id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<style>
	#cimg{
		width:100%;
		max-height:20vh;
		object-fit:scale-down;
		object-position:center center;
	}
</style>
<div class="container-fluid">
	<form action="" id="voter-form">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="firstname" class="control-label">First Name <small class="text-danger">*</small></label>
					<input type="text" name="firstname" id="firstname" class="form-control form-control-sm rounded-0" value="<?php echo isset($firstname) ? $firstname : ''; ?>"  required/>
				</div>
				<div class="form-group">
					<label for="middlename" class="control-label">Middl Name</label>
					<input type="text" name="middlename" id="middlename" class="form-control form-control-sm rounded-0" value="<?php echo isset($middlename) ? $middlename : ''; ?>"/>
				</div>
				<div class="form-group">
					<label for="lastname" class="control-label">Last Name <small class="text-danger">*</small></label>
					<input type="text" name="lastname" id="lastname" class="form-control form-control-sm rounded-0" value="<?php echo isset($lastname) ? $lastname : ''; ?>"  required/>
				</div>
				<div class="form-group">
					<label for="gender" class="control-label">Gender <small class="text-danger">*</small></label>
					<select name="gender" id="gender" class="form-control form-control-sm rounded-0" required>
						<option value="Male" <?php echo isset($gender) && $gender == 'Male' ? 'selected' : '' ?>>Male</option>
						<option value="Female" <?php echo isset($gender) && $gender == 'Female' ? 'selected' : '' ?>>Female</option>
					</select>
				</div>
				<div class="form-group">
					<label for="email" class="control-label">Email</label>
					<input type="email" name="email" id="email" class="form-control form-control-sm rounded-0" value="<?php echo isset($email) ? $email : ''; ?>"/>
				</div>
				<div class="form-group">
					<label for="contact" class="control-label">Contact No.</label>
					<input type="text" name="contact" id="contact" class="form-control form-control-sm rounded-0" value="<?php echo isset($contact) ? $contact : ''; ?>"/>
				</div>
				<div class="form-group">
					<label for="address" class="control-label">Address <small class="text-danger">*</small></label>
					<textarea type="text" name="address" id="address" class="form-control form-control-sm rounded-0" required><?php echo isset($address) ? $address : ''; ?></textarea>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="state_id" class="control-label">State/Province <small class="text-danger">*</small></label>
					<select name="state_id" id="state_id" class="select2 form-control form-control-sm rounded-0" required>
						<option value="" <?php echo !isset($state_id)? 'selected' : '' ?>></option>
						<?php 
						$states = $conn->query("SELECT * FROM `state_list` where delete_flag = 0 and `status` = 1 ".(isset($city_id) ? " or id = '{$state_id}' " : "" )." order by `name` asc ");
						while($row = $states->fetch_assoc()):
						?>
						<option value="<?= $row['id'] ?>" <?php echo isset($state_id) && $state_id == $row['id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="city_id" class="control-label">City <small class="text-danger">*</small></label>
					<select name="city_id" id="city_id" class="form-control form-control-sm rounded-0" required>
						<option value="" <?php echo !isset($city_id)? 'selected' : '' ?>></option>
						<?php 
						$cities = $conn->query("SELECT * FROM `city_list` where delete_flag = 0 and `status` = 1 ".(isset($city_id) ? " or id = '{$city_id}'" : "" )." order by `name` asc ");
						$city_arr = [];
						while($row = $cities->fetch_assoc()):
							$city_arr[$row['state_id']][] = $row;
						endwhile; ?>
					</select>
					<small class="text-muted"><em>Select State/Province First</em></small>
				</div>
				<div class="form-group">
					<label for="precinct_id" class="control-label">Precinct No./Code <small class="text-danger">*</small></label>
					<select name="precinct_id" id="precinct_id" class="select2 form-control form-control-sm rounded-0" required>
						<option value="" <?php echo !isset($precinct_id)? 'selected' : '' ?>></option>
						<?php 
						$cities = $conn->query("SELECT * FROM `precinct_list` where delete_flag = 0 and `status` = 1 ".(isset($precinct_id) ? " or id = '{$precinct_id}'" : "" )." order by `code` asc ");
						$precinct_arr = [];
						while($row = $cities->fetch_assoc()):
						?>
						<option value="<?= $row['id'] ?>" <?php echo isset($precinct_id) && $precinct_id == $row['id'] ? 'selected' : '' ?>><?= $row['code'] ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="date_registered" class="control-label">Date Registered <small class="text-danger">*</small></label>
					<input type="date" name="date_registered" id="date_registered" class="form-control form-control-sm rounded-0" value="<?php echo isset($date_registered) ? $date_registered : ''; ?>" max="<?= date("Y-m-d") ?>" required/>
				</div>
				<div class="form-group">
					<label for="status" class="control-label">Status <small class="text-danger">*</small></label>
					<select name="status" id="status" class="form-control form-control-sm rounded-0" required>
						<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
						<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
					</select>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Thumbnail</label>
					<div class="custom-file">
						<input type="file" class="custom-file-input rounded-circle" id="customFile1" accept="image/png, image/jpeg" name="img" onchange="displayImg(this,$(this))">
						<label class="custom-file-label" for="customFile1">Choose file</label>
					</div>
				</div>
				<div class="form-group">
					<img src="<?= validate_image(isset($image_path) ? $image_path : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail w-100">
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	var cities = $.parseJSON('<?= isset($city_arr) && count($city_arr) > 0 ? json_encode($city_arr) : "{}" ?>')
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	_this.siblings('.custom-file-label').html(input.files[0].name)
	        }
	        reader.readAsDataURL(input.files[0]);
	    }else{
				$('#cimg').attr('src', "<?= validate_image(isset($image_path) ? $image_path : '') ?>");
		}
	}
	$(document).ready(function(){
		$('#uni_modal').on('shown.bs.modal',function(){
			$('.select2, #city_id').select2({
				placeholder:'Please Select Here',
				dropdownParent:$('#uni_modal'),
				containerCssClas:'form-control form-control-sm rounded-0'
			})

			$('#state_id').change(function(){
				var id = $(this).val()
				$('#city_id').html('')
				if('<?= isset($city_id) ?>' == '')
					$('#city_id').append('<option disabled selected></option>')
				if(!!cities[id]){
					Object.keys(cities[id]).map(k=>{
						if('<?= isset($city_id) ? $city_id : '' ?>' == cities[id][k].id)
							$('#city_id').append('<option value="'+cities[id][k].id+'" selected>'+cities[id][k].name+'</option>');
						else
							$('#city_id').append('<option value="'+cities[id][k].id+'">'+cities[id][k].name+'</option>');
					})
				}
				$('#city_id').select2("destroy").select2({
					placeholder:'Please Select Here',
					dropdownParent:$('#uni_modal'),
					containerCssClas:'form-control form-control-sm rounded-0'
				})
			})
			
			if('<?= isset($state_id) ?>' == '1'){
				$('#state_id').trigger('change')
			}
				
		})
		
		$('#voter-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_voter",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.reload()
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body,.modal").scrollTop(0);
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
					}
				}
			})
		})

	})
</script>