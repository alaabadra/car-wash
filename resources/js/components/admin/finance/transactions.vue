<style scoped>
button{
    color:white;
}
</style>
<template>
    <div class="container">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $t('100') }}</h3>
                            <div class="card-tools">
                                <button class="btn btn-success" @click="newModal">
                                <i class="fas fa-plus fa-fw"></i>&nbsp; {{ $t('102') }}</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-bordered table-hover text-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>{{ $t('92') }}</th>
                                            <th>{{ $t('101') }}</th>
                                            <th>{{ $t('113') }}</th>
                                            <th>{{ $t('110') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="jor in jornals" :key="jor.id">
                                            <td>{{ jor.jor_number }}</td>
                                            <td>{{ jor.jor_date }}</td>
                                            <td>{{ jor.description }}</td>
                                            <td>
                                                <a href="#" @click="editModal(jor)">
                                                    <i class="fa fa-edit blue"></i>
                                                </a>
                                                /
                                                <a href="#" @click="deleteJornal(jor.id)">
                                                    <i class="fa fa-trash red"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal-->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="!editmode" id="addNewLabel">{{ $t('104') }} {{ $t('108') }}</h5>
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="editmode" id="addNewLabel">{{ $t('105') }} {{ $t('108') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="editmode ? updateJornal() : createJornal()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group my-3">
                                        <div class="input-group-prepend">
                                            <label for="jor_date" class="input-group-text">{{ $t('101') }}</label>
                                        </div>
                                        <input v-model="form.jor_date" type="date" name="jor_date" class="form-control">
                                    </div>

                                    <div class="input-group my-3">
                                        <div class="input-group-prepend">
                                            <label for="jor_number" class="input-group-text">{{ $t('112') }}</label>
                                        </div>
                                        <input v-model="form.jor_number" disabled type="text" name="jor_number" placeholder="Number" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group mt-2">
                                        <div class="input-group-prepend">
                                            <label for="description" class="input-group-text">{{ $t('113') }}</label>
                                        </div>
                                        <textarea v-model="form.description" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $t('91') }}</h3>
                                    <div class="card-tools">
                                        <button class="btn btn-success" type="button" @click="newModalDetails">
                                        <i class="fas fa-plus fa-fw"></i>&nbsp; {{ $t('102') }}</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-bordered table-hover text-center">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>{{ $t('116') }}</th>
                                                    <th>{{ $t('117') }}</th>
                                                    <th>{{ $t('118') }}</th>
                                                    <th>{{ $t('113') }}</th>
                                                    <th>{{ $t('110') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="jor_detail in jornal_details" :key="jor_detail.id">
                                                    <td>{{ jor_detail.acc_name }}</td>
                                                    <td>{{ jor_detail.depit }}</td>
                                                    <td>{{ jor_detail.credit }}</td>
                                                    <td>{{ jor_detail.description }}</td>
                                                    <td>
                                                        <a href="#" @click="editModalDetails(jor_detail)">
                                                            <i class="fa fa-edit blue"></i>
                                                        </a>
                                                        /
                                                        <a href="#" @click="deleteModalDetails(jor_detail.id)">
                                                            <i class="fa fa-trash red"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $t('114') }}</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">{{ $t('105') }}</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">{{ $t('104') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addNewDetails" tabindex="-1" role="dialog" aria-labelledby="addNewDetailsLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="!editmode1" id="addNewDetailsLabel">{{ $t('104') }} {{ $t('91') }}</h5>
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="editmode1" id="addNewDetailsLabel">{{ $t('105') }} {{ $t('91') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="editmode1 ? updateJornalDetails() : createJornalDetails()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="acc_name" class="control-label">{{ $t('116') }}</label>
                                        <input type="text" v-model="detailsForm.acc_name" name="acc_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="description">{{ $t('113') }}</label>
                                        <textarea class="form-control" cols="30" type="text"  v-model="detailsForm.description" name="description" id="description"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="depit" class="control-label">{{ $t('117') }}</label>
                                        <input type="number" v-model="detailsForm.depit" name="depit" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="credit" class="control-label">{{ $t('118') }}</label>
                                        <input type="number" v-model="detailsForm.credit" name="credit" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $t('114') }}</button>
                            <button v-show="editmode1" type="submit" class="btn btn-success">{{ $t('105') }}</button>
                            <button v-show="!editmode1" type="submit" class="btn btn-primary">{{ $t('104') }}</button>
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
            editmode1:false,
            jornals:{},
            jornal_details:{},
            jornal_new_id:'',
            form: new Form({
                id:'',
                jor_date:new Date().toISOString().substr(0, 10),
                jor_number: '',
                description: '',
            }),

            detailsForm:new Form({
                id:'',
                jornal_id:'',
                acc_name:'',
                description:'',
                depit:'',
                credit:'',
            })
        }
    },
    methods: {
        getResults(page = 1) {
            axios.get('api/jornals/?page=' + page).then((response) => {
                this.jornals = response.data;
            });
        },

        newModal() {
            this.editmode = false;
            this.form.reset();
            this.getJornalId()
            $('#addNew').modal('show');
        },

        getJornalId(){
            axios.get('api/get_jornal_id').then((response) => {
                this.form.jor_number = response.data;
                this.jornal_id = response.data;
            });
        },

        createJornal(){
            this.$Progress.start();
            this.form.post('api/jornals').then(()=>{
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Role Created successfully',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.$Progress.finish();
            })
        },

        editModal(user){
            this.editmode = true;
            this.form.reset();
            this.getJornalDetails(user.id);
            $('#addNew').modal('show');
            this.form.fill(user);
        },

        updateJornal(){
            this.$Progress.start();
            this.form.put('api/jornals/'+this.form.id).then(() => {
                $('#addNew').modal('hide');
                swal.fire(
                    'Updated!',
                    'Information has been updated.',
                    'success'
                )
                this.$Progress.finish();
                Fire.$emit('AfterCreate');
            })
            .catch(() => {
                this.$Progress.fail();
            });
        },

        deleteJornal(id){
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
                    this.form.delete('api/jornals/'+id).then(()=>{
                        swal.fire(
                            'Deleted!',
                            'Jornal has been deleted.',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    }).catch(()=> {
                        swal.fire("Failed!", "This Role assigned to an employee.", "warning");
                    });
                }
            })
        },

        getJornalDetails(id,page = 1){
            this.detailsForm.jornal_id=id
            axios.get('api/jornal_details/'+id+'/?page=' + page).then((response) => {
                this.jornal_details = response.data;
            });
        },

        newModalDetails() {
            this.editmode1 = false;
            this.detailsForm.reset();
            this.detailsForm.jornal_id=this.form.jor_number
            $('#addNewDetails').modal('show');
        },

        createJornalDetails(){
            this.$Progress.start();
            this.detailsForm.post('api/jornal_details_create').then(()=>{
                Fire.$emit('AfterCreateDetail');
                $('#addNewDetails').modal('hide')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Role Created successfully',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.$Progress.finish();
            })
        },

        editModalDetails(user){
            this.editmode1 = true;
            this.detailsForm.reset();
            $('#addNewDetails').modal('show');
            this.detailsForm.fill(user);
        },

        updateJornalDetails(){
            this.$Progress.start();
            this.detailsForm.post('api/jornal_details_update').then(() => {
                $('#addNewDetails').modal('hide');
                swal.fire(
                    'Updated!',
                    'Information has been updated.',
                    'success'
                )
                this.$Progress.finish();
                Fire.$emit('AfterCreateDetail');
            })
            .catch(() => {
                this.$Progress.fail();
            });
        },

        deleteModalDetails(id){
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
                    axios.get('api/jornal_details_delete/'+id).then(()=>{
                        swal.fire(
                            'Deleted!',
                            'Jornal has been deleted.',
                            'success'
                        )
                        Fire.$emit('AfterCreateDetail');
                    }).catch(()=> {
                        swal.fire("Failed!", "This Role assigned to an employee.", "warning");
                    });
                }
            })
        },
    },

    created() {
        this.getResults();
        Fire.$on('AfterCreate',() => {
            this.getResults();
        });
        Fire.$on('AfterCreateDetail',() => {
            this.getJornalDetails(this.detailsForm.jornal_id);
        });
    },
}
</script>
