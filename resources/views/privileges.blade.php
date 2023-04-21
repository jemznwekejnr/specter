@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<div class="page-wrapper">
<div class="page-content">
        <div class="card">
          <div class="col-12 col-lg-12">
            <div class=" radius-10">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-5">
                    <h4 class="card-title">Manage Role Privileges</h4>
                  </div> 
                </div>
              </div>
              <hr />
            


              <div class="card-body">
                <div class="row">
                <div class="col-md-3">
                  <div class="card ">
                    <div class="card-header ">
                      
                          <h4 class="card-title">Existing Roles</h4>
                      
                    </div>
                    <div class="card-body ">
                    <form id="submitprivileges" action="{{ url('submitprivileges') }}" method="post">
                    @csrf

                    @isset($setrole)
                    @isset($roles)
                    @foreach($roles as $role)
                    <div class="form-check form-check-radio form-group">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" name="role" id="role{{ $role->id }}" value="{{ $role->id }}" @if($role->id == $setrole) checked @endif>
                          <span class="form-check-sign"></span>
                          {{ $role->role }}
                        </label>
                      </div>
                      @endforeach
                      @endisset
                    @else
                    @isset($roles)
                    @foreach($roles as $role)
                    <div class="form-check form-check-radio form-group">
                        <label class="form-check-label">
                          <input class="form-check-input" type="radio" name="role" id="role{{ $role->id }}" value="{{ $role->id }}">
                          <span class="form-check-sign"></span>
                          {{ $role->role }}
                        </label>
                      </div>
                      @endforeach
                      @endisset
                      @endisset
                    </div>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="card " style="padding: 20px;">
                    <div class="card-header ">
                      <div class="row">
                        <div class="col-md-4">
                          <h4 class="card-title">Role Privileges</h4>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4 text-right float-right" style="padding: 10px;">
                          <div class="form-check float-right">
                                  <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="checkall" id="checkall">
                                    <span class="form-check-sign"></span>
                                    Check All
                                  </label>
                                </div>
                        </div> 
                      </div>
                    </div>
                    <div class="card-body ">
                        @isset($setactions) 
                        @isset($processes)

                        @php 
                        $proprocess = array();
                        $proactions = array(); 
                        @endphp

                        @foreach($setactions as $setaction)
                        @php 
                        array_push($proprocess, $setaction->privilege); 
                        array_push($proactions, $setaction->action);
                        @endphp
                        @endforeach

                        
                        

                        @foreach($processes as $process)
                        <h5><b>{{ $process->process }}</b></h5>
                        
                        @php $actions = explode(",", $process->actions) @endphp
                        @php $total = count($actions) @endphp
                        <div class="row">
                        
                        @for($a=0; $a<$total; $a++)
                          <div class="col-md-2 form-group">
                            <div class="form-check">
                            <label class="form-check-label">
                              
                              <input class="form-check-input" type="checkbox" name="actions[]" id="" value="{{ $process->id }}|{{ $actions[$a] }}" @if( app\Http\Controllers\Controller::checkprocess($setrole, $process->id, $actions[$a]) == "found") checked @endif  >
                              <span class="form-check-sign"></span>
                              <small style="font-weight: normal;">@php echo app\Http\Controllers\Controller::getaction($actions[$a]) @endphp</small>
                            </label>
                          </div>
                        </div>
                      @endfor
                      </div>
                      
                      @endforeach
                      @endisset
                      

                      @else
                      @isset($processes)
                      @foreach($processes as $process)
                      <h5><b>{{ $process->process }}</b></h5>
                      
                      @php $actions = explode(",", $process->actions) @endphp
                      @php $total = count($actions) @endphp
                      <div class="row">

                      	@php $x=1 @endphp
                        @for($a=0; $a<$total; $a++)
                        <div class="col-md-2 form-group">
                          <div class="form-check">
                          <label class="form-check-label" style="font-style:normal;">
                            
                            <input class="form-check-input" type="checkbox" name="actions[]" id="" value="{{ $process->id }}|{{ $actions[$a] }}">
                            <small style="font-weight: normal;">@php echo app\Http\Controllers\Controller::getaction($actions[$a]) @endphp</small>
                          </label>
                        </div>
                      </div>
                      @php $x++ @endphp
                    @endfor
                    	
                    </div>
                    @endforeach
                    @endisset
                    @endisset
                      
                    <div id="message" class="alert"></div>
                    
                    <div class="col-md-4">
                    <input type="submit" id="button" class="btn btn-round btn-primary btn-lg" value="Update Previleges">
                    <img src="{{ asset('assets/images/processing.gif') }}" width="50px;" id="processing" class="processing" style="display: none;">
                    </div>
                    





                    </div>
                  </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@include("layouts.app-footer")
@include("process.access-control")