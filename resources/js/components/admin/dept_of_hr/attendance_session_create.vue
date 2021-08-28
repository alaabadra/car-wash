<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="modal fade" id="addNew" data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="!editmode" id="addNewLabel">{{ $t('147') }}&nbsp;{{date}}</h5>
                                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="editmode" id="addNewLabel">{{ $t('147') }}&nbsp;{{date}}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form @submit.prevent="createLog()">
                                        <div class="modal-body">
                                            <div class="row justify-content-center">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="employee">{{ $t('59') }}<span style="color:red;">*</span></label>
                                                        <select name="employee" id="employee" v-model="form.employee" class="form-control">
                                                            <option v-for="emp in employees" :key="emp.id" :value="emp.id">{{ emp.first_name }} {{emp.last_name}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-danger" data-dismiss="modal">{{ $t('114') }}</button>
                                            <button v-show="editmode" type="submit" class="btn btn-success" style="color:white;">{{ $t('105') }}</button>
                                            <button v-show="!editmode" type="submit" class="btn btn-primary" style="color:white;">{{ $t('148') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <form>
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{ $t('184') }}</a>
                                    <a class="nav-item nav-link" id="nav-job_info-tab" data-toggle="tab" href="#nav-job_info"  role="tab"  aria-controls="nav-job_info" aria-selected="false">{{ $t('185') }}</a>
                                    <a class="nav-item nav-link" id="nav-att_info-tab" data-toggle="tab" href="#nav-att_info" role="tab" aria-controls="nav-att_info" aria-selected="false">{{ $t('186') }}</a>
                                </div>
                            </nav>

                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mt-4">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label style="color:gray;">{{ $t('188') }}</label><br>
                                                            <span>#{{session.session_num}}</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-4">
                                                        <div class="form-group">
                                                           <label style="color:gray;">{{ $t('190') }}</label><br>
                                                           <span>{{session.created_at}}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                           <label style="color:gray;">{{ $t('191') }}</label><br>
                                                           <span>{{session.source_type}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label style="color:gray;">{{ $t('192') }}</label><br>
                                                            <span>{{sign}}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label style="color:gray;">{{ $t('18') }}</label><br>
                                                            <span v-if="session.status==1" class="badge badge-sm badge-rounded badge-success">{{session.status ==1?'Active':'Stopped'}}</span>
                                                            <span v-if="session.status==2" class="badge badge-sm badge-rounded badge-danger">{{session.status ==1?'Active':'Stopped'}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="nav-job_info" role="tabpanel" aria-labelledby="nav-job_info-tab">
                                    <div class="container-fluid">
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <h5 class="mb-4 text-center">{{$t('193')}}</h5>
                                                <div class="card-body table-responsive p-0">
                                                    <table class="table table-bordered table-hover text-center">
                                                        <thead class="thead-light">
                                                                <tr>
                                                                    <th>{{ $t('109') }}</th>
                                                                    <th>{{ $t('59') }}</th>
                                                                    <th>{{ $t('187') }}</th>
                                                                    <th>{{ $t('188') }}</th>
                                                                    <th>{{ $t('189') }}</th>
                                                                    <th>{{ $t('18') }}</th>
                                                                    <th>{{ $t('110') }}</th>
                                                                </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="emp_log in loggs.data" :key="emp_log.id">
                                                                <td>{{emp_log.id}}</td>
                                                                <td>{{emp_log.employee_name}}</td>
                                                                <td>{{emp_log.source_type}}</td>
                                                                <td>#{{emp_log.session_num}}</td>
                                                                <td>{{emp_log.created_at}}</td>
                                                                <td>{{emp_log.status==1?'Active':'Inactive'}}</td>
                                                                <td>
                                                                    <a href="#" @click="deleteLog(emp_log.id)">
                                                                        <i class="fa fa-trash red" style="color:red;"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div><hr>
                                        <!-- <div class="card-footer">
                                            <pagination :data="logs" @pagination-change-page="getResults"></pagination>
                                        </div> -->
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="nav-att_info" role="tabpanel" aria-labelledby="nav-att_info-tab">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                            <div class="card mt-3 bg-light">
                                                <div class="row ml-4">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label>Today</label><br>
                                                            <p>المغسلة للكافيهات قام بإضافة جلسة حضور</p>&nbsp;
                                                              <span><i class="fas fa-clock"></i>&nbsp; 08:24:39</span>&nbsp;
                                                              <span><i class="fas fa-user"></i>&nbsp; Car Wash</span>&nbsp;
                                                              <span><i class="fas fa-home"></i>&nbsp; Root Branch</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
export default {
    props: ['employee'],
    data: function(){
        return{
            date:moment().format("YYYY-MM-DD"),
            sign:0,
            loggs:{},
            session:{},
            employees:[],
            editmode:false,
            form: new Form({
                id:'',
                employee:'',
            })
        }
    },

    methods:{
        loadLogs() {
            axios.get('api/emp_logs/'+this.form.id).then((response) => {
                this.loggs = response;
            });
            axios.get('api/get_all_employees').then((response)=>{
                this.employees=response.data;
            });
            axios.get('api/session_log/'+this.form.employee).then((response)=>{
                this.session=response.data;
            });
        },

        get_sign_num(){
            axios.get('api/sign_num/'+this.form.employee).then((response)=>{
                this.sign=response.data
            });
        },

        createLog(){
            this.$Progress.start();
            this.form.post('api/attendance_logs').then((res)=>{
                this.form.employee=res.data.id
                this.form.id=res.data.employee_name
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide')
                this.get_sign_num();
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Attendance Log Created successfully',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.$Progress.finish();
            });
        },

        deleteLog(id){
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    this.form.delete('api/attendance_logs/'+id).then(()=>{
                        swal.fire(
                            'Deleted!',
                            'Attendance Log has been deleted.',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    }).catch(()=> {
                        swal.fire("Failed!", "This Attendance Log assigned to an employee.", "warning");
                    });
                }
            })
        },

        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
    },

    created() {
        this.loadLogs();
        Fire.$on('AfterCreate',() => {
            this.loadLogs();
        });
    },

    mounted() {
        this.newModal();
    },
}
</script>
