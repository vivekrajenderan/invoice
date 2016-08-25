<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class Invoice extends Controller {

	public function form()
	{
		$q = DB::table('product')->get();
		return view('inv.form')->with('data',$q);
	}

	public function save(Request $request)
	{
		$post = $request->all();
		$data = array(
						'ordername' => $post['ordername'],
						'location'  => $post['location']
			         );
		$j = DB::table('order')->insertGetId($data);
		if($j > 0)
		{
			for($i=0;$i <count($post['product_id']);$i++)
			{
				$datadetail = array(
					                'order_id' => $j,
					                'product_id'=> $post['product_id'][$i],
					                'quantity'  => $post['qty'][$i],
					                'unitprice' => $post['price'][$i],
					                'discount'  => $post['dis'][$i],
					                'amount'    => $post['amount'][$i]
					                );
				DB::table('orderdetail')->insert($datadetail);
			}
			return redirect('form');
		}

	}
}
