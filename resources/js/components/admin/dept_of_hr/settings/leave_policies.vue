<template>
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title">{{$t('160')}}</h3>
                            <div class="card-tools">
                                <button class="btn btn-success" @click="newModal">
                                    <i class="fas fa-plus fa-fw"></i>&nbsp; {{ $t('159') }}
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-bordered table-hover text-center">
                                    <thead class="thead-light">
                                            <tr>
                                                <th>{{ $t('109') }}</th>
                                                <th>{{ $t('229') }}</th>
                                                <th>{{ $t('174') }}</th>
                                                <th>{{ $t('110') }}</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="type in types" :key="type.id">
                                            <td>{{ type.id }}</td>
                                            <td :style="{color:type.colour}">{{ type.name }}</td>
                                            <td :style="{color:type.colour}">{{ type.max_days }}</td>
                                            <td>
                                                <a href="#" @click="editModal(type)">
                                                    <i class="fa fa-edit red"></i>
                                                </a>&nbsp;/
                                                <a href="#" @click="showLeave(type.id)">
                                                    <i class="fa fa-eye" style="color:green;"></i>
                                                </a>
                                                /
                                                <a href="#" @click="deleteLeave(type.id)">
                                                    <i class="fa fa-trash" style="color:red;"></i>
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
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="!editmode" id="addNewLabel">{{ $t('162') }}</h5>
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="editmode" id="addNewLabel">{{ $t('161') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateLeave() : createLeave()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="name">{{$t('50')}}<span style="color:red;">*</span></label>
                                                 <input type="text" placeholder="Name" class="form-control" v-model="form.name" name="name" id="name">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="name_ar">{{$t('56')}}<span style="color:red;">*</span></label>
                                                 <input type="text" placeholder="Name_ar" class="form-control" v-model="form.name_ar" name="name_ar" id="name_ar" dir="rtl">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="colour" class="control-label">{{$t('149')}}</label>
                                                <input v-model="form.colour" type="color" name="colour" placeholder="Flag colour" class="form-control" :class="{ 'is-invalid': form.errors.has('colour') }">
                                                <has-error :form="form" field="colour"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="description">{{$t('113')}}</label>
                                                <textarea class="form-control" id="description" name="description" v-model="form.description" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div><hr>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="max_days">{{$t('171')}}<span style="color:red;">*</span></label>
                                                <input type="number" class="form-control" v-model="form.max_days" name="max_days" id="max_days">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="max_applicable_days">{{$t('172')}}</label>
                                                <input type="number" class="form-control" v-model="form.max_applicable_days" name="max_applicable_days" id="max_applicable_days">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="applicable_after">{{$t('173')}}</label>
                                                <input type="number" class="form-control" v-model="form.applicable_after" name="applicable_after" id="applicable_after">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" style="color:white;">{{ $t('114') }}</button>
                            <button v-show="editmode" type="submit" class="btn btn-success" style="color:white;">{{ $t('105') }}</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary" style="color:white;">{{ $t('104') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- show Leave Modal -->
        <div class="modal fade" id="showTicket" tabindex="-1" role="dialog" aria-labelledby="showTicketLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center w-100 font-weight-bold py-2" v-show="!editmode" id="showTicketLabel">{{ $t('262') }}</h5>
                        <button type="button" style="color:black;" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="PrintTicket">
                        <table class="table table-bordered table-striped" id="shiftTable">
                            <tbody>
                                <tr>
                                    <th>{{ $t('109') }}</th>
                                    <td :style="{color:type.colour}">{{ type.id }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t('229') }}</th>
                                    <td :style="{color:type.colour}">{{ type.name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t('113') }}</th>
                                    <td :style="{color:type.colour}">{{ type.description }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t('174') }}</th>
                                    <td :style="{color:type.colour}">{{ type.max_days }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t('263') }}</th>
                                    <td :style="{color:type.colour}">{{ type.max_applicable_days }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t('173') }}</th>
                                    <td :style="{color:type.colour}">{{ type.applicable_after }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $t('114') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function(){
        return{
            types:{},
            type:{},
            editmode: false,
            form: new Form({
                 id:'',
                name:'',
                name_ar:'',
                colour:'',
                description:'',
                max_days:'',
                max_applicable_days:'',
                applicable_after:'',
            })
        }
    },
    methods:{

        getResults(page = 1) {
            axios.get('api/leave_policies/?page=' + page).then((response) => {
                this.types = response.data;
            });
        },

        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        createLeave(){
            this.$Progress.start();
            this.form.post('api/leave_policies').then(()=>{
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Leave Created successfully',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.$Progress.finish();
            })
        },

        editModal(user){
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(user);
        },

        updateLeave() {
            this.$Progress.start();
            this.form.put('api/leave_policies/'+ this.form.id)
                .then(() => {
                    // success
                    $('#addNew').modal('hide');
                    swal.fire(
                        'Updated!',
                        'Leave has been updated.',
                        'success'
                    )
                    this.$Progress.finish();
                    Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },

        showLeave(id){
            $('#showTicket').modal('show');
            this.form.get('api/leave_show/'+id).then((response) => {
                this.type = response.data;
            });
        },

        deleteLeave(id){
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
                    this.form.delete('api/leave_policies/'+id).then(()=>{
                        swal.fire(
                            'Deleted!',
                            'Leave Type has been deleted.',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    }).catch(()=> {
                        swal.fire("Failed!", "This Leave is Error", "warning");
                    });
                }
            })
        },
    },

    created(){
        this.getResults();
        Fire.$on('AfterCreate',() => {
            this.getResults();
        });
    }
}
</script>
