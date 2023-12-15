@extends('backend.layout.app')
@section('section')
    <style>
        .user_permission_acc .card-header .checkbox-inline {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 9;
        }

        .accordion.user_permission_acc .card .card-header .card-title {
            padding-left: 40px;
        }
        .form-group label {
            font-size: 1.1rem !important;
            font-weight: 600 !important;
        }
        .checkbox-inline .checkbox:last-child {
            margin-right: 0;
        }

    </style>
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            @csrf
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">{{ $header['title'] }}</h3>
                    </div>
                </div>

                <form class="form" id="user-roles-permissions" method="POST" action="{{ route('admin.user-role.permission',['id' => $user_role_id]) }}">@csrf

                    @php
                        $role_list =  explode(',' , $user_roles[0]['permission']);
                    @endphp

                    <input type="hidden" name="editId" class="form-control" value="{{ $user_role_id }}">
                    <div class="card-body">
                        <!--begin::Accordion-->
                        <div class="accordion accordion-solid accordion-toggle-plus user_permission_acc" id="accordionExample3">

                            @php
                                $i = 0 ;
                            @endphp
                            @foreach (Config::get('constants.permission_master') as $key => $value)

                                <div class="card">

                                    <div class="card-header" id="headingOne{{$i}}">
                                        <div class="checkbox-inline">
                                            <label class="checkbox">
                                                <input type="checkbox"   class="module_master {{$key}}_master" id="{{$key}}_master" data-module-master-class-name="{{$key}}_module_master"/>

                                                <span></span>
                                            </label>
                                        </div>

                                        <div class="card-title {{ $i != 0 ? 'collapsed' : '' }}" data-toggle="collapse" data-target="#collapseOne{{$i}}">
                                            {{ ucfirst($key) }}
                                        </div>
                                    </div>

                                    <div id="collapseOne{{$i}}" class="collapse {{ $i == 0 ? 'show' : '' }} " data-parent="#accordionExample3">
                                        <div class="card-body master-menu-div" data-class="{{$key}}_module_master" data-id="{{$key}}_master">

                                            @foreach ($value as $sm_key => $sm_value)

                                                <div class="form-group " >
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox">
                                                            <input type="checkbox"  id="{{$sm_key}}_module_check_box"   class="{{$key}}_module_master master_check_box" data-master-class="{{$key}}_module_master" data-master-id="{{$key}}_master" data-module-id="{{$sm_key}}_module_check_box" data-module-class="{{$sm_key}}_module" data-sub-menu-class-name="{{$sm_key}}_sub_menu_class" />
                                                            <span></span>{{ ucfirst($sm_key)}}
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 sub-menu-div" data-class="{{$sm_key}}_module" data-id="{{$sm_key}}_module_check_box">
                                                    <div class="row ml-5">
                                                        @foreach ($sm_value as $menu_key => $menu_value)
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <div class="checkbox-inline">
                                                                        <label class="checkbox">
                                                                            <input type="checkbox" {{ in_array($menu_key, $role_list) ? 'checked="checked"':'' }}  class="{{$sm_key}}_module {{$sm_key}}_sub_menu_class sub_menu {{$key}}_module_master"
                                                                            data-module-id="{{$sm_key}}_module_check_box" data-module-class="{{$sm_key}}_module" data-master-class="{{$key}}_module_master" data-master-id="{{$key}}_master" value="{{ $menu_key }}"   name="permission[]"/>
                                                                            <span></span>{{ ucfirst($menu_value) }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $i++;
                                @endphp

                            @endforeach

                        </div>
                        <!--end::Accordion-->

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2 submitbtn">Submit</button>
                        <a href="{{ route('admin.user-role.list') }}" class="btn btn-secondary">Cancel</a>
                    </div>

                </form>

            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
@endsection
