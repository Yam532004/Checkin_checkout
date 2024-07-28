<input type="hidden" id="user_id" value="{{Auth::user()->id}}">
<div class="col-md-3">
    <div class="card card-primary card-outline h-100">
        <div class="card-body box-profile">
            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="https://fr.web.img6.acsta.net/pictures/15/06/10/14/56/066018.jpg" alt="User profile picture">
            </div>
            <h3 class="profile-username text-center" id="user-name-avt"></h3>
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Absent</b> <a class="float-right" id="absent_total"></a>
                </li>
                <li class="list-group-item">
                    <b>Checkin late</b> <a class="float-right" id="checkin_late_total"></a>
                </li>
                <li class="list-group-item">
                    <b>Checkout early</b> <a class="float-right" id="checkout_early_total"></a>
                </li>
            </ul>
            <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
        </div>
    </div>
</div>
