<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">
        @csrf
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                </div>

                <div class="card-toolbar">
                </div>

            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-bordered table-checkable" id="salary-slip">
                    <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>Emp. Name</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Month - Year</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
