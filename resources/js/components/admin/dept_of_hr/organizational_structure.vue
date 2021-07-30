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
                            <h3 class="card-title">{{ $t('132') }}</h3>
                            <div class="card-tools">
                                <button class="btn btn-success" @click="addNew();form.addNewValue=1">{{ $t('133') }} {{ $t('35') }}</button>
                                <button class="btn btn-success" @click="addNew();form.addNewValue=2">{{ $t('133') }} {{ $t('36') }}</button>
                                <button class="btn btn-success" @click="addNew();form.addNewValue=3">{{ $t('133') }} {{ $t('37') }}</button>
                            </div>
                        </div>

                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="filters">{{ $t('134') }}</label>
                                    <select name="filters" id="filters"  v-model="filter" class="form-control" @change="search">
                                        <option value="-1">{{ $t('135') }}</option>
                                        <option value="1">{{ $t('35') }}</option>
                                        <option value="2">{{ $t('36') }}</option>
                                        <option value="3">{{ $t('37') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row card" v-if="des">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $t('35') }}</h3>
                                </div>

                                <div class="table-responsive p-0">
                                    <table class="table table-bordered table-hover text-center" >
                                        <thead class="thead-light">
                                            <tr>
                                                <th>{{ $t('109') }}</th>
                                                <th>{{ $t('229') }}</th>
                                                <th>{{ $t('18') }}</th>
                                                <th>{{ $t('110') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="design in designations" :key="design.id">
                                                <td>{{ design.id }}</td>
                                                <td>{{ design.name }}</td>
                                                <td>{{ design.status == 1 ? $t('19') : $t('20') }}</td>
                                                <td>
                                                    <a href="#" @click="editData(1,design)">
                                                        <i class="fa fa-edit blue"></i>
                                                    </a>/
                                                    <a href="#" @click="showData(1,design.id,1)">
                                                        <i class="fa fa-eye" style="color:green;"></i>
                                                    </a>/
                                                    <a href="#" @click="deleteData(1,design.id)">
                                                        <i class="fa fa-trash" style="color:red;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row card" v-if="dep">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $t('36') }}</h3>
                                </div>
                                <div class="table-responsive p-0">
                                    <table class="table table-bordered table-hover text-center" >
                                        <thead class="thead-light">
                                            <tr>
                                                <th>{{ $t('109') }}</th>
                                                <th>{{ $t('229') }}</th>
                                                <th>{{ $t('18') }}</th>
                                                <th>{{ $t('110') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="dept in departments" :key="dept.id">
                                                <td>{{ dept.id }}</td>
                                                <td>{{ dept.name }}</td>
                                                <td>{{ dept.status == 1 ? $t('19') : $t('20') }}</td>
                                                <td>
                                                    <a href="#" @click="editData(2,dept)">
                                                        <i class="fa fa-edit blue"></i>
                                                    </a>/
                                                    <a href="#" @click="showData(2,dept.id,2)">
                                                        <i class="fa fa-eye" style="color:green;"></i>
                                                    </a>/
                                                    <a href="#" @click="deleteData(2,dept.id)">
                                                        <i class="fa fa-trash" style="color:red;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row card" v-if="emp">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $t('37') }}</h3>
                                </div>
                                <div class="table-responsive p-0">
                                    <table class="table table-bordered table-hover text-center" >
                                        <thead class="thead-light">
                                            <tr>
                                                <th>{{ $t('109') }}</th>
                                                <th>{{ $t('229') }}</th>
                                                <th>{{ $t('18') }}</th>
                                                <th>{{ $t('110') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="emp in employements" :key="emp.id">
                                                <td>{{ emp.id }}</td>
                                                <td>{{ emp.name }}</td>
                                                <td>{{ emp.status == 1 ? $t('19') : $t('20') }}</td>
                                                <td>
                                                    <a href="#" @click="editData(3,emp)">
                                                        <i class="fa fa-edit blue"></i>
                                                    </a>/
                                                    <a href="#" @click="showData(3,emp.id,3)">
                                                        <i class="fa fa-eye" style="color:green;"></i>
                                                    </a>/
                                                    <a href="#" @click="deleteData(3,emp.id)">
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
        </div>

        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="!editmode" id="addNewLabel">{{ $t('104') }} {{form.addNewValue==2 ? $t('36') :(form.addNewValue==1?$t('35'):$t('37')) }}</h5>
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="editmode" id="addNewLabel">{{ $t('105') }} {{form.addNewValue==2 ? $t('36') :(form.addNewValue==1?$t('35'):$t('37')) }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateData() : createData()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="required" for="name">{{ $t('50') }}<span style="color:red;">*</span></label>
                                        <input class="form-control"  v-model="form.name" type="text" name="name" id="name" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="required" for="name">{{ $t('56') }}<span style="color:red;">*</span></label>
                                        <input class="form-control"  v-model="form.name_ar" type="text" name="name_ar" id="name_ar" required dir="rtl">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="status">{{ $t('18') }}<span style="color:red;">*</span></label>
                                        <select name="status" id="status"  v-model="form.status" class="form-control">
                                            <option value="1">{{ $t('19') }}</option>
                                            <option value="0">{{ $t('20') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="description">{{ $t('113') }}</label>
                                        <textarea class="form-control" cols="30" type="text"  v-model="form.description" name="description" id="description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="form.addNewValue==2">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="employee_id">{{ $t('94') }}</label>
                                        <select name="employee_id" id="employee_id"  v-model="form.employee_id" class="form-control">
                                            <option v-for="emp in employees" :key="emp.id" :value="emp.id">{{ emp.name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div  v-if="form.addNewValue==2" class="panel-head bg-light" style="height:40px">
                                <span style="font-weight:bold;" class="pr-3">{{$t('93')}}</span>
                            </div>
                            <div class="row" v-if="form.addNewValue==2">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="month">{{ $t('138') }}</label>
                                        <select name="month" id="month"  v-model="form.month" class="form-control" @change="get_month_days">
                                            <option v-for="(mnth,indx) in months" :key="indx" :value="indx">{{ mnth }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="day">{{ $t('139') }}</label>
                                        <select name="day" id="day"  v-model="form.day" class="form-control">
                                            <option v-for="dy in days" :key="dy" :value="dy">{{ dy }}</option>
                                        </select>
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

        <!-- show Data Modal -->
        <div class="modal fade" id="showTicket" tabindex="-1" role="dialog" aria-labelledby="showTicketLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="!editmode" id="addNewLabel">{{form.addNewValue==2 ? $t('36') :(form.addNewValue==1?$t('35'):$t('37')) }}</h5>
                        <button type="button" style="color:black;" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="PrintTicket">
                        <table class="table table-bordered table-striped" id="shiftTable" v-if="des">
                            <tbody>
                                <tr>
                                    <th>{{ $t('109') }}</th>
                                    <td>{{ organizes.id }}</td>
                                </tr>
                                <tr>
                                    <th>{{ $t('229') }}</th>
                                    <td>
                                        {{ organizes.name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('18') }}</th>
                                    <td>
                                        <span v-if="organizes.status==0" class="badge badge-danger">Stopped</span>
                                        <span v-if="organizes.status==1" class="badge badge-success">Active</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('113') }}</th>
                                    <td>
                                        {{ organizes.description }}
                                    </td>
                                </tr>
                                <tr v-if="form.addNewValue==2">
                                    <th>{{ $t('59') }}</th>
                                    <td>
                                        {{ organizes.employee_id }}
                                    </td>
                                </tr>
                                <tr v-if="form.addNewValue==2">
                                    <th>{{ $t('138') }}</th>
                                    <td>
                                        {{ organizes.month }}
                                    </td>
                                </tr>
                                <tr v-if="form.addNewValue==2">
                                    <th>{{ $t('139') }}</th>
                                    <td>
                                        {{ organizes.day }}
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
    data: function() {
        return {
            lang:'en',
            editmode: false,
            des: true,
            dep: true,
            emp: true,
            filter:-1,
            designations:{},
            departments:{},
            employements:{},
            employees:{},
            months:['January','February','March','April','May','June','July','August','September','October','November','December'],
            days:[],
            organizes:{},
            form: new Form({
                id:'',
                name: '',
                name_ar: '',
                status: 1,
                description: '',
                employee_id:-1,
                day:new Date().getDate(),
                month:new Date().getMonth(),
                addNewValue:1,
            }),
        }
    },
    methods: {
        search(){
            if(this.filter==-1){
                this.des=true;
                this.dep=true;
                this.emp=true;
                this.getDesignations()
                this.getDepartments()
                this.getEmployments()
            }else if(this.filter==1){
                this.des=true;
                this.dep=false;
                this.emp=false;
                this.getDesignations()
            }else if(this.filter==2){
                this.des=false;
                this.dep=true;
                this.emp=false;
                this.getDepartments()
            }else{
                this.des=false;
                this.dep=false;
                this.emp=true;
                this.getEmployments()
            }
        },

        getDesignations(){
            axios.get('api/organizational_structure_designations').then((res)=>{
                this.designations=res.data;
            });
        },

        getDepartments(){
            axios.get('api/organizational_structure_departments').then((res)=>{
                this.departments=res.data;
            });
        },

        getEmployments(){
            axios.get('api/organizational_structure_employments').then((res)=>{
                this.employements=res.data;
            });
        },

        getEmployees(){
            axios.get('api/get_employees').then((res)=>{
                this.employees=res.data
            })
            this.get_month_days()
        },

        get_month_days(){
            this.days=[]
            axios.get('api/get_month_days/'+parseInt(this.form.month+1)).then((res)=>{
                for(var i=1;i<=parseInt(res.data);i++)
                    this.days.push(i);
            })
        },

        showData(type,id,val){

            this.form.get('api/data_show/'+id+"/"+type).then((response) => {
                this.organizes = response.data;
            });
            this.form.addNewValue=val
            $('#showTicket').modal('show');
        },

        addNew() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },

        createData(){
            this.$Progress.start();
            this.form.post('api/organizational_structure').then(()=>{
                $('#addNew').modal('hide')
                Fire.$emit('AfterCreate')
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Data Created successfully',
                    showConfirmButton: false,
                    timer: 1500
                })
            })
            this.$Progress.finish();
        },

        editData(val,data) {
            this.editmode = true;
            this.form.reset();
            this.form.fill(data)
            this.form.addNewValue=val
            $('#addNew').modal('show');
        },

        updateData(){
            this.$Progress.start();
            this.form.put('api/organizational_structure/'+this.form.id).then(() => {
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

        deleteData(type,id){
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
                    this.form.delete('api/organizational_structure/'+type+"/"+id).then(()=>{
                        swal.fire(
                            'Deleted!',
                            'Record has been deleted.',
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    }).catch(()=> {
                        swal.fire("Failed!", "This is an error", "warning");
                    });
                }
            })
        },
    },

    created() {
        this.lang=window.default_locale_lang
        this.search();
        this.getEmployees()
        Fire.$on('AfterCreate',() => {
            this.search();
        });
    },
}
</script>
