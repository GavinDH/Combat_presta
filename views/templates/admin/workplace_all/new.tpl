<style type="text/css">
.project-line{
padding-left:0px !important;
margin-bottom:2.5px;
padding-bottom:12.5px;
border-style:none none solid none;
border-color:#eaeaea;
border-width: 1px;
height: 34.5px!important;
}
.project-line-padding{
margin-bottom:2.5px;
padding-bottom:12.5px;
border-style:none none solid none;
border-color:#eaeaea;
border-width: 1px;
height: 34.5px!important;
}
	.all-products-holder{
		background-color:#f5f5f5;
		padding:10px;
		border-radius:5px;
		margin-bottom:10px;
		float:right;
		width:100%;
	}

		.clear{
		clear:both;
	}
</style>
<script>
function showCustomer(str) {
        var xmlhttp = new XMLHttpRequest();
        var response
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            	response = this.responseText;
            	response = response.split('[id]');
                document.getElementById("show_customers").innerHTML = response[0];
                document.getElementById("chose_customer").onclick = "getCustomerInfo(" + response[1] + ")";
            }
        };
        xmlhttp.open("GET", "../modules/workplace/getcustomer.php?q=" + str, true);
        xmlhttp.send();
    
}

function getCustomerInfo(id,check){
	if(check == true){
			        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            	var info = this.responseText;
            	info = info.replace("]","");
            	info = info.replace("[","");
            	info = info.split(",");
                document.getElementById("selected_name").innerHTML = info[0];
                if(info[1] == "FALSE"){
                	document.getElementById("selected_phone").innerHTML = '<input id="phoneNBR" type="text" placeholder="PhoneNumber Not found" class=""></input>';
                }else{
                	document.getElementById("selected_phone").innerHTML = info[1] + '<input id="phoneNBR" type="hidden" value="'+ info[1] +'" >'; 
                }
                document.getElementById("selected_email").innerHTML = info[2];
                document.getElementById("hiddenUserValue").value = id;

            }
        };
        xmlhttp.open("GET", "../modules/workplace/getcustomer.php?id=" + id, true);
        xmlhttp.send();

		}
	}

function makeNew(){
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            	if(this.responseText == '1'){
            		document.getElementById("add_button").disabled = true;
            		document.getElementById("getNewReturn").innerHTML ='<div class="alert alert-info"><strong>Added!</strong> The new project is added to the database</div>';
            	}else{
            		document.getElementById("getNewReturn").innerHTML = '<div class="alert alert-info">' + this.responseText + '</div>'; // get return
            	}
                

            }
        };
        xmlhttp.open("GET", "../modules/workplace/makeNewProject.php?NW=" + getValue('nameWorker') + "&CI=" + getValue('hiddenUserValue') + "&DD=" + getValue('datetimepicker4') + "&BT=" + getValue('budget') + "&BD=" + getValue('brand') + "&TY=" + getValue('type') + "&PM=" + getValue('problem') + "&INC=" + getValue('include') + "&P=" + getValue('phoneNBR'), true);
        xmlhttp.send();
    
}

function getValue(name){
	var returnvar,
	element = document.getElementById(name);
	if (element != null) {
		if(element.value == ''){
			returnvar = "Undifened";
		}else{
			returnvar = element.value; // gebruik id ipv name
		}
   		
	}
	else {
    	returnvar = "Undifened";
	}
	
	return returnvar;
}
	

</script>
<div class="row">
	<div class="col-md-2 col-md-push-10">
		<div class="panel">
			<div class="panel-heading">Menu</div>
			<div class="panel-body">

				<a href="{$homeLink}">All Projects</a><br>
				<a href="{$homeLink}&NEW=TRUE">Add new Project</a>
			</div>
		</div>
	</div>
	<div class="col-md-10 col-md-pull-2">
		<div class="panel">
			<div class="panel-heading">Project informatie</div>
			<div class="panel-body">
				<div id="getNewReturn"></div>
				<div class="col-md-12">
					<div class="col-sm-3  project-line-padding"><b>Medewerker:</b> </div>
					<div class="col-sm-9  project-line"><input id="nameWorker" type="text" placeholder="Naam Medewerker" class=""></input></div>
				</div>
				<div class="col-md-12" style="margin-top:20px;">
					
					<div class="col-md-6">
						<div class="col-sm-6 project-line">
							<b>Naam klant:</b>
						</div>
						<div class="col-sm-6 project-line">
							 <input id="hiddenUserValue" type="hidden" id="userValue" value="">
							<span id="selected_name"></span><button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;">Zoek Klant</button>
						</div>
						<div class="col-sm-6 project-line">
							<b>Telefoonnummer:</b>
						</div>
						<div class="col-sm-6 project-line">
							<span id="selected_phone"></span>
						</div>
						<div class="col-sm-6 project-line">
							<b>Email adres:</b>
						</div>
						<div class="col-sm-6 project-line">
							<span id="selected_email"></span>
						</div>
					</div>

					<div class="col-md-6">
						<div class="col-sm-6 project-line">
							<b>Datum ingeleverd:</b>
						</div>
						<div class="col-sm-6 project-line">
							{$date}
						</div>
						<div class="col-sm-6 project-line">
							<b>Uiterste oplever datum</b>
						</div>
						<div class="col-sm-6 project-line">
							<input id="datetimepicker4" type="text" placeholder="Selecteer een datum" class=""></input>
							    <script type="text/javascript">
            $(function () {
                $('#datetimepicker4').datepicker();
            });
        </script>
						</div>
						<div class="col-sm-6 project-line">
							<b>Uiterste budget</b>
						</div>
						<div class="col-sm-6 project-line">
							<input  id="budget" type="text" placeholder="Maximale budget" class=""></input>
						</div>
					</div>
				</div>

				<div class="col-md-12" style="margin-top:20px;">
					<div class="col-sm-3  project-line-padding"><b>Merk:</b> </div>
					<div class="col-sm-9  project-line"><input id="brand" type="text" placeholder="Merk" class=""></input></div>

					<div class="col-sm-3  project-line-padding"><b>Type:</b> </div>
					<div class="col-sm-9  project-line"><input  id="type" type="text" placeholder="Type" class=""></input></div>

					<div class="col-sm-3  project-line-padding"><b>Storing:</b> </div>
					<div class="col-sm-9  project-line"><input id="problem" type="text" placeholder="Storing apperaat" class=""></input></div>

					<div class="col-sm-3  project-line-padding"><b>Wat word er geleverd:</b> </div>
					<div class="col-sm-9  project-line"><input id="include" type="text" placeholder="Tas, BB's en gas" class=""></input></div>
				</div>
<!-- Trigger the modal with a button -->

				<button id="add_button" class="btn btn-info" onclick="makeNew()" style="float:right;margin-top:10px;margin-right:10px;">Maak project</button>
<!-- Modal -->

			</div>
		</div>


		</div>
	</div>

	<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Kies uw klant</h4>
      </div>
      <div class="modal-body">
        <p><b>Naam klant:</b></p>
        <input id="search_customer" type="text" placeholder="Naam klant" class="" autocomplete="off" onkeyup="showCustomer(this.value)" style="margin-bottom:15px;"></input>

        <span id="show_customers">
        	
        </span>
        <div class="clear"></div>
      </div>
      <div class="modal-footer">
        <button id="chose_customer" type="button" class="btn btn-default" data-dismiss="modal">Kies Klant</button>
      </div>
    </div>

  </div>
</div>
</div>




