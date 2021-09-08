<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction as ModelTransaction;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $transactions = ModelTransaction::with('user', 'account', 'category', 'sub_category', 'tag');

        if ($request->filled(['category_id', 'subcategory_id', 'account_id', 'tag_id', 'start_date', 'end_date'])) {
            $transactions->where(function($query) use ($request)  {
                        return $query->where('category_id', 'like', '%'.$request->category_id.'%')
                        ->where('subcategory_id', 'like', '%'.$request->subcategory_id.'%')
                        ->where('account_id', 'like', '%'.$request->account_id.'%')
                        ->where('tag_id', 'like', '%'.$request->tag_id.'%')
                        ->whereBetween('tanggal', array(date($request->start_date), date($request->end_date)));
                });
        }

        if ($request->keyword != null) {
            $transactions->where('keterangan', 'like', '%'.$request->keyword.'%');
        }

        if ($request->transaksi_id == 'terbaru') {
            $transactions->orderBy('id', 'DESC');

        } else if ($request->transaksi_id == 'terlama') {
            $transactions->orderBy('id', 'ASC');

        } else if ($request->nominal == 'tertinggi') {
            $transactions->orderBy('nominal', 'DESC');

        } else if ($request->nominal == 'terendah') {
            $transactions->orderBy('nominal', 'ASC');

        }  else if ($request->tanggal == "terbaru") {
            $transactions->orderBy('tanggal', 'DESC');
            
        }  else if ($request->tanggal == "terlama") {
            $transactions->orderBy('tanggal', 'ASC');
        } 

        return $this->sendResponsePaginate(TransactionResource::collection($transactions->paginate(10)), 'Transactions retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        $user_id = Auth::user()->id;
        $data = array_merge($request->all(), compact('user_id'));

        ModelTransaction::create($data);

        return $this->sendResponse('', 'Adding transaction successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = ModelTransaction::where('id', $id)->firstOrFailToJson('Transaction not found.');

        return $this->sendResponse(new TransactionResource($transaction), 'Get transaction successfully.'); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, $id)
    {
        $transaksi = ModelTransaction::where('id', $id)->firstOrFailToJson('Transaction not found.');
        $user_id = Auth::user()->id;
        $data = array_merge($request->all(), compact('user_id'));

        $transaksi->update($data);
        
        return $this->sendResponse('', 'Update transaction successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaksi = ModelTransaction::where('id', $id)->firstOrFailToJson('Transaction not found.');

        $transaksi->delete();

        return $this->sendResponse('', 'Delete transaction successfully.');
    }
}
