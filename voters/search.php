<section class="py-5">
    <div class="container">
        <h2 class="text-center"><b>Search Voter's Details</b></h2>
        <center>
            <hr class="bg-navy" width="10%" style="height:2px;opacity:1">
        </center>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <div class="card card-default rounded-0 shadow blur">
                    <div class="card-body container-fluid">
                        <form action="" id="search-form">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="firstname" class="control-label">First Name <small class="text-danger">*</small></label>
                                        <input type="text" name="firstname" id="firstname" class="form-control form-control-lg rounded-pill"  required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="middlename" class="control-label">Middl Name</label>
                                        <input type="text" name="middlename" id="middlename" class="form-control form-control-lg rounded-pill"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname" class="control-label">Last Name <small class="text-danger">*</small></label>
                                        <input type="text" name="lastname" id="lastname" class="form-control form-control-lg rounded-pill"  required/>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="state_id" class="control-label">State/Province <small class="text-danger">*</small></label>
                                        <select name="state_id" id="state_id" class="select2 form-control form-control-lg rounded-pill" required>
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
                                        <select name="city_id" id="city_id" class="form-control form-control-lg rounded-pill" required>
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
                                </div>
                            </div>
                            <hr>
                            <div class="clear-fix py-3"></div>
                            <div class="text-center">
                                <button class="btn btn-primary btn-lg w-50 rounded-pill"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var cities = $.parseJSON('<?= isset($city_arr) && count($city_arr) > 0 ? json_encode($city_arr) : '{}' ?>')
    $(function(){
        $('.select2, #city_id').select2({
            placeholder:'Please Select Here',
            containerCssClass:'form-control form-control-lg rounded-pill'
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
                containerCssClass:'form-control form-control-lg rounded-pill'
            })
        })
        $('#search-form').submit(function(e){
            e.preventDefault()
            location.href="./?p=voters&"+$(this).serialize()
        })
    })
</script>