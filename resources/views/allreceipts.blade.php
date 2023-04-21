@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		
		<div class="card" style="padding: 20px;">
					<div class="card-body">
						<div class="card-title">
							<h4 class="mb-0"><b>Client Invoices</b></h4>
						</div>
						<hr/>
						<div class="table-responsive">
							<table class="table datatable table-responsive table-striped" id="example">
								<thead>
									<tr>
										<th>Date</th>
										<th>Project</th>
										<th>Client</th>
										<th>Amount (&#8358;)</th>
										<th>Created By</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									@foreach($invoices as $invoice)
									<tr>
										<td>{{ $invoice->created_at }}</td>
										<td><a href="{{ url('receiptdetails?id='.$invoice->id) }}">{{ app\Http\Controllers\Controller::projectname($invoice->project) }} </a></td>
										<td>{{ $invoice->clientinfo }}</td>
										<td>{{ number_format($invoice->sumamounts, 2) }}</td>
										<td>{{ app\Http\Controllers\Controller::staffname($invoice->sentform) }}</td>
										<td>
											<a href="{{ url('receiptdetails?id='.$invoice->id) }}">@if($invoice->status == "Pending")
											<button type="button" class="btn btn-warning btn-sm">{{ $invoice->status }}</button>
											@elseif($invoice->status == "Approved")
											<button type="button" class="btn btn-primary btn-sm">{{ $invoice->status }}</button>
											@elseif($invoice->status == "Paid")
											<button type="button" class="btn btn-success btn-sm">{{ $invoice->status }}</button>
											@elseif($invoice->status == "Rejected")
											<button type="button" class="btn btn-danger btn-sm">{{ $invoice->status }}</button>
											@else
											<button type="button" class="btn btn-info btn-sm">{{ $invoice->status }}</button>
											@endif</a>
											</td>
										
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
	</div>
</div>
<!--end page wrapper -->
@include("layouts.app-footer")