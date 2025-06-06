<style>
	.collapse a {
		text-indent: 10px;
	}
	.bg-red {
		background-color: #C1444A !important;
	}
	.sidebar-list a {
		display: flex;
		align-items: center;
		padding: 16px;
		margin: 5px 8px;
		background-color: #F1D4D6;
		color: black;
		border: 1px solid #A04444;
		border-radius: 3px;
		text-decoration: none;
		font-weight: 600;
		transition: 0.2s ease;
		text-transform: uppercase;
	}

	.sidebar-list .icon-field {
		width: 30px;
		display: inline-block;
		text-align: center;
		margin-right: 10px;
	}

	.sidebar-list a.active {
		background-color: #5E0E13 !important;
		color: white !important;
	}

	.sidebar-list a:hover {
		background-color: #C1444A;
		color: white;
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-red'>
	<div class="sidebar-list mt-3">
		<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home text-danger"></i></span> Home</a>
		<a href="index.php?page=donors" class="nav-item nav-donors"><span class='icon-field'><i class="fa fa-user-friends text-danger"></i></span> Donors</a>
		<a href="index.php?page=donations" class="nav-item nav-donations"><span class='icon-field'><i class="fa fa-tint text-danger"></i></span> Blood Donations</a>
		<a href="index.php?page=requests" class="nav-item nav-requests"><span class='icon-field'><i class="fa fa-th-list text-danger"></i></span> Requests</a>
		<a href="index.php?page=handedovers" class="nav-item nav-handedovers"><span class='icon-field'><i class="fa fa-toolbox text-danger"></i></span> Handed Over</a>
		<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users text-danger"></i></span> Users</a>
	</div>
</nav>

<script>
	$('.nav_collapse').click(function() {
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>