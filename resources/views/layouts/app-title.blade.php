<!doctype html>
<html lang="en" class="semi-dark">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{ asset('assets/images/RELIA-ENERGY-Logo-2020 (1).png') }}" type="image/png" />
	<!--plugins-->
	<link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
	<link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('assets/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
	<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet'>

	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<title>Relia Energy ERP</title>

	<style>

		.required{

			color: #ff0000;
		}

		body{
			font-family: Garamond !important;
		}

		/* PV table definition */
		.tdsn{
			width: 5%;
		}
		.tdds{
			width: 20%;
		}
		.tdqt{
			width: 5%;
		}
		.tdpr{
			width: 10%;
		}
		.tdam{
			width: 10%;
		}
		.tdva{
			width: 5%;
		}
		.tdvt{
			width: 10%;
		}
		.tdgr{
			width: 10%;
		}
		.tdwh{
			width: 5%;
		}
		.tdwt{
			width: 10%;
		}
		.tdnt{
			width: 10%;
		}

		.vouchericon:hover{
			cursor: pointer;
		}

		.totalsum{
			font-weight: bold;
		}


		/*# sourceMappingURL=bootstrap-select.css.map */

		.btn-file {
		  position: relative;
		  overflow: hidden;
		  vertical-align: middle;
		}

		.btn-file>input {
		  position: absolute;
		  top: 0;
		  right: 0;
		  width: 100%;
		  height: 100%;
		  margin: 0;
		  font-size: 23px;
		  cursor: pointer;
		  filter: alpha(opacity=0);
		  opacity: 0;
		  direction: ltr;
		}

		.fileinput {
		  display: inline-block;
		  margin-bottom: 9px;
		}

		.fileinput .form-control {
		  display: inline-block;
		  padding-top: 7px;
		  padding-bottom: 5px;
		  margin-bottom: 0;
		  vertical-align: middle;
		  cursor: text;
		}

		.fileinput .thumbnail {
		  display: inline-block;
		  margin-bottom: 10px;
		  overflow: hidden;
		  text-align: center;
		  vertical-align: middle;
		  max-width: 250px;
		  box-shadow: 0 1px 15px 1px rgba(39, 39, 39, 0.1);
		}

		.fileinput .thumbnail.img-circle {
		  border-radius: 50%;
		  max-width: 100px;
		}

		.fileinput .thumbnail>img {
		  max-height: 100%;
		}

		.fileinput .btn {
		  vertical-align: middle;
		}

		.fileinput-exists .fileinput-new,
		.fileinput-new .fileinput-exists {
		  display: none;
		}

		.fileinput-inline .fileinput-controls {
		  display: inline;
		}

		.fileinput-filename {
		  display: inline-block;
		  overflow: hidden;
		  vertical-align: middle;
		}

		.form-control .fileinput-filename {
		  vertical-align: bottom;
		}

		.fileinput.input-group>* {
		  position: relative;
		  z-index: 2;
		}

		.fileinput.input-group>.btn-file {
		  z-index: 1;
		}

		.fileinput-new.input-group .btn-file,
		.fileinput-new .input-group .btn-file {
		  border-radius: 0 4px 4px 0;
		}

		.fileinput-new.input-group .btn-file.btn-xs,
		.fileinput-new .input-group .btn-file.btn-xs,
		.fileinput-new.input-group .btn-file.btn-sm,
		.fileinput-new .input-group .btn-file.btn-sm {
		  border-radius: 0 3px 3px 0;
		}

		.fileinput-new.input-group .btn-file.btn-lg,
		.fileinput-new .input-group .btn-file.btn-lg {
		  border-radius: 0 6px 6px 0;
		}

		.form-group.has-warning .fileinput .fileinput-preview {
		  color: #FFB236;
		}

		.form-group.has-warning .fileinput .thumbnail {
		  border-color: #FFB236;
		}

		.form-group.has-error .fileinput .fileinput-preview {
		  color: #FF3636;
		}

		.form-group.has-error .fileinput .thumbnail {
		  border-color: #FF3636;
		}

		.form-group.has-success .fileinput .fileinput-preview {
		  color: #18ce0f;
		}

		.form-group.has-success .fileinput .thumbnail {
		  border-color: #18ce0f;
		}

		.input-group-addon:not(:first-child) {
		  border-left: 0;
		}

		.thumbnail {
		  border: 0 none;
		  border-radius: 3px;
		  padding: 0;
		}

		.card .image {
		  overflow: hidden;
		  height: 200px;
		  position: relative;
		}

		.card .avatar {
		  width: 250px;
		  height: 250px;
		  overflow: hidden;
		  border-radius: 50%;
		  margin-bottom: 15px;
		}
		.card-user .image {
		  height: 120px;
		}

		
	</style>
</head>