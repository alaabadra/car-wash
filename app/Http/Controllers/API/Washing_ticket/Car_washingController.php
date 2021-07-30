<?php

namespace App\Http\Controllers\API\Washing_ticket;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\code_table;
use App\Models\Store_manage\Custom_unit;
use App\Models\Store_manage\Product_manage;
use App\Models\Store_manage\Service;
use App\Models\Washing_tickets\Car;
use App\Models\Washing_tickets\Car_washing;
use App\Models\Washing_tickets\Inform;
use Illuminate\Http\Request;
use Symfony\Polyfill\Intl\Idn\Info;
use Throwable;
use Illuminate\Support\Facades\DB;


class Car_washingController extends Controller
{
    public function getAllClients()
    {
        DB::beginTransaction();
        try {
            $clients = Client::get();
            if ($clients) {
                DB::commit();
                return $clients;
            } else {
                return \response()->json([
                    'data' => 'there is no data',
                    'status' => 404
                ]);
            }
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }
    public function getAllTickets(){
        DB::beginTransaction();
        try {
         $car_wash= Car_washing::get();
 
            if($car_wash){
                DB::commit();
                return $car_wash;
             }else{
               return \response()->json([
                   'data'=>'there is no data',
                   'status'=>404
               ]);
             }
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
 
     }
    public function index($filter, $one, $two)
    {
        DB::beginTransaction();
        try {

            $cars = DB::table('car_washings')
                ->leftJoin('clients', 'clients.id', 'car_washings.client_id')
                ->leftJoin('cars', 'cars.id', 'car_washings.car_id')
                ->select(
                    'car_washings.*',
                    'car_washings.id as id',
                    'clients.name as client',
                    'cars.car_number',
                    'cars.car_letters'
                )
                ->paginate(5);
            $services = Service::where('type', 1)->get();
            foreach ($services as $ser) {
                $x = 1;
                foreach ($cars as $car) {
                    if ($ser->ticket_id == $car->id) {
                        $x = 2;
                        break;
                    }
                }
                if ($x == 1)
                    $ser->delete();
            }

            if ($filter == 1) {
                $cars = Car_washing::where('ticket_date', '>=', $one);
                if ($two != 'xx')
                    $cars->where('ticket_date', '<=', $two);
                return $cars->paginate(5);
            }

            if ($filter == 2) {
                $cars = Car_washing::where('receipt_time', '>=', $one);
                if ($two != 'xx')
                    $cars->where('exit_time', '>=', $two);
                return $cars->paginate(5);
            }

            if ($filter == 3)
                return Car_washing::where('id', $one)->paginate(5);

            if ($cars) {
                DB::commit();
                return $cars;
            } else {
                return \response()->json([
                    'data' => 'there is no data',
                    'status' => 404
                ]);
            }
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    public function check_car_number($number, $letters)
    {
        DB::beginTransaction();
        try {
            if (strlen($letters) != 3)
                return 'letter_error';
            if (strlen($number) > 4) {
                return 'num_error';
            }
            $car = Car::where(['car_number' => $number, 'car_letters' => $letters])->first();
            if ($car) {
                DB::commit();
                return $car;
            } else {
                return \response()->json([
                    'data' => 'there is no data',
                    'status' => 404
                ]);
            }
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    public function get_total_services($ticket_id)
    {
        DB::beginTransaction();
        try {
            $res = Service::where(['ticket_id' => $ticket_id, 'type' => 1])->count();
            if ($res !== 0) {
                DB::commit();
                return $res;
            } else {
                return \response()->json([
                    'data' => 'there is no data',
                    'status' => 404
                ]);
            }
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    public function car_washing_get_total_servs()
    {
        Car_washing::sum('num_of_materials');
    }

    public function car_washing_get_total_cost()
    {
        return Car_washing::sum('total_price');
    }

    public function get_total_tickets()
    {
        $tickets = Car_washing::count('id');
        return $tickets;
    }

    public function get_total_cost($ticket_id)
    {
        return Service::where(['ticket_id' => $ticket_id, 'type' => 1])->sum('cost') + Service::where(['ticket_id' => $ticket_id, 'type' => 1])->sum('extra_cost');
    }

    public function get_total_discount($ticket_id)
    {
        return Service::where(['ticket_id' => $ticket_id, 'type' => 1])->where('extra_cost', '<', '0')->sum('extra_cost') * -1;
    }

    public function get_id()
    {
        return Car_washing::max('id') + 1;
    }

    public function get_product_manages()
    {
        DB::beginTransaction();
        try {

            $res = Product_manage::where('classifications', 1)->get();
            if ($res) {
                DB::commit();
                return $res;
            } else {
                return \response()->json([
                    'data' => 'there is no data',
                    'status' => 404
                ]);
            }
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }
    public function showCar($car_number){
        DB::beginTransaction();
        try {

            $res=Car::where('car_number',$car_number)->first();
            if($res){
                DB::commit();
                return $res;
             }else{
               return \response()->json([
                   'data'=>'there is no data',
                   'status'=>404
               ]);
             }
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
    public function getCar($id){
        DB::beginTransaction();
        try {

            $res=Car::where('id',$id)->first();
            if($res){
                DB::commit();
                return $res;
             }else{
               return \response()->json([
                   'data'=>'there is no data',
                   'status'=>404
               ]);
             }
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }

    }
    public function get_units($product_id)
    {
        DB::beginTransaction();
        try {
            $res = Custom_unit::where('product_id', $product_id)->get();

            if ($res) {
                DB::commit();
                return $res;
            } else {
                return \response()->json([
                    'data' => 'there is no data',
                    'status' => 404
                ]);
            }
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    public function get_cost($unit_id)
    {
        DB::beginTransaction();
        try {

            $unit = Custom_unit::where('id', $unit_id)->first();
            if ($unit) {
                DB::commit();
                return $unit->cost;
            } else {
                return \response()->json([
                    'data' => 'there is no data',
                    'status' => 404
                ]);
            }
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    // 
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            DB::commit();
            $check_car = Car::where(['car_number' => $request->car_number_num_ar, 'car_letters' => $request->car_number_letters_ar])->first();
            $car_id = 0;
            if (!$check_car) {
                $car = new Car;
                $car->account_id = $request->account_id;
                $car->equipment_id = $request->equipment_id;
                $car->car_number = $request->car_number_num_ar;
                $car->card_num = $request->card_num;

                $car->car_letters = $request->car_number_letters_ar;
                $car->brand = $request->brand;
                $car->color = $request->color;
                $car->name = $request->name;
                $car->model = $request->model;
                $car->details = $request->details;

                $car->status = $request->car_status;
                $car->client_id = $request->client_id;
                $car->last_repaire_date = $request->last_repaire_date;
                $car->default_driver_id	 = $request->default_driver_id;
                $car->km= $request->km;

                $car->save();
                $car_id = $car->id;
            } else {
                Car::where([
                    'car_number' => $request->car_number_num_ar, 'car_letters' => $request->car_number_letters_ar])->update([
                    'account_id' => $request->account_id,
                    'brand' => $request->brand,
                    'color' => $request->color,
                    'status' => $request->car_status,
                    'client_id' => $request->client_id,
                ]);
                $car_id = $check_car->id;
            }

            $car_wash = new Car_washing;
            $car_wash->serial_number = $request->serial_number;
            $car_wash->ticket_date = $request->ticket_date;
            $car_wash->wash = $request->wash;
            $car_wash->ticket_status = $request->ticket_status;
            $car_wash->car_id = $car_id;
            $car_wash->client_id = $request->client_id;
            $car_wash->total_discount = $request->total_discount;
            $car_wash->receipt_time = $request->receipt_time;
            $car_wash->exit_time = $request->exit_time;
            $car_wash->num_of_materials = $request->total_services;
            $car_wash->total_price = $request->total_price;
            if ($request->ticket_status == 2)
                $car_wash->pended = 1;
            if ($request->ticket_status == 3) {
                $car_wash->pended = 1;
                $car_wash->completed = 1;
            }
            $car_wash->save();
            $ticketId = $car_wash->id;
            return \response()->json([
                'status' => 200,
                'message' => 'your data been created successfully',
                'ticketId' => $ticketId
            ]);
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $check_car = Car::where(['car_number' => $request->car_number_num_ar, 'car_letters' => $request->car_number_letters_ar])->first();
            $car_id = 0;
            if (!$check_car) {
                $car = Car::where(['id' => $id])->first();
                $car->account_id = $request->account_id;
                $car->equipment_id = $request->equipment_id;
                $car->car_number = $request->car_number_num_ar;
                $car->car_letters = $request->car_number_letters_ar;
                $car->brand = $request->brand;
                $car->color = $request->color;
                $car->status = $request->car_status;
                $car->name = $request->name;
                $car->card_num = $request->card_num;
                $car->model = $request->model;
                $car->details = $request->details;
                $car->km = $request->km;
                $car->last_repaire_date = $request->last_repaire_date;

                $car->type = $request->type;
                $car->client_id = $request->client_id;
                $car->save();
                $car_id = $car->id;
            } else {
                Car::where(['car_number' => $request->car_number_num_ar, 'car_letters' => $request->car_number_letters_ar])->update([
                    'account_id' => $request->account_id,
                    'equipment_id' => $request->equipment_id,
                    'brand' => $request->brand,
                    'color' => $request->color,
                    'status' => $request->car_status,
                    'client_id' => $request->client_id,
                    'name' => $request->name,
                    'card_num' => $request->card_num,
                    'model' => $request->model,
                    'details' => $request->details,
                    'km' => $request->km,
                    'last_repair_date' => $request->last_repair_date,
                ]);
                $car_id = $check_car->id;
            }
            $car_wash = Car_washing::find($id);
            $car_wash->serial_number = $request->serial_number;
            $car_wash->ticket_date = $request->ticket_date;
            $car_wash->wash = $request->wash;
            $car_wash->ticket_status = $request->ticket_status;
            $car_wash->car_id = $car_id;
            $car_wash->client_id = $request->client;
            $car_wash->total_discount = $request->total_discount;
            $car_wash->receipt_time = $request->receipt_time;
            $car_wash->exit_time = $request->exit_time;
            $car_wash->num_of_materials = $request->total_services;
            $car_wash->total_price = $request->total_cost;
            if ($request->ticket_status == 2)
                $car_wash->pended = 1;
            if ($request->ticket_status == 3) {
                $car_wash->pended = 1;
                $car_wash->completed = 1;
            }
            $car_wash->save();
            return \response()->json([
                'status' => 200,
                'message' => 'your data been updated successfully'
            ]);
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            Service::where(['ticket_id' => $id, 'type' => 1])->delete();
          $car=  Car_washing::find($id);
       $car->ticket_status='pending';
            return response(['success', 'this element became pending status'], 200);
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 404);
        }
    }

    public function show_ticket($id)
    {
        DB::beginTransaction();
        try {

            $cars = DB::table('car_washings')
                ->leftJoin('clients', 'clients.id', 'car_washings.client_id')
                ->leftJoin('cars', 'cars.id', 'car_washings.car_id')
                ->leftJoin('code_tables as codes', function ($join) {
                    $join->on('cars.brand', '=', 'codes.sys_code');
                    $join->on('codes.sys_code_type', '=', DB::raw('2'));
                })
                ->leftJoin('code_tables as colors', function ($join) {
                    $join->on('cars.color', '=', 'colors.sys_code');
                    $join->on('colors.sys_code_type', '=', DB::raw('1'));
                })
                ->leftJoin('code_tables as statas', function ($join) {
                    $join->on('cars.color', '=', 'colors.sys_code');
                    $join->on('statas.sys_code_type', '=', DB::raw('3'));
                })
                ->select(
                    'car_washings.*',
                    'car_washings.id as id',
                    'clients.*',
                    'clients.name as client',
                    'codes.name as brand',
                    'cars.car_number as car_number',
                    'cars.car_letters as car_letters',
                    'colors.name as color',
                    'statas.name as status'
                )
                ->where('car_washings.id', $id)
                ->get();
            // dd($cars);
            if ($cars) {
                DB::commit();
                return $cars;
            } else {
                return \response()->json([
                    'data' => 'there is no data',
                    'status' => 404
                ]);
            }
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    public function add_code_table(Request $request)
    {
        DB::beginTransaction();
        try {

            $sys_code = code_table::where('sys_code_type', $request->sys_code_type)->max('sys_code') + 1;
            code_table::create([
                'sys_code_type' => $request->sys_code_type,
                'sys_code' => $sys_code,
                'name' => $request->name,
                'name_ar' => $request->name_ar
            ]);
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    public function show($id)
    {
        DB::beginTransaction();
        try {

            $res = code_table::where('sys_code_type', $id)->get();
            if ($res) {
                DB::commit();
                return $res;
            } else {
                return \response()->json([
                    'data' => 'there is no data',
                    'status' => 404
                ]);
            }
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    public function get_clients()
    {
        DB::beginTransaction();
        try {

            $res = Client::all();
            if ($res) {
                DB::commit();
                return $res;
            } else {
                return \response()->json([
                    'data' => 'there is no data',
                    'status' => 404
                ]);
            }
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    public function get_serial()
    {
        DB::beginTransaction();
        try {

            $serial = Car_washing::max('id') + 1;
            $ser = 0;
            if ($serial <= 9)
                $ser = ' 000' . $serial;
            else if ($serial <= 99)
                $ser = ' 00' . $serial;
            else if ($serial <= 999)
                $ser = ' 0' . $serial;
            else
                $ser = ' ' . $serial;
            $serial = date('Y') . ' 0110' . $ser;
            if ($serial) {
                DB::commit();
                return $serial;
            } else {
                return \response()->json([
                    'data' => 'there is no data',
                    'status' => 404
                ]);
            }
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    public function create_client(Request $request)
    {
        DB::beginTransaction();
        try {

            Client::create($request->all());
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    public function get_client($id)
    {
        try {

            $res = Client::find($id);
            if ($res) {
                return $res;
            } else {
                return \response()->json([
                    'data' => 'there is no data',
                    'status' => 404
                ]);
            }
        } catch (Throwable $err) {
            return \response()->json($err, 500);
        }
    }

    public function update_rate(Request $request)
    {
        DB::beginTransaction();
        try {
            $client = Client::find($request->client_id);
            $client->status = $request->status;
            $client->save();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    public function update_ticket_status(Request $request)
    {
        DB::beginTransaction();
        try {

            $car = Car_washing::find($request->ticket_id);
            if ($request->status == 2) {
                $car->pended = 1;
                $car->receipt_time = date("h:i:s");
            } else if ($request->status == 3) {
                $car->completed = 1;
                $car->exit_time = date("h:i:s");
            }
            $car->ticket_status = $request->status;
            $car->save();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }

    public function inform(Request $request)
    {
        DB::beginTransaction();
        try {
            $inform = new Inform;
            $inform->ticket_id = $request->ticket_id;
            $inform->ticket_type = $request->ticket_type;
            $inform->topic = $request->topic;
            $inform->message = $request->message;
            $inform->save();
            DB::commit();
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }
}
