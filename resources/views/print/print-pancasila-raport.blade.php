<!DOCTYPE html>
< lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
    <style>
		.page-break {
			page-break-after: always;
		}
		.heading_progress_title,
		.heading_progress_title_cover {
			text-align: center;
			margin-top: 0;
		}
		.heading_progress_title {
			background-color: #FCD5B4;
		}


		/* BASIC TEXT */
		.logoB {
			color: red;
			font-weight: 700;
			margin-left: 0px!important;
		}
		.logoA {
			color: #00B050;
			font-weight: 700;
		}
		.logoS {
			color: #0070C0;
			font-weight: 700;
		}
		.logoI {
			color: yellow;
			font-weight: 700;
		}
		.logoC{
			color: #7030A0;
			font-weight: 700;
		}

		.logoB,
		.logoA,
		.logoS,
		.logoI,
		.logoC {
			display: inline-block;
			margin-left: -4px;
			line-height: 0;
		}

		/* BASIC TEXT */

		/* STUDENT DETAILS */
		table tr td {
			padding: 5px
		}
		/* STUDENT DETAILS */

		/* GRADE  SECTION */
		#grade table td,
		.grade table td,
		#grade table th,
		.grade table th,
		#extracurricular table td,
		#extracurricular table th,
		#absence table td,
		#absence table th,
		.border
		{
			border: 1px solid black;
			text-align: center;
			padding: 0;
			color: black;
			span-size: 10.0pt;
			span-weight: 400;
			span-style: normal;
			text-decoration: none;
		}

		#grade table,
		.grade table,
		#extracurricular table,
		#absence table,
		.border
		{
			border: 1px solid black;
			margin-top: 10px;
			table-layout: fixed;
		}
		/* GRADESECTION */

		
        /* TUTWURI LOGO */
        #tutwuri_logo, 
        #student_name {
            margin: 0 auto;
            display: block;
            text-align: center;
        }
        /* TUTWURI LOGO */

		/* Global class */
		table {
			width: 100%;
			/* border: 1px solid black; */
			border-collapse: collapse;
			
		}
		@page {
            margin: 21px 0;
            size: 215mm 330mm;
        }
		body { 
			margin: 0 21px 21px ; 
			-webkit-print-color-adjust:exact !important;
  			print-color-adjust:exact !important;
			size: 215mm 330mm;
		}
		img {
            width: 200px;
            height: 200px;
            margin: 50px auto!important;
        }
        p {
            margin: 10px auto!important;
        }
		@media print {
			#fase {
				border: none
			}
            footer {
                position: absolute;
                bottom: -30px;
                left: 0;
				right: 0;
                /* width: 100%; */
                text-align: center;
                /* padding: 10px; */
            }
            body {
                size: 215mm 330mm;
            }
		}
		table#details_ {
			border-collapse:separate; 
  			border-spacing: 0 .5em;
		}

		table#details_peserta_didik tr td {
			padding: 2px 5px
		}

		#fase {
			border: none
		}
		footer {
			position: absolute;
			bottom: -30px;
			left: 0;
			right: 0;
			/* width: 100%; */
			text-align: center;
			/* padding: 10px; */
		}

		/* Global class */
	</style>
