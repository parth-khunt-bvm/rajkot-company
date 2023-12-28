        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body">
                <div class="asset-allocation-list-div">
                <!--begin: Datatable-->
                    <table class="table table-bordered table-checkable" id="asset-allocation-list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Asset Type</th>
                                <th>Brand</th>
                                <th>Supplier</th>
                                <th>Asset Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 0;
                            @endphp
                            @foreach ( $asset_allocation_details as $asset_allocation_detail )
                            @php
                            $i++;
                            @endphp
                                    <tr>
                                        <td>{{ $i }} </td>
                                        <td>{{ $asset_allocation_detail->asset_type  }} </td>
                                        <td>{{ $asset_allocation_detail->brand_name  }} </td>
                                        <td>{{ $asset_allocation_detail->suppiler_name . ' - ' . $asset_allocation_detail->supplier_shop_name  }} </td>
                                        <td>{{ $asset_allocation_detail->asset_code  }} </td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
        </div>
        <!--end::Card-->

