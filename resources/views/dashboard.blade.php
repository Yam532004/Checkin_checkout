@extends ('adminLayout')
@section('title', 'STATISTICAL')

@section('content')

<div class="container mt-5">

    <div class="row mb-3" id="form-datepicker-dashboard">
        <div class="input-group" style="width:fit-content; ">
            <input data-date-format="dd/mm/yyyy" id="datepicker-dashboard" class="form-control" disabled />
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa-solid fa-calendar-days align-content-center fs-4"></i></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Members</span>
                    <span class="number_account"></span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fa-solid fa-square-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">On time</span>
                    <span class="info-box-number">760</span>
                </div>

            </div>

        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Not yet</span>
                    <span class="info-box-number">
                        10
                        <small>%</small>
                    </span>
                </div>

            </div>

        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Late</span>
                    <span class="info-box-number">41,410</span>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#datepicker-dashboard').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
    })
    $('#datepicker-dashboard').datepicker("setDate", new Date());

    // statistical

    $.ajax({
        url: '/admin/users',
        method: 'GET',
        success: function(response) {
            console.log("res"+response.length);
            $('.number_account').text(response.length);
        }
    })
})

</script>
@endsection