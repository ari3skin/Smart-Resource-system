<main class="tabcontent" id="registration-request">
    <div class="head-title">
        <div class="left">
            <h1>Registration Requests</h1>

            <ul class="breadcrumb">
                <li>
                    <a href="#">{{session('first_name')}} {{session('last_name')}}'s</a>
                </li>
                <li><i class="uil uil-angle-right-b"></i></li>
                <li>
                    <a class="active" href="#">Sent Registration Requests</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">

        <div class="order">
            <table>
                <thead>
                <tr>
                    <th>Employer Id</th>
                    <th>Employee Id</th>
                    <th>Work Email</th>
                    <th>Request Date Sent</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($registration_requests as $item)
                    <tr>
                        <td>
                            <p>{{$item->employer_id}}</p>
                        </td>
                        <td>
                            <p>{{$item->employee_id}}</p>
                        </td>
                        <td>{{$item->work_email}}</td>
                        <td>{{$item->request_date}}</td>
                        <td>
                            <span class="status {{$item->status}}">
                                {{$item->status}}
                            </span>
                        </td>
                        <td>
                            <form action="#" method="post">
                                @csrf
                                <input type="hidden" name="MID" value="{{$item->id}}">
                                <input type="hidden" name="status" value="sent">
                                <button type="submit">
                                    <i class="uil uil-envelope-check" style="cursor: pointer"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>
