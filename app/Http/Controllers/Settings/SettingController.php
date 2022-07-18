<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Crypt;
use Illuminate\Http\Request;
use App\Http\Requests\Affiliates\Idmatrix;
use App\Http\Requests\Settings\DmoRequest;
use App\Models\Plans\PlanDmo;
use App\Models\{MoveInCalender,Settings};
use App\Http\Requests\Settings\{
   NationalHolidayRequest,StateHolidayRequest,WeekContentRequest
};
use Illuminate\Support\Facades\Route;
class SettingController extends Controller
{
   public function index(){
      $request = new Request([
         'action'  => 'master',
      ]);
      $result = PlanDmo::getdmoContent($request);
      return view('pages.settings.index', compact('result'));
    }

  	public function update(DmoRequest $request){
      	$update = PlanDmo::UpdateRateDetails($request);
		if ($update) {
			return response()->json(['status' => true, 'message' => trans('settings.update'),'id' => $update->id], 200);
		} else {
			return response()->json(['status' => true, 'message' => trans('settings.update_error')], 400);
		}
    }

   /**
    * Author: Geetanjali(29-March-2022)
    * holidayCalendar
    */
   public function holidayCalendar(Request $request){

		$currentURL = Route::getFacadeRoot()->current()->uri();
		$info = 'Holiday Calendar';
		$weekend_content = MoveInCalender::where('holiday_type', WEEKEND_HOLIDAY_TYPE)->select('holiday_title', 'holiday_content')->first();
		$closing_time = Settings::where('key', '=', 'move_in_closing_time')->value('value');
      	return view('pages.settings.calender.move-in-calender', compact('info','weekend_content', 'closing_time','currentURL'));

    }

	public function getCalendarEvents(Request $request){

		$start_date_calender = $request->input('start');

		$holidays = [];$json_array = [];
		$end_date_calender = $request->input('end');

		$current_date = \Carbon::now()->format('Y-m-d');
		$closing_time = Settings::where('key', '=', 'move_in_closing_time')->value('value');
		if ($start_date_calender < $current_date) {
			$start_date_calender = $current_date;
		}
		$state_requested = $request->input('state_requested');
		$calender_records = MoveInCalender::whereBetween('date', [$start_date_calender, $end_date_calender])->where(function ($q) use ($state_requested) {
			$q->where('holiday_type', NATIONAL_HOLIDAY_TYPE)
				->orWhere(function ($query) use ($state_requested) {
					$query->where('state', $state_requested)
						->where('holiday_type', STATE_HOLIDAY_TYPE);
				});
		})->get();
		// echo "<pre>";print_r($start_date_calender);echo "-->";print_r($end_date_calender);echo "-->";print_r($calender_records);die;
		// check if records empty or not
		if (!empty($calender_records)) {
			$calender_records = $calender_records->toArray();
			foreach ($calender_records as $value) {
				$subarray = "";
				$subarray = [
					'id' => \Crypt::encrypt($value['id']),
					'title' => $value['holiday_title'],
					'description' => $value['holiday_content'],
					'start' => date('Y-m-d', strtotime($value['date'])),
					'end' => date('Y-m-d', strtotime($value['date']))
				];
				$json_array[] = $subarray;
				$holidays[] = $value['date'];
			}
		}

		$expected_days = array('Saturday', 'Sunday');
		// get sat and sunday dates b/w two dates.
		$weekend_days = self::isWeekend($start_date_calender, $end_date_calender, $expected_days);
		// add weekend content if content is set.
		if (!empty($weekend_content)) {
			if (!empty($weekend_days)) {
				foreach ($weekend_days as $value) {
					$subarray = "";
					$subarray = [
						'id' => '',
						'title' => (isset($weekend_content['holiday_title']) && $weekend_content['holiday_title']) ? $weekend_content['holiday_title'] : '',
						'description' => (isset($weekend_content['holiday_content']) && $weekend_content['holiday_content']) ? $weekend_content['holiday_content'] : '',
						'start' => date('Y-m-d', strtotime($value)),
						'end' => date('Y-m-d', strtotime($value))
					];
					$json_array[] = $subarray;
				}
			}
		}

		$minimum_date = $this->getMinimumSelectDate($closing_time, $holidays);

		return response()->json(array('json' => $json_array, 'minimum_date' => $minimum_date), 200);


	}

