<!DOCTYPE html>
<html>
<head>
	<title></title>

	<!-- Latest compiled and minified CSS -->
	<!-- <link rel="stylesheet" href="<?php //echo base_url(); ?>assets/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">

	<!-- jQuery library -->
	<!-- <script src="<?php //echo base_url(); ?>assets/js/jquery.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
	

	<!-- Latest compiled JavaScript -->
	<!-- <script src="<?php //echo base_url(); ?>assets/js/bootstrap.min.js"></script> -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</head>
<body>

	<div class="container-fluid">

		<div class="row" style="padding: 10px;">
			<button type="button" id="save_api" class="btn btn-primary">Save From API</button>
		</div>
		<br><br>
		<div class="row" style="padding: 10px;">
            <div class="col-lg-12">
            	<table id="example" class="table table-striped table-bordered" style="width:100%">
	                <thead>
	                    <tr>
	                        <th>Iso2 code</th>
	                        <th>Name</th>
	                        <th>Region</th>
	                        <th>Income Level</th>
	                        <th>Capital City</th>
	                        <th>Latitude</th>
	                        <th>Longitude</th>
	                        <th>Edit</th>
	                    </tr>
	                </thead>
	                <tbody id="country_data">
	                    
	                </tbody>
            </table>
            </div>
			
		</div>

		<div class="modal fade" id="add_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content card">
                <div class="header bg-blue-grey">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div id="show_msg"></div>
                    <form id="form_validation1" method="POST" name="frm_add_edit">
                        <input type="hidden" id="id" name="id" value="">

                        <div class="row">
                        	<div class="col-lg-12">
                        		<label>Name :</label>
                        		<input type="text" readonly="" id="name" name="name" class="form-control">
                        	</div>                        	
                        </div>
                        <div class="row">
                        	<div class="col-lg-12">
                        		<label>Iso2 Code :</label>
                        		<input type="text" readonly="" id="iso2code" name="iso2code" class="form-control">
                        	</div>                        	
                        </div>
                        <div class="row">
                        	<div class="col-lg-12">
                        		<label>Region :</label>
                        		<input type="text" readonly="" id="region" name="region" class="form-control">
                        	</div>                        	
                        </div>
                        <div class="row">
                        	<div class="col-lg-12">
                        		<label>Income Level :</label>
                        		<input type="text" id="income_level" name="income_level" class="form-control">
                        	</div>                        	
                        </div>
                        <div class="row">
                        	<div class="col-lg-12">
                        		<label>Capital City :</label>
                        		<input type="text" id="capital_city" name="capital_city" class="form-control">
                        	</div>                        	
                        </div>
                        <div class="row">
                        	<div class="col-lg-12">
                        		<label>Latitude :</label>
                        		<input type="text" id="latitude" name="latitude" class="form-control">
                        	</div>                        	
                        </div>
                        <div class="row">
                        	<div class="col-lg-12">
                        		<label>Longitude :</label>
                        		<input type="text" id="longitude" name="longitude" class="form-control">
                        	</div>                        	
                        </div>
                        <div class="row" style="padding-top: 10px;">
                        	<div class="col-md-12 col-sm-12">
                                <button class="btn btn-primary waves-effect btn-lg btn-block" id="add_edit_material" type="submit">SUBMIT</button>
                            </div>
                        </div>
                        
                    </form>

                </div>
            </div>
        </div>
    </div>

		

	</div>

	<script type="text/JavaScript">

		$(document).ready( function () {
    		$('#example').DataTable();
    		getData();
		});

		$("#save_api").click(function(){ 
			//alert(1);
			let url = "https://api.worldbank.org/v2/country?format=json";

			$.get(
				url,
				(data, status, xhr) => {
					let resData = data[1];
					saveData(resData);
				},
				"json"
				);
		});

		function saveData(resData) {
			$.ajax({
				url: "<?php echo base_url('dashboard/savedata'); ?>",
				type: 'POST',
				data: {'res': resData},
				//data: resData,
				dataType: 'json',
		        encode: true,
		        async:false,
				success: function(data) {
					getData();
				},
				error: function(res) {
					console.error(res);
				}
			});
		}

		function getData(){
			$.ajax({
				url: "<?php echo base_url('dashboard/getdata'); ?>",
				type: 'GET',
				dataType: 'json',
		        encode: true,
		        async:false,
				success: function(data) {
					var html = '';
		            var c = 0;
		            if(data.status)
		            {
		                $.each(data.country_list,function(key,value)
		                {
		                	c++;
		                    html += '<tr>';
		                    html += '<td>'+value.name+'</td>';
		                    html += '<td>'+value.iso2_code+'</td>';
		                    html += '<td>'+value.region+'</td>';
		                    html += '<td>'+value.income_level+'</td>';
		                    html += '<td>'+value.capital_city+'</td>';
		                    html += '<td>'+value.latitude+'</td>';
		                    html += '<td>'+value.longitude+'</td>';
		                    html += '<td style="text-align: center;"><button type="button" class="btn btn-sm btn-info waves-effect edit_in_menu" data-toggle="modal"  onclick="get_country(' + value.id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>';
		                    html += '</tr>';
		                })
		            }
		            else{
		                html += '<tr>';
		                html += '<td colspan="8">No data Found</td>';
		                html += '</tr>';
		            }
	            $("#example").dataTable().fnDestroy();
	            $("#country_data").html(html);
	            $("#example").DataTable();
				},
				error: function(res) {
					console.error(res);
				}
			});
		}

		function get_country(id){
			$('#add_item').modal('show');
			var modal = $('#add_item');

			$("#id").val(id);
			$.ajax({
				url: "<?php echo base_url('dashboard/getCountrydata'); ?>/" + id,
				type: 'GET',
				dataType: 'json',
		        encode: true,
		        async:false,
		        success: function(data) {
		        	//console.log(data.country_data.name);
		        	$("#name").val(data.country_data.name);
		        	$("#iso2code").val(data.country_data.iso2_code);
		        	$("#region").val(data.country_data.region);
		        	$("#income_level").val(data.country_data.income_level);
		        	$("#capital_city").val(data.country_data.capital_city);
		        	$("#latitude").val(data.country_data.latitude);
		        	$("#longitude").val(data.country_data.longitude);

		        }
			});
		}

		$("#form_validation1").submit(function (event) {
			event.preventDefault();

			var frm_data = $("#form_validation1").serializeArray();
			//console.log(frm_data);

			$.ajax({
                    type: "POST", // data goto the server through POST method
                    url: "<?php echo base_url('dashboard/updatedata'); ?>",
                    data: frm_data, // send data as array formate
                    dataType: "json", // what type of data formate we will wante from the server
                    encode: true,
                    async: false,
                    success: function(data) {
		        	//console.log(data.country_data.name);
		        	alert('Updated Successfully');
		        	window.location.reload();

		        }
                });
		});
		
		
	</script>

	
</body>
</html>

		
		