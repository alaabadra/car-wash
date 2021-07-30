<template>
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title">{{ $t('140') }}</h3>
                            <div class="card-tools">
                                <div class="input-group mr-3">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-success">{{ $t('102') }}</button>
                                        <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu">
                                        <button class="dropdown-item" style="hover:light"  @click="pullFromMachine">{{ $t('141') }}</button>
                                        <router-link :to="{ path: '/attendance_session_create'}" class="dropdown-item">
                                            {{ $t('142') }}
                                        </router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
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
                                        <tr v-for="log in logs.data" :key="log.id">
                                            <td>{{log.id}}</td>
                                            <td>{{log.employee_name}}</td>
                                            <td>{{log.source_type}}</td>
                                            <td>#{{log.session_num}}</td>
                                            <td>{{log.created_at}}</td>
                                            <td>{{log.status==1?'Active':'Inactive'}}</td>
                                            <td>
                                                <a href="#" @click="deleteLog(log.id)">
                                                    <i class="fa fa-trash red" style="color:red;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer">
                        <pagination :data="logs" @pagination-change-page="getResults"></pagination>
                       </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="pullFromMachine" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="!editmode" id="addNewLabel">{{ $t('143') }}</h5>
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="editmode" id="addNewLabel">{{ $t('143') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="machine">{{ $t('144') }}<span style="color:red;">*</span></label>
                                        <select name="machine" id="machine"  v-model="form.machine" class="form-control">
                                            <option value="-1">{{ $t('145') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $t('114') }}</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">{{ $t('105') }}</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">{{ $t('146') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            editmode: false,
            logs:{},
            form: new Form({
                machine:-1,
            }),
        }
    },
    methods: {

        getResults(page = 1) {
            axios.get('api/attendance_logs/?page=' + page).then((response) => {
                this.logs = response.data;
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

        pullFromMachine() {
            this.editmode = false;
            this.form.reset();
            $('#pullFromMachine').modal('show');
        },
    },

    created() {
        this.getResults();
        Fire.$on('AfterCreate',() => {
            this.getResults();
        });
    },

}
</script>

