<template>

    <div>
        <!--begin::Main-->
        <v-app>

            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <!--begin::Content wrapper-->
                <div class="d-flex flex-column flex-column-fluid">
                    <!--begin::Toolbar-->
                    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                        <!--begin::Toolbar container-->
                        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                            <!--begin::Page title-->
                            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                <!--begin::Title-->
                                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Dashboard</h1>
                                <!--end::Title-->
                                <!--begin::Breadcrumb-->
                                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">
                                        <a href="/user/dashboard" class="text-muted text-hover-primary">Home</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">User dashboard</li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->

                            <!--end::Actions-->
                        </div>
                        <!--end::Toolbar container-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Content-->
                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <!--begin::Content container-->
                        <div id="kt_app_content_container" class="app-container container-xxl">
                            <!--begin::Navbar-->
                            <div class="card mb-6">
                                <div class="card-body pt-9 pb-0">
                                    <!--begin::Details-->
                                    <div class="d-flex flex-wrap flex-sm-nowrap">
                                        <!--begin: Pic-->
                                        <div class="me-7 mb-4">
                                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                                <img src="/assets/image/avatar.png" alt="" />
<!--                                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>-->
                                            </div>
                                        </div>

                                        <!--end::Pic-->
                                        <!--begin::Info-->
                                        <div class="flex-grow-1">
                                            <!--begin::Title-->
                                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                                <!--begin::User-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Name-->
                                                    <div class="d-flex align-items-center mb-2">

                                                        <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{userInfo.full_name}}</a>
                                                        <a>
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
                                                            <span class="svg-icon svg-icon-1 svg-icon-primary">
																		<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
																			<path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="currentColor" />
																			<path d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
																		</svg>
																	</span>
                                                            <!--end::Svg Icon-->
                                                        </a>
                                                    </div>
                                                    <!--end::Name-->
                                                    <!--begin::Info-->
                                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                                        <a class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                            <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                            <span class="svg-icon svg-icon-4 me-1">
																	<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path opacity="0.3" d="M16.5 9C16.5 13.125 13.125 16.5 9 16.5C4.875 16.5 1.5 13.125 1.5 9C1.5 4.875 4.875 1.5 9 1.5C13.125 1.5 16.5 4.875 16.5 9Z" fill="currentColor" />
																		<path d="M9 16.5C10.95 16.5 12.75 15.75 14.025 14.55C13.425 12.675 11.4 11.25 9 11.25C6.6 11.25 4.57499 12.675 3.97499 14.55C5.24999 15.75 7.05 16.5 9 16.5Z" fill="currentColor" />
																		<rect x="7" y="6" width="4" height="4" rx="2" fill="currentColor" />
																	</svg>
																</span>
                                                            <!--end::Svg Icon-->{{userInfo.is_login_verified?'Verified':''}}</a>

                                                        <a class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                                            <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                                            <span class="svg-icon svg-icon-4 me-1">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="currentColor" />
																		<path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="currentColor" />
																	</svg>
																</span>
                                                            <!--end::Svg Icon-->{{userInfo.email}}</a>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                                <!--end::User-->
                                                <!--begin::Actions-->
                                                <!--end::Actions-->
                                            </div>
                                            <!--end::Title-->
                                            <!--begin::Stats-->
                                            <div class="d-flex flex-wrap flex-stack">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                                    <!--begin::Stats-->
                                                    <div class="d-flex flex-wrap">
                                                        <!--begin::Stat-->
                                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3" v-if="userInfo.account_type=='beneficiary'">
                                                            <!--begin::Number-->
                                                            <div class="d-flex align-items-center">
                                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="0" data-kt-countup-prefix="">{{ requestCount }}</div>
                                                            </div>
                                                            <!--end::Number-->
                                                            <!--begin::Label-->
                                                            <div class="fw-semibold fs-6 text-gray-400">Requests</div>
                                                            <!--end::Label-->
                                                        </div>

                                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3" v-if="userInfo.account_type=='pharmaceutical_company'">
                                                            <!--begin::Number-->
                                                            <div class="d-flex align-items-center">
                                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="0" data-kt-countup-prefix="">{{ responseCount }}</div>
                                                            </div>
                                                            <!--end::Number-->
                                                            <!--begin::Label-->
                                                            <div class="fw-semibold fs-6 text-gray-400">Responses</div>
                                                            <!--end::Label-->
                                                        </div>

                                                        <!--end::Stat-->

                                                    </div>
                                                    <!--end::Stats-->
                                                </div>
                                                <!--end::Wrapper-->
                                                <!--begin::Progress-->
                                                <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3" v-if="userInfo.is_profile_complete">
                                                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                        <span class="fw-semibold fs-6 text-gray-400">Profile Completion</span>
                                                        <span class="fw-bold fs-6">100%</span>
                                                    </div>
                                                    <div class="h-5px mx-3 w-100 bg-light mb-3">
                                                        <div class="bg-success rounded h-5px" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>

                                                <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3" v-else>
                                                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                        <span class="fw-semibold fs-6 text-gray-400">Profile Completion</span>
                                                        <span class="fw-bold fs-6">50%</span>
                                                    </div>
                                                    <div class="h-5px mx-3 w-100 bg-light mb-3">
                                                        <div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <!--end::Progress-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::Details-->

                                </div>
                            </div>
                            <!--end::Navbar-->
                            <!--begin::Timeline-->
                            <div v-if="!userInfo.is_profile_complete">
                                <div class="card mb-5 mb-xl-10">
                                    <!--begin::Card head-->
                                    <div class="card-header card-header-stretch">
                                        <!--begin::Title-->
                                        <div class="card-title d-flex align-items-center">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                            <span class="svg-icon svg-icon-1 svg-icon-primary me-3 lh-0">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor" />
														<path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor" />
														<path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor" />
													</svg>
												</span>
                                            <!--end::Svg Icon-->

                                            <h3 class="fw-bold m-0 text-gray-800">
                                                {{userInfo.status=='pending' ? `You have submitted the required documents and your account is pending approval. Please wait for approval.` : `Your account is incomplete. Please submit the following documents to complete your profile.`}}
                                            </h3>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Card head-->
                                    <!--begin::Card body-->
                                    <div class="card-body">
                                        <v-row>
                                         <v-col md="6" v-if="userInfo.status == 'received'">
                                             <v-file-input
                                                 label="Agreement signed by focal person of both Ashwini foundation and your organisation"
                                                 placeholder="Agreement signed by focal person of both Ashwini foundation and your organisation"
                                                 v-model="setting.agreement_document_file"
                                                 :error="$v.setting.agreement_document_file.$error"
                                                 prepend-icon=""
                                                 prepend-inner-icon="mdi-file"
                                                 clearable
                                                 outlined
                                                 required
                                             >
                                             </v-file-input>
                                         </v-col>

                                            <v-col md="6" v-if="userInfo.status == 'received'  && userInfo.account_type == 'beneficiary'">
                                                <v-file-input
                                                    label="Application signed by Mayor/RM chairman"
                                                    placeholder="Application signed by Mayor/RM chairman"
                                                    v-model="setting.application_document_file"
                                                    :error="$v.setting.application_document_file.$error"
                                                    prepend-icon=""
                                                    prepend-inner-icon="mdi-file"
                                                    clearable
                                                    outlined
                                                    required
                                                >
                                                </v-file-input>
                                            </v-col>

                                            <v-col class="text-right" v-if="userInfo.status=='received'">
                                                <v-btn
                                                    class="text-white ml-2 btn btn-primary"
                                                    dark
                                                    :loading="loading"
                                                    @click="submitDocument"
                                                >
                                                    Submit
                                                </v-btn>
                                            </v-col>
                                        </v-row>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                            </div>

                            <div v-else>
                                <!--begin::Basic info-->
                                <div class="card mb-5 mb-xl-10">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                                        <v-row>
                                            <v-col cols="12" md="10" class="mt-5 col-md-10">
                                                <h3 class="fw-bold m-0">Details</h3>
                                            </v-col>

                                            <v-col cols="12" md="2"  class="mt-5 justify-content-end">


                                                <v-btn
                                                    v-if="!edit"
                                                    class="btn-primary ml-3"
                                                    @click="edit = true"
                                                >
                                                    Edit
                                                </v-btn>


                                                <v-btn v-if="edit"
                                                       @click="cancel"
                                                >
                                                    Cancel
                                                </v-btn>
                                                <v-btn v-if="edit"
                                                       class="text-white ml-2 btn-primary"
                                                       dark
                                                       @click="createOrUpdate"
                                                       :loading="loading"
                                                >
                                                    Update
                                                </v-btn>

                                            </v-col>
                                        </v-row>
                                    </div>
                                    <!--begin::Card header-->
                                    <!--begin::Content-->
                                    <div id="kt_account_settings_profile_details" class="collapse show">
                                        <!--begin::Form-->
                                        <form id="kt_account_profile_details_form" class="form">
                                            <!--begin::Card body-->
                                            <div class="card-body border-top p-9">
                                                <!--begin::Input group-->
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8">
                                                        <!--begin::Row-->
                                                        <div class="row" v-if="!edit">
                                                            <!--begin::Col-->
                                                            <div class="col-lg-4 fv-row">
                                                                {{ userInfo.first_name }}
                                                            </div>
                                                            <!--end::Col-->

                                                            <!--begin::Col-->
                                                            <div class="col-lg-4 fv-row">
                                                                {{ userInfo.last_name }}
                                                            </div>
                                                            <!--end::Col-->
                                                        </div>
                                                        <!--end::Row-->
                                                        <!--begin::Row-->
                                                        <div class="row" v-else>
                                                            <!--begin::Col-->
                                                            <div class="col-lg-4 fv-row">
                                                                <v-text-field
                                                                    label="First name"
                                                                    v-model="userInfo.first_name"
                                                                    :error="$v.userInfo.first_name.$error"
                                                                    clearable
                                                                    outlined
                                                                    required
                                                                >
                                                                <template v-slot:label>
                                                                    First name <span class="text-danger"> *</span>
                                                                </template>
                                                                </v-text-field>
                                                            </div>
                                                            <!--end::Col-->
                                                            <!--begin::Col-->
                                                            <div class="col-lg-4 fv-row">
                                                                <v-text-field
                                                                    label="Last name"
                                                                    v-model="userInfo.last_name"
                                                                    :error="$v.userInfo.last_name.$error"
                                                                    clearable
                                                                    outlined
                                                                    required
                                                                >
                                                                <template v-slot:label>
                                                                    Last name <span class="text-danger"> *</span>
                                                                </template>
                                                                </v-text-field>
                                                            </div>
                                                            <!--end::Col-->
                                                        </div>
                                                        <!--end::Row-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>

                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Gender</label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8 fv-row" v-if="!edit">
                                                        <span class="badge badge-success">{{ userInfo.gender_text }}</span>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8 fv-row" v-else>
                                                        <v-select
                                                        label="Gender"
                                                        :items="gender_option"
                                                        v-model="userInfo.gender"
                                                        item-text="title"
                                                        item-value="value"
                                                        variant="outlined"
                                                        :error="$v.userInfo.gender.$error"
                                                        outlined
                                                        required
                                                    >
                                                        <template v-slot:label>
                                                            Gender <span class="text-danger"> *</span>
                                                        </template>
                                                    </v-select>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Date of birth</label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8">
                                                        <!--begin::Row-->
                                                        <div class="row" v-if="!edit">
                                                            <!--begin::Col-->
                                                            <div class="col-lg-6 fv-row">
                                                                {{ userInfo.date_of_birth || 'N/A' }}
                                                            </div>
                                                            <!--end::Col-->
                                                        </div>
                                                        <!--end::Row-->
                                                        <!--begin::Row-->
                                                        <div class="row" v-else>
                                                            <!--begin::Col-->
                                                            <div class="col-lg-12 fv-row">
                                                                <v-menu
                                                                    v-model="menu"
                                                                    :close-on-content-click="false"
                                                                    :nudge-right="40"
                                                                    transition="scale-transition"
                                                                    offset-y
                                                                    min-width="290px"
                                                                >
                                                                    <template v-slot:activator="{ on, attrs }">
                                                                        <v-text-field
                                                                            v-model="userInfo.date_of_birth"
                                                                            :error="$v.userInfo.date_of_birth.$error"
                                                                            label="Date of birth"
                                                                            prepend-inner-icon="mdi-calendar"
                                                                            readonly
                                                                            dense
                                                                            outlined
                                                                            v-bind="attrs"
                                                                            v-on="on"
                                                                        >
                                                                        <template v-slot:label>
                                                                            Date of birth <span class="text-danger"> *</span>
                                                                        </template>
                                                                        </v-text-field>
                                                                    </template>
                                                                    <v-date-picker
                                                                        no-title
                                                                        v-model="userInfo.date_of_birth"
                                                                        @input="menu = false"
                                                                    >
                                                                    </v-date-picker>
                                                                </v-menu>
                                                            </div>
                                                            <!--end::Col-->

                                                        </div>
                                                        <!--end::Row-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span class="required">Mobile</span>
                                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Mobile number must be active"></i>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8 fv-row">
                                                         <!--begin::Row-->
                                                         <div class="row" v-if="!edit">
                                                            <!--begin::Col-->
                                                            <div class="col-lg-6 fv-row">
                                                                {{ userInfo.mobile_format || 'N/A' }}
                                                            </div>
                                                            <!--end::Col-->
                                                            <!--begin::Col-->

                                                            <!--end::Col-->
                                                        </div>
                                                        <!--end::Row-->
                                                        <!--begin::Row-->
                                                        <div class="row" v-else>
                                                            <!--begin::Col-->
                                                            <div class="col-lg-12 fv-row">
                                                                <v-text-field
                                                                    label="Mobile"
                                                                    v-model="userInfo.mobile"
                                                                    :error="$v.userInfo.mobile.$error"
                                                                    clearable
                                                                    outlined
                                                                    required
                                                                >
                                                                    <template v-slot:label>
                                                                        Mobile <span class="text-danger"> *</span>
                                                                    </template>
                                                                </v-text-field>
                                                            </div>
                                                            <!--end::Col-->

                                                        </div>
                                                        <!--end::Row-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span>Phone</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8 fv-row">
                                                         <!--begin::Row-->
                                                         <div class="row" v-if="!edit">
                                                            <!--begin::Col-->
                                                            <div class="col-lg-6 fv-row">
                                                                {{ userInfo.phone_format|| 'N/A' }}
                                                            </div>
                                                            <!--end::Col-->
                                                            <!--begin::Col-->

                                                            <!--end::Col-->
                                                        </div>
                                                        <!--end::Row-->
                                                        <!--begin::Row-->
                                                        <div class="row" v-else>
                                                            <!--begin::Col-->
                                                            <div class="col-lg-12 fv-row">
                                                                <v-text-field
                                                                    label="Phone"
                                                                    v-model="userInfo.phone"
                                                                    clearable
                                                                    outlined
                                                                    required
                                                                >
                                                                </v-text-field>
                                                            </div>
                                                            <!--end::Col-->

                                                        </div>
                                                        <!--end::Row-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span>Work phone</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8 fv-row">
                                                         <!--begin::Row-->
                                                         <div class="row" v-if="!edit">
                                                            <!--begin::Col-->
                                                            <div class="col-lg-6 fv-row">
                                                                {{ userInfo.work_phone || 'N/A' }}
                                                            </div>
                                                            <!--end::Col-->
                                                            <!--begin::Col-->

                                                            <!--end::Col-->
                                                        </div>
                                                        <!--end::Row-->
                                                        <!--begin::Row-->
                                                        <div class="row" v-else>
                                                            <!--begin::Col-->
                                                            <div class="col-lg-12 fv-row">
                                                                <v-text-field
                                                                    label="Work phone"
                                                                    v-model="userInfo.work_phone"
                                                                    clearable
                                                                    outlined
                                                                    required
                                                                >
                                                                </v-text-field>
                                                            </div>
                                                            <!--end::Col-->

                                                        </div>
                                                        <!--end::Row-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Input group-->


                                            </div>
                                            <!--end::Card body-->
                                            <!--begin::Actions-->
                                            <div class="card-footer d-flex justify-content-end py-6 px-9" v-if="edit">
                                                <v-btn
                                                    class="ml-2 btn-standard"
                                                    @click="cancel"
                                                >
                                                    Cancel
                                                </v-btn>
                                                <v-btn
                                                    class="text-white ml-2  btn-primary"
                                                    dark
                                                    @click="createOrUpdate"
                                                    :loading="loading"
                                                >
                                                    Update
                                                </v-btn>
                                            </div>
                                            <!--end::Actions-->
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Basic info-->

                                <!--begin::Volunteer Setting info-->
                                <div class="card mb-5 mb-xl-10" v-if="userInfo.account_type == 'volunteer'">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                                        <v-row>
                                            <v-col cols="12" md="10" class="mt-5 col-md-10">
                                                <h3 class="fw-bold m-0">Other Details</h3>
                                            </v-col>

                                            <v-col cols="12" md="2"  class="mt-5 justify-content-end">


                                                <v-btn
                                                    v-if="!editSetting"
                                                    class="btn-primary ml-3"
                                                    @click="editSetting = true"
                                                >
                                                    Edit
                                                </v-btn>


                                                <v-btn v-if="editSetting"
                                                    @click="cancelSetting"
                                                >
                                                    Cancel
                                                </v-btn>
                                                <v-btn v-if="editSetting"
                                                       class="text-white ml-2 btn-primary"
                                                       dark
                                                       @click="createOrUpdateSetting"
                                                       :loading="isLoading"
                                                >
                                                    Update
                                                </v-btn>

                                            </v-col>
                                        </v-row>
                                    </div>
                                    <!--begin::Card header-->
                                    <!--begin::Content-->
                                    <div id="kt_account_settings_profile_details" class="collapse show">
                                        <!--begin::Form-->
                                        <form id="kt_account_profile_details_form" class="form">
                                            <!--begin::Card body-->
                                            <div class="card-body border-top p-9">
                                                <!--begin::Input group-->
                                                <div class="row mb-6" v-if="userInfo.account_type == 'volunteer'">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span class="required">Volunteering type</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8 fv-row">
                                                         <!--begin::Row-->
                                                         <div class="row" v-if="!editSetting">
                                                            <!--begin::Col-->
                                                            <div class="col-lg-6 fv-row">
                                                                <span class="badge badge-primary" :class="{'badge-primary' : userInfo.user_type == 'paid', 'badge-warning' : userInfo.user_type == 'unpaid'}">{{ userInfo.user_type_text || 'N/A' }}</span>
                                                            </div>
                                                            <!--end::Col-->
                                                            <!--begin::Col-->

                                                            <!--end::Col-->
                                                        </div>
                                                        <!--end::Row-->
                                                        <!--begin::Row-->
                                                        <div class="row" v-else>
                                                            <!--begin::Col-->
                                                            <div class="col-lg-12 fv-row">
                                                                <v-select
                                                                    label="Volunteering type"
                                                                    v-model="userInfo.user_type"
                                                                    :items="userTypes"
                                                                    item-text="title"
                                                                    item-value="value"
                                                                    clearable
                                                                    outlined
                                                                    required
                                                                >
                                                                    <template v-slot:label>
                                                                        Volunteering type <span class="text-danger"> *</span>
                                                                    </template>
                                                                </v-select>
                                                            </div>
                                                            <!--end::Col-->

                                                        </div>
                                                        <!--end::Row-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Blood group</label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8">
                                                        <!--begin::Row-->
                                                        <div class="row" v-if="!editSetting">
                                                            <!--begin::Col-->
                                                            <div class="col-lg-12 fv-row">
                                                                {{ setting.blood_group || 'N/A'}}
                                                            </div>
                                                            <!--end::Col-->
                                                        </div>
                                                        <!--end::Row-->
                                                        <!--begin::Row-->
                                                        <div class="row" v-else>
                                                            <!--begin::Col-->
                                                            <div class="col-lg-12 fv-row">
                                                                <v-text-field
                                                                    v-model="setting.blood_group"
                                                                    :error="$v.setting.blood_group.$error"
                                                                    clearable
                                                                    outlined
                                                                    required
                                                                    dense
                                                                >
                                                                    <template v-slot:label>
                                                                        Blood group <span class="text-danger"> *</span>
                                                                    </template>
                                                                </v-text-field>
                                                            </div>
                                                            <!--end::Col-->

                                                        </div>
                                                        <!--end::Row-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>

                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Education</label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8 fv-row" v-if="!editSetting">
                                                        {{ setting.education || 'N/A' }}
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8 fv-row" v-else>
                                                        <v-text-field
                                                            v-model="setting.education"
                                                            :error="$v.setting.education.$error"
                                                            clearable
                                                            outlined
                                                            required
                                                            dense
                                                        >
                                                        <template v-slot:label>
                                                            Education <span class="text-danger"> *</span>
                                                        </template>
                                                        </v-text-field>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="row mb-6" v-if="userInfo.user_type == 'paid'">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Experience</label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8">
                                                        <!--begin::Row-->
                                                        <div class="row" v-if="!editSetting">
                                                            <!--begin::Col-->
                                                            <div class="col-lg-6 fv-row">
                                                                {{ setting.experience || 'N/A' }}
                                                            </div>
                                                            <!--end::Col-->
                                                        </div>
                                                        <!--end::Row-->
                                                        <!--begin::Row-->
                                                        <div class="row" v-else>
                                                            <!--begin::Col-->
                                                            <div class="col-lg-12 fv-row">
                                                                <v-textarea
                                                                    v-model="setting.experience"
                                                                    :error="$v.setting.experience.$error"
                                                                    clearable
                                                                    outlined
                                                                    dense
                                                                >
                                                                <template v-slot:label>
                                                                    Experience <span class="text-danger"> *</span>
                                                                </template>
                                                                </v-textarea>
                                                            </div>
                                                            <!--end::Col-->

                                                        </div>
                                                        <!--end::Row-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="row mb-6" v-if="userInfo.user_type == 'paid'">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                        <span class="required">CV</span>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8 fv-row">
                                                         <!--begin::Row-->
                                                         <div class="row" v-if="!editSetting">
                                                            <!--begin::Col-->
                                                            <div class="col-lg-6 fv-row" v-if="setting.cv_file_path && setting.cv_file_path.real">
                                                                <a :href="setting.cv_file_path.real" target="_blank">CV file</a>
                                                            </div>
                                                            <!--end::Col-->
                                                            <div class="col-lg-6 fv-row" v-else>
                                                                N/A
                                                            </div>
                                                        </div>
                                                        <!--end::Row-->
                                                        <!--begin::Row-->
                                                        <div class="row" v-else>
                                                            <!--begin::Col-->
                                                            <div class="col-lg-12 fv-row">
                                                                <v-file-input
                                                                    label="CV"
                                                                    v-model="setting.cv_file"
                                                                    :error="$v.setting.cv_file.$error"
                                                                    prepend-icon=""
                                                                    prepend-inner-icon="mdi-file"
                                                                    clearable
                                                                    outlined
                                                                    dense
                                                                >
                                                                </v-file-input>
                                                            </div>
                                                            <!--end::Col-->

                                                        </div>
                                                        <!--end::Row-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Input group-->


                                            </div>
                                            <!--end::Card body-->
                                            <!--begin::Actions-->
                                            <div class="card-footer d-flex justify-content-end py-6 px-9" v-if="editSetting">
                                                <v-btn
                                                    class="ml-2 btn-standard"
                                                    @click="cancelSetting"
                                                >
                                                    Cancel
                                                </v-btn>
                                                <v-btn
                                                    class="text-white ml-2  btn-primary"
                                                    dark
                                                    @click="createOrUpdateSetting"
                                                    :loading="isLoading"
                                                >
                                                    Update
                                                </v-btn>
                                            </div>
                                            <!--end::Actions-->
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Volunteer Setting info-->

                                <!--begin::Setting info-->
                                <div class="card mb-5 mb-xl-10" v-if="userInfo.account_type == 'pharmaceutical_company'">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                                        <v-row>
                                            <v-col cols="12" md="10" class="mt-5 col-md-10">
                                                <h3 class="fw-bold m-0">Company Details</h3>
                                            </v-col>

                                            <v-col cols="12" md="2"  class="mt-5 justify-content-end">


                                                <v-btn
                                                    v-if="!editOrgSetting"
                                                    class="btn-primary ml-3"
                                                    @click="editOrgSetting = true"
                                                >
                                                    Edit
                                                </v-btn>


                                                <v-btn v-if="editOrgSetting"
                                                    @click="cancelSetting"
                                                >
                                                    Cancel
                                                </v-btn>
                                                <v-btn v-if="editOrgSetting"
                                                       class="text-white ml-2 btn-primary"
                                                       dark
                                                       @click="createOrUpdateSetting"
                                                       :loading="isLoading"
                                                >
                                                    Update
                                                </v-btn>

                                            </v-col>
                                        </v-row>
                                    </div>
                                    <!--begin::Card header-->
                                    <!--begin::Content-->
                                    <div id="kt_account_settings_profile_details" class="collapse show">
                                        <!--begin::Form-->
                                        <form id="kt_account_profile_details_form" class="form">
                                            <!--begin::Card body-->
                                            <div class="card-body border-top p-9">
                                                <!--begin::Input group-->
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Organisation name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8">
                                                        <!--begin::Row-->
                                                        <div class="row" v-if="!editOrgSetting">
                                                            <!--begin::Col-->
                                                            <div class="col-lg-12 fv-row">
                                                                {{ setting.org_name || 'N/A'}}
                                                            </div>
                                                            <!--end::Col-->
                                                        </div>
                                                        <!--end::Row-->
                                                        <!--begin::Row-->
                                                        <div class="row" v-else>
                                                            <!--begin::Col-->
                                                            <div class="col-lg-12 fv-row">
                                                                <v-text-field
                                                                    v-model="setting.org_name"
                                                                    :error="$v.setting.org_name.$error"
                                                                    clearable
                                                                    outlined
                                                                    required
                                                                    dense
                                                                >
                                                                    <template v-slot:label>
                                                                        Organisation name <span class="text-danger"> *</span>
                                                                    </template>
                                                                </v-text-field>
                                                            </div>
                                                            <!--end::Col-->

                                                        </div>
                                                        <!--end::Row-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>

                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Organisation email</label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8 fv-row" v-if="!editOrgSetting">
                                                        {{ setting.org_email || 'N/A' }}
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8 fv-row" v-else>
                                                        <v-text-field
                                                            v-model="setting.org_email"
                                                            :error="$v.setting.org_email.$error"
                                                            clearable
                                                            outlined
                                                            required
                                                            dense
                                                        >
                                                        <template v-slot:label>
                                                            Organisation email <span class="text-danger"> *</span>
                                                        </template>
                                                        </v-text-field>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Input group-->

                                                <!--begin::Input group-->
                                                <div class="row mb-6">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Organisation contact name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8">
                                                        <!--begin::Row-->
                                                        <div class="row" v-if="!editOrgSetting">
                                                            <!--begin::Col-->
                                                            <div class="col-lg-6 fv-row">
                                                                {{ setting.org_contact_name || 'N/A' }}
                                                            </div>
                                                            <!--end::Col-->
                                                        </div>
                                                        <!--end::Row-->
                                                        <!--begin::Row-->
                                                        <div class="row" v-else>
                                                            <!--begin::Col-->
                                                            <div class="col-lg-12 fv-row">
                                                                <v-text-field
                                                                    v-model="setting.org_contact_name"
                                                                    :error="$v.setting.org_contact_name.$error"
                                                                    clearable
                                                                    outlined
                                                                    dense
                                                                >
                                                                <template v-slot:label>
                                                                    Organisation contact name <span class="text-danger"> *</span>
                                                                </template>
                                                                </v-text-field>
                                                            </div>
                                                            <!--end::Col-->

                                                        </div>
                                                        <!--end::Row-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Input group-->

                                            </div>
                                            <!--end::Card body-->
                                            <!--begin::Actions-->
                                            <div class="card-footer d-flex justify-content-end py-6 px-9" v-if="editOrgSetting">
                                                <v-btn
                                                    class="ml-2 btn-standard"
                                                    @click="cancelOrgSetting"
                                                >
                                                    Cancel
                                                </v-btn>
                                                <v-btn
                                                    class="text-white ml-2  btn-primary"
                                                    dark
                                                    @click="createOrUpdateSetting"
                                                    :loading="isLoading"
                                                >
                                                    Update
                                                </v-btn>
                                            </div>
                                            <!--end::Actions-->
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Setting info-->

                                <!--begin::Sign-in Method-->
                                <div class="card mb-5 mb-xl-10">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                                        <div class="card-title m-0">
                                            <h3 class="fw-bold m-0">Sign-in Method</h3>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Content-->
                                    <div id="kt_account_settings_signin_method" class="collapse show">
                                        <!--begin::Card body-->
                                        <div class="card-body border-top p-9">
                                            <!--begin::Email Address-->
                                            <div class="d-flex flex-wrap align-items-center">
                                                <!--begin::Label-->
                                                <div id="kt_signin_email">
                                                    <div class="fs-6 fw-bold mb-1">Email address</div>
                                                    <div class="fw-semibold text-gray-600">{{ userInfo.email }}</div>
                                                </div>
                                                <!--end::Label-->

                                            </div>
                                            <!--end::Email Address-->
                                            <!--begin::Separator-->
                                            <div class="separator separator-dashed my-6"></div>
                                            <!--end::Separator-->
                                            <!--begin::Password-->
                                            <div class="d-flex flex-wrap align-items-center mb-10">
                                                <!--begin::Label-->
                                                <div id="kt_signin_password">
                                                    <div class="fs-6 fw-bold mb-1">Password</div>
                                                    <div class="fw-semibold text-gray-600">************</div>
                                                </div>
                                                <!--end::Label-->

                                                <!--begin::Action-->
                                                   <!--begin::Action-->
                                                   <div id="kt_signin_password_button" class="ms-auto">
                                                    <v-btn
                                                        class="text-white ml-2  btn-primary"
                                                        @click="openChangePassword()"
                                                    >
                                                        Reset password
                                                    </v-btn>
                                                </div>
                                                <!--end::Action-->
                                                <!--end::Action-->
                                            </div>
                                            <!--end::Password-->

                                            <!--begin::MFA-->
                                            <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                                                <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor" />
															<path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor" />
														</svg>
													</span>
                                                <!--end::Svg Icon-->
                                                <!--end::Icon-->
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                                    <!--begin::Content-->
                                                    <div class="mb-3 mb-md-0 fw-semibold">
                                                        <h4 class="text-gray-900 fw-bold">Setup MFA - authenticator App</h4>
                                                        <div class="fs-6 text-gray-700 pe-7">Two-factor authentication adds an extra layer of security to your account. To log in, in addition you'll need to provide a 6 digit code.</div>
                                                    </div>
                                                    <!--end::Content-->
                                                    <!--begin::Action-->
                                                    <v-btn color="primary" large rounded  class="inline-block py-3 px-6 rounded-full shadow-lg bg-blue-600 text-white text-center text-uppercase"  v-if="!userInfo.is_mfa_enabled" @click="getMfaAuthenticatorCode">
                                                        Setup MFA authenticator
                                                    </v-btn>
                                                    <v-btn color="red" large rounded  class="inline-block py-3 px-6 rounded-full shadow-lg bg-red-600 text-white text-center text-uppercase"  v-if="userInfo.is_mfa_enabled" @click="deActivateMfaAuthenticator">
                                                        Deactivate MFA authenticator
                                                    </v-btn>
                                                    <!--end::Action-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::MFA-->

                                            <!--begin::Email-->
                                            <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mt-3 p-6">
                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                                                <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor" />
                                                                <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Icon-->
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                                    <!--begin::Content-->
                                                    <div class="mb-3 mb-md-0 fw-semibold">
                                                        <h4 class="text-gray-900 fw-bold">Setup MFA - email verification</h4>
                                                        <div class="fs-6 text-gray-700 pe-7">Use multi-factor authentication (MFA) to add an extra layer of security to your account.</div>
                                                    </div>
                                                    <!--end::Content-->
                                                    <!--begin::Action-->
                                                    <v-btn color="primary" large rounded  class="inline-block py-3 px-6 rounded-full shadow-lg bg-blue-600 text-white text-center text-uppercase"  v-if="!userInfo.is_email_authentication_enabled" @click="getEmailAuthenticator">
                                                        Setup Email authenticator
                                                    </v-btn>
                                                    <v-btn color="red" large rounded  class="inline-block py-3 px-6 rounded-full shadow-lg bg-blue-600 text-white text-center text-uppercase"  v-if="userInfo.is_email_authentication_enabled" @click="deActivateEmailAuthenticator">
                                                        Deactivate Email authenticator
                                                    </v-btn>


                                                    <!--end::Action-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Email-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Sign-in Method-->
                                <!--begin::Sign-in Method-->
                                <div class="card mb-5 mb-xl-10">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                                        <div class="card-title m-0">
                                            <h3 class="fw-bold m-0">Address</h3>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Content-->
                                    <div id="kt_account_settings_signin_method" class="collapse show">
                                        <!--begin::Card body-->
                                        <div class="card-body border-top p-9">
                                            <!--begin::Email Address-->
                                            <div class="d-flex flex-wrap align-items-center">
                                                <!--begin::Label-->
                                                <div id="kt_signin_email">
                                                    <div class="fs-6 fw-bold mb-1">Temporary address</div>
                                                    <div class="fw-semibold text-gray-600">{{ userInfo.full_temporary_address || 'N/A' }}</div>
                                                </div>
                                                <!--end::Label-->

                                                <!--begin::Action-->
                                                <div id="kt_signin_email_button" class="ms-auto">
                                                    <v-btn
                                                        class="text-white ml-2 btn-primary"
                                                        @click="openAddress('temporary')"
                                                    >
                                                        Update
                                                    </v-btn>
                                                </div>
                                                <!--end::Action-->
                                            </div>
                                            <!--end::Email Address-->
                                            <!--begin::Separator-->
                                            <div class="separator separator-dashed my-6"></div>
                                            <!--end::Separator-->
                                            <!--begin::Password-->
                                            <div class="d-flex flex-wrap align-items-center mb-10">
                                                <!--begin::Label-->
                                                <div id="kt_signin_password">
                                                    <div class="fs-6 fw-bold mb-1">Permanent address</div>
                                                    <div class="fw-semibold text-gray-600">{{ userInfo.full_permanent_address || 'N/A' }}</div>
                                                </div>
                                                <!--end::Label-->
                                                <!--begin::Action-->
                                                <div id="kt_signin_password_button" class="ms-auto">
                                                    <v-btn
                                                        class="text-white ml-2 btn-primary"
                                                        @click="openAddress('permanent')"
                                                    >
                                                        Update
                                                    </v-btn>
                                                </div>
                                                <!--end::Action-->
                                            </div>
                                            <!--end::Password-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Sign-in Method-->
                            </div>

                            <!--end::Timeline-->
                        </div>
                        <!--end::Content container-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Content wrapper-->
                <!--begin::Footer-->

                <!--end::Footer-->

                <user-address ref="user-address" :user-id="userId" @refresh="getUser" ></user-address>

                <change-password ref="change-password" :user-id="userId"></change-password>

                <user-account-security ref="user-account-security" @refresh="getUser"></user-account-security>
            </div>
        </v-app>
        <!--end:::Main-->
    </div>
