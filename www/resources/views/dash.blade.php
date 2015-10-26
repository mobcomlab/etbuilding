@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-2">
			<div class="panel panel-default">
				<div class="panel-heading text-center">Temperature</div>
				<div class="panel-body text-center">
					<div id="tempNow" class="lead">-°C</div>
					<hr>
					<div class="">Outside <span id="extTempNow">-°C</span></div>
					<hr>
					<div class="small">Updated <span id="tempNowUpdated">-</span></div>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="panel panel-default">
				<div class="panel-heading text-center">Humidity</div>
				<div class="panel-body text-center">
					<div id="humidNow" class="lead">-%</div>
					<hr>
					<div class="">Outside <span id="extHumidNow">-%</span></div>
					<hr>
					<div class="small">Updated <span id="humidNowUpdated">-</span></div>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="panel panel-default">
				<div class="panel-heading text-center">Power</div>
				<div class="panel-body text-center">
					<div id="powerNow" class="lead">-kW</div>
					<hr>
					<div class="">Today's avg <span id="powerDayAverage">-kW</span></div>
					<hr>
					<div class="small">Updated <span id="powerNowUpdated">-</span></div>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="panel panel-default">
				<div class="panel-heading text-center">Energy consumption</div>
				<div class="panel-body text-center">
					<div class="small">Today's usage</div>
					<div class="lead" id="powerDayHoursUsed"></div>
					<hr>
					<div class="small">Total energy</div>
					<div class="lead" id="powerDayEnergy">-kWh</div>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="panel panel-default">
				<div class="panel-heading text-center">CO<sub>2</sub> emissions</div>
				<div class="panel-body text-center">
					<div id="emissions" class="lead">-kg/h</div>
					<hr>
					<div id="emissionsPerPerson">-kg/h</div>
					<div>per person</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading text-center">Last 24 hours</div>
				<div class="panel-body">
					<div id="chart_temperature_div" style="width: 100%; height: 280px;"></div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading text-center">Last 24 hours</div>
				<div class="panel-body">
					<div id="chart_humidity_div" style="width: 100%; height: 280px;"></div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading text-center">Last 24 hours</div>
				<div class="panel-body">
					<div id="chart_power_div" style="width: 100%; height: 280px;"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6"></div>

	</div>
	<div class="row">

	</div>

</div>
@endsection

@section('body-close')
	<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['corechart']}]}"></script>
	<script>
        $(document).ready(function() {
            startUpdates();
        });
    </script>
@endsection