</head>
<body>
    @php 
		$getSchoolSetting = App\Models\SchoolSetting::first();
	@endphp
	<h1 class="heading_progress_title">Laporan Proyek Penguatan Profil Pelajar Pancasila</h1>
	<section id="student_details">
		<div style="float: left; width: 70%;">
			<table>
				<tr>
					<td style="width: 100px">Nama Sekolah</td>
					<td style="width: 5px">:</td>
					<td>{{$getSchoolSetting->school_name_prefix}}
						<span class="logoB">B</span>
						<span class="logoA">A</span>
						<span class="logoS">S</span>
						<span class="logoI">I</span>
						<span class="logoC">C</span>
						<span class="font511880">{{$getSchoolSetting->school_name_suffix}}</span>
					</td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td style="width: 5px">:</td>
					<td>{{$getSchoolSetting->school_address}}</td>
				</tr>
				<tr>
					<td>Nama Peserta Didik</td>
					<td style="width: 5px">:</td>
					<td><strong>{{Str::title($student->student_name)}}</strong></td>
				</tr>
				<tr>
					<td>NIS/NISN</td>
					<td style="width: 5px">:</td>
					<td>{{$student->student_nis}}/{{$student->student_nisn}}</td>
				</tr>
			</table>
		</div>
		<div style="float: right; width: 30%;">
			<table>
				<tr>
					<td>Kelas</td>
					<td>:</td>
					<td>{{Helper::numberToRomawi($student->active_classroom_level)}} {{$student->active_classroom_name}}</td>
				</tr>
				<tr>
					<td>Fase</td>
					<td>:</td>
					<td>{{auth()->user()->activeHomeroom->first()->classroom->fase}}</td>
				</tr>
				<tr>
					<td>Tahun Pelajaran</td>
					<td>:</td>
					<td>{{Helper::getSchoolYearName(request('school_year_id'))}}</td>
				</tr>
			>
		</div>
	</section>
	<div style="clear: both;"></div>
	@foreach ($PancasilaRaportProject->where('pancasila_raport_group_id',1) as $tema)
		@if ($loop->first)
			<h3 style="margin: 10px 0 10px">A. Identitas Proyek</h3>
		@endif
		@if (!$loop->first)
			<div style="margin-top:30px"></div>
		@endif
		<div>
			<table>
				<tr>
					<td style="width: 100px">Tema Proyek {{$loop->iteration}}</td>
					<td style="width: 5px">:</td>
					<td>{{$tema->title}}</td>
				</tr>
				@if ($tema->children->count())
					@foreach ($tema->children as $subTema)
						<tr>
							<td>Sub Tema</td>
							<td style="width: 5px">:</td>
							<td>
								{{$subTema->title}}
							</td>
						</tr>
					@endforeach
				@endif
			</table>
		</div>
		<p>Proyek ini diharapkan dapat membangun dimensi pelajar pancasila yaitu:</p>
		@if ($tema->children->count())
			@foreach ($tema->children as $subTema)
				<ol>
				@foreach ($subTema->children as $dimention)
					<li>{{$dimention->title}}</li>
				@endforeach
				</ol>
			@endforeach
		@endif

		@if ($loop->first)
			<section id="grade" style="margin-top:10px;">
			<h3 style="margin: 10px 0 10px">B. Keterangan Nilai</h3>
				<table>
					<thead>
						<tr>
							@foreach ($pancasilaRaportValueDescription as $data)
								<th style="width:{{count(str_split($data->short_name))}}0%">{{$data->short_name}} <br> {{$data->title}}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						<tr style="text-align:left">
							@foreach ($pancasilaRaportValueDescription as $data)
								<td>{{$data->description}}</td>
							@endforeach
						</tr>
					</tbody>
				</table>
			</section>
		@endif

		<div id="grade" style="margin-top:20px">
			<table>
				<thead>
					<tr>
						<th style="width: 60%;text-align:left;padding-left:2px">Elemen Profil Pelajar Pancasila</th>
						@foreach ($pancasilaRaportValueDescription as $data)
							<th>{{$data->short_name}}</th>
						@endforeach
					</tr>
				</thead>
				<tbody>
					@php
						$items = \app\Models\PancasilaRaportProject::where('pancasila_raport_group_id',3)->get();
        			 	$parentIdToCheck = $tema->id;
						$iter = 1;
					@endphp		
					
					@foreach ($items as $subProject)
						@if ($subProject->hasParentId($parentIdToCheck))
							<tr>
								<td style="text-align:left;padding:2px;vertical-align: middle;"
									colspan="{{$pancasilaRaportValueDescription->count()+1}}"
									>{{$iter}}. {{ $subProject->name }}</td>
								@php
									$iter++;
								@endphp
							</tr>
							@if ($subProject->children->count())
								@foreach ($subProject->children as $child)
									@php
									@endphp
									<tr>
										<td style="text-align:left;padding:2px">- {{ $child->name }}</td>
										@foreach ($pancasilaRaportValueDescription as $value)
											<td style="vertical-align: middle;padding:2px">
												<label style="display:block">
													<input type="checkbox" name="" id="" 
													@if ($student->pancasilaRaport()->where('pancasila_raport_project_id',$child->id)->where('prv_description_id',$value->id)->count())
														checked
													@endif>
												</label>
											</td>
										@endforeach
									</tr>
								@endforeach
							@endif
						@endif
					@endforeach
				</tbody>
			</table>
		</div>
	</section>
	@if (!$loop->last)
		<div class="page-break"></div>
	@endif
	@endforeach

	
	<section id="sign" style="margin-top: @if(!empty($getSchoolSetting->meta['margin_top_sign_parent'])) {{$getSchoolSetting->meta['margin_top_sign_parent']}} @else 50px @endif">
		<div id="sign_parent" style="float:left;width:40%;">
			<div class="sign_top" style="margin-bottom: @if(!empty($getSchoolSetting->meta['margin_bottom_sign_parent'])) {{$getSchoolSetting->meta['margin_bottom_sign_parent']}} @else 60px @endif">
				@if(!empty($print_progress_report_date))
					<p>Batam, {!!$print_progress_report_date!!}</p>
				@else
					<p>Batam, {!!$getSchoolSetting->school_progress_report_date!!}</p>
				@endif
				<p>Wali Kelas/Koordinator P5</p>
			</div>

			<div class="border_sign">
				<!-- <p style="visibility:hidden;text-decoration:underline;text-decoration-thickness: 1px;text-decoration-color:black; text-underline-offset: 8px;">parentsignasasasasa</p>
				<hr style='margin-top:-10px;display: block;margin-left: -5px;margin-right:-5px;height:1px;border-width:0;background-color:black'> -->
				<p style="text-decoration:underline;text-decoration-thickness: 1px;text-decoration-color:black; text-underline-offset: 8px;">{{$ttd}}</p>
			</div>
		</div>
		<div id="sign_main_teacher" style="float:right;width:auto;">
			<div class="sign_top" style="margin-bottom: @if(!empty($getSchoolSetting->meta['margin_bottom_sign_homeroom_teacher'])) {{$getSchoolSetting->meta['margin_bottom_sign_homeroom_teacher']}} @else 60px @endif">
				<p>Mengetahui</p>
				<p>
				Kepala 
				{{$getSchoolSetting->school_name_prefix}}
				<span class="logoB">B</span>
				<span class="logoA">A</span>
				<span class="logoS">S</span>
				<span class="logoI">I</span>
				<span class="logoC">C</span>
				<span class="font511880">{{$getSchoolSetting->school_name_suffix}}</span>
				</p>
			</div>

			<div class="border_sign">
				<p style="text-decoration:underline;text-decoration-thickness: 1px;text-decoration-color:black; text-underline-offset: 8px;">{{$getSchoolSetting->school_principal_name}}</p>
				<!-- <hr style="margin-top:-10px;display: block"> -->
			</div>
		</div>
	</section>
	<div style="clear: both;"></div>

	<footer class=""><h2>Vision : To Know God and God is Known</h2></footer>
	
	<!-- <div class="page-break"></div> -->
	<!-- <footer class=""><h2>Vision : To Know God and God is Known</h2></footer> -->
</body>
</html>