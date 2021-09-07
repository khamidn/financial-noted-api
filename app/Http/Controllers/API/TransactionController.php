<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction as ModelTransaction;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = ModelTransaction::with('user', 'account', 'category', 'sub_category', 'tag')->paginate(10);

        return $this->sendResponsePaginate(TransactionResource::collection($transactions), 'Transactions retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