   /**
    * Author: Geetanjali(30-March-2022)
    * isWeekend
    */
	public function isWeekend($start_date, $end_date, $expected_days = array()){
	   $start_timestamp = strtotime($start_date);
	   $end_timestamp   = strtotime($end_date);
	   $dates = [];
	   while ($start_timestamp <= $end_timestamp) {
		   if (in_array(date('l', $start_timestamp), $expected_days)) {
			   $dates[] = date('Y-m-d', $start_timestamp);
		   }
		   $start_timestamp = strtotime('+1 day', $start_timestamp);
	   }
	   return $dates;

	}

	/**
    * Author: Geetanjali(30-March-2022)
    * getMinimumSelectDate
    */
	public function getMinimumSelectDate($closing_time, $holidays)
	{
		$time_now = \Carbon::now();
		$min_selectable_date = '';
		if ($closing_time) {
			$time_with_compare = \Carbon::parse($time_now->format('Y-m-d') . ' ' . $closing_time);
			if ($time_now > $time_with_compare) {
				//enter here if current time passed the master closing time
				$add_days = \Carbon::now()->addDay();
				$min_selectable_date = $add_days->toDateString();

				//keep on checking for holiday
				$ahead_days = 1;
				$required_ahead_days = 0;
				while ($required_ahead_days < 2) {
					//if min selectable date is a holiday add 1 more day
					if (in_array($min_selectable_date, $holidays) || $add_days->isWeekend()) {
						$ahead_days++;
					} else {
						$ahead_days++;
						$required_ahead_days++;
					}
					$time_now = \Carbon::now();
					$add_days = $time_now->addDays($ahead_days);
					$min_selectable_date = $add_days->toDateString();
				}

				$add_days = \Carbon::now()->addDays($ahead_days - 1);
				$min_selectable_date = $add_days->toDateString();
			} else {
				//enter here if current time not passed the master closing time
				$add_days = \Carbon::now();
				$min_selectable_date = $add_days->toDateString();

				//keep on checking for holiday
				$ahead_days = 1;
				$required_ahead_days = 0;
				while ($required_ahead_days < 2) {
					//if min selectable date is a holiday add 1 more day
					if (in_array($min_selectable_date, $holidays) || $add_days->isWeekend()) {
						$ahead_days++;
					} else {
						$ahead_days++;
						$required_ahead_days++;
					}
					$time_now = \Carbon::now();
					$add_days = $time_now->addDays($ahead_days - 1);
					$min_selectable_date = $add_days->toDateString();
				}

				$time_now = \Carbon::now();
				$add_days = $time_now->addDays($ahead_days - 2);
				$min_selectable_date = $add_days->toDateString();
			}
		} else {
			//enter here if current time not passed the master closing time
			$add_days = \Carbon::now();
			$min_selectable_date = $add_days->toDateString();

			//keep on checking for holiday
			$ahead_days = 1;
			$required_ahead_days = 0;
			while ($required_ahead_days < 2) {
				//if min selectable date is a holiday add 1 more day
				if (in_array($min_selectable_date, $holidays) || $add_days->isWeekend()) {
					$ahead_days++;
				} else {
					$ahead_days++;
					$required_ahead_days++;
				}
				$time_now = \Carbon::now();
				$add_days = $time_now->addDays($ahead_days - 1);
				$min_selectable_date = $add_days->toDateString();
			}

			$time_now = \Carbon::now();
			$add_days = $time_now->addDays($ahead_days - 2);
			$min_selectable_date = $add_days->toDateString();
		}
		return $min_selectable_date;
	}

   /**
    * Author: Geetanjali(29-March-2022)
    * getNationalHolidays
    */
   public function getNationalHolidays(Request $request)
	{
	  $currentURL = Route::getFacadeRoot()->current()->uri();

      $info = 'National Holidays';
      try {
			$year  = date('Y');
			if ($request->has('sort_year')) {
				$year = $request->sort_year;
			}
			$contents = MoveInCalender::where('year', $year)->where('holiday_type', NATIONAL_HOLIDAY_TYPE)->orderBy('date', 'ASC')->get();

			if($request->ajax()) {

				$records = \View::make('pages.settings.calender.national.national-holiday-tbody', ['contents' => $contents])->render();

            	return response()->json(array('html' => $records));
			}
			return view('pages.settings.calender.national.national-holiday', compact('contents','info','currentURL'));
		} catch (\Exception $e) {

			return back()->with(['error' => $e->getMessage(), 'toast' => true]);
		}
	}

