<?php


namespace App\Http\Controllers\API\Destruction;

use App\Http\Controllers\Controller;
use App\Models\AccTransaction;
use App\Models\Activity;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class DestructionController extends Controller
{

    public function store()
    {
        DB::beginTransaction();
        try {
            $main = Equipment::find(\request()->main_id);
            $transaction = AccTransaction::create(request()->only('type', 'date', 'notes', 'value') + ['user_id' => auth()->id()]);

            if (\request()->type == 'destruction') {
                $transaction->details()->create(['account_id' => \request()->main_account_id, 'creditor' => \request()->destruction_value, 'description' => 'اهلاك', 'date' => \request()->date]);
                $transaction->details()->create(['account_id' => 541, 'debtor' => \request()->destruction_value, 'description' => 'اهلاك اصل ' . $main->name, 'date' => \request()->date]);
                $main->update(['last_destruction_date' => \request()->date]);
                $main->activities()->save(new Activity(['user_id' => auth()->id(), 'type' => 'اضافة امر اهلاك جديد']));
            } elseif (\request()->type == 'selling') {
                $transaction->details()->create(['account_id' => \request()->main_account_id, 'creditor' => $main->account->balance -  \request()->value, 'description' => 'اهلاك بيع', 'date' => \request()->date]);
                $transaction->details()->create(['account_id' => 541, 'debtor' =>  $main->account->balance -  \request()->value, 'description' => 'اهلاك اصل ' . $main->name, 'date' => \request()->date]);
                $transaction->details()->create(['account_id' => \request()->main_account_id, 'creditor' => \request()->value, 'description' => 'قيمة  البيع', 'date' => \request()->date]);
                $transaction->details()->create(['account_id' => \request()->seller_account_id, 'debtor' => \request()->value, 'description' => 'شراء الاصل', 'date' => \request()->date]);
                $main->update(['destruction_end_date' => \request()->date]);
                $main->activities()->save(new Activity(['user_id' => auth()->id(), 'type' => 'تم بيع الاصل']));
            } elseif (\request()->type == 'takheen') {
                $transaction->details()->create(['account_id' => \request()->main_account_id, 'creditor' => $main->account->balance, 'description' => 'تكهين', 'date' => \request()->date]);
                $transaction->details()->create(['account_id' => 542, 'debtor' => $main->account->balance, 'description' => 'تكهين اصل ' . $main->name, 'date' => \request()->date]);
                $main->update(['destruction_end_date' => \request()->date]);
                $main->activities()->save(new Activity(['user_id' => auth()->id(), 'type' => 'تم تكهين الاصل']));
            }

            DB::commit();
            return $main->load('account', 'account.details');
        } catch (Throwable $err) {
            DB::rollback();
            return \response()->json($err, 500);
        }
    }
}
