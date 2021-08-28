<style scoped>
button{
    color:white;
}
</style>
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $t('51') }}</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">
                            <i class="fas fa-plus fa-fw"></i>&nbsp; {{ $t('55') }}</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-bordered table-hover text-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>{{ $t('109') }}</th>
                                            <th>{{ $t('229') }}</th>
                                            <th>{{ $t('110') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="role in roles" :key="role.id">
                                            <td>{{ role.id }}</td>
                                            <td>{{ role.name }}</td>
                                            <td>
                                                <a href="#" @click="editRole(role)">
                                                    <i class="fa fa-edit red"></i>
                                                </a>&nbsp;/
                                                <a href="#" @click="deleteRole(role.id)">
                                                    <i class="fa fa-trash red"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><br><br>

                        <form @submit.prevent="set_permissions()">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="control-label">{{ $t('23') }}</label>
                                        <select class="form-control" id="role_id" name="role_id" v-model="form.role_id" @change="get_roles">
                                            <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label">{{ $t('52') }}</label>
                                        <select class="form-control" id="module_id" name="module_id" v-model="module_id" @change="get_pages">
                                            <option v-for="mod in modules" :key="mod.module_id" :value="mod.module_id">{{ mod.module_name }}</option>
                                        </select>
                                    </div>
                                </div><hr>


                                <div class="row">
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <th>{{ $t('53') }}</th>
                                                    <th class="text-center">{{ $t('121') }}</th>
                                                    <th class="text-center">{{ $t('105') }}</th>
                                                    <th class="text-center">{{ $t('106') }}</th>
                                                    <th class="text-center">{{ $t('53') }}</th>
                                                </tr>
                                                <tr v-for="page in form.pages" :key="page.screen_name">
                                                    <td>{{ page.screen_name }}</td>
                                                    <td class="text-center" v-if="check_permission(page,1)!=''"><input type="checkbox" v-model="page.operation_type[1]"></td>
                                                    <td class="text-center" v-else></td>

                                                    <td class="text-center" v-if="check_permission(page,2)!=''"><input type="checkbox" v-model="page.operation_type[2]"></td>
                                                    <td class="text-center" v-else></td>

                                                    <td class="text-center" v-if="check_permission(page,3)!=''"><input type="checkbox" v-model="page.operation_type[3]"></td>
                                                    <td class="text-center" v-else></td>

                                                    <td class="text-center" v-if="check_permission(page,4)!=''"><input type="checkbox" v-model="page.operation_type[4]"></td>
                                                    <td class="text-center" v-else></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">{{ $t('121') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">{{ $t('55') }}</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">{{ $t('105') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label">{{ $t('50') }}</label>
                                <input type="text" v-model="roleForm.name" name="name" placeholder="English Description" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="roleForm" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-4 control-label">{{ $t('56') }}</label>
                                <input v-model="roleForm.name_ar" type="text" name="name_ar" placeholder="Arabic Description" class="form-control" :class="{ 'is-invalid': form.errors.has('name_ar') }" dir="rtl">
                                <has-error :form="roleForm" field="name_ar"></has-error>
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
    </div>
</template>

<script>
export default {
    data: function(){
        return{
            roles:{},
            modules:{},
            module_id:1,
            editmode:false,

            form: new Form({
                role_id:1,
                pages:{},
            }),

            roleForm: new Form({
                id:'',
                name : '',
                name_ar: '',
            })
        }
    },

    methods: {

            newModal(){
                this.editmode = false;
                this.roleForm.reset();
                $('#addNew').modal('show');
            },

            createUser(){
                this.$Progress.start();
                this.roleForm.post('api/roles').then(()=>{
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

            editRole(user){
                this.editmode = true;
                this.roleForm.reset();
                $('#addNew').modal('show');
                this.roleForm.fill(user);
            },

            updateUser(){
                this.$Progress.start();
                this.roleForm.put('api/roles/'+this.roleForm.id).then(() => {
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

            deleteRole(id){
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
                        this.roleForm.delete('api/roles/'+id).then(()=>{
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
        get_roles(){
            axios.get('api/permission_roles').then((res)=>{
                this.roles=res.data
                this.get_modules()
            })
        },

        get_modules(){
            axios.get('api/permission_modules').then((res)=>{
                this.modules=res.data
                this.get_pages()
            })
        },

        get_pages(){
            axios.get('api/permissions_pages/'+this.form.role_id+"/"+this.module_id).then((res)=>{
                this.form.pages=res.data
            })
        },

        check_permission(page,per_id){
            var x='operation_type';
            for(var i=0;i<this.form.pages.length;i++){
                if(page.screen_name==this.form.pages[i]['screen_name']){
                    if(this.form.pages[i]['operation_type'][per_id]== undefined)
                        return '';
                    if(this.form.pages[i]['operation_type'][per_id]== true)
                        return 'found'
                    return 'notfound'
                }
            }
        },

        set_permissions(){
            this.form.post('api/permission').then(()=>{
                Fire.$emit('AfterCreate');
                swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Permissions assigned successfully',
                    showConfirmButton: false,
                    timer: 1500
                })
                this.$Progress.finish();
            })
        }
    },

    created() {
        this.get_roles()
        Fire.$on('AfterCreate', () => {
            this.get_roles();
        });
    },

}

</script>