   /**
    * Author: Geetanjali(29-March-2022)
    * saveNationalHolidays
    */
   public function saveNationalHolidays(NationalHolidayRequest $request)
	{
		try {

			$year = date('Y', strtotime($request->input('date')));
			$holiday_date = $request->input('date');
			$string = explode('/', $holiday_date);
			$date = $string[2] . '-' . $string[0] . '-' . $string[1];
			$holiday_title = $request->input('holiday_title');
			$holiday_content = $request->input('holiday_content');
			$id = '';
			if($request->filled('move_in_calender_id')) {


				$id = $request->input('move_in_calender_id');

				$id = Crypt::decrypt($id);
				$records = MoveInCalender::where('year', $year)
					->where(function ($query) use ($holiday_title, $date) {
						$query->where('date', $date)
							->orWhere(function ($x) use ($holiday_title) {
								$x->where('holiday_title', $holiday_title)
									->where('holiday_type', '!=', STATE_HOLIDAY_TYPE);
							});
					})->where('id', '!=', $id)
					->select('holiday_type', 'date', 'holiday_title')
					->first();
			} else {
				$records = MoveInCalender::where('year', $year)
					->where(function ($query) use ($holiday_title, $date) {
						$query->where('date', $date)
							->orWhere(function ($x) use ($holiday_title) {
								$x->where('holiday_title', $holiday_title)
									->where('holiday_type', '!=', STATE_HOLIDAY_TYPE);
							});
					})->select('holiday_type', 'date', 'holiday_title')->first();
			}


			if (!count((array)$records)) {
				$array = [
					'year' => $year,
					'date' => $date,
					'holiday_type' => NATIONAL_HOLIDAY_TYPE, //national
					'state' => '',
					'holiday_title' => $holiday_title,
					'holiday_content' => $holiday_content,
					'created_by' => '',
					'updated_by' => '',
					'status' => 1, //status
				];
				if (MoveInCalender::updateOrCreate(['id' => $id], $array)) {

					$result = [
						'status' => 200,
						'message' => 'Record successfully saved.'
						// ''
					];
				} else {

					// if record not saved then return error.
					$result = [
						'status' => 422,
						'message' => 'Record not saved, Please try again later.'
					];
				}
			} else {
				if ($holiday_title == $records['holiday_title']) {

					$result_message = 'A ' .'National Holiday with title ' . $records['holiday_title'] . ' is already set.';
				}
				if ($date == $records['date']) {
					$result_message = 'A '. 'National Holiday on ' . \Carbon::parse($records['date'])->format('d/m/Y') . ' is already set.';
				}
				$result = [
					'status' => 422,
					'message' => $result_message
				];
			}
			return response()->json($result);
		} catch (\Exception $e) {

			$result = [
				'status' => 422,
				'message' => $e->getMessage()
			];
			return response()->json($result);
		}
	}

   /**
    * Author: Geetanjali(29-March-2022)
    * getStateHolidays
    */
   	public function getStateHolidays(Request $request)
	{
		
		$currentURL = Route::getFacadeRoot()->current()->uri();
		try {
         	$info = 'State Holidays';
			$year = \Carbon\Carbon::now()->year;
			$state = '';
			// check if request has year value or not if not then by default current year value will be selected.
			if ($request->has('sort_year')) {
				$year = $request->sort_year;
			}
			// check if request has selected state name or not.
			if ($request->has('sort_state')) {
				$state = $request->sort_state;
			}
			if($request->has('sort_state') && ($request->sort_state == 'all')){
				$contents = MoveInCalender::where('year', $year)->where('holiday_type', STATE_HOLIDAY_TYPE)->orderBy('date', 'ASC')->get();
			}else{
				$contents = MoveInCalender::where('year', $year)->where('state', $state)->where('holiday_type', STATE_HOLIDAY_TYPE)->orderBy('date', 'ASC')->get();

			}

			
			if ($request->ajax()) {
				$records = \View::make('pages.settings.calender.state.state-holiday-tbody', ['contents' => $contents])->render();
				return response()->json(array('html' => $records));
			}

			return view('pages.settings.calender.state.state-holiday', compact('contents','info','currentURL'));
		} catch (\Exception $e) {
			return back()->with(['error' => $e->getMessage(), 'toast' => true]);
		}
	}

