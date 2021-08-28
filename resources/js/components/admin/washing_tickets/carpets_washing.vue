<template>
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $t('201') }}</h3>
                            <div class="card-tools">
                                <button class="btn btn-success" @click="newModal">
                                <i class="fas fa-plus fa-fw"></i>&nbsp; {{ $t('202') }}</button>
                                <button class="btn btn-info" @click="printForCarpet">
                                    <i class="fas fa-print fa-fw"></i>&nbsp; {{$t('212')}}
                                </button>
                            </div>
                        </div>
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="filters">{{ $t('134') }}</label>
                                    <select name="filters" id="filters"  v-model="filter" class="form-control" @change="getResults">
                                        <option value="-1">{{ $t('135') }}</option>
                                        <option value="1">{{ $t('210') }} / {{$t('211')}}</option>
                                        <option value="2">{{ $t('254') }} / {{$t('255')}}</option>
                                        <option value="3">{{ $t('195') }}</option>
                                    </select>
                                </div>

                                <div class="col-md-2" v-if="filter==1">
                                    <div class="form-group">
                                        <label>{{ $t('210') }}</label>
                                        <input v-model="enter_date" type="text" name="enterance_date" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Enterance Date" class="form-control"  @change="getResults">
                                    </div>
                                </div>

                                <div class="col-md-2" v-if="filter==1">
                                    <div class="form-group">
                                        <label>{{ $t('211') }}</label>
                                        <input v-model="exit_date" type="text" name="exit_date" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Exit Date" class="form-control"  @change="getResults">
                                    </div>
                                </div>

                                <div class="col-md-2" v-if="filter==2">
                                    <div class="form-group">
                                        <label>{{ $t('254') }}</label>
                                        <input v-model="enter_time" type="text" name="enter_time"  placeholder="Enterance Time" onblur="(this.type='text')" onfocus="(this.type='time')" class="form-control" required  @change="getResults">
                                    </div>
                                </div>

                                <div class="col-md-2" v-if="filter==2">
                                    <div class="form-group">
                                        <label>{{ $t('255') }}</label>
                                        <input v-model="exit_time_filter" type="text" name="exit_time_filter"  placeholder="Exit Time" onblur="(this.type='text')" onfocus="(this.type='time')" class="form-control"  @change="getResults">
                                    </div>
                                </div>

                                <div class="col-md-2" v-if="filter==3">
                                    <div class="form-group">
                                        <label>{{ $t('195') }}</label>
                                        <input v-model="ticket" type="number" name="ticket_number" class="form-control" required  @change="getResults">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                 <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{$t('273')}}</label>
                                        <input type="text" name="total_tickets" class="form-control" :value="total_tickets" disabled>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{$t('274')}}</label>
                                        <input type="text" name="total_servs" class="form-control" :value="servs" disabled>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{$t('275')}}</label>
                                        <input type="text" name="total_cost" class="form-control" :value="fin_cost" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body" id="PrintCarpet">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-bordered table-hover text-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{ $t('109') }}</th>
                                        <th>{{ $t('194') }}</th>
                                        <th>{{ $t('195') }}</th>
                                        <th>{{ $t('196') }}</th>
                                        <th>{{ $t('197') }}</th>
                                        <th>{{ $t('205') }}</th>
                                        <th>{{ $t('203') }}</th>
                                        <th>{{ $t('254') }}</th>
                                        <th>{{ $t('255') }}</th>
                                        <th>{{ $t('110') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="carpet in carpets.data" :key="carpet.id">
                                        <td>{{ carpet.id }}</td>
                                        <td>{{ carpet.client }}</td>
                                        <td>{{ carpet.id }}</td>
                                        <td>{{ carpet.num_of_materials }}</td>
                                        <td>{{ carpet.total_price }}</td>
                                        <td v-if="carpet.ticket_status==1"><span class="badge badge-warning">{{$t('238')}}</span></td>
                                        <td v-else-if="carpet.ticket_status==2"><span class="badge badge-danger">{{$t('239')}}</span></td>
                                        <td v-else-if="carpet.ticket_status==3"><span class="badge badge-primary">{{$t('240')}}</span></td>
                                        <td v-else><span class="badge badge-success">{{$t('241')}}</span></td>
                                        <td>{{ carpet.ticket_date }}</td>
                                        <td>{{ carpet.pended==1?carpet.receipt_time:'Pending' }}</td>
                                        <td>{{ carpet.completed==1?carpet.exit_time:'Under Washing' }}</td>
                                        <td>
                                            <a href="#" @click="editCarpet(carpet)">
                                                <i class="fa fa-edit"></i>
                                            </a>&nbsp;/
                                            <a href="#" @click="showCarpet(carpet.id)">
                                                <i class="fa fa-eye" style="color:green;"></i>
                                            </a>&nbsp;/
                                            <a href="#" @click="deleteCarpet(carpet.id)">
                                                <i class="fa fa-trash" style="color:red;"></i>
                                            </a>&nbsp;/
                                            <a href="#" @click="UpdateCarpet(carpet)">
                                                <i class="fa fa-cogs" style="color:navy;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                            <div class="card-footer">
                                <pagination :data="carpets" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <span class="badge badge-pill badge-success" :class="client_status==2?'badge-danger':'badge-success'">{{ client_status==2?'Bad Client':'Good Client' }}</span>
                        <button type="button" class="close" style="color:black;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                        <div class="modal-body bg-light">
                           <div class="row">
                                <div class="col-md-2">
                                   <h5><span class="badge badge-pill badge-secondary">{{ form.serial_number }}</span></h5>
                                </div>

                                <div class="col-md-3">
                                    <input v-model="form.ticket_date" type="text" name="ticket_date" :placeholder="ticket_date" onblur="(this.type='text')" onfocus="(this.type='date')" class="form-control form-rounded" :class="{ 'is-invalid': form.errors.has('ticket_date') }">
                                    <has-error :form="form" field="ticket_date"></has-error>
                                </div>

                                <div class="col-md-1"></div>

                                <div class="col-md-3">
                                   <select class="form-control form-rounded" name="wash" v-model="form.wash">
                                        <option disabled value="-1">{{$t('204')}}</option>
                                        <option value="1">{{$t('99')}} 1</option>
                                        <option value="2">{{$t('99')}} 2</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                     <select class="form-control form-rounded" name="ticket_status" v-model="form.ticket_status">
                                        <option selected value="-1">{{$t('205')}}</option>
                                        <option selected value="1">{{$t('238')}}</option>
                                        <option selected value="2">{{$t('239')}}</option>
                                        <option selected value="3">{{$t('240')}}</option>
                                        <option selected value="4">{{$t('241')}}</option>
                                    </select>
                                </div>
                           </div>

                           <div class="row mt-3">
                                <div class="col-md-2">
                                    <select class="form-control form-rounded" name="client" v-model="form.client" @change="get_client_phone">
                                        <option selected value="-1">{{$t('206')}}</option>
                                        <option v-for="client in clients" :key="client.id" :value="client.id">{{ client.name }}</option>
                                    </select>
                                </div>
                                <div class="col-md-1 mt-1" style="margin-left:-7px; width">
                                    <button class="btn btn-sm btn-success default" type="button" @click="openClientModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input v-model="form.phone" type="text" name="phone" :placeholder="phone_number" class="form-control form-rounded" :class="{ 'is-invalid': form.errors.has('phone') }">
                                        <has-error :form="form" field="phone"></has-error>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                   <select class="form-control form-rounded" name="carpet_size" v-model="form.carpet_size">
                                        <option selected value="-1">{{$t('208')}}</option>
                                        <option v-for="size in sizes" :key="size.sys_code" :value="size.sys_code">{{ size.name }}</option>
                                    </select>
                                </div>
                                <div class="col-md-1 mt-1" style="margin-left:-7px; width">
                                    <button type="button" class="btn btn-sm btn-success default" @click="newCode_tableModal(4)">
                                    <i class="fas fa-plus"></i></button>
                                </div>

                                <div class="col-md-2">
                                   <select class="form-control form-rounded" name="wash_type" v-model="form.wash_type">
                                        <option selected value="-1">{{ $t('209') }}</option>
                                        <option v-for="type in types" :key="type.sys_code" :value="type.sys_code">{{ type.name }}</option>
                                    </select>
                                </div>
                                <div class="col-md-1 mt-1" style="margin-left:-7px; width">
                                    <button type="button" class="btn btn-sm btn-success default" @click="newCode_tableModal(5)">
                                    <i class="fas fa-plus"></i></button>
                                </div>
                           </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <input v-model="form.receipt_time" type="text" name="receipt_time"  :placeholder="receipt_time" onblur="(this.type='text')" onfocus="(this.type='time')" class="form-control form-rounded" :class="{ 'is-invalid': form.errors.has('receipt_time') }">
                                    <has-error :form="form" field="receipt_time"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <input v-model="form.exit_time" type="text" name="exit_time"  :placeholder="exit_time" onblur="(this.type='text')" onfocus="(this.type='time')" class="form-control form-rounded" :class="{ 'is-invalid': form.errors.has('exit_time') }">
                                    <has-error :form="form" field="exit_time"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <input v-model="form.receipt_date" type="text" name="Time of receipt" :placeholder="entrance_date" onblur="(this.type='text')" onfocus="(this.type='date')" class="form-control form-rounded" :class="{ 'is-invalid': form.errors.has('receipt_date') }">
                                    <has-error :form="form" field="receipt_date"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <input v-model="form.expected_exit_date" type="text" name="expected_exit_date" :placeholder="expected_exit_date" onblur="(this.type='text')" onfocus="(this.type='date')" class="form-control form-rounded" :class="{ 'is-invalid': form.errors.has('expected_exit_date') }">
                                    <has-error :form="form" field="expected_exit_date"></has-error>
                                </div>
                           </div>

                            <div class="row mt-3  d-flex justify-content-center">
                                <div class="col-md-12">
                                    <div class="card card-default">
                                        <div class="card-body">
                                            <div class="table-responsive p-0">
                                                <form @submit.prevent="createMaterial()">
                                                    <table class="table text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ $t('229') }}</th>
                                                                <th>{{ $t('227') }}</th>
                                                                <th>{{ $t('228') }}</th>
                                                                <th>{{ $t('244') }}</th>
                                                                <th>{{ $t('113') }}</th>
                                                                <th>{{ $t('230') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <select class="form-control" name="product_id" v-model="serviceForm.product_id" @change="get_services" style="min-width:120px;">
                                                                        <option v-for="pro in products" :key="pro.id" :value="pro.id">{{ pro.name }}</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control" name="unit_id" v-model="serviceForm.unit_id" @change="get_cost" style="min-width:120px;">
                                                                        <option v-for="unt in units" :key="unt.id" :value="unt.id">{{ unt.name }}</option>
                                                                    </select>
                                                                </td>
                                                                <td><input  type="number" class="form-control" name="cost" disabled :value="serviceForm.cost" style="min-width:80px;"></td>
                                                                <td><input  type="number" class="form-control" name="extra_cost" v-model="serviceForm.extra_cost" style="min-width:80px;"></td>
                                                                <td><textarea class="form-control" name="description" v-model="serviceForm.description" style="min-width:80px;"></textarea></td>
                                                                <td><button type="submit" class="btn btn-sm btn-info">{{$t('133')}}</button></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                        <table class="table text-center">
                                            <tbody v-for="mat in materials.data" :key="mat.id">
                                                <tr>
                                                    <td>{{mat.name}}</td>
                                                    <td>{{mat.units}}</td>
                                                    <td>{{mat.cost}}</td>
                                                    <td>{{mat.extra_cost}}</td>
                                                    <td>{{mat.descr}}</td>
                                                    <td>
                                                        <a href="#" @click="deleteMaterial(mat.id)">
                                                            <i class="fa fa-trash" style="color:red;"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <div class="d-flex justify-content-center">
                                                <pagination :data="materials" @pagination-change-page="getMaterials"></pagination>
                                            </div>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row d-flex justify-content-center">
                                <div class="col-sm-2">
                                    <label for="total_services">{{$t('242')}}</label>
                                    <input type="number" class="form-control" disabled name="total_services" :value="form.total_services">
                                </div>

                                <div class="col-sm-2">
                                    <label for="total_discount">{{$t('264')}}</label>
                                    <input type="number" class="form-control" disabled name="total_discount" :value="form.total_discount">
                                </div>

                                <div class="col-sm-3">
                                    <label for="price_before_taxes">{{$t('257')}}</label>
                                    <input type="number" class="form-control" disabled name="price_before_taxes" :value="form.price_before_taxes">
                                </div>

                                <div class="col-sm-2">
                                    <label for="taxes_value">{{$t('256')}}</label>
                                    <input type="number" class="form-control" disabled name="taxes_value" :value="form.taxes_value">
                                </div>

                                <div class="col-sm-2">
                                    <label for="total_cost">{{$t('245')}}</label>
                                    <input type="number" class="form-control" disabled name="total_cost" :value="form.total_cost">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <button v-show="!editmode" type="submit" class="btn btn-success default mr-3">{{ $t('104') }}</button>
                            <button v-show="!editmode" type="submit" class="btn btn-success default mr-3">{{ $t('265') }}</button>
                            <button v-show="editmode" type="submit" class="btn btn-success default mr-3">{{ $t('105') }}</button>
                            <button v-show="editmode" type="button" class="btn btn-success default mx-3" @click="printForTicket">{{ $t('212') }}</button>
                            <button type="button" class="btn btn-danger default ml-3"  data-dismiss="modal">{{ $t('114') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Disabled Modal -->
        <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="updateLabel" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <span class="badge badge-pill badge-success">{{ form.client_status }}</span>
                        <button type="button" class="close" style="color:black;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                        <div class="modal-body bg-light disabled" id="update">
                           <div class="row">
                                <div class="col-md-2">
                                   <h5><span class="badge badge-pill badge-secondary">{{ form.serial_number }}</span></h5>
                                </div>

                                <div class="col-md-3">
                                    <input v-model="form.ticket_date" type="text" name="ticket_date" :placeholder="ticket_date" onblur="(this.type='text')" onfocus="(this.type='date')" class="form-control form-rounded" :class="{ 'is-invalid': form.errors.has('ticket_date') }">
                                    <has-error :form="form" field="ticket_date"></has-error>
                                </div>

                                <div class="col-md-1"></div>

                                <div class="col-md-3">
                                   <select class="form-control form-rounded" name="wash" v-model="form.wash">
                                        <option selected value="-1">{{$t('204')}}</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <select class="form-control form-rounded" name="ticket_status" v-model="form.ticket_status">
                                        <option selected value="-1">{{$t('205')}}</option>
                                        <option selected value="1">{{$t('238')}}</option>
                                        <option selected value="2">{{$t('239')}}</option>
                                        <option selected value="3">{{$t('240')}}</option>
                                        <option selected value="4">{{$t('241')}}</option>
                                    </select>
                                </div>
                           </div>

                           <div class="row mt-3">
                                <div class="col-md-2">
                                   <select class="form-control form-rounded" name="client" v-model="form.client">
                                        <option selected value="-1">{{$t('206')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-1 mt-1" style="margin-left:-7px; width">
                                    <button class="btn btn-sm btn-success default">
                                    <i class="fas fa-plus"></i></button>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input v-model="form.phone_number" type="text" name="phone_number" :placeholder="phone_number" class="form-control form-rounded" :class="{ 'is-invalid': form.errors.has('phone_number') }">
                                        <has-error :form="form" field="phone_number"></has-error>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                   <select class="form-control form-rounded" name="carpet_size" v-model="form.carpet_size">
                                        <option selected value="-1">{{$t('208')}}</option>
                                        <option v-for="size in sizes" :key="size.sys_code" :value="size.sys_code">{{ size.name }}</option>
                                    </select>
                                </div>
                                <div class="col-md-1 mt-1" style="margin-left:-7px; width">
                                    <button type="button" class="btn btn-sm btn-success default" @click="newCode_tableModal(4)">
                                    <i class="fas fa-plus"></i></button>
                                </div>

                                <div class="col-md-2">
                                   <select class="form-control form-rounded" name="wash_type" v-model="form.wash_type">
                                        <option selected value="-1">{{ $t('209') }}</option>
                                        <option v-for="type in types" :key="type.sys_code" :value="type.sys_code">{{ type.name }}</option>
                                    </select>
                                </div>
                                <div class="col-md-1 mt-1" style="margin-left:-7px; width">
                                    <button type="button" class="btn btn-sm btn-success default" @click="newCode_tableModal(5)">
                                    <i class="fas fa-plus"></i></button>
                                </div>
                           </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <input v-model="form.receipt_time" type="text" name="receipt_time"  :placeholder="receipt_time" onblur="(this.type='text')" onfocus="(this.type='time')" class="form-control form-rounded" :class="{ 'is-invalid': form.errors.has('receipt_time') }">
                                    <has-error :form="form" field="receipt_time"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <input v-model="form.exit_time" type="text" name="exit_time"  :placeholder="exit_time" onblur="(this.type='text')" onfocus="(this.type='time')" class="form-control form-rounded" :class="{ 'is-invalid': form.errors.has('exit_time') }">
                                    <has-error :form="form" field="exit_time"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <input v-model="form.receipt_date" type="text" name="Time of receipt" :placeholder="entrance_date" onblur="(this.type='text')" onfocus="(this.type='date')" class="form-control form-rounded" :class="{ 'is-invalid': form.errors.has('receipt_date') }">
                                    <has-error :form="form" field="receipt_date"></has-error>
                                </div>

                                <div class="col-md-3">
                                    <input v-model="form.expected_exit_date" type="text" name="expected_exit_date" :placeholder="expected_exit_date" onblur="(this.type='text')" onfocus="(this.type='date')" class="form-control form-rounded" :class="{ 'is-invalid': form.errors.has('expected_exit_date') }">
                                    <has-error :form="form" field="expected_exit_date"></has-error>
                                </div>
                           </div>

                            <div class="row mt-3  d-flex justify-content-center">
                                <div class="col-md-12">
                                    <div class="card card-default">
                                        <div class="card-body">
                                            <div class="table-responsive p-0">
                                                <form @submit.prevent="createMaterial()">
                                                    <table class="table text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ $t('229') }}</th>
                                                                <th>{{ $t('227') }}</th>
                                                                <th>{{ $t('228') }}</th>
                                                                <th>{{ $t('244') }}</th>
                                                                <th>{{ $t('113') }}</th>
                                                                <th>{{ $t('230') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <select class="form-control" name="product_id" v-model="serviceForm.product_id" @change="get_services" style="min-width:120px;">
                                                                        <option v-for="pro in products" :key="pro.id" :value="pro.id">{{ pro.name }}</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control" name="unit_id" v-model="serviceForm.unit_id" @change="get_cost" style="min-width:120px;">
                                                                        <option v-for="unt in units" :key="unt.id" :value="unt.id">{{ unt.name }}</option>
                                                                    </select>
                                                                </td>
                                                                <td><input  type="number" class="form-control" name="cost" disabled :value="serviceForm.cost" style="min-width:80px;"></td>
                                                                <td><input  type="number" class="form-control" name="extra_cost" :value="serviceForm.extra_cost" style="min-width:80px;"></td>
                                                                <td><textarea class="form-control" name="description" v-model="serviceForm.description" style="min-width:80px;"></textarea></td>
                                                                <td><button type="submit" class="btn btn-sm btn-info">{{$t('133')}}</button></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                        <table class="table text-center">
                                            <tbody v-for="mat in materials.data" :key="mat.id">
                                                <tr>
                                                    <td>{{mat.name}}</td>
                                                    <td>{{mat.units}}</td>
                                                    <td>{{mat.cost}}</td>
                                                    <td>
                                                        <a href="#" @click="deleteMaterial(mat.id)">
                                                            <i class="fa fa-trash" style="color:red;"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <div class="d-flex justify-content-center">
                                                <pagination :data="materials" @pagination-change-page="getMaterials"></pagination>
                                            </div>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row d-flex justify-content-center">
                                <div class="col-sm-2">
                                    <label for="total_services">{{$t('242')}}</label>
                                    <input type="number" class="form-control" disabled name="total_services" :value="form.total_services">
                                </div>

                                <div class="col-sm-2">
                                    <label for="total_discount">{{$t('264')}}</label>
                                    <input type="number" class="form-control" disabled name="total_discount" :value="form.total_discount">
                                </div>

                                <div class="col-sm-3">
                                    <label for="price_before_taxes">{{$t('257')}}</label>
                                    <input type="number" class="form-control" disabled name="price_before_taxes" :value="form.price_before_taxes">
                                </div>

                                <div class="col-sm-2">
                                    <label for="taxes_value">{{$t('256')}}</label>
                                    <input type="number" class="form-control" disabled name="taxes_value" :value="form.taxes_value">
                                </div>

                                <div class="col-sm-2">
                                    <label for="total_cost">{{$t('245')}}</label>
                                    <input type="number" class="form-control" disabled name="total_cost" :value="form.total_cost">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <button v-show="updatemode" type="button" class="btn btn-success default mx-3" @click="AddTicketStatus">{{ $t('213') }}</button>
                            <button v-show="updatemode" type="button" class="btn btn-success default mx-3" @click="AddRate">{{ $t('214') }}</button>
                            <button v-show="updatemode" type="button" class="btn btn-success default mx-3" @click="AddInform">{{ $t('215') }}</button>
                            <button type="button" class="btn btn-danger default ml-3"  data-dismiss="modal">{{ $t('114') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Codetable Modal -->
        <div class="modal fade" id="codeTableModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="!editmode" id="addNewLabel">{{ $t('102') }}</h5>
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="editmode" id="addNewLabel">{{ $t('105') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createNew">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ $t('50') }}</label>
                                <input v-model="code_tableForm.sys_code_type" type="hidden" name="sys_code_type">
                                <input v-model="code_tableForm.name" type="text" name="name" placeholder="English Description" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{ $t('56') }}</label>
                                <input v-model="code_tableForm.name_ar" type="text" name="name_ar" placeholder="الاسم بالعربية" class="form-control" dir="rtl">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-show="!editmode" type="submit" class="btn btn-success">{{ $t('121') }}</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">{{ $t('105') }}</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $t('114') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- client Modal -->
        <div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="clientLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="!editmode" id="clientLabel">{{ $t('102') }}</h5>
                        <h5 class="modal-title w-100 font-weight-bold py-2" v-show="editmode" id="clientLabel">{{ $t('105') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createNewClient">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ $t('229') }}</label>
                                <input v-model="clientForm.name" type="text" name="name" placeholder="Enter Client Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{ $t('207') }}</label>
                                <input v-model="clientForm.phone" type="text" name="phone" placeholder="Enter Client Phone" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{ $t('18') }}</label>
                                <select class="form-control form-rounded" name="client_status" v-model="clientForm.status">
                                    <option value="1">{{$t('401')}}</option>
                                    <option value="2">{{$t('402')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">{{ $t('121') }}</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $t('114') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Rate Modal -->
        <div class="modal fade" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="rateLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 font-weight-bold py-2" id="rateModal">{{ $t('214') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="updateRate">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ $t('266') }}</label>
                                <label>{{ $t('18') }}</label>
                                <select class="form-control form-rounded" name="status" v-model="rateForm.status">
                                    <option value="1">{{$t('401')}}</option>
                                    <option value="2">{{$t('402')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">{{ $t('121') }}</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $t('114') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ticket Status Modal -->
        <div class="modal fade" id="TicketStatusModal" tabindex="-1" role="dialog" aria-labelledby="TicketStatusModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 font-weight-bold py-2" id="TicketStatusModal">{{ $t('205') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="updateTicketStatus">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ $t('205') }}</label>
                                <select class="form-control form-rounded" name="status" v-model="ticketStatusForm.status">
                                    <option selected value="-1">{{$t('205')}}</option>
                                    <option selected value="1">{{$t('238')}}</option>
                                    <option selected value="2">{{$t('239')}}</option>
                                    <option selected value="3">{{$t('240')}}</option>
                                    <option selected value="4">{{$t('241')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-show="!editmode" type="submit" class="btn btn-success">{{ $t('121') }}</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">{{ $t('105') }}</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $t('114') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Inform Modal -->
        <div class="modal fade" id="InformModal" tabindex="-1" role="dialog" aria-labelledby="InformModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 font-weight-bold py-2" id="InformModal">{{ $t('269') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="informAdmin">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ $t('270') }}</label>
                                <input  type="text" class="form-control" name="topic" v-model="InformForm.topic">
                            </div>

                            <div class="form-group">
                                <label>{{ $t('271') }}</label>
                                <textarea class="form-control" name="message" v-model="InformForm.message"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">{{ $t('272') }}</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $t('114') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- showTicket_Modal -->
        <div class="modal fade" id="showTicket" tabindex="-1" role="dialog" aria-labelledby="showTicketLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center w-100 font-weight-bold py-2" id="showTicketLabel">{{ $t('246') }}</h5>
                        <button type="button" style="color:black;" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="PrintTicket">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>{{ $t('247') }}</th>
                                    <td>
                                        {{ ticket_show.serial_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('194') }}</th>
                                    <td>
                                        {{ ticket_show.client }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('207') }}</th>
                                    <td>
                                        {{ ticket_show.phone }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('195') }}</th>
                                    <td>
                                        {{ ticket_show.id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('248') }}</th>
                                    <td>
                                        {{ ticket_show.wash_type==1?($t('99')+' 1'):($t('99')+' 2')}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('251') }}</th>
                                    <td>
                                        {{ ticket_show.carpet_size }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('196') }}</th>
                                    <td>
                                        {{ ticket_show.num_of_materials }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('197') }}</th>
                                    <td>
                                        {{ ticket_show.total_price }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('205') }}</th>
                                    <td v-if="ticket_show.ticket_status==1"><span class="badge badge-danger">{{$t('238')}}</span></td>
                                    <td v-else-if="ticket_show.ticket_status==2"><span class="badge badge-warning">{{$t('239')}}</span></td>
                                    <td v-else-if="ticket_show.ticket_status==3"><span class="badge badge-info">{{$t('240')}}</span></td>
                                    <td v-else><span class="badge badge-success">{{$t('241')}}</span></td>
                                </tr>
                                <tr>
                                    <th>{{ $t('203') }}</th>
                                    <td>
                                        {{ ticket_show.ticket_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('210') }}</th>
                                    <td>
                                        {{ ticket_show.receipt_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ $t('243') }}</th>
                                    <td>
                                        {{ ticket_show.expected_exit_date }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                    <button class="btn btn-info" @click="print"><i class="fas fa-print fa-fw"></i>&nbsp; {{$t('212')}}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $t('114') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    $("#update").addClass("disabled");
    import moment from 'moment';
    export default {
        data: function(){
            return{
                editmode: false,
                updatemode: false,
                carpets :{},
                sizes:{},
                types:{},
                products:{},
                clients:{},
                units:{},
                materials:{},
                ticket_show:{},
                client_status:'',
                total_tickets:0,
                servs:0,
                fin_cost:0,

                filter:-1,
                enter_date:new Date().toISOString().slice(0, 10),
                exit_date:'',
                enter_time:moment().format('HH:mm'),
                exit_time_filter:'',
                ticket:1,

                form: new Form({
                    id:'',
                    serial_number :-1,
                    ticket_date:new Date().toISOString().slice(0, 10),
                    wash:1,
                    ticket_status:1,
                    client:-1,
                    client_status:1,
                    phone:'',
                    carpet_size:-1,
                    wash_type:-1,
                    receipt_date:'',
                    expected_exit_date:'',
                    exit_time:'',
                    receipt_time:'',
                    total_cost:0,
                    total_services:0,
                    taxes_value:0,
                    price_before_taxes:0,
                    total_discount:0,
                }),
                type_x:2,
                serviceForm:new Form({
                    id:'',
                    ticket_id:'',
                    type:'',
                    product_id:'',
                    unit_id:'',
                    cost:0,
                    extra_cost:0,
                    total_cost:0,
                    total_materials:0,
                    description:'',
                }),

                code_tableForm:new Form({
                    sys_code_type:'',
                    sys_code:'',
                    name:'',
                    name_ar:'',
                }),

                clientForm:new Form({
                    id:'',
                    name:'',
                    phone:'',
                    status:1
                }),

                rateForm:new Form({
                    client_id:'',
                    status:1,
                }),

                ticketStatusForm:new Form({
                    ticket_id:'',
                    status:'',
                }),

                InformForm:new Form({
                    id:'',
                    ticket_id:'',
                    ticket_type:2,
                    topic:'',
                    message:'',
                })
            }
        },

        methods: {
            get_client_phone(){
                axios.get('api/get_client/'+this.form.client).then((res) => {
                    this.client_status=res.data['status']
                    this.form.phone=res.data['phone']
                    this.form.client=res.data['id']
                })
            },

            get_total_tickets(){
                axios.get('api/get_total_tickets').then((res) => {
                    this.total_tickets=res.data
                })
            },

            get_total_servs(){
                axios.get('api/carpet_washing_get_total_servs').then((res) => {
                    this.servs=res.data
                })
            },

            get_total_tickcost(){
                axios.get('api/carpet_washing_get_total_cost').then((res) => {
                    this.fin_cost=res.data
                })
            },

            get_total_cost(){
                axios.get('api/carpet_washing_get_total_cost/'+this.serviceForm.ticket_id).then((res) => {
                    var r=(res.data/100*15).toFixed(2)
                    var x=res.data
                    this.form.taxes_value=r
                    this.form.price_before_taxes = x
                    this.form.total_cost=(parseFloat(r)+parseFloat(x)).toFixed(2)
                });

                axios.get('api/carpet_washing_get_total_services/'+this.serviceForm.ticket_id).then((res) => {
                    this.form.total_services=res.data
                })

                axios.get('api/carpet_washing_get_total_discount/'+this.serviceForm.ticket_id).then((res) => {
                    this.form.total_discount=res.data
                })
            },

            print(){
                this.$htmlToPaper('PrintTicket');
            },

            printForTicket(){
                this.form.get('api/carpet_wash_show/'+this.form.id).then((response) => {
                    this.ticket = response.data;
                });
                $('#showTicket').modal('show');
            },

            printForCarpet(){
                this.$htmlToPaper('PrintCarpet');
            },

            getResults(page = 1) {
                this.cars={}
                var one='xx'
                var two='xx'
                if(this.filter==1){
                    one=this.enter_date
                    if(this.exit_date!='')
                        two=this.exit_date
                }else if(this.filter==2){
                    one=this.enter_time
                    if(this.exit_time_filter!='')
                        two=this.exit_time_filter
                }else if(this.filter==3){
                    one=this.ticket
                }
                axios.get('api/carpet_wash/'+ this.filter+"/"+one+"/"+two+'?page=' + page).then((res) => {
                    this.carpets = res.data;
                });
            },

            get_all_data(){
                axios.get('api/get_clients').then((res) => {
                    this.clients = res.data;
                });
                axios.get('api/car_washing/4').then((res) => {
                    this.sizes=res.data
                        if(res.data!=[])
                            this.form.carpet_size=res.data[0]['sys_code']
                });
                axios.get('api/car_washing/5').then((res) => {
                    this.types=res.data
                        if(res.data!=[])
                            this.form.wash_type=res.data[0]['sys_code']
                });
                this.get_services();
            },

            get_serial(){
                axios.get('api/get_carpet_serial').then((res) => {
                    this.form.serial_number = res.data;
                });
            },

            getMaterials(page = 1) {
                if(this.form.id!='')
                axios.get('api/carpet_material/'+this.form.id+'/2?page=' + page).then((res) => {
                    this.materials = res.data;
                });
            },

            getId(){
                axios.get('api/carpet_washing_get_id').then((res) => {
                    this.form.id = res.data
                });
            },

            get_product_manages(){
                axios.get('api/carpet_washing_get_product_manages').then((res) => {
                    this.products = res.data
                });
            },

            get_services(){
                if(this.serviceForm.product_id!='')
                axios.get('api/carpet_washing_get_units/'+this.serviceForm.product_id).then((res) => {
                    this.units = res.data
                });
            },

            get_cost(){
                axios.get('api/carpet_washing_get_cost/'+this.serviceForm.unit_id).then((res) => {
                    this.serviceForm.cost = res.data
                });
            },

            getCodeTable() {
                axios.get('api/car_washing/' + this.code_tableForm.sys_code_type).then((res) => {
                    if(this.code_tableForm.sys_code_type==4){
                        this.sizes=res.data
                        if(res.data!=[])
                        this.form.carpet_size=res.data[0]['sys_code']
                    }
                    else if(this.code_tableForm.sys_code_type==5){
                        this.types=res.data
                        if(res.data!=[])
                        this.form.wash_type=res.data[0]['sys_code']
                    }
                });
            },

            newCode_tableModal(x){
                this.code_tableForm.reset();
                this.code_tableForm.sys_code_type=x
                $('#codeTableModal').modal('show');
            },

            createNew(){
                this.code_tableForm.post('api/car_washing_add_code_table').then(()=>{
                    Fire.$emit('AfterCreateCode_table');
                    $('#codeTableModal').modal('hide')
                    swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Item Created successfully',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.$Progress.finish();
                })
            },

            newModal(){
                this.editmode = false;
                this.form.reset();
                this.get_serial()
                $('#addNew').modal('show');
                this.getId()
            },

            newStatus(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            createUser(){
                this.$Progress.start();
                this.form.post('api/carpet_wash').then(()=>{
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

            editCarpet(user){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);
                this.serviceForm.ticket_id=user.id
                this.form.client=user.client_id
                this.getMaterials();
                this.get_total_cost()
                this.get_client_phone()
            },

            UpdateCarpet(user){
                this.updatemode = true;
                this.form.reset();
                $('#update').modal('show');
                this.form.fill(user);
                this.serviceForm.ticket_id=user.id
                this.getMaterials();
                this.get_total_cost()
            },

            updateUser(){
                this.$Progress.start();
                this.form.put('api/carpet_wash/'+this.form.id).then(() => {
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

            deleteCarpet(id){
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
                        this.form.delete('api/carpet_wash/'+id).then(()=>{
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

            showCarpet(id){
                $('#showTicket').modal('show');
                this.form.get('api/carpet_wash_show/'+id).then((response) => {
                    this.ticket_show = response.data[0];
                });
            },

            createMaterial(){
                this.serviceForm.type=this.type_x
                this.serviceForm.ticket_id=this.form.id
                this.$Progress.start();
                this.serviceForm.post('api/carpet_material').then(()=>{
                    Fire.$emit('AfterCreateInside');
                    this.serviceForm.reset()
                    this.serviceForm.ticket_id=this.form.id
                })
                this.get_total_cost()
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
                        this.serviceForm.delete('api/carpet_material/'+id).then(()=>{
                            Fire.$emit('AfterCreateInside');
                        }).catch(()=> {
                            swal.fire("Failed!", "This data assigned to an employee.", "warning");
                        });
                    }
                })
            },

            UpdateCarpet(user){
                console.log(user)
                this.rateForm.client_id=user.client_id
                this.rateForm.status=user.client_status

                this.ticketStatusForm.ticket_id=user.id
                this.ticketStatusForm.status=user.ticket_status

                this.InformForm.ticket_id=user.id
                this.InformForm.ticket_type=2

                this.updatemode = true;
                this.form.reset();
                $('#update').modal('show');
                this.form.fill(user);
                this.serviceForm.ticket_id=user.id
                this.getMaterials();
                this.get_total_cost()
            },

            /* client Modal */
            openClientModal(){
                this.clientForm.reset();
                $('#clientModal').modal('show');
            },

            createNewClient(){
                this.clientForm.post('api/create_client').then(()=>{
                    $('#clientModal').modal('hide');
                    this.get_all_data()
                    this.clientForm.reset()
                })
            },

            /*  show Rate Model */
            AddRate(){
                $('#rateModal').modal('show');
            },

            updateRate(){
                this.client_status=this.rateForm.status
                this.rateForm.post('api/update_rate').then(()=>{
                    $('#rateModal').modal('hide');
                    this.get_all_data()
                })
            },

            /*  show Ticket Status Model */
            AddTicketStatus(){
                $('#TicketStatusModal').modal('show');
            },

            updateTicketStatus(){
                this.form.ticket_status=this.ticketStatusForm.status
                this.ticketStatusForm.post('api/update_ticket_status_carpet').then(()=>{
                    $('#TicketStatusModal').modal('hide');
                    this.get_all_data()
                    this.getResults();
                })
            },

            /*  show Inform Status Model */
            AddInform(){
                $('#InformModal').modal('show');
            },

            informAdmin(){
                this.InformForm.post('api/informAdmin').then(()=>{
                    $('#InformModal').modal('hide');
                    this.get_all_data()
                })
            },
        },

        created(){
            this.get_product_manages();
            this.getResults();
            this.get_all_data();
            this.get_total_tickets();
            this.get_total_servs();
            this.get_total_tickcost();
            Fire.$on('AfterCreate',() => {
                this.getResults();
                this.get_total_tickets();
                this.get_total_servs();
                this.get_total_tickcost();
            });

            Fire.$on('AfterCreateCode_table',() => {
                this.getCodeTable();
            });

            Fire.$on('AfterCreateInside',() => {
                this.getMaterials();
                this.get_total_cost()
            });
        },

        computed: {
            ticket_date() {
                return this.$t('203')
            },

            phone_number() {
                return this.$t('207')
            },

            entrance_date() {
                return this.$t('210')
            },

            expected_exit_date() {
                return this.$t('211')
            },

            receipt_time() {
                return this.$t('254')
            },

            exit_time() {
                return this.$t('255')
            },
        }
    }
</script>
<style scoped>
    button{
        color:white;
    }
    .form-rounded {
        border-radius: 1rem;
    }
    .default{
        border-radius: 20px;
    }
    .form-control:focus {
    border-color: inherit;
    -webkit-box-shadow: none;
    box-shadow: none;
    }
    .verticalLine {
    border-left: thin solid black;
    }
    input[disabled][type='number']{
        /*color: rgb(0,0,0);*/
        background-color:lightblue;
    }
    .disabled{
        pointer-events: none;
        opacity: 0.6;
    }
</style>
