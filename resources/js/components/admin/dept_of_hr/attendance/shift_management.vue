<style scoped>
button{
    color:white;
}
#shiftTable th{
    width: 300px;
}
</style>
<template>
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title">{{ $t('65') }}</h3>
                            <div class="card-tools" >
                                <button class="btn btn-success" @click="newModal">
                                    <i class="fas fa-plus fa-fw"></i>&nbsp; {{ $t('66') }}
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
                                            <th>{{ $t('67') }}</th>
                                            <th>{{ $t('68') }}</th>
                                            <th>{{ $t('69') }}</th>
                                            <th>{{ $t('70') }}</th>
                                            <th>{{ $t('110') }}</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="shift in shifts" :key="shift.id">
                                        <td>{{ shift.id }}</td>
                                        <td>{{ shift.name }}</td>
                                        <td>{{ shift.on_duty_time1 }}</td>
                                        <td>{{ shift.off_duty_time1 }}</td>
                                        <td>{{ shift.begin1 }}</td>
                                        <td>{{ shift.end1 }}</td>
                                        <td>
                                            <a href="#" @click="editShift(shift)">
                                                <i class="fa fa-edit blue"></i>
                                            </a>
                                            /
                                            <a href="#" @click="showShift(shift.id)">
                                                <i class="fa fa-eye" style="color:green;"></i>
                                            </a>
                                            /
                                            <a href="#" @click="deleteShift(shift.id)">
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
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="!editmode" id="addNewLabel">{{ $t('66') }}</h5>
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="editmode" id="addNewLabel">{{ $t('105') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="row">
                               <div class="form-group col-md-6">
                                    <label for="name" class="control-label">{{ $t('50') }} *</label>
                                    <input v-model="form.name" type="text" name="name" placeholder="English Description" class="form-control">
                                    <has-error :form="form" field="name"></has-error>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="name" class="control-label">{{ $t('56') }} *</label>
                                    <input v-model="form.name_ar" type="text" name="name_ar" placeholder="Arabic Description" class="form-control" dir="rtl">
                                    <has-error :form="form" field="name_ar"></has-error>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="on_duty_time1">{{ $t('67') }} *</label>
                                    <div>
                                        <input type="time" name="on_duty_time1" v-model="form.on_duty_time1" id="on_duty_time1" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="off_duty_time1">{{ $t('68') }} *</label>
                                    <div>
                                        <input type="time" name="off_duty_time1" v-model="form.off_duty_time1" id="off_duty_time1" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="begin1">{{ $t('69') }} *</label>
                                    <div>
                                        <input type="time" name="begin1" v-model="form.begin1" id="begin1" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="end1">{{ $t('70') }} *</label>
                                    <div>
                                        <input type="time" name="end1" v-model="form.end1" id="end1" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div v-if="form.assign_another_shift==1">
                                <fieldset style="border:1px solid black">
                                    <legend>
                                        &nbsp;&nbsp; {{ $t('95') }} {{ $t('71') }}
                                    </legend>
                                    <div class="row container">
                                        <div class="form-group col-md-6">
                                            <label for="on_duty_time2">{{ $t('67') }} * ({{ $t('71') }} 2)</label>
                                            <div>
                                                <input type="time" name="on_duty_time2" v-model="form.on_duty_time2" id="on_duty_time2" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="off_duty_time">{{ $t('68') }} * ({{ $t('71') }} 2)</label>
                                            <div>
                                                <input type="time" name="off_duty_time2" v-model="form.off_duty_time2" id="off_duty_time2" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row container">
                                        <div class="form-group col-md-6">
                                            <label for="begin2">{{ $t('69') }} * ({{ $t('71') }} 2)</label>
                                            <div>
                                                <input type="time" name="begin2" v-model="form.begin2" id="begin2" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="end2">{{ $t('70') }} * ({{ $t('71') }} 2)</label>
                                            <div>
                                                <input type="time" name="end2" v-model="form.end2" id="end2" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label">{{ $t('72') }}</label>
                                    <v-select multiple  :options="week_days_all"  label="week_days" id="week_days" name="week_days" v-model="form.week_days"></v-select>
                                </div>

                                <div class="form-group col-md-6" style="margin-top:10px">
                                    <label class="control-label"></label>
                                    <div class="custom-control custom-switch custom-switch-on-success">
                                        <input type="checkbox"  class="custom-control-input" id="assign_another_shift" checked name="assign_another_shift" v-model="form.assign_another_shift">
                                        <label class="custom-control-label" for="assign_another_shift">{{ $t('73') }}</label>
                                    </div>
                                </div>
                            </div><br>

                            <div class="row">
                                <div class="form-group col-md-6" style="margin-top:-20px">
                                    <label class="control-label"></label>
                                    <div class="custom-control custom-switch custom-switch-on-success">
                                        <input type="checkbox"  class="custom-control-input" id="start_late" checked name="start_late" v-model="form.start_late">
                                        <label class="custom-control-label" for="start_late">{{ $t('74') }}</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <input :disabled="disable_late()" v-model="form.late_minutes" type="number" name="late_minutes" class="form-control">
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

        <!-- show Shift Modal -->
        <div class="modal fade" id="showTicket" tabindex="-1" role="dialog" aria-labelledby="showTicketLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center w-100 font-weight-bold py-2" v-show="!editmode" id="showTicketLabel">{{ $t('260') }}</h5>
                        <button type="button" style="color:black;" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="PrintTicket">
                        <table class="table table-bordered table-striped" id="shiftTable">
                            <tbody>
                                <tr>
                                    <th>{{ $t('229') }}</th>
                                    <td>
                                        {{ shift.name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('67') }}</th>
                                    <td>
                                        {{ shift.on_duty_time1 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('68') }}</th>
                                    <td>
                                        {{ shift.off_duty_time1 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('69') }}</th>
                                    <td>
                                        {{ shift.begin1 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('70') }}</th>
                                    <td>
                                        {{ shift.end1 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('67') }} * ({{ $t('71') }} 2)</th>
                                    <td>
                                        {{ shift.on_duty_time2 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('68') }} * ({{ $t('71') }} 2)</th>
                                    <td>
                                        {{ shift.off_duty_time2 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('69') }} * ({{ $t('71') }} 2)</th>
                                    <td>
                                        {{ shift.begin2 }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('70') }} * ({{ $t('71') }} 2)</th>
                                    <td>
                                        {{ shift.end2 }}
                                    </td>
                                </tr>
                                <!--<tr>
                                    <th>{{ $t('72') }}</th>
                                    <td>
                                        {{ shift.week_days }}
                                    </td>
                                </tr>-->
                                <tr v-if="shift.start_late==1">
                                    <th>{{ $t('74') }}</th>
                                    <td>
                                        {{ shift.late_minutes }}
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
            week_days_all:['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
            shifts:{},
            shift:{},
            editmode: false,
            form: new Form({
                id:'',
                name:'',
                name_ar:'',
                on_duty_time1:'',
                off_duty_time1:'',
                begin1:'',
                end1:'',
                on_duty_time2:'',
                off_duty_time2:'',
                begin2:'',
                end2:'',
                assign_another_shift:0,
                week_days:[],
                start_late:0,
                late_minutes:0,
            })
        }
    },
    methods:{
        disable_late(){
            if(this.form.start_late==0){
                this.form.late_minutes=0
                return true;
            }
            return false;
        },

        getResults(page = 1) {
            axios.get('api/shift_management/?page=' + page).then((response) => {
                this.shifts = response.data;
            });
        },

        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        createUser(){
            this.$Progress.start();
            this.form.post('api/shift_management').then(()=>{
                Fire.$emit('AfterCreate');
                $('#addNew').modal('hide')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Shift Created successfully',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.$Progress.finish();
            })
        },

        editShift(shift){
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(shift);
        },

        updateUser(){
            this.$Progress.start();
            this.form.put('api/shift_management/'+this.form.id).then(() => {
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

        showShift(id){
            $('#showTicket').modal('show');
            this.form.get('api/shift_show/'+id).then((response) => {
                this.shift = response.data;
            });
        },

        deleteShift(id){
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
                    this.form.delete('api/shift_management/'+id).then(()=>{
                        swal.fire(
                            'Deleted!',
                            'Role has been deleted.',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    }).catch(()=> {
                        swal.fire("Failed!", "This Role assigned to an employee.", "warning");
                    });
                }
            })
        },
    },

    created() {
        this.getResults()
        Fire.$on('AfterCreate',() => {
            this.getResults();
        });
    },
}
</script>