   /**
    * Author: Geetanjali(29-March-2022)
    * saveStateHolidays
    */
   public function saveStateHolidays(StateHolidayRequest $request)
	{
		try {

			$year = date('Y', strtotime($request->input('date')));
			$holiday_date = $request->input('date');
			$string = explode('/', $holiday_date);
			$date = $string[2] . '-' . $string[0] . '-' . $string[1];
			$holiday_title = $request->input('holiday_title');
			$holiday_content = $request->input('holiday_content');
			$state = $request->input('state');
			$id = '';

			// check if request has table id or not.

         if($request->filled('move_in_calender_id')) {
				$id = $request->input('move_in_calender_id');
				$id = Crypt::decrypt($id);
				$records = MoveInCalender::where('year', $year)
					->where(function ($master_query) use ($date, $state, $holiday_title) {
						$master_query->where(function ($query) use ($date) {
							$query->where('holiday_type', NATIONAL_HOLIDAY_TYPE)
								->where('date', $date);
						})
							->orWhere(function ($q) use ($state, $holiday_title, $date) {
								$q->where('state', $state)
									->where(function ($y) use ($date, $holiday_title) {
										$y->where('holiday_title', $holiday_title)
											->orWhere('date', $date);
									});
							});
					})
					->select('holiday_type', 'date', 'holiday_title')
					->where('id', '!=', $id)->first();
			} else {

				$records = MoveInCalender::where('year', $year)
					->where(function ($master_query) use ($date, $state, $holiday_title) {
						$master_query->where(function ($query) use ($date) {
							$query->where('holiday_type', NATIONAL_HOLIDAY_TYPE)
								->where('date', $date);
						})
							->orWhere(function ($q) use ($state, $holiday_title, $date) {
								$q->where('state', $state)
									->where(function ($y) use ($date, $holiday_title) {
										$y->where('holiday_title', $holiday_title)
											->orWhere('date', $date);
									});
							});
					})
					->select('holiday_type', 'date', 'holiday_title')
					->first();

			}
			// check count of records.

			if (!count((array)$records)) {
				$array = [
					'year' => $year,
					'date' => $date,
					'holiday_type' => STATE_HOLIDAY_TYPE,
					'state' => $state,
					'holiday_title' => $holiday_title,
					'holiday_content' => $holiday_content,
					'created_by' => '',
					'updated_by' => '',
					'status' => 1, //status
				];
				if (MoveInCalender::updateOrCreate(['id' => $id], $array)) {
					$result = [
						'status' => 200,
						'message' => 'Record successfully saved.'
					];
				} else {
					// if record not saved then return error.
					$result = [
						'status' => 422,
						'message' => 'Record not saved, Please try again later.'
					];
				}
			} else {
				$result_message = '';

				if ($holiday_title == $records['holiday_title']) {

               // STATE_HOLIDAY_TYPE
					$result_message = 'A ' . 'State Holiday with title ' . $records['holiday_title'] . ' is already set.';
				}
				if ($date == $records['date']) {
					$result_message = 'A ' . 'State Holiday on ' . \Carbon::parse($records['date'])->format('d/m/Y') . ' is already set.';
				}
				$result = [
					'status' => 422,
					'message' => $result_message
				];
			}
			return response()->json($result);
		} catch (\Exception $e) {
			$result = [
				'status' => 422,
				'message' => $e->getMessage()
			];
			return response()->json($result);
		}
	}

   /**
    * Author: Geetanjali(29-March-2022)
    * deleteNationalHoliday
    */
   public function deleteNationalHoliday(Request $request)
	{
		try {
			if ($request->has('id')) {
				$id = Crypt::decrypt($request->id);
				if ($record = MoveInCalender::find($id)) {
					if ($record->delete()) {
						$result = [
							'status' => true,
							'message' => 'Record successfully deleted.'
						];
					} else {
						$result = [
							'status' => false,
							'message' => 'Record not deleted, Plase try again later.'
						];
					}
				} else {
					$result = [
						'status' => false,
						'message' => 'Record Not Found, Plase try again later.'
					];
				}
			} else {
				$result = [
					'status' => false,
					'message' => 'Something went wrong, Plase try again later.'
				];
			}
			return response()->json($result, 200);
		} catch (\Exception $e) {
			$result = [
				'status' => false,
				'message' => $e->getMessage()
			];
			return response()->json($result, 422);
		}
	}

