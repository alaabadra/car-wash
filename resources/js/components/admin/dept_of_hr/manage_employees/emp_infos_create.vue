<style>
    button{
        color:white;
    }
    .btn{
        color:white;
    }
    label{
        font-weight: 500;
    }
    section{
        padding: 60px 0;
    }

    #accordion-style-1 h1,#accordion-style-1 a{
        color:#007b5e;
    }

    #accordion-style-1 .btn-link {
        font-weight: 400;
        color:royalblue;
        background-color: transparent;
        text-decoration: none !important;
        font-size: 16px;
        font-weight: bold;
        padding-left: 25px;
    }

    #accordion-style-1 .card-header .btn.collapsed .fa.main{
        display:none;
    }

    #accordion-style-1 .card-header .btn .fa.main{
        background: royalblue;
        padding: 13px 11px;
        color: #ffffff;
        width: 35px;
        height: 41px;
        position: absolute;
        left: -1px;
        top: 10px;
        border-top-right-radius: 7px;
        border-bottom-right-radius: 7px;
        display:block;
    }
</style>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="createUser()" enctype="multipart/form-data">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{ $t('44') }}</a>
                                    <a class="nav-item nav-link" id="nav-personal_prof-tab" data-toggle="tab" href="#nav-personal_prof"  role="tab"  aria-controls="nav-personal_prof" aria-selected="false">{{ $t('45') }}</a>
                                    <a class="nav-item nav-link" id="nav-job_info-tab" data-toggle="tab" href="#nav-job_info"  role="tab"  aria-controls="nav-job_info" aria-selected="false">{{ $t('46') }}</a>
                                    <a class="nav-item nav-link" id="nav-att_info-tab" data-toggle="tab" href="#nav-att_info" role="tab" aria-controls="nav-att_info" aria-selected="false">{{ $t('47') }}</a>
                                </div>
                            </nav>

                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mt-4"  dir="rtl">
                                                    <div class="col-4">
                                                        <div class="form-group text-right">
                                                            <label class="required" for="fist_name">الإســم الأول <span style="color:red">*</span></label>
                                                            <input class="form-control"  v-model="form.first_name" type="text" name="fist_name" id="fist_name" :class="{ 'is-invalid': form.errors.has('fist_name') }" dir="rtl">
                                                            <has-error :form="form" field="fist_name"></has-error>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group text-right">
                                                            <label for="sir_name">الإســم الثانى </label>
                                                            <input class="form-control"  v-model="form.sir_name" type="text" name="sir_name" id="sir_name"  dir="rtl">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group text-right">
                                                            <label for="last_name">الإســم الثالث <span style="color:red">*</span></label>
                                                            <input class="form-control"  v-model="form.last_name" type="text" name="last_name" id="last_name"  dir="rtl">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label class="required" for="fist_name_en">First Name<span style="color:red">*</span></label>
                                                            <input class="form-control"  v-model="form.fist_name_en" type="text" name="fist_name_en" id="fist_name_en" :class="{ 'is-invalid': form.errors.has('fist_name_en') }">
                                                            <has-error :form="form" field="fist_name_en"></has-error>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="sir_name_en">Second Name</label>
                                                            <input class="form-control"  v-model="form.sir_name_en" type="text" name="sir_name_en" id="sir_name_en">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="last_name_en">Third Name<span style="color:red">*</span></label>
                                                            <input class="form-control"  v-model="form.last_name_en" type="text" name="last_name_en" id="last_name_en">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="emp_picture">{{ $t('13') }}</label>
                                                            <div class="custom-file">
                                                                <input type="file" id="emp_picture" name="emp_picture" class="custom-file-input" data-locale="en" @change="updateProfile">
                                                                <label class="custom-file-label" for="emp_picture">{{ $t('14') }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="notes">{{ $t('15') }}</label>
                                                            <textarea class="form-control" cols="30" type="text"  v-model="form.notes" name="notes" id="notes"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row mt-4">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="email" class="required">{{ $t('16') }}<span style="color:red">*</span></label>
                                                            <input class="form-control"  v-model="form.email" type="text" name="email" id="email" :class="{ 'is-invalid': form.errors.has('email') }">
                                                            <has-error :form="form" field="email"></has-error>
                                                        </div>
                                                        <div class="form-check pt-2 ml-3">
                                                            <input class="form-check-input" name="send_credentials" v-model="form.send_credentials" type="checkbox" value="" id="defaultCheck">
                                                            <label class="form-check-label" for="defaultCheck">
                                                                {{ $t('17') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="status" class="required">{{ $t('18') }}<span style="color:red">*</span></label>
                                                            <select name="status" id="status"  v-model="form.status" class="form-control">
                                                                <option value="1">{{ $t('19') }}</option>
                                                                <option value="2">{{ $t('20') }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-check pt-2 ml-3">
                                                            <input class="form-check-input" name="allow_access" v-model="form.allow_access" type="checkbox" value="" id="defaultCheck1">
                                                            <label class="form-check-label" for="defaultCheck1">{{ $t('21') }}</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4" v-show="form.allow_access">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="language" class="required">{{ $t('22') }}<span style="color:red">*</span></label>
                                                            <select name="language" v-model="form.language" id="language" class="form-control">
                                                                <option value="1">{{ $t('4') }}</option>
                                                                <option value="2">{{ $t('5') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="role" class="required">{{ $t('23') }}<span style="color:red">*</span></label>
                                                            <select name="role" v-model="form.role" id="role" class="form-control">
                                                                <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><hr>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="nav-personal_prof" role="tabpanel" aria-labelledby="nav-personal_prof-tab">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mt-4">
                                                    <div class="col-6 mt-3">
                                                            <div class="form-group">
                                                                <label class="required" for="date_of_birth">{{ $t('24') }}<span style="color:red">*</span></label>
                                                                <input type="date" id="date_of_birth" name="date_of_birth"  v-model="form.date_of_birth" class="form-control"  :class="{ 'is-invalid': form.errors.has('date_of_birth') }">
                                                                <has-error :form="form" field="date_of_birth"></has-error>
                                                            </div>
                                                    </div>
                                                    <div class="col-6 mt-3">
                                                        <div class="form-group">
                                                            <label for="date_of_birth">{{ $t('25') }}</label>
                                                            <select name="gender"  v-model="form.gender" id="gender" class="form-control">
                                                                <option value="1">{{ $t('26') }}</option>
                                                                <option value="2">{{ $t('27') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 mt-3">
                                                        <div class="form-group">
                                                            <label for="country" class="required">{{ $t('28') }} <span style="color:red">*</span></label>
                                                            <select name="country"  v-model="form.country" id="country" class="form-control">
                                                                <option value="1">Egypt</option>
                                                                <option value="2">Saudi Arabia</option>
                                                                <option value="3">Jordan</option>
                                                                <option value="4">Syria</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 mt-3">
                                                        <div class="form-group">
                                                            <label for="mobile_number">{{ $t('29') }}</label>
                                                            <input type="text" id="mobile_number"  v-model="form.mobile_number" name="mobile_number" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><hr>
                                    </div>
                                    <!-- Accordion -->
                                    <div class="container-fluid bg-light" id="accordion-style-1">
                                        <div class="row">
                                            <div class="col-12 mx-auto">
                                                <div class="accordion mt-3" id="accordionExample">
                                                    <div class="card">
                                                        <div class="card-header" id="headingTwo">
                                                            <h5 class="mb-0">
                                                                <button class="btn btn-link collapsed btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                    <i class="fa fa-home main"></i><i class="fa fa-angle-double-right mr-3"></i>{{ $t('30') }}
                                                                </button>
                                                            </h5>
                                                        </div>
                                                        <div id="collapseTwo" class="collapse fade" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-6 mt-3">
                                                                        <div class="form-group">
                                                                            <label for="address">{{ $t('30') }}</label>
                                                                            <input type="text"  v-model="form.present_address" id="present_address" name="present_address" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 mt-3">
                                                                        <div class="form-group">
                                                                            <label for="city">{{ $t('31') }}</label>
                                                                            <input type="text"  v-model="form.present_city" id="present_city" name="present_city" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6 mt-3">
                                                                        <div class="form-group">
                                                                            <label for="state">{{ $t('32') }}</label>
                                                                            <input type="text" id="present_state"  v-model="form.present_state" name="present_state" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div class="card-header" id="headingTwo">
                                                            <h5 class="mb-0">
                                                                <button class="btn btn-link collapsed btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                    <i class="fa fa-home main"></i><i class="fa fa-angle-double-right mr-3"></i>{{ $t('33') }}
                                                                </button>
                                                            </h5>
                                                        </div>
                                                        <div id="collapseThree" class="collapse fade" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-6 mt-3">
                                                                        <div class="form-group">
                                                                            <label for="address">{{ $t('34') }}</label>
                                                                            <input type="text" id="perm_address" name="perm_address" v-model="form.perm_address" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 mt-3">
                                                                        <div class="form-group">
                                                                            <label for="city">{{ $t('31') }}</label>
                                                                            <input type="text" id="perm_city" name="perm_city" v-model="form.perm_city" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6 mt-3">
                                                                        <div class="form-group">
                                                                            <label for="state">{{ $t('32') }}</label>
                                                                            <input type="text" id="perm_state" name="perm_state" v-model="form.perm_state" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><hr>
                                    <!-- .// Accordion -->
                                </div>

                                <div class="tab-pane fade" id="nav-job_info" role="tabpanel" aria-labelledby="nav-job_info-tab">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mt-4">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="designation">{{ $t('35') }}</label>
                                                            <select name="designation" v-model="form.designation" id="designation" class="form-control">
                                                                <option value="-1">{{ $t('115') }}</option>
                                                                <option v-for="des in designations" :key="des.id" :value="des.id">{{ des.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="department">{{ $t('36') }}</label>
                                                            <select name="department" v-model="form.department" id="department" class="form-control">
                                                                <option value="-1">{{ $t('115') }}</option>
                                                                <option v-for="dep in departments" :key="dep.id" :value="dep.id">{{ dep.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 mt-3">
                                                        <div class="form-group">
                                                            <label for="emp_level">{{ $t('37') }}</label>
                                                            <select name="emp_level" v-model="form.emp_level" id="emp_level" class="form-control">
                                                                <option value="-1">{{ $t('115') }}</option>
                                                                <option v-for="emp in employments" :key="emp.id" :value="emp.id">{{ emp.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 mt-3">
                                                        <div class="form-group">
                                                            <label class="required" for="join_date">{{ $t('38') }}<span style="color:red">*</span></label>
                                                            <input type="date" id="join_date" name="join_date" v-model="form.join_date" class="form-control" :class="{ 'is-invalid': form.errors.has('join_date') }">
                                                            <has-error :form="form" field="join_date"></has-error>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 mt-3">
                                                        <div class="form-group">
                                                            <label for="salary">{{ $t('253') }}<span style="color:red">*</span></label>
                                                            <input type="number" id="salary" name="salary" v-model="form.salary" class="form-control" :class="{ 'is-invalid': form.errors.has('salary') }">
                                                            <has-error :form="form" field="salary"></has-error>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 mt-3">
                                                        <div class="form-group">
                                                            <label for="branch" class="required">{{ $t('39') }}<span style="color:red">*</span></label>
                                                            <select name="branch" v-model="form.branch" id="branch" class="form-control">
                                                                <option value="1">Main Branch</option>
                                                                <option value="2">Assiut Branch</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><hr>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="nav-att_info" role="tabpanel" aria-labelledby="nav-att_info-tab">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mt-4">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="attendance_shift">{{ $t('40') }}</label>
                                                            <select name="attendance_shift" v-model="form.attendance_shift" id="attendance_shift" class="form-control">
                                                                <option value="-1">{{ $t('115') }}</option>
                                                                <option v-for="att in attendances" :key="att.id" :value="att.id">{{ att.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="leave_policy">{{ $t('41') }}</label>
                                                            <select name="leave_policy" v-model="form.leave_policy" id="leave_policy" class="form-control">
                                                                <option value="-1">{{ $t('115') }}</option>
                                                                <option v-for="lev in leaves" :key="lev.id" :value="lev.id">{{ lev.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 mt-3">
                                                        <div class="form-group">
                                                            <label for="name">{{ $t('42') }}</label>
                                                            <select name="holiday_lists" v-model="form.holiday_lists" id="holiday_lists" class="form-control">
                                                                <option value="-1">{{ $t('115') }}</option>
                                                                <option v-for="hol in holidays" :key="hol.id" :value="hol.id">{{ hol.name }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="form-group pt-2 ml-3 float-right">
                                            <button class="btn btn-success" type="submit">{{ $t('121') }}</button>
                                            <router-link :to="{ path: '/manage_emp'}" class="btn btn-danger">{{ $t('43') }}</router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--
                    <div class="card-footer">
                        <ul class="pagination justify-content-end">
                            <li class="page-item previous">
                                <a class="nav-item page-link"  data-toggle="tab" @click="decrement_var" :href="'#'+tabs[next]" role="tab" :aria-controls="tabs[next]" aria-selected="true">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                            </li>&nbsp;

                            <li class="page-item next">
                                <a class="nav-item page-link" data-toggle="tab" @click="increment_var" :href="'#'+tabs[next]" role="tab" :aria-controls="tabs[next]" aria-selected="true">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['employee'],
    data: function(){
        return{
            roles:{},
            designations:{},
            departments:{},
            employments:{},
            attendances:{},
            leaves:{},
            holidays:{},

            form: new Form({
                id:'',
                first_name:'',
                sir_name:'',
                last_name:'',
                fist_name_en:'',
                sir_name_en:'',
                last_name_en:'',
                emp_picture:'',
                notes:'',
                email:'',
                status:1,
                send_credentials:'',
                allow_access:0,
                language:1,
                role:'',
                date_of_birth:'',
                gender:1,
                country:1,
                mobile_number:'',
                present_address:'',
                present_city:'',
                present_state:'',
                perm_address:'',
                perm_city:'',
                perm_state:'',
                designation:-1,
                department:-1,
                emp_level:-1,
                join_date:'',
                branch:1,
                salary:0,
                attendance_shift:-1,
                leave_policy:-1,
                holiday_lists:-1,
            })
        }
    },

    methods:{
        getDesignations(){
            axios.get('api/organizational_structure_designations').then((res)=>{
                this.designations=res.data;
            });
            this.getDepartments()
            this.getEmployments()

            this.getHolidays()
            this.getLeaves()
            this.getAttendances()
        },

        getDepartments(){
            axios.get('api/organizational_structure_departments').then((res)=>{
                this.departments=res.data;
            });
        },

        getEmployments(){
            axios.get('api/organizational_structure_employments').then((res)=>{
                this.employments=res.data;
            });
        },

        getHolidays() {
            axios.get('api/get_holidays').then((response) => {
                this.holidays = response.data
            });
        },

        getLeaves() {
            axios.get('api/get_leaves').then((response) => {
                this.leaves = response.data;
            });
        },

        getAttendances(){
            axios.get('api/get_shifts').then((response) => {
                this.attendances = response.data
            });
        },

        get_roles(){
            axios.get('api/permission_roles').then((res)=>{
                this.roles=res.data
                if(res.data!='')
                this.form.role=res.data[0]['id']
            })
        },

        loadUsers(){
            if(this.form.id!=undefined)
                axios.get('api/manage_emp/'+this.form.id).then((res)=>{
                    this.form.fill(res.data)
                })
            this.get_roles()
        },

        updateProfile(e) {
            let file = e.target.files[0];
            let reader = new FileReader();
            let limit = 1024 * 1024 * 2;
            if (file['size'] > limit) {
                swal({
                    type: 'error',
                    title: 'Oops...',
                    text: 'You are uploading a large file',
                })
                return false;
            }
            reader.onloadend = (file) => {
                this.form.emp_picture = reader.result;
            }
            reader.readAsDataURL(file);
        },

        createUser(){
            this.$Progress.start();
            this.form.post('api/manage_emp').then(()=>{
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Employee Created successfully',
                    showConfirmButton: false,
                    timer: 1500
                })
            })
            this.$Progress.finish();
        },
    },

    created() {
        this.form.id = this.$route.query.employee;
        this.loadUsers()
        this.getDesignations()
    },
}

</script>
