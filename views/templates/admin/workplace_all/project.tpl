<style type="text/css">
.project-line{
padding-left:0px !important;
margin-bottom:2.5px;
padding-bottom:2.5px;
border-style:none none solid none;
border-color:#eaeaea;
border-width: 1px;
}
.project-line-padding{
margin-bottom:2.5px;
padding-bottom:2.5px;
border-style:none none solid none;
border-color:#eaeaea;
border-width: 1px;
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
.btn-left{
	float:right;
}
/* Style the tab */
.tab {
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons that are used to open the tab content */
.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}

.fix{
	margin-top:0px;
	margin-bottom:0px;
}

.tab-pane:not(.active) {
    display: none;
}
</style>
<script type="text/javascript">
	function showProducts(str) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("show_customers").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "../modules/workplace/getproducts.php?q=" + str, true);
        xmlhttp.send();
    
}

	function addProductToProject(str) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("addedProductsList").innerHTML += this.responseText;
            }
        };
        xmlhttp.open("GET", "../modules/workplace/getproducts.php?id=" + str + "&pid={$projectID}", true);
        xmlhttp.send();
    
}

	function dellProductFromProject(str) {
        if (str == "refresh"){
        	    if (confirm("Sorry, you can not remove this item right now. we have to reloasd te page first. Would you like to reload the page?") == true) {
        			location.reload();
    			} 
        }else{
        var xmlhttp = new XMLHttpRequest();
        var productInnerHTML = document.getElementById("addedProductsList").innerHTML;
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

                if(this.responseText == "removed"){
                	location.reload();
                }
            }
        };
        xmlhttp.open("GET", "../modules/workplace/getproducts.php?did=" + str + "&pid={$projectID}", true);
        xmlhttp.send();
    
}}

		function addLogbook(str) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("addedProductsList").innerHTML += this.responseText;
            }
        };
        xmlhttp.open("GET", "../modules/workplace/logbook.php?var=" + str + "&pid={$projectID}", true);
        xmlhttp.send();
    
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


		<div id="Project" class="tabContent">
				<div class="col-md-10  col-md-pull-2">


	
		<div class="panel">
			<div class="panel-heading">Project informatie
				
				<button type="button" class="btn btn-default btn-sm" data-toggle="tab" href="#log" style="float:right;margin-top:2.5px;">Logboek</button>
				<button type="button" class="btn btn-default btn-sm" data-toggle="tab" href="#home" style="float:right;margin-top:2.5px;">Overview</button>
			</div>
			<div class="panel-body">

				<div id="log" class="tab-pane fade">
					<pre>
						hallo dit is een test
						gweeee 

						ja
					</pre>

					<textarea type="" name=""></textarea>
					<button id="add_button" class="btn btn-info" onclick="makeNew()" style="float:right;margin-top:10px;margin-right:10px;">Add to logboek</button>
				</div>

				<div id="home" class="tab-pane fade in active">
					<div class="col-md-12">
						<div class="col-sm-3  project-line-padding"><b>Medewerker:</b> </div>
						<div class="col-sm-9  project-line">{$nameWorker}</div>
					</div>

					<div class="col-md-12" style="margin-top:20px;">
						<div class="col-md-6">
							<div class="col-sm-6 project-line">
								<b>Naam klant:</b>
							</div>
							<div class="col-sm-6 project-line">
								{$name}
							</div>
							<div class="col-sm-6 project-line">
								<b>Telefoonnummer:</b>
							</div>
							<div class="col-sm-6 project-line">
								{$phone}&nbsp;
							</div>
							<div class="col-sm-6 project-line">
								<b>Email adres:</b>
							</div>
							<div class="col-sm-6 project-line">
								{$email}
							</div>
						</div>

						<div class="col-md-6">
							<div class="col-sm-6 project-line">
								<b>Datum ingeleverd:</b>
							</div>
							<div class="col-sm-6 project-line">
								{$dateAdded}
							</div>
							<div class="col-sm-6 project-line">
								<b>Uiterste oplever datum</b>
							</div>
							<div class="col-sm-6 project-line">
								{$endDate}
							</div>
							<div class="col-sm-6 project-line">
								<b>Uiterste budget</b>
							</div>
							<div class="col-sm-6 project-line">
								{$projectBudget}
							</div>
						</div>

						
					</div>

					<div class="col-md-12" style="margin-top:20px;">
						<div class="col-sm-3  project-line-padding"><b>Merk:</b> </div>
						<div class="col-sm-9  project-line">{$brand}</div>

						<div class="col-sm-3  project-line-padding"><b>Type:</b> </div>
						<div class="col-sm-9  project-line">{$kind}</div>

						<div class="col-sm-3  project-line-padding"><b>Storing:</b> </div>
						<div class="col-sm-9  project-line">{$problem}</div>

						<div class="col-sm-3  project-line-padding"><b>Wat word er geleverd:</b> </div>
						<div class="col-sm-9  project-line">{$included}</div>
					</div>
				</div>
			</div>





			</div>

						<!-- Products added-->
			<div class="panel">
			<div class="panel-heading">Added products <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;margin-top:2.5px;">Add product</button></div>
				<div class="panel-body">
					
					
					<div id="addedProductsList">
						{$products}
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
        <h4 class="modal-title">Kies Producten</h4>
      </div>
      <div class="modal-body">
        <p><b>Naam Product:</b></p>
        <input id="search_customer" type="text" placeholder="Product" class=""  autocomplete="off" onkeyup="showProducts(this.value)" style="margin-bottom:15px;"></input>

        <span id="show_customers">
        	
        </span>
        <div class="clear"></div>
      </div>
      <div class="modal-footer">
        <button id="chose_customer" type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>
    </div>

  </div>
</div>
</div>
		</div>
		</div>

	</div>