   /**
    * Author: Geetanjali(29-March-2022)
    * deleteStateHoliday
    */
   public function deleteStateHoliday(Request $request)
	{
		try {

			if ($request->has('id')) {
				$id = Crypt::decrypt($request->id);
				if ($record = MoveInCalender::find($id)) {
					if ($record->delete()) {
						$result = [
							'status' => true,
							'message' => 'Record successfully deleted.'
						];
					} else {
						$result = [
							'status' => false,
							'message' => 'Record not deleted, Plase try again later.'
						];
					}
				} else {
					$result = [
						'status' => false,
						'message' => 'Record Not Found, Plase try again later.'
					];
				}
			} else {
				$result = [
					'status' => false,
					'message' => 'Something went wrong, Plase try again later.'
				];
			}
			return response()->json($result, 200);
		} catch (\Exception $e) {
			$result = [
				'status' => false,
				'message' => $e->getMessage()
			];
			return response()->json($result, 422);
		}
	}

   /**
     * Author: Geetanjali(29-March-2022)
     * getWeekendContent
     */
   public function getWeekendContent(WeekContentRequest $request)
	{

		try {
			$id = '';
			$year = date('Y');
			$date = date('Y-m-d');
			$id = MoveInCalender::where('holiday_type', WEEKEND_HOLIDAY_TYPE)->value('id');
			$holiday_title = $request->input('holiday_title');
			$holiday_content = $request->input('holiday_content');
			$array = [
				'year' => $year,
				'date' => $date,
				'holiday_type' => WEEKEND_HOLIDAY_TYPE,
				'state' => '',
				'holiday_title' => $holiday_title,
				'holiday_content' => $holiday_content,
				'created_by' => '',
				'updated_by' => '',
				'status' => 1, //status
			];
			if (MoveInCalender::updateOrCreate(['id' => $id], $array)) {
				$result = [
					'status' => 200,
					'message' => 'Record successfully saved'
				];
			} else {
				// if record not saved then return error.
				$result = [
					'status' => 422,
					'message' => 'Record not saved, Please try again later.'
				];
			}
			// return response in json format.
			return response()->json($result);
		} catch (\Exception $e) {
			$result = [
				'message' => $e->getMessage(),
				'status' => 422
			];
			return response()->json($result);
		}
	}

    /**
     * Author: Geetanjali(29-March-2022)
     * getClosingTime
     */
	public function getClosingTime(Request $request)
	{
		if(!$request->input('move_in_closing_time')){
			$result = [
				'status' => 422,
				'message' => 'Please select time.'
			];
			return response()->json($result);
		}
		try {

			$settings = Settings::where('key', '=', 'move_in_closing_time')->first();
			if ($settings) {
				$inputs['value'] = $request->input('move_in_closing_time');
				$settings->update($inputs);
				return response()->json(array('status' => 200, 'message' => 'Record has been updated successfully'));
			} else {
				$result = [
					'status' => 422,
					'message' => 'Record not saved, Please try again later.'
				];
			}
			// return response in json format.
			return response()->json($result);
		} catch (\Exception $e) {

			$result = [
				'message' => $e->getMessage(),
				'status' => 422
			];
			return response()->json($result);
		}
	}

    /**
     * Author: Prakash Poudel(12-April-2022)
     * saveIdMatrix
     */
    public function saveIdMatrix(Idmatrix $request)
    {
        try {
            $response = PlanDmo::saveIdMatrix($request);
            return response()->json(['status' => true, 'message' => trans('settings.update'), 'matrix_settings' => $response]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => trans('settings.update_error')], 400);
        }
    }

    /**
     * Author: Prakash Poudel(12-April-2022)
     * getIdMatrix
     */
    public function getIdMatrix()
    {
        try {
            return PlanDmo::getIdMatrix();
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Internal server error'], 400);
        }
    }
}
