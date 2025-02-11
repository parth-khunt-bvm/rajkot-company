@extends('backend.layout.app')
@section('section')

@php
    // $image = url("upload/userprofile/default.jpg");

@endphp
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="row mb-7 px-4" style="gap: 5px;">
                <div class="px-6 py-8 tiles-bg-color rounded-lg" style="background: linear-gradient(to bottom, #7a96fe, #3632F2);">
                    <span class="svg-icon svg-icon-3x svg-icon-light my-2">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path
                                    d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                    fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                <path
                                    d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                    fill="#000000" fill-rule="nonzero" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <a href="{{ route('admin.attendance.day-list', ['date' => $date]) }}"
                        class="text-primary font-weight-bold font-size-h6 mt-2">Employee
                        {{ $employee['employee']->employee_count ?? 0 }}</a>
                </div>

                <div class="px-6 py-8 tiles-bg-color rounded-lg"  style="background: linear-gradient(to bottom, #7a96fe, #3632F2);">
                    <span class="svg-icon svg-icon-3x svg-icon-light my-2">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                        <svg width="98" height="99" viewBox="0 0 98 99" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0 98.9972C0.113013 92.2192 -0.14609 85.488 0.421731 78.8286C1.39199 67.428 10.309 57.1218 21.3594 54.1256C23.9863 53.4145 26.7537 53.1113 29.4798 52.8907C32.0681 52.6813 33.5813 54.6769 32.9611 57.188C31.0151 65.0548 29.0388 72.9161 27.101 80.7856C27.0156 81.1274 27.0431 81.6676 27.2554 81.8826C30.2543 84.9588 33.2947 87.9964 36.3708 91.0891C36.6602 90.8327 36.8945 90.648 37.104 90.4358C39.8549 87.6904 42.592 84.9285 45.3622 82.2024C45.8391 81.7338 45.9493 81.3369 45.7812 80.6726C43.7911 72.8168 41.834 64.9528 39.8908 57.086C39.3147 54.7541 40.8059 52.8384 43.1929 52.8604C44.4967 52.8742 45.8115 52.9376 47.1015 53.125C60.4563 55.06 70.6716 65.3139 72.4991 78.6191C72.6865 79.978 72.7499 81.3617 72.7554 82.7344C72.783 88.1314 72.7664 93.5285 72.7664 98.9999C48.5569 98.9972 24.397 98.9972 0 98.9972Z"
                                fill="white" />
                            <path
                                d="M36.5224 6.61892C47.4157 6.64373 56.2969 15.6048 56.2555 26.5312C56.2142 37.419 47.2476 46.2754 36.3074 46.234C25.4747 46.1927 16.6046 37.2371 16.6266 26.3686C16.6459 15.4697 25.5877 6.59411 36.5224 6.61892Z"
                                fill="white" />
                            <path
                                d="M89.5769 9.69231C89.5769 11.2564 89.218 12.6923 88.5 14C87.7821 15.2821 86.6795 16.3205 85.1923 17.1154C83.7051 17.9103 81.859 18.3077 79.6539 18.3077H75.5769V28H69V1H79.6539C81.8077 1 83.6282 1.37179 85.1154 2.11538C86.6026 2.85897 87.718 3.88461 88.4615 5.19231C89.2051 6.5 89.5769 8 89.5769 9.69231ZM79.1538 13.0769C80.4103 13.0769 81.3462 12.7821 81.9615 12.1923C82.5769 11.6026 82.8846 10.7692 82.8846 9.69231C82.8846 8.61539 82.5769 7.78205 81.9615 7.19231C81.3462 6.60256 80.4103 6.30769 79.1538 6.30769H75.5769V13.0769H79.1538Z"
                                fill="white" />
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <a href="{{ route('admin.attendance.day-list', ['date' => $date]) }}"
                        class="text-primary font-weight-bold font-size-h6 mt-2">Present
                        {{ $employee['attendance']->present ?? 0 }}</a>
                </div>

                <div class="px-6 py-8 tiles-bg-color rounded-lg"  style="background: linear-gradient(to bottom, #7a96fe, #3632F2);">
                    <span class="svg-icon svg-icon-3x svg-icon-light my-2">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
                        <svg width="97" height="100" viewBox="0 0 97 100" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_3_92)">
                                <path
                                    d="M58.2048 49.9484C58.2048 61.6106 58.2443 73.2759 58.1897 84.9381C58.1593 91.2791 55.2969 95.9628 49.5143 98.6856C46.3514 100.176 43.0063 100.379 39.6521 99.3838C29.8658 96.4789 20.0795 93.583 10.3205 90.5871C4.05537 88.6626 0.0576731 83.2989 0.0394604 76.7332C-0.0151778 58.8969 -0.0151778 41.0636 0.0394604 23.2273C0.0576731 16.5493 4.09786 11.2403 10.5118 9.28849C20.0947 6.36838 29.6867 3.47863 39.3 0.652621C49.0135 -2.20374 58.1593 4.66853 58.1957 14.8494C58.2382 26.5481 58.2048 38.2498 58.2048 49.9484ZM38.7658 49.9636C38.7658 47.256 36.6501 45.1433 33.9424 45.1433C31.2348 45.1433 29.1191 47.259 29.1191 49.9636C29.1191 52.6682 31.2379 54.7839 33.9424 54.7839C36.6531 54.7839 38.7688 52.6712 38.7658 49.9636Z"
                                    fill="white" />
                                <path
                                    d="M80.3819 45.1372C79.708 44.4269 79.2223 43.9564 78.7852 43.4465C77.0975 41.4795 77.1977 38.6626 78.9977 36.8565C80.7734 35.0747 83.645 34.8136 85.4784 36.562C88.5412 39.4821 91.434 42.5783 94.3875 45.5895C93.917 45.4559 93.3918 45.3102 92.8697 45.1615C92.8424 45.2313 92.8151 45.3011 92.7878 45.3709C93.234 45.5591 93.6832 45.7504 94.1325 45.9355C97.0404 47.1315 97.8964 50.3885 95.9659 52.914C95.805 53.1235 95.629 53.3238 95.4408 53.512C92.2839 56.675 89.1331 59.844 85.958 62.9887C84.592 64.3425 82.9499 64.8585 81.0648 64.2909C79.2405 63.7415 78.1113 62.4909 77.6985 60.6453C77.3434 59.0608 77.7744 57.6463 78.8368 56.4291C79.2557 55.9495 79.7141 55.5033 80.394 54.793C79.7475 54.793 79.368 54.793 78.9856 54.793C75.1973 54.7869 71.4091 54.8294 67.6238 54.7596C65.2471 54.7171 63.3196 52.8321 63.0616 50.4917C62.8066 48.1544 64.294 45.9203 66.5827 45.3163C67.2292 45.1463 67.9304 45.1433 68.6073 45.1402C72.4229 45.1281 76.2415 45.1372 80.3819 45.1372Z"
                                    fill="white" />
                                <path
                                    d="M75.4948 93.5982C73.0725 93.5982 70.6502 93.6073 68.2249 93.5982C65.2137 93.5861 63.0403 91.5493 63.0373 88.7597C63.0342 85.9701 65.1955 83.9091 68.2127 83.8939C72.7568 83.8696 77.2978 83.8908 81.8419 83.8848C85.3843 83.8787 87.2845 81.9603 87.2966 78.3967C87.3027 76.9579 87.2663 75.5191 87.3118 74.0833C87.3968 71.403 89.5186 69.3449 92.1351 69.351C94.7578 69.3571 96.9463 71.4121 96.919 74.1015C96.8887 77.0004 97.0161 79.9872 96.3908 82.7799C94.9672 89.127 89.1452 93.5163 82.6493 93.5922C80.2665 93.6195 77.8806 93.5952 75.4948 93.5982Z"
                                    fill="white" />
                                <path
                                    d="M75.6526 6.52926C78.6759 6.52926 81.7357 6.22875 84.7165 6.58997C91.4856 7.40954 96.6944 13.3681 96.9281 20.1949C96.9919 22.0465 96.9858 23.9042 96.9433 25.7589C96.8826 28.5151 94.7487 30.6065 92.0957 30.5822C89.4275 30.5549 87.3664 28.4665 87.3057 25.6951C87.2723 24.1804 87.3179 22.6657 87.2936 21.1541C87.242 18.0397 85.2629 16.0697 82.1394 16.0545C77.5953 16.0333 73.0543 16.0636 68.5102 16.0363C67.7635 16.0333 66.9834 15.9513 66.2822 15.7237C64.1118 15.0164 62.7702 12.7944 63.0676 10.5664C63.3833 8.22305 65.329 6.4473 67.6997 6.34106C67.7756 6.33803 67.8515 6.33803 67.9274 6.33803C70.5015 6.33803 73.0755 6.33803 75.6496 6.33803C75.6526 6.39874 75.6526 6.46552 75.6526 6.52926Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_3_92">
                                    <rect width="97.001" height="100" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <a href="{{ route('admin.attendance.day-list', ['date' => $date]) }}"
                        class="text-primary font-weight-bold font-size-h6 mt-2">Absent
                        {{ $employee['attendance']->absent ?? 0 }}</a>
                </div>

                <div class="px-6 py-8 tiles-bg-color rounded-lg"  style="background: linear-gradient(to bottom, #7a96fe, #3632F2);">
                    <span class="svg-icon svg-icon-3x svg-icon-light my-2">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                        <svg width="101" height="100" viewBox="0 0 101 100" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_3_110)">
                                <path
                                    d="M100.015 49.9941C100.024 77.597 77.5522 100.048 49.9553 100C22.3673 99.9524 0.00596422 77.5731 1.18679e-06 50.0031C-0.00596184 22.3972 22.4597 -0.044656 50.0596 6.67275e-05C77.6565 0.0447894 100.006 22.4121 100.015 49.9941ZM49.9672 9.71384C34.356 10.489 22.1855 17.0722 14.8151 30.8289C6.88134 45.6351 8.01431 60.3698 17.8742 73.9774C25.6738 84.7377 36.6726 89.8271 49.9672 90.2237C49.9672 63.3334 49.9672 36.6459 49.9672 9.71384Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_3_110">
                                    <rect width="100.015" height="100" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <a href="{{ route('admin.attendance.day-list', ['date' => $date]) }}"
                        class="text-primary font-weight-bold font-size-h6 mt-2">Half Day
                        {{ $employee['attendance']->half_day ?? 0 }}</a>
                </div>
                <div class="px-6 py-8 tiles-bg-color rounded-lg"  style="background: linear-gradient(to bottom, #7a96fe, #3632F2);">
                    <span class="svg-icon svg-icon-3x svg-icon-light my-2">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Urgent-mail.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path
                                    d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                    fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                <path
                                    d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                    fill="#000000" fill-rule="nonzero" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <a href="{{ route('admin.attendance.day-list', ['date' => $date]) }}"
                        class="text-primary font-weight-bold font-size-h6 mt-2">Short Leave
                        {{ $employee['attendance']->short_leave ?? 0 }}</a>
                </div>
                <div class="px-6 py-8 tiles-bg-color rounded-lg"  style="background: linear-gradient(to bottom, #7a96fe, #3632F2);">
                    <span class="svg-icon svg-icon-3x svg-icon-light my-2">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                        <svg width="82" height="100" viewBox="0 0 82 100" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_3_87)">
                                <path
                                    d="M3.65645 100C2.90914 99.565 2.08711 99.218 1.42788 98.6709C0.392326 97.8088 0.0293498 96.5731 0.0266809 95.2573C0.0160051 88.5155 0.021343 81.7765 0.0240119 75.0347C0.0240119 74.9146 0.0640461 74.7918 0.10408 74.5676C0.445705 74.7438 0.725944 74.8772 0.995508 75.0294C5.91704 77.8157 10.9667 78.0586 16.011 75.5178C17.5777 74.7304 18.9655 73.5107 20.2866 72.3257C21.8773 70.8978 23.3132 69.2965 24.8932 67.6898C26.4572 69.2644 27.9145 70.7457 29.3877 72.211C34.416 77.2152 41.5208 78.5444 47.9049 75.4911C49.5142 74.7224 50.9608 73.5214 52.314 72.3257C53.918 70.9112 55.3406 69.2885 56.9152 67.6818C58.5273 69.3018 60.0432 70.8204 61.5539 72.3417C63.9052 74.7171 66.6702 76.3478 69.9797 76.951C73.8764 77.6609 77.5488 77.0391 80.9678 75.0053C81.1626 74.8879 81.3628 74.7785 81.5656 74.6744C81.6163 74.6477 81.6857 74.6637 81.8805 74.6504C81.8805 75 81.8805 75.3416 81.8805 75.6806C81.8805 81.8031 81.7925 87.9257 81.9206 94.0456C81.9793 96.9174 81.1199 98.9831 78.3122 99.9973C53.4269 100 28.5417 100 3.65645 100Z"
                                    fill="white" />
                                <path
                                    d="M57.0166 58.0148C55.1617 59.8964 53.4323 61.6579 51.6921 63.4114C50.3149 64.7966 48.9377 66.1818 47.5392 67.5456C43.7333 71.2528 38.2086 71.2555 34.4187 67.5323C31.3094 64.4737 28.2348 61.3777 25.1414 58.3004C25.1201 58.2791 25.0881 58.2657 24.9546 58.1803C24.7304 58.3912 24.4742 58.618 24.234 58.8582C21.3275 61.754 18.4371 64.6632 15.5172 67.5456C12.2851 70.7377 8.17764 71.3542 4.37706 69.123C1.84157 67.6284 0.277564 65.3464 0.160131 62.3812C0.0266833 59.0717 -0.162812 55.7062 0.26155 52.4448C1.15832 45.5535 6.91523 40.9203 14.1641 40.8882C21.1647 40.8589 28.1654 40.8802 35.1633 40.8802C35.545 40.8802 35.9293 40.8802 36.4097 40.8802C36.4097 37.8136 36.4097 34.8644 36.4097 31.8565C39.4577 31.8565 42.4042 31.8565 45.4788 31.8565C45.4788 34.8217 45.4788 37.7949 45.4788 40.8802C45.9859 40.8802 46.3676 40.8802 46.7492 40.8802C53.7499 40.8802 60.7505 40.8562 67.7485 40.8882C73.7136 40.9149 78.0693 43.5945 80.7035 48.9751C81.5603 50.7286 81.9179 52.6182 81.9259 54.5532C81.9366 57.2195 81.9553 59.8938 81.8058 62.5547C81.5576 66.9825 76.9697 70.7537 72.5659 70.3854C70.0971 70.1799 68.0794 69.1737 66.3713 67.4522C63.302 64.3589 60.2327 61.2576 57.0166 58.0148Z"
                                    fill="white" />
                                <path
                                    d="M40.9202 0C41.1204 0.290915 41.2379 0.437707 41.3286 0.597843C43.8027 4.87349 46.3062 9.13313 48.7349 13.4355C50.8194 17.1293 50.3977 21.066 47.694 24.2153C45.3907 26.8976 41.5288 27.8718 37.8963 26.6841C34.747 25.6539 32.2889 22.4725 31.9606 19.131C31.7791 17.2921 32.0247 15.5466 32.9268 13.9506C35.537 9.33864 38.1899 4.75606 40.9202 0Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_3_87">
                                    <rect width="81.9366" height="100" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <a href="{{ route('admin.employee.birthday.list') }}"
                        class="text-primary font-weight-bold font-size-h6 mt-2">Birthday
                        {{ $employee['employee']->birthday_count ?? 0 }}</a>
                </div>
                <div class="px-6 py-8 tiles-bg-color rounded-lg"  style="background: linear-gradient(to bottom, #7a96fe, #3632F2);">
                    <span class="svg-icon svg-icon-3x svg-icon-light my-2">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
                        <svg width="101" height="100" viewBox="0 0 101 100" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_3_82)">
                                <path
                                    d="M71.4286 74.8102C83.6439 61.2146 79.3651 42.305 68.392 33.4714C57.4189 24.6377 41.5459 25.0518 31.1249 34.6446C20.3589 44.5135 18.2885 62.1808 29.3996 74.7412C28.9855 74.8102 28.6404 74.8102 28.2954 74.8102C23.6715 74.8102 19.1166 74.8102 14.4928 74.8102C6.14217 74.8792 0 68.6681 0 60.3175C0 45.0656 0 29.8137 0 14.5618C0 6.21118 6.21118 0 14.6308 0C38.5093 0 62.3188 0 86.1974 0C94.548 0 100.759 6.21118 100.759 14.4928C100.759 29.8137 100.759 45.0656 100.759 60.3865C100.759 68.599 94.617 74.8102 86.4044 74.8792C81.7115 74.9482 77.0186 74.8792 72.3257 74.8792C72.1187 74.8792 71.7736 74.8792 71.4286 74.8102ZM50.5176 10.352C42.236 10.352 33.8854 10.352 25.6039 10.352C25.1898 10.352 24.7067 10.352 24.2926 10.352C21.9462 10.49 20.2899 12.6984 20.842 15.0449C21.256 17.0462 22.7743 18.0814 25.2588 18.0814C42.029 18.0814 58.7302 18.0814 75.5003 18.0814C76.1215 18.0814 76.7426 18.0124 77.2947 17.8744C79.6411 17.2533 80.8144 14.5618 79.7102 12.4914C78.882 10.9041 77.5707 10.352 75.8454 10.352C67.3568 10.352 58.9372 10.352 50.5176 10.352Z"
                                    fill="white" />
                                <path
                                    d="M29.7447 55.4865C29.7447 44.0304 39.0614 34.8516 50.5176 34.8516C61.9048 34.9206 71.0835 44.1684 71.0835 55.5556C71.0835 66.9427 61.8358 76.1905 50.4486 76.1905C38.9924 76.2595 29.7447 66.9427 29.7447 55.4865Z"
                                    fill="white" />
                                <path
                                    d="M65.9075 79.4341C65.9075 81.4355 65.9075 83.2298 65.9075 85.0932C65.9075 88.2678 65.9075 91.3734 65.9075 94.548C65.9075 98.6197 62.6639 100.966 58.7302 99.6549C56.7288 99.0338 54.7274 98.3437 52.795 97.6536C51.1387 97.0324 49.5514 97.1014 47.9641 97.6536C46.0317 98.3437 44.0304 99.0338 42.029 99.6549C38.2333 100.897 34.9896 98.4817 34.9206 94.479C34.9206 89.51 34.9206 84.4721 34.9206 79.3651C45.2036 85.5072 55.4865 85.5073 65.9075 79.4341Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_3_82">
                                    <rect width="100.759" height="100" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <a href="{{ route('admin.employee.bond-last-date.list') }}"
                        class="text-primary font-weight-bold font-size-h6 mt-2">Bond Last Date
                        {{ $employee['employee']->bond_last_date_count ?? 0 }}</a>
                </div>
                <div class="px-6 py-8 tiles-bg-color rounded-lg"  style="background: linear-gradient(to bottom, #7a96fe, #3632F2);">
                    <span class="svg-icon svg-icon-3x svg-icon-light my-2">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Add-user.svg-->
                        <svg width="101" height="100" viewBox="0 0 101 100" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_3_82)">
                                <path
                                    d="M71.4286 74.8102C83.6439 61.2146 79.3651 42.305 68.392 33.4714C57.4189 24.6377 41.5459 25.0518 31.1249 34.6446C20.3589 44.5135 18.2885 62.1808 29.3996 74.7412C28.9855 74.8102 28.6404 74.8102 28.2954 74.8102C23.6715 74.8102 19.1166 74.8102 14.4928 74.8102C6.14217 74.8792 0 68.6681 0 60.3175C0 45.0656 0 29.8137 0 14.5618C0 6.21118 6.21118 0 14.6308 0C38.5093 0 62.3188 0 86.1974 0C94.548 0 100.759 6.21118 100.759 14.4928C100.759 29.8137 100.759 45.0656 100.759 60.3865C100.759 68.599 94.617 74.8102 86.4044 74.8792C81.7115 74.9482 77.0186 74.8792 72.3257 74.8792C72.1187 74.8792 71.7736 74.8792 71.4286 74.8102ZM50.5176 10.352C42.236 10.352 33.8854 10.352 25.6039 10.352C25.1898 10.352 24.7067 10.352 24.2926 10.352C21.9462 10.49 20.2899 12.6984 20.842 15.0449C21.256 17.0462 22.7743 18.0814 25.2588 18.0814C42.029 18.0814 58.7302 18.0814 75.5003 18.0814C76.1215 18.0814 76.7426 18.0124 77.2947 17.8744C79.6411 17.2533 80.8144 14.5618 79.7102 12.4914C78.882 10.9041 77.5707 10.352 75.8454 10.352C67.3568 10.352 58.9372 10.352 50.5176 10.352Z"
                                    fill="white" />
                                <path
                                    d="M29.7447 55.4865C29.7447 44.0304 39.0614 34.8516 50.5176 34.8516C61.9048 34.9206 71.0835 44.1684 71.0835 55.5556C71.0835 66.9427 61.8358 76.1905 50.4486 76.1905C38.9924 76.2595 29.7447 66.9427 29.7447 55.4865Z"
                                    fill="white" />
                                <path
                                    d="M65.9075 79.4341C65.9075 81.4355 65.9075 83.2298 65.9075 85.0932C65.9075 88.2678 65.9075 91.3734 65.9075 94.548C65.9075 98.6197 62.6639 100.966 58.7302 99.6549C56.7288 99.0338 54.7274 98.3437 52.795 97.6536C51.1387 97.0324 49.5514 97.1014 47.9641 97.6536C46.0317 98.3437 44.0304 99.0338 42.029 99.6549C38.2333 100.897 34.9896 98.4817 34.9206 94.479C34.9206 89.51 34.9206 84.4721 34.9206 79.3651C45.2036 85.5072 55.4865 85.5073 65.9075 79.4341Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_3_82">
                                    <rect width="100.759" height="100" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <a href="{{ route('admin.leave-request.list') }}"
                        class="text-primary font-weight-bold font-size-h6 mt-2">Leave Request
                        {{ $employee['employee']->bond_last_date_count ?? 0 }}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4">
                    <!--begin::Advance Table Widget 2-->
                    <div class="card card-custom gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bolder text-dark">Absent Employee</h3>
                            {{-- <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Absent Employee</span>
                            </h3> --}}
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-2">
                            <div class="card-scroll" style="height: 300px;">
                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-checkable" id="absent-emp-list">
                                        <thead>
                                            <tr>
                                                {{-- <th>#</th> --}}
                                                {{-- <th>Date</th> --}}
                                                <th>Employee</th>
                                                <th>Attendance Type</th>
                                                {{-- <th>Minutes</th> --}}
                                                <th>Reason</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Advance Table Widget 2-->
                </div>
                <div class="col-xl-3">
                    <div class="card card-custom card-stretch gutter-b">

                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bolder text-dark">Employee Birthday List</h3>
                        </div>

                        <div class="card-body pt-2">
                            <div class="card-scroll" style="height: 300px;">
                                @foreach ($employees as $employee)
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-40 symbol-light-success mr-5">
                                        @php
                                            if(file_exists( public_path() . '/upload/userprofile/' . $employee['employee_image']) && $employee['employee_image'] != ''){
                                                $image = url("upload/userprofile/" . $employee['employee_image']);
                                            }else{
                                                $image = url("upload/userprofile/default.jpg");
                                            }
                                        @endphp
                                        <img src="{{ $image }}" class="h-75 align-self-end pre-img" alt="">
                                    </div>

                                    @php
                                        $isBirthday = date('m-d', strtotime($employee['DOB'])) == date('m-d');
                                        $birthdayClass = $isBirthday ? 'text-danger' : 'text-dark';
                                        $detailsClass = $isBirthday ? 'text-danger' : 'text-muted';
                                        $dobFormatted = \Carbon\Carbon::parse($employee['DOB'])->format('j M');
                                    @endphp

                                    <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                        <a href="{{ route('admin.employee.view', $employee['id']) }}" class="{{ $birthdayClass }} text-hover-primary mb-1 font-size-lg">
                                            {{ $employee['first_name'] . ' ' . $employee['last_name'] }}
                                        </a>
                                        <span class="{{ $detailsClass }}">
                                            {{ $employee['technology_name'] . ' ' . $employee['designation_name'] }}
                                        </span>
                                        <span class="font-weight-bold {{ $detailsClass }}">
                                            {{ $dobFormatted }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <!--begin::Advance Table Widget 2-->
                    <div class="card card-custom gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bolder text-dark">Social Media Post</h3>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-2">
                            <div class="card-scroll" style="height: 300px;">
                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-checkable" id="social-media-post-list">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Day</th>
                                                <th>Post</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Advance Table Widget 2-->
                </div>
                {{-- <div class="col-xl-6">
                    <h2 class="mt-2 mb-2">Employee Birthday List</h2>
                    @php
                        $total_birthdays = count($employees);
                    @endphp
                    <div class="row mt-5">
                        @foreach ($employees as $employee)
                        <div class="{{ $total_birthdays > 4 ? 'col-xl' : 'col-xl-3' }} col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-custom gutter-b card-stretch">
                                <div class="card-body{{ date('m-d', strtotime($employee['DOB'])) == date('m-d') ? ' tiles-bg-color' : '' }}">
                                    <div class="d-flex align-items-end m-0">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                                <div class="symbol symbol-circle symbol-lg-75">
                                                    @php
                                                        if(file_exists( public_path() . '/upload/userprofile/' . $employee['employee_image']) && $employee['employee_image'] != ''){
                                                            $image = url("upload/userprofile/" . $employee['employee_image']);
                                                        }else{
                                                            $image = url("upload/userprofile/default.jpg");
                                                        }
                                                    @endphp
                                                    <img src="{{ $image }}" alt="image" />
                                                </div>
                                                <div class="symbol symbol-lg-75 symbol-circle symbol-primary d-none">
                                                    <span class="font-size-h3 font-weight-boldest">JM</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="{{ route('admin.employee.view', $employee['id']) }}" class="text-dark font-weight-bold text-hover-primary font-size-h6 mb-0">{{$employee['first_name'] .' '.$employee['last_name']}}</a>
                                                <span class="text-muted font-weight-bold">{{$employee['technology_name'] . ' ' . $employee['designation_name']}}</span>
                                                <span class="font-weight-bold {{ date('m-d', strtotime($employee['DOB'])) == date('m-d') ? 'text-danger' : 'text-muted' }}">{{ date('j M', strtotime($employee['DOB'])) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div> --}}
            </div>

            <div class="row mt-5">
                <div class="col-xxl-6 order-2 order-xxl-1">
                    <!--begin::Advance Table Widget 2-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Employee Bond Last Date List</span>
                            </h3>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-2 pb-0 mt-n3 pb-5">
                            <div class="tab-content mt-5" id="myTabTables11">
                                <!--begin::Tap pane-->
                                <div class="tab-pane fade show active" id="kt_tab_pane_11_3" role="tabpanel"
                                    aria-labelledby="kt_tab_pane_11_3">
                                    <!--begin::Table-->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-checkable" id="dash-employee-bond-last-date-list">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Employee Name</th>
                                                    <th>Bond Last Date</th>
                                                    <th>Department</th>
                                                    <th>Designation</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>

                                    </div>
                                    <!--end::Table-->
                                </div>
                                <!--end::Tap pane-->
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Advance Table Widget 2-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
