<?php 
extract($_GET);
$search = "";

if(isset($firstname) && !empty($firstname)){
    if(!empty($search)) $search .= " and ";
    $search .= " v.firstname LIKE '%{$firstname}%' ";
}
if(isset($middlename) && !empty($middlename)){
    if(!empty($search)) $search .= " and ";
    $search .= " v.middlename LIKE '%{$middlename}%' ";
}
if(isset($lastname) && !empty($lastname)){
    if(!empty($search)) $search .= " and ";
    $search .= " v.lastname LIKE '%{$lastname}%' ";
}
if(isset($city_id) && !empty($city_id)){
    if(!empty($search)) $search .= " and ";
    $search .= " v.city_id = '{$city_id}' ";
}
if(isset($state_id) && !empty($state_id)){
    if(!empty($search)) $search .= " and ";
    $search .= " s.id = '{$state_id}' ";
}

if(!empty($search))
$search = " where ({$search}) ";
else{
    echo "<script> alert('No search data given'); location.replace('./?p=voters/search') </script>";
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
	.prod-img{
		width: 2.8em;
    	height: 2.8em;
		object-fit:scale-down;
		object-position:center center;
	}
</style>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">Search Results</h3>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="15%">
					<col width="25%">
					<col width="30%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Registered</th>
						<th>Image</th>
						<th>Name</th>
						<th>Address</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
                        

						$qry = $conn->query("SELECT v.*, concat(v.lastname, ', ', v.firstname, ' ', coalesce(v.middlename,'')) as `name`, s.`name` as `state`, c.`name` as `city` from `voter_list` v inner join city_list c on v.city_id = c.id inner join state_list s on c.state_id = s.id {$search} order by concat(v.lastname, ', ', v.firstname, ' ', coalesce(v.middlename,'')) asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d",strtotime($row['date_created'])) ?></td>
							<td class="text-center">
								<img class="img-thumbnail prod-img rounded-circle border" src="<?= validate_image($row['image_path']) ?>" alt="">
							</td>
							<td><?php echo $row['name'] ?></td>
							<td class=""><p class="m-0 truncate-1"><?php echo $row['address'].", ". $row['city'].", ". $row['state'] ?></p></td>
							<td align="center">
								 <button type="button" class="btn btn-flat p-1 btn-light bg-gradient-light border btn-sm view_data" data-id="<?= $row['id'] ?>">
				                  		<i class="fa fa-eye"></i> View
				                  </button>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.view_data').click(function(){
			uni_modal("<i class='fa fa-bars'></i> Voter Details","voters/view_voter.php?id="+$(this).attr('data-id'), 'modal-lg')
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [6] }
			],
			order:[0,'asc']
		});
	})
</script>