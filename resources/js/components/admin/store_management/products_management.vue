<style scoped>
button{
    color:white;
}
.modal-lg{
    max-width:900px;
}
</style>

<template>
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $t('221') }}</h3>
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
                                        <th>{{ $t('109') }}</th>
                                        <th>{{ $t('229') }}</th>
                                        <th>{{ $t('222') }}</th>
                                        <th>{{ $t('110') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="product in products.data" :key="product.id">
                                        <td>{{ product.id }}</td>
                                        <td>{{ product.name }}</td>
                                        <td>{{ product.classifications==1? $t('235') : $t('236')}}</td>
                                        <td>
                                            <a href="#" @click="editProduct(product)">
                                                <i class="fa fa-edit red"></i>
                                            </a>&nbsp;/
                                            <a href="#" @click="deleteProduct(product.id)">
                                                <i class="fa fa-trash" style="color:red;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>

                            <div class="card-footer">
                                <pagination :data="products" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="!editmode" id="addNewLabel">{{ $t('102') }}</h5>
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="editmode" id="addNewLabel">{{ $t('105') }}</h5>
                        <button type="button" class="close" style="color:black;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                        <div class="modal-body bg-light">
                            <div class="row">
                                <div class="col-md-6">
                                    <input v-model="form.name" type="text" name="name" :placeholder="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error><br>

                                    <input v-model="form.name_ar" type="text" name="name_ar" :placeholder="name_ar" class="form-control" :class="{ 'is-invalid': form.errors.has('name_ar') }" dir="rtl">
                                    <has-error :form="form" field="name_ar"></has-error><br>

                                    <select class="form-control" name="classifications" v-model="form.classifications">
                                        <option selected value="-1">{{$t('223')}}</option>
                                        <option selected value="1">{{$t('235')}}</option>
                                        <option selected value="2">{{$t('236')}}</option>
                                    </select><br>

                                    <select class="form-control" name="type" v-model="form.type">
                                        <option selected value="-1">{{$t('103')}}</option>
                                        <option selected value="1">{{$t('231')}}</option>
                                        <option selected value="2">{{$t('232')}}</option>
                                    </select><br>

                                    <div class="row" v-if="form.type==1">
                                        <div class="col-sm-4 col-12">
                                            <select class="form-control" name="part_unit" v-model="form.part_unit">
                                                <option selected value="-1">part_unit</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <input v-model="form.unit_parts" type="text" name="unit_parts" :placeholder="unit_parts" class="form-control form-rounded" :class="{ 'is-invalid': form.errors.has('unit_parts') }">
                                            <has-error :form="form" field="unit_parts"></has-error>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <select class="form-control" name="default_unit" v-model="form.default_unit">
                                                <option selected value="-1">default_unit</option>
                                            </select>
                                        </div>
                                    </div><br>
                                    <div class="row" v-if="form.type==1">
                                        <input v-model="form.unit_price" type="number" name="unit_price" :placeholder="unit_price" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card card-default">
                                        <div class="card-header">#{{$t('226')}}</div>
                                        <div class="card-body">
                                             <div class="table-responsive p-0">
                                            <form @submit.prevent="createMaterial()">
                                                <table class="table text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ $t('229') }}</th>
                                                            <th>{{ $t('227') }}</th>
                                                            <th>{{ $t('228') }}</th>
                                                            <th>{{ $t('230') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input  type="text"    class="form-control"   name="name"  v-model="form2.name" style="min-width:110px;"></td>
                                                            <td><input  type="number"  class="form-control"   name="units" v-model="form2.units" style="min-width:40px;"></td>
                                                            <td><input  type="number"  class="form-control"   name="cost"  v-model="form2.cost" style="min-width:40px;"></td>
                                                            <td><button type="submit" class="btn btn-sm btn-info">{{$t('133')}}</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                             </form>
                                            </div>
                                        </div>
                                        <table class="table text-center">
                                            <tbody v-for="unit in units.data" :key="unit.id">
                                                <tr>
                                                    <td>{{unit.name}}</td>
                                                    <td>{{unit.units}}</td>
                                                    <td>{{unit.cost}}</td>
                                                    <td>
                                                        <a href="#" @click="deleteMaterial(unit.id)">
                                                            <i class="fa fa-trash" style="color:red;"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="card card-default" v-if="form.type==2">
                                        <div class="card-header">#{{$t('233')}}</div>
                                        <div class="card-body">
                                             <div class="table-responsive p-0">
                                            <form @submit.prevent="createService()">
                                                <table class="table text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ $t('229') }}</th>
                                                            <th>{{ $t('234') }}</th>
                                                            <th>{{ $t('230') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input type="text" class="form-control" v-model="form3.name"></td>
                                                            <td><input type="number" class="form-control" v-model="form3.quantity"></td>
                                                            <td><button type="submit" class="btn btn-sm btn-info">{{$t('133')}}</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                             </form>
                                            </div>
                                        </div>
                                        <table class="table text-center">
                                            <tbody v-for="ser in services.data" :key="ser.id">
                                                <tr>
                                                    <td>{{ser.name}}</td>
                                                    <td>{{ser.quantity}}</td>
                                                    <td>
                                                        <a href="#" @click="deleteService(ser.id)">
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

                        <div class="modal-footer d-flex justify-content-center">
                            <button v-show="!editmode" type="submit" class="btn btn-success">{{ $t('121') }}</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">{{ $t('105') }}</button>
                            <button type="button" class="btn btn-danger"  data-dismiss="modal">{{ $t('114') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function(){
            return{
                editmode: false,
                products:{},
                units:{},
                services:{},
                form: new Form({
                    id:'',
                    name:'',
                    name_ar:'',
                    classifications:-1,
                    type:-1,
                    part_unit:-1,
                    default_unit:-1,
                    unit_parts:'',
                }),

                form2: new Form({
                    id:'',
                    product_id:'',
                    name:'',
                    units:'',
                    cost:'',
                }),

                form3: new Form({
                    id:'',
                    product_id:'',
                    name:'',
                    quantity:'',
                })
            }
        },

        methods: {
            getResults(page = 1) {
                axios.get('api/products_management/?page=' + page).then((response) => {
                    this.products = response.data;
                });
            },

            getUnits(page = 1) {
                axios.get('api/get_units/'+this.form.id+'?page=' + page).then((response) => {
                    this.units = response.data;
                });
            },

            getServices(page = 1) {
                axios.get('api/get_services/'+this.form.id+'?page=' + page).then((response) => {
                    this.services = response.data;
                });
            },

            newModal(){
                this.editmode = false;
                this.form.reset();
                this.getId();
                $('#addNew').modal('show');
            },

            getId(){
                axios.get('api/get_id').then((response) => {
                    this.form.id = response.data;
                    this.form2.product_id = response.data;
                    this.form3.product_id = response.data;
                });
                this.getUnits();
                this.getServices();
            },

            createUser(){
                this.$Progress.start();
                this.form.post('api/products_management').then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data Created successfully',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.$Progress.finish();
                })
            },

            editProduct(user){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);
                this.getUnits();
                this.getServices();
            },

            updateUser(){
                this.$Progress.start();
                this.form.put('api/products_management/'+this.form.id).then(() => {
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

            deleteProduct(id){
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
                        this.form.delete('api/products_management/'+id).then(()=>{
                            swal.fire(
                                'Deleted!',
                                'Data has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');
                        }).catch(()=> {
                            swal.fire("Failed!", "This data assigned to an employee.", "warning");
                        });
                    }
                })
            },

            createMaterial(){
                this.form2.product_id=this.form.id
                this.$Progress.start();
                this.form2.post('api/get_units').then(()=>{
                    Fire.$emit('AfterCreateInside');
                    this.form2.reset()
                })
            },

            deleteMaterial(id){
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
                        this.form2.delete('api/get_units/'+id).then(()=>{
                            Fire.$emit('AfterCreateInside');
                        }).catch(()=> {
                            swal.fire("Failed!", "This data assigned to an employee.", "warning");
                        });
                    }
                })
            },

            createService(){
                this.form3.product_id=this.form.id
                this.$Progress.start();
                this.form3.post('api/get_services').then(()=>{
                    Fire.$emit('AfterCreateInside');
                    this.form3.reset()
                })
            },

            deleteService(id){
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
                        this.form3.delete('api/get_services/'+id).then(()=>{
                            Fire.$emit('AfterCreateInside');
                        }).catch(()=> {
                            swal.fire("Failed!", "This data assigned to an employee.", "warning");
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

            Fire.$on('AfterCreateInside',() => {
                this.getUnits();
                this.getServices();
            });
        },

        computed: {
            name() {
                return this.$t('50')
            },

            name_ar() {
                return this.$t('56')
            },

            unit_parts() {
                return this.$t('224')
            },

            unit_price() {
                return this.$t('225')
            },
        }
    }
</script>
