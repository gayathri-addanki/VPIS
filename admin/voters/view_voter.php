<?php

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT v.*, concat(v.lastname, ', ', v.firstname, ' ', coalesce(v.middlename,'')) as `name`, s.`name` as `state`, c.`name` as `city` from `voter_list` v inner join city_list c on v.city_id = c.id inner join state_list s on c.state_id = s.id where v.id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
    if(isset($precinct_id) && $precinct_id > 0){
        $precinct = $conn->query("SELECT * FROM `precinct_list` where id = '{$precinct_id}'");
        if($precinct->num_rows > 0){
            $precinct_code = $precinct->fetch_array()['code'];
        }
    }
}
?>
<style>
    #uni_modal .modal-footer{
        display:none;
    }
    #cimg{
        width:100%;
        max-height:20vh;
        object-fit:scale-down;
        object-position:center center
    }
</style>
<div class="container-fluid">
    <div class="text-center">
			<img src="<?= validate_image(isset($image_path) ? $image_path : '') ?>" alt="" id="cimg" class="img-fluid bg-gradient-dark w-100">
    </div>
	<dl>
        <dt class="text-muted">Precinct No./Code</dt>
        <dd class="pl-4"><h4><b><?= isset($precinct_code) ? $precinct_code : "N/A" ?></b></h4></dd>
        <dt class="text-muted">Name</dt>
        <dd class="pl-4"><?= isset($name) ? $name : "" ?></dd>
        <dt class="text-muted">Gender</dt>
        <dd class="pl-4"><?= isset($gender) ? $gender : '' ?></dd>
        <dt class="text-muted">Email</dt>
        <dd class="pl-4"><?= isset($email) ? $email : 'N/A' ?></dd>
        <dt class="text-muted">Contact No.</dt>
        <dd class="pl-4"><?= isset($contact) ? $contact : 'N/A' ?></dd>
        <dt class="text-muted">Address</dt>
        <dd class="pl-4"><?= isset($address) ? $address : 'N/A' ?></dd>
        <dt class="text-muted">City</dt>
        <dd class="pl-4"><?= isset($city) ? $city : '' ?></dd>
        <dt class="text-muted">State</dt>
        <dd class="pl-4"><?= isset($state) ? $state : '' ?></dd>
        <dt class="text-muted">Date Registered</dt>
        <dd class="pl-4"><?= isset($date_registered) ? date("F d, Y", strtotime($date_registered)) : '' ?></dd>
        <dt class="text-muted">Status</dt>
        <dd class="pl-4">
            <?php if($status == 1): ?>
                <span class="badge badge-success px-3 rounded-pill">Active</span>
            <?php else: ?>
                <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
            <?php endif; ?>
        </dd>
    </dl>
    <div class="clear-fix my-3"></div>
    <div class="text-right">
        <button class="btn btn-sm btn-dark bg-gradient-dark btn-flat" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>