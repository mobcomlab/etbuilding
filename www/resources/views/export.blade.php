@extends('app')

@section('content')
<div class="container">
	<div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
            <div class="panel panel-default">
                <div class="panel-body panel-base">
                    <div id="baseHead">
                        <img id="base" src="{{ asset('images/export-blue.png') }}">
                        <b>Export</b>
                    </div>
                    <hr>
                    <p>Choose a date range to export:</p>
                    <form action="{{ route('download') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="download">
                            <?php
                            $errorFormat = '<div class="alert alert-danger">:message</div>';
                            ?>
                            {!! $errors->first('startDate', $errorFormat) !!}
                            {!! $errors->first('endDate', $errorFormat) !!}

                            <label class="checkbox">
                                <div class="form-inline">
                                    <input type="radio" name="download" checked="checked" value="excel">
                                    Excel (Humidity + Temperature + Power) - maximum period 20 days<br>
                                    <div class="form-group date-select">
                                        <div class="input-daterange input-group" id="datepicker" data-provide="datepicker" data-date-end-date="0d">
                                            <input type="text" class="form-control" name="startDate" placeholder="Earliest date" value="{{ Carbon::today()->subDays(20)->format('d/m/Y') }}"/>
                                            <span class="input-group-addon">to</span>
                                            <input type="text" class="form-control" name="endDate" placeholder="Latest date" value="{{ Carbon::today()->format('d/m/Y') }}"/>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            <label class="checkbox">
                                <input type="radio" name="download" value="csv_humidity">
                                CSV (Humidity)
                            </label>
                            <label class="checkbox">
                                <input type="radio" name="download" value="csv_temperature">
                                CSV (Temperature)
                            </label>
                            <label class="checkbox">
                                <input type="radio" name="download" value="csv_power">
                                CSV (Power)
                            </label>
                        </div>

                        <button type="submit" class="btn btn-base">Download</button>

                    </form>
				</div>
			</div>

		</div>
	</div>
</div>

@endsection

@section('body-close')
    <script>
        $(document).ready(function() {
        };
    </script>
@endsection
