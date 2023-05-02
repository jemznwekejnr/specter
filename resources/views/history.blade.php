@include("layouts.app-title")
@include("layouts.app-header")
@include("layouts.app-sidebar")
!--**********************************
   Content body start
***********************************-->
<div class="content-body" style="margin-top: -15px;">
   <!-- row -->	
<div class="page-titles">
	<ol class="breadcrumb">
		<li><h5 class="bc-title">Dashboard</h5></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">
			<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M2.125 6.375L8.5 1.41667L14.875 6.375V14.1667C14.875 14.5424 14.7257 14.9027 14.4601 15.1684C14.1944 15.4341 13.8341 15.5833 13.4583 15.5833H3.54167C3.16594 15.5833 2.80561 15.4341 2.53993 15.1684C2.27426 14.9027 2.125 14.5424 2.125 14.1667V6.375Z" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M6.375 15.5833V8.5H10.625V15.5833" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
			Home </a>
		</li>
		<li class="breadcrumb-item active"><a href="javascript:void(0)">Search History</a></li>
	</ol>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-xl-9 col-sm-9 col-md-9 wid-100">
			<div class="row">
				<!--Start-->
				<div class="col-xl-12 col-lg-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Search History</h4>
						</div>
						<div class="card-body">
							<!--Table-->
							<div class="col-xl-6 active-p">
								<div class="card">
									<div class="card-body p-0">
										<div class="table-responsive active-projects" style="padding: 20px;">
										<div class="tbl-caption">
											
										</div>
										<table id="example" class="table example table-striped">
										<thead>
											<tr>
												<th>Entry Date</th>
												<th>Search Entity</th>
												<th>Start Date</th>
												<th>End Date</th>
											</tr>
										</thead>
										<tbody>
											@isset($historys)
											@foreach($historys as $history)
											<tr>
												<td>{{ $history->created_at }}</td>
												<td>{{ $history->entity }}</td>
												<td>{{ $history->startdate }}</td>
												<td>{{ $history->enddate }}</td>
											</tr>
											@endforeach
											@endisset
										</tbody>
										
									</table>
										</div>
									</div>
								</div>
							</div>
							<!--End of Table-->
						</div>
					</div>
				</div>
				<!--End-->
<!--**********************************
   Content body end
***********************************-->
@include("layouts.app-footer")
<script>
	$(document).ready(function() {
		$('.example').DataTable();
	  });
</script>
@include("process.dashboard")