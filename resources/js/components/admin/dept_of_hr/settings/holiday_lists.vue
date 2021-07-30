<template>
<div class="container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">{{$t('42')}}</h3>
                    <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">
                                <i class="fas fa-plus fa-fw"></i>&nbsp; {{ $t('177') }}
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
                                            <th>{{ $t('179') }}</th>
                                            <th>{{ $t('181') }}</th>
                                            <th>{{ $t('110') }}</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="holiday in holidays" :key="holiday.id">
                                        <td>{{ holiday.id }}</td>
                                        <td>{{ holiday.name }}</td>
                                        <td>{{ holiday.start_date }}</td>
                                        <td>{{ holiday.end_date }}</td>
                                        <td>
                                            <a href="#" @click="editModal(holiday)">
                                                <i class="fa fa-edit red"></i>
                                            </a>&nbsp;/
                                            <a href="#" @click="showHoliday(holiday.id)">
                                                <i class="fa fa-eye" style="color:green;"></i>
                                            </a>
                                            /
                                            <a href="#" @click="deleteHoliday(holiday.id)">
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
                    <h5 class="modal-title w-100 font-weight-bold py-2" v-show="!editmode" id="addNewLabel">{{ $t('178') }}</h5>
                    <h5 class="modal-title w-100 font-weight-bold py-2" v-show="editmode" id="addNewLabel">{{ $t('176') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateHoliday() : createHoliday()">
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
                                            <label for="start_date">{{$t('179')}}</label>
                                            <input type="date" class="form-control" v-model="form.start_date" name="start_date" id="start_date">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="end_date">{{$t('181')}}</label>
                                            <input type="date" class="form-control" v-model="form.end_date" name="end_date" id="end_date">
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

    <!-- show Holiday Modal -->
        <div class="modal fade" id="showTicket" tabindex="-1" role="dialog" aria-labelledby="showTicketLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center w-100 font-weight-bold py-2" v-show="!editmode" id="showTicketLabel">{{ $t('261') }}</h5>
                        <button type="button" style="color:black;" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="PrintTicket">
                        <table class="table table-bordered table-striped" id="shiftTable">
                            <tbody>
                                <tr>
                                    <th>{{ $t('109') }}</th>
                                    <td>{{ holiday.id }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t('229') }}</th>
                                    <td>
                                        {{ holiday.name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('67') }}</th>
                                    <td>
                                        {{ holiday.start_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('68') }}</th>
                                    <td>
                                        {{ holiday.end_date }}
                                    </td>
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
            holidays:{},
            holiday:{},
            editmode: false,
            form: new Form({
                id:'',
                name:'',
                name_ar:'',
                start_date:'',
                end_date:'',
            })
        }
    },
    methods:{

        getResults(page = 1) {
            axios.get('api/holiday_lists/?page=' + page).then((response) => {
                this.holidays = response.data;
            });
        },

        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        createHoliday(){
            this.$Progress.start();
            this.form.post('api/holiday_lists').then(()=>{
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Holiday Created successfully',
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

        updateHoliday() {
            this.$Progress.start();
            this.form.put('api/holiday_lists/'+ this.form.id)
                .then(() => {
                    // success
                    $('#addNew').modal('hide');
                    swal.fire(
                        'Updated!',
                        'Holiday has been updated.',
                        'success'
                    )
                    this.$Progress.finish();
                    Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },

        showHoliday(id){
            $('#showTicket').modal('show');
            this.form.get('api/holiday_show/'+id).then((response) => {
                this.holiday = response.data;
            });
        },

        deleteHoliday(id){
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
                    this.form.delete('api/holiday_lists/'+id).then(()=>{
                        swal.fire(
                            'Deleted!',
                            'Holiday has been deleted.',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    }).catch(()=> {
                        swal.fire("Failed!", "This Holiday is Error", "warning");
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