</template>
<script>
import { required, requiredIf} from "vuelidate/lib/validators";
import DashboardService from '@/services/front/dashboard/DashboardService';
import UserSettingService from "../../../../services/front/user/setting/UserSettingService";
import UserService from "../../../../services/front/user/UserService";
import UserAddress from "../user/address/UserAddress.vue";
import ChangePassword from "../user/change-password/ChangePassword.vue";
import UserAccountSecurity from "../user/UserAccountSecurity.vue";

const userSetting = new UserSettingService();
const dashboard = new DashboardService();
const user = new UserService();

export default {
    name: 'Dashboard',
    props:['userId','_token'],
    components: {
        ChangePassword,
        UserAddress,
        UserAccountSecurity
    },
    data(){
        return {
            edit: false,
            editSetting: false,
            editOrgSetting: false,
            menu: false,
            loading: false,
            isLoading: false,
            volunteering_type: null,
            requestCount: 0,
            responseCount: 0,
            gender_option:[
                { title: "Male", value: "male" },
                { title: "Female", value: "female" },
            ],
            userTypes:[
                { title: "Paid", value: "paid" },
                { title: "Unpaid", value: "unpaid" },
            ],
            userInfo: {},
            setting: {
                application_document_file: null,
                agreement_document_file: null,
                cv_file: null,
            }
        }
    },

    validations:{
      userInfo:{
            first_name:{required},
            last_name:{required},
            gender: {required},
            mobile: {required},
            date_of_birth: {required},
      },
      setting: {
        agreement_document_file: {required},
        application_document_file: {required: requiredIf(function() {
            return this.userInfo.account_type == 'beneficiary';
        })},
        blood_group: {required:requiredIf(function() {
            return this.editSetting;
        })
        },
        education: {required:requiredIf(function() {
            return this.editSetting;
        })
        },
        experience: {required:requiredIf(function() {
            return this.editSetting;
        }),
        },
        cv_file: {required:requiredIf(function() {
            return this.editSetting;
        }),
        },
        org_name: {required:requiredIf(function() {
            return this.editOrgSetting;
        }),
        },
        org_email: {required:requiredIf(function() {
            return this.editOrgSetting;
        }),
        },
        org_contact_name: {required:requiredIf(function() {
            return this.editOrgSetting;
        }),
        },
      }
    },

    mounted() {
        this.getUser();
        this.getStats();
    },

    methods:{
        cancel() {
            this.edit = false;
            this.getUser();
        },

        cancelSetting() {
            this.$v.setting.$reset();
            this.editSetting = false;
            this.getUser();
        },

        cancelOrgSetting() {
            this.$v.setting.$reset();
            this.editOrgSetting = false;
            this.getUser();
        },

        openAddress(field) {
            this.$refs['user-address'].openDialog(field);
        },

        openChangePassword() {
            this.$refs['change-password'].openDialog();
        },

        getUser() {
            user.show(this.userId).then(response => {
                this.userInfo = response.data.user;
                this.setting = this.userInfo.setting;
                this.volunteering_type = this.userInfo.user_type;
            }).catch(() => {})
        },

        getStats() {
            dashboard.getStats().then(response => {
                this.requestCount = response.data.requestCount;
                this.responseCount = response.data.responseCount;
            }).catch(() => {})
        },

        getMfaAuthenticatorCode() {
            this.$refs['user-account-security'].openMfaAuthenticator();
        },

        deActivateMfaAuthenticator() {
            this.$refs['user-account-security'].deActivateMfaAuthenticator();
        },

        getEmailAuthenticator() {
            this.$refs['user-account-security'].getEmailAuthenticator();
        },

        deActivateEmailAuthenticator() {
            this.$refs['user-account-security'].deactivateEmailAuthenticator();
        },

        generateSettingFd() {
            let fd = new FormData();
            for (let key in this.setting) {
                if (key == "application_document_file" && this.setting["application_document_file"] && this.setting["application_document_file"] != null) {
                    fd.append("application_document_file", this.setting[key]);
                } else if(key == "agreement_document_file" && this.setting["agreement_document_file"] && this.setting["agreement_document_file"] != null) {
                    if (this.setting[key] != null) {
                        fd.append("agreement_document_file", this.setting[key]);
                    }
                } else if(key == "cv_file" && this.setting["cv_file"] && this.setting["cv_file"] != null) {
                    if (this.setting[key] != null) {
                        fd.append("cv_file", this.setting[key]);
                    }
                } else {
                    if (this.setting[key] != null) {
                        fd.append(key, this.setting[key]);
                    }
                }
            }
            return fd;
        },

        generateFd() {
            let fd = new FormData();
            for (let key in this.userInfo) {
            if (
                key == "file" &&
                this.userInfo["file"] &&
                this.userInfo["file"].length > 0
            ) {

                fd.append("file", this.userInfo[key]);

            } else {
                if (this.userInfo[key] != null) {
                    fd.append(key, this.userInfo[key]);
                }
            }
            }
            return fd;
        },

        submitDocument() {
            this.$v.setting.$touch();
            if (this.$v.setting.$error) {
                setTimeout(() => {
                    this.$v.setting.$reset();
                }, 3000);
            } else {

                this.createOrUpdateSetting()
            }
        },

        createOrUpdate() {
            this.$v.userInfo.$touch()
            if (this.$v.userInfo.$error) {
                setTimeout(() => {
                    this.$v.userInfo.$reset();
                }, 10000);
            } else {
                this.updateProfile();
            }
        },

        updateProfile() {
            this.loading = true;
            let formData = this.generateFd();
            user.update(this.userInfo.id, formData).then(response => {
                if(response.data.status == "OK") {
                    this.$snotify.success('Update Successfully');
                    this.loading = false;
                    this.cancel();
                } else {
                    this.loading = false;
                    this.$snotify.error('Oops Something went wrong');
                }
            }).catch(() => {
                this.loading = false;
                this.$snotify.error('Oops Something went wrong');
            });

        },

        createOrUpdateSetting() {
            let fd = this.generateSettingFd();
            this.isLoading = true;
            if(this.userInfo.user_type && this.userInfo.user_type != this.volunteering_type) {
                user.update(this.userInfo.id, this.userInfo).then(response => {}).catch(() => {
                    this.$snotify.error('adadasd');
                });
            }
            userSetting
                .createOrUpdate(this.userInfo.id, fd)
                .then(() => {
                    this.isLoading = false;
                    this.$snotify.success("Updated successfully");
                    this.setting.application_document_file = null;
                    this.setting.agreement_document_file = null;
                    this.cancelSetting();
                    this.cancelOrgSetting();
                })
                .catch(error => {
                    this.isLoading = false;
                    this.$snotify.error("Oops Something Went Wrong");
                });
        }
    }
};
</script>
