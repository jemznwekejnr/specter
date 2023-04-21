@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		

		<div class="card">
					<div class="card-body">
						<div class="card-title">
							<h4 class="mb-0">All Memos Sent to or Copied {{ Auth::user()->name }}</h4>
						</div>
						<hr/>
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>Date</th>
										<th>Title</th>
										<th>Sender</th>
										<th>CCs</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									@foreach($memos as $memo)
									<tr>
										<td>{{ $memo->created_at }}</td>
										<td>{{ $memo->title }} @if(!empty($memo->attachment)) <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"><path fill="currentColor" d="M0 4.5V0h1v4.5a1.5 1.5 0 1 0 3 0v-3a.5.5 0 0 0-1 0V5H2V1.5a1.5 1.5 0 1 1 3 0v3a2.5 2.5 0 0 1-5 0Z"/><path fill="currentColor" fill-rule="evenodd" d="M12.5 0H6v4.5A3.5 3.5 0 0 1 2.5 8H1v5.5A1.5 1.5 0 0 0 2.5 15h10a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 0ZM11 4H7v1h4V4Zm0 3H7v1h4V7Zm-7 3h7v1H4v-1Z" clip-rule="evenodd"/></svg> @endif</td>
										<td>{{ app\Http\Controllers\Controller::staffname($memo->sentform) }}</td>
										
										<td>
											@if(!empty($memo->copies)) |
											@php $copy = explode(",", $memo->copies) @endphp
											@for($j=0; $j < count($copy); $j++)
											{{ app\Http\Controllers\Controller::staffname($copy[$j]) }} |
											@endfor
											@endif
										</td>
										<td><a href="{{ url('memodetails?id='.$memo->id) }}">@if($memo->status == 'Pending') <button class="btn btn-warning btn-sm">{{ $memo->status }}</button> @elseif($memo->status == 'Approved') <button class="btn btn-success btn-sm">{{ $memo->status }}</button> @elseif($memo->status == 'Rejected') <button class="btn btn-danger btn-sm">{{ $memo->status }}</button> 
										@else <button class="btn btn-primary btn-sm convertuser">{{ $memo->status }}</button> 
										@endif</a></td>
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