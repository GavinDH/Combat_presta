<style type="text/css">
	.all-products-holder{
		background-color:#f5f5f5;
		padding:10px;
		border-radius:5px;
		margin-bottom:10px;
		float:right;
		width:100%;
	}

	.basic-info{
		float:left;
		width:80%;
	}
	.special-info{
		float:right;
	}
	.clear{
		clear:both;
	}
	.search_users{
	height: 31px !important;
    margin-left: -1px !important;
    border-radius: 0px 5px 5px 0px !important;
    border-style: solid solid solid none !important;
    border-width: 1px !important;
    border-color: #dddddd !important;
}
.user_bar_fix{
    border-style:solid none solid solid!important;
}

.navigation-fix{
	margin-top:-20px !important;
	margin-bottom:20px !important;
}
</style>


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
			<div class="panel-heading">Workplace</div>
			<div class="panel-body">
				<center class="navigation-fix">
					<nav aria-label="Page navigation example">
  						<ul class="pagination">
    						<li class="page-item">
    							<a class="page-link" href="{$homeLink}&done=FALSE">
    								Niet af projecten
    							</a>
    						</li>
    						<li class="page-item">
    							<a class="page-link" href="{$homeLink}">
    								Niewste eerst
    							</a>
    						</li>
    						<li class="page-item">
    							<a id="search_link" class="page-link user_bar_fix" href="#" ><i class="icon-search"></i> </a>
    							<input id="search_input" type="" placeholder="search" class="page-item search_users" onkeydown = "if (event.keyCode == 13)
                        		document.getElementById('search_link').click()" ></input>
                        	</li>
  </ul>
</nav>
</center>

			{$allProjects}</div>
		</div>
	</div>
</div>



</script>
    <script type="text/javascript">

        // Wait for the page to load first
        window.onload = function() {

          //Get a reference to the link on the page
          // with an id of "mylink"
          var a = document.getElementById("search_link");

          //Set code to run when the link is clicked
          // by assigning a function to "onclick"
          a.onclick = function() {

    var searchSTRING = document.getElementById("search_input").value;
    searchSTRING = searchSTRING.replace(/(\r\n|\n|\r)/gm,"");
    var url = ('{$homeLink}&search='+searchSTRING);
   window.location = url;
            return false;
          }
        }

    </script>