@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		
		<div class="card">
					<div class="card-body" style="padding: 20px;">
						<div class="card-title">
							<h4 class="mb-0"><b>All Projects</b></h4>
						</div>
						<hr/>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Date</th>
										<th>Title</th>
										<th>Client</th>
										<th>Amount (&#8358;)</th>
										<th>Budget (&#8358;)</th>
										<th>Start Date</th>
										<th>Due Date</th>
										<th>Created By</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									@foreach($projects as $project)
									<tr>
										<td>{{ $project->created_at }}</td>
										<td><a href="{{ url('projectdetails?pj='.$project->id) }}"> {{ $project->title }} @if(!empty($project->attachment)) <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"><path fill="currentColor" d="M0 4.5V0h1v4.5a1.5 1.5 0 1 0 3 0v-3a.5.5 0 0 0-1 0V5H2V1.5a1.5 1.5 0 1 1 3 0v3a2.5 2.5 0 0 1-5 0Z"/><path fill="currentColor" fill-rule="evenodd" d="M12.5 0H6v4.5A3.5 3.5 0 0 1 2.5 8H1v5.5A1.5 1.5 0 0 0 2.5 15h10a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 0ZM11 4H7v1h4V4Zm0 3H7v1h4V7Zm-7 3h7v1H4v-1Z" clip-rule="evenodd"/></svg> @endif</a></td>
										<td>{{ $project->client }}</td>
										<td>{{ number_format($project->amount, 2) }}</td>
										<td>{{ number_format($project->budget, 2) }}</td>
										<td>{{ $project->startdate }}</td>
										<td>{{ $project->enddate }}</td>
										<td>{{ app\Http\Controllers\Controller::staffname($project->created_by) }}</td>
										<td>{{ number_format(app\Http\Controllers\Controller::projectprogress($project->id)) }}%</td>
										
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