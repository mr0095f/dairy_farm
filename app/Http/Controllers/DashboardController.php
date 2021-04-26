<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\Models\Animal;
use App\Models\Calf;
use App\Models\Supplier;
use App\Models\Expense;
use App\Models\Shed;
use App\Models\CollectMilk;
use App\Models\SaleMilk;
use App\Models\FoodItem;
use Session;
use Auth;
use DB;

class DashboardController extends Controller
{	
	public function index() {
		$data['totalEmployee'] = User::where('id', '!=', 1)->where('branch_id', Session::get('branch_id'))->count();
		$data['totalCow'] = Animal::where('branch_id', Session::get('branch_id'))->count();
		$data['totalCalf'] = Calf::where('branch_id', Session::get('branch_id'))->count();
		$data['totalSupplier'] = Supplier::where('branch_id', Session::get('branch_id'))->count();
		$data['totalShed'] = Shed::where('branch_id', Session::get('branch_id'))->count();
		$data['totalCollectMilk'] = CollectMilk::where('branch_id', Session::get('branch_id'))->sum('liter');
		$data['totalSaleMilk'] = SaleMilk::where('branch_id', Session::get('branch_id'))->sum('litter');
		$data['totalExpense'] = Expense::sum('amount');

		$data['todayCollectMilk'] = CollectMilk::where('branch_id', Session::get('branch_id'))
									->where('date', date('Y-m-d'))->sum('liter');
		$data['todaySaleMilk'] = SaleMilk::where('branch_id', Session::get('branch_id'))
								 ->where('date', date('Y-m-d'))->sum('litter');

		$data['todayCollectMilkAmnt'] = CollectMilk::where('branch_id', Session::get('branch_id'))
									->where('date', date('Y-m-d'))->sum('total');
		$data['todaySaleMilkAmnt'] = SaleMilk::where('branch_id', Session::get('branch_id'))
								 ->where('date', date('Y-m-d'))->sum('total_amount');

		// Chart Of Yearly Donation -------------------------------------------------------------
		$monthly_expense_data = Expense::whereYear('date', date('Y'))
									  ->select(DB::Raw('sum(amount) as total_amount'), DB::raw('MONTH(date) as months'))
									  ->groupBy('months')
									  ->get();	
		for($i=1; $i<=12; $i++){
			$monthly_expense[$i] = 0;
		}
		foreach($monthly_expense_data as $expensedata){
			$monthly_expense[$expensedata->months] = $expensedata->total_amount;
		}
		$data['monthly_expense'] = json_encode($monthly_expense);

		// Chart Of Yearly Milk Sale Amount ------------------------------------------------------
		$monthly_milk_data = SaleMilk::whereYear('date', date('Y'))
							->where('branch_id', Session::get('branch_id'))
							->select(DB::Raw('sum(total_amount) as total_amount'), DB::raw('MONTH(date) as months'))
							->groupBy('months')
							->get();	
		for($i=1; $i<=12; $i++){
			$monthly_milk_sale[$i] = 0;
		}
		foreach($monthly_milk_data as $milksaledata){
			$monthly_milk_sale[$milksaledata->months] = $milksaledata->total_amount;
		}
		$data['monthly_milk_sale'] = json_encode($monthly_milk_sale);

		//-----------------------------------------------------------------------------------------

		$data['lastFiveExpense'] = Expense::leftJoin('expense_purpose', 'expense_purpose.id', 'expenses.purpose_id')
		                           ->select('expenses.*', 'expense_purpose.purpose_name')
		                           ->orderBy('expenses.id', 'desc')
		                           ->limit(5)
						           ->get();

		$data['lastFiveMilkSale'] = SaleMilk::where('branch_id', Session::get('branch_id'))
								 	->orderBy('id', 'desc')
		                           ->limit(5)
						           ->get();

		
		$data['food_items'] = FoodItem::orderBy('name', 'asc')->get();
		$data['all_sheds'] = Shed::where('branch_id', Session::get('branch_id'))->get();
		
		return view('dashboard', $data);
	}
	 
	public function selectBranch()
	{
		return view('branchPanelPopup');
	}

	public function adminSelectedDashboard($branch_id)
	{
		if(Auth::user()->user_type == 1)
		{
			session(['branch_id' => $branch_id]);
			return redirect('dashboard');
		}
	}
}
