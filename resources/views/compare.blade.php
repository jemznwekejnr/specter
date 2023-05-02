@include("layouts.app-title")
@include("layouts.app-header")
@include("layouts.app-sidebar")
<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Compare Entities</a></li>
                </ol>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 wid-100">
                        <div class="row">
                            <!--Start-->
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Compare Two Entities (Person or Organization)</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="basic-form">
                                            <form action="submitcompare" method="post" id="submitcompare">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-xl-4">
                                                        <div class="mb-3">
                                                            <input type="text" name="entity1" required class="form-control input-rounded" placeholder="Frist Entity (Name or Organization)">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="mb-3">
                                                            <input type="text"  name="entity2" required class="form-control input-rounded" placeholder="Second Entity (Name or Organization)">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2">
                                                        <div class="mb-3">
                                                            <input type="date" class="form-control input-rounded" name="startdate" id="startdate">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2">
                                                        <div class="mb-3">
                                                            <input type="date" class="form-control input-rounded" readonly name="enddate" id="enddate">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="mb-6">
                                                <button type="submit" id="button" class="btn btn-primary btn-sm btn-rounded">Compare</button>
                                                <img src="{{ asset('assets/images/processing.gif') }}" width="50px;" id="processing" class="processing" style="display: none;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End-->
                           <div id="compare">
                               
                           </div>
@include("layouts.app-footer")
@include("process.dashboard")