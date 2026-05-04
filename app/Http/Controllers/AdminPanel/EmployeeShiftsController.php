<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateDepartmentShiftRequest;
use App\Models\AppType;
use App\Models\Clinic;
use App\Models\Day;
use App\Models\Shift;
use App\Models\ShiftEmployee;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeShiftsController extends Controller
{
    // show department shifts
    function index_old($employee_id)
    {
        $check_authorization = Auth::user()->app_type == 7 ? Auth::user()->id : Auth::user()->parent_id;
        $employee = Clinic::with('employee_shifts')->where('id',$employee_id)->first();
        $days = Day::get();
        $data['shifts'] = Shift::where('clinic_id',$check_authorization)->where('account_type',$employee->app_type)->orderBy('id','desc')->get();
        return view('employee.shifts', compact('employee','data','days'));
    }

    public function index($id)
    {
        $check_authorization = Auth::user()->app_type == 7 ? Auth::user()->id : Auth::user()->parent_id;
        $employee = Clinic::with('employee_shifts')->where('id',$id)->first();
        $data['shifts'] = Shift::where('clinic_id',$check_authorization)->where('account_type',$employee->app_type)->orderBy('id','desc')->get();

        $employee = Clinic::with(['shifts' => function($q) {
            $q->with('shift')->latest();
        }])->findOrFail($id);

        // جلب الشيفتات والإجازات الحالية للموظف
        $employeeShifts = ShiftEmployee::with('shift')
            ->where('employee_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'shifts' => Shift::all(),
        ];

        $days = Day::all(); // أيام الأسبوع من قاعدة البيانات

        // تجهيز الأحداث للكاليندر
        $calendarEvents = $this->prepareCalendarEvents($employeeShifts);

        return view('employee.shifts', compact('employee', 'data', 'days', 'calendarEvents', 'employeeShifts'));
    }

    // add department_shift
    public function add_employee_shift_old($employee_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dateA' => 'required',
        ], [
            'dateA.required' => 'اختر يوم واحد على الاقل',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $auth_app = Auth::user()->app_type == 7 ? Auth::user()->id : Auth::user()->parent_id;

        $clinic = Clinic::where('id', $employee_id)->select('id', 'parent_id', 'app_type')->first();
        $data = $request->all();
        $dates = explode(', ', $request->dateA);
        foreach ($dates as $date) {

            $add_shift = ShiftEmployee::updateOrCreate(
                [
                    'id' => $request->id ?? null,
                ],
                [
                    'account_type' => $clinic->app_type,
                    'employee_id' => $request->employee_id,
                    'clinic_id' => $auth_app,
                    'shift_id' => $request->shift_id,
                    'status' => $request->status,
                    'dateA' => $date,
                ]
            );

//        $data['account_type'] = $clinic->app_type;
//        $data['shift_id'] = $request->shift_id;
//        $data['employee_id'] = $clinic->id;
//        $data['status'] = $request->status;
//        $data['dateA'] = $date;
//        $data['clinic_id'] = Auth::user()->id;
//        $add_shift = ShiftEmployee::create($data);
    }
        if ($add_shift) {
            session()->flash('success', trans('messages.Added'));
            return redirect()->back();
        }
    }


    public function add_employee_shift_olllll($employee_id, Request $request)
    {
        $request->validate([
            'dateA'      => 'required_if:status,0',
            'status'     => 'required|in:0,1',
            'shift_id'   => 'nullable|array|max:2',
            'shift_id.*' => 'nullable|exists:shifts,id',
            'days'       => 'required|array|min:1',
            'days.*'     => 'exists:days,id',
        ], [
            'dateA.required' => 'اختر يوم واحد على الأقل',
        ]);

        $auth_app = Auth::user()->app_type == 7
            ? Auth::user()->id
            : Auth::user()->parent_id;

        $clinic = Clinic::select('id','app_type')->findOrFail($employee_id);

        $dates  = array_map('trim', explode(',', $request->dateA));
        $days   = $request->days; // day_id[]
        $shifts = array_filter($request->shift_id ?? []);

        foreach ($dates as $date) {


            // 🟥 Holiday
            if ($request->status == 0) {

                // حذف أي شيفتات قديمة في نفس اليوم
                ShiftEmployee::where('employee_id', $clinic->id)
                    ->whereDate('dateA', $date)
                    ->delete();

                ShiftEmployee::create([
                    'employee_id' => $clinic->id,
                    'clinic_id'   => $auth_app,
                    'account_type'=> $clinic->app_type,
                    'dateA'       => $date,
                    'status'      => 0,
                    'shift_id'    => null,
                ]);

                continue;
            }

            // 🟩 Working day (1 or 2 shifts)
            $i = 0;
            foreach ($shifts as $shiftId) {

                ShiftEmployee::updateOrCreate(
                    [
                        'employee_id' => $clinic->id,
                        'shift_id'    => $shiftId,
                        'dateA'       => $date,
                    ],
                    [
                        'day_id'   => $days[$i],
                        'clinic_id'   => $auth_app,
                        'account_type'=> $clinic->app_type,
                        'status'      => 1,
                    ]
                );
                $i++;
            }
        }

        session()->flash('success', trans('messages.Added'));
        return redirect()->back();
    }



    public function add_employee_shift_olds($employee_id, Request $request)
    {
        // إزالة validation لـ dateA من هنا
        $request->validate([
            'status'     => 'required|in:0,1',
            'shift_id'   => 'nullable|array|max:2',
            'shift_id.*' => 'nullable|exists:shifts,id',
            'days'       => 'required_if:status,1|array|min:1',
            'days.*'     => 'exists:days,id',
        ], [
            'days.required_if' => 'اختر أيام الأسبوع للعمل',
        ]);

        // التحقق يدوياً من dateA
        if (!$request->has('dateA') || empty(trim($request->dateA))) {
            return redirect()->back()->withErrors(['dateA' => 'يرجى اختيار التواريخ أولاً'])->withInput();
        }

        $auth_app = Auth::user()->app_type == 7
            ? Auth::user()->id
            : Auth::user()->parent_id;

        $clinic = Clinic::select('id','app_type')->findOrFail($employee_id);

        // معالجة التواريخ
        $dates = array_map('trim', explode(',', $request->dateA));
        $dates = array_filter($dates); // إزالة القيم الفارغة

        if (empty($dates)) {
            return redirect()->back()->withErrors(['dateA' => 'لم يتم اختيار أي تواريخ'])->withInput();
        }

        $days   = $request->days ?? [];
        $shifts = array_filter($request->shift_id ?? []);

        foreach ($dates as $date) {
            // التحقق من صحة التاريخ
            if (!strtotime($date)) {
                continue;
            }

            // حالة الإجازة
            if ($request->status == 0) {
                ShiftEmployee::where('employee_id', $clinic->id)
                    ->whereDate('dateA', $date)
                    ->delete();

                ShiftEmployee::create([
                    'employee_id' => $clinic->id,
                    'clinic_id'   => $auth_app,
                    'account_type'=> $clinic->app_type,
                    'dateA'       => $date,
                    'status'      => 0,
                    'shift_id'    => null,
                    'day_id'      => null,
                ]);

                continue;
            }

            // حالة العمل
            foreach ($days as $dayId) {
                $i = 0;
                foreach ($shifts as $shiftId) {
                    if (!empty($shiftId)) {
                        ShiftEmployee::updateOrCreate(
                            [
                                'employee_id' => $clinic->id,
                                'shift_id'    => $shiftId,
                                'dateA'       => $date,
                                'day_id'      => $dayId,
                            ],
                            [
                                'clinic_id'    => $auth_app,
                                'account_type' => $clinic->app_type,
                                'status'       => 1,
                            ]
                        );
                        $i++;
                    }
                }
            }
        }

        session()->flash('success', trans('messages.Added'));
        return redirect()->back();
    }



    public function add_employee_shift($employee_id, Request $request)
    {
        $auth_app = Auth::user()->app_type == 7
            ? Auth::user()->id
            : Auth::user()->parent_id;
        $clinic = Clinic::select('id','app_type')->findOrFail($employee_id);
        // =========================
        // 1️⃣ حالة الإجازة
        // =========================
        if ($request->status == 0) {

            $request->validate([
                'holiday_from' => 'required|date',
                'holiday_to'   => 'required|date|after_or_equal:holiday_from',
            ]);

            $period = CarbonPeriod::create(
                $request->holiday_from,
                $request->holiday_to
            );

            foreach ($period as $date) {

                // ❌ منع إجازة فوق شيفت
                $hasShift = ShiftEmployee::where('employee_id', $employee_id)
                    ->where('dateA', $date->format('Y-m-d'))
                    ->where('status', 1)
                    ->exists();

                if ($hasShift) {
                    return back()->withErrors([
                        'holiday' =>
                            'لا يمكن إضافة إجازة، يوجد شيفت بتاريخ ' .
                            $date->format('Y-m-d')
                    ]);
                }
            }

            // ✔ حفظ الإجازات
            foreach ($period as $date) {
                ShiftEmployee::create([
                    'employee_id' => $employee_id,
                    'status'      => 0, // إجازة
                    'dateA'       => $date->format('Y-m-d'),
                    'clinic_id'   => $auth_app,
                    'account_type'=> $clinic->app_type,
                ]);
            }

            return back()->with('success', 'تمت إضافة الإجازة بنجاح');
        }

        // =========================
        // 2️⃣ حالة الشيفت
        // =========================
        if ($request->status == 1) {

            $request->validate([
                'shift_id' => 'required|exists:shifts,id',
                'days'     => 'required|array|min:1',
            ]);

            foreach ($request->days as $dayId) {

                ShiftEmployee::create([
                    'employee_id' => $employee_id,
                    'shift_id'    => $request->shift_id,
                    'day_id'      => $dayId,
                    'status'      => 1,
                    'clinic_id'   => $auth_app,
                    'account_type'=> $clinic->app_type,
                ]);
            }

            return back()->with('success', 'تمت إضافة الشيفت بنجاح');
        }

        return back();
    }


    public function calendar(Clinic $employee)
    {
        return ShiftEmployee::where('employee_id', $employee->id)
            ->get()
            ->map(function ($shift) {
                return [
                    'id'    => $shift->id,
                    'title' => $shift->status == 1
                        ? optional($shift->shift)->name
                        : 'إجازة',
                    'start' => $shift->dateA,
                    'allDay'=> true,
                    'color' => $shift->status == 1
                        ? '#28a745'
                        : '#dc3545',
                ];
            });
    }

    /**
     * تحريك الشيفت أو الإجازة (Drag & Drop)
     */
    public function move(Request $request, ShiftEmployee $shift)
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        // ❌ منع تحريك إجازة فوق شيفت
        if ($shift->status == 0) {

            $exists = ShiftEmployee::where('employee_id', $shift->employee_id)
                ->where('dateA', $request->date)
                ->where('status', 1)
                ->exists();

            if ($exists) {
                return response()->json([
                    'error' => 'يوجد شيفت في هذا اليوم'
                ], 422);
            }
        }

        $shift->update([
            'dateA' => $request->date
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    //Edit department_shift
    public function edit_employee_shift($id, Request $request)
    {
        $edit_shift = ShiftEmployee::where('id', $id)->first();
        $data = $request->all();
        $edit_shift->update($data);
        session()->flash('success', trans('messages.updated'));
        return redirect()->back();
    }

    public function update_status_employee_shift($id, $status)
    {
        $status_shift = ShiftEmployee::where('id', $id)->first();
        $status_shift->status = $status;
        $status_shift->save();
        session()->flash('success', trans('messages.update_status'));
    }

    // delete department_shift
    function destroy_employee_shift($id)
    {
        ShiftEmployee::where('id', $id)->delete();
        session()->flash('success', trans('messages.deleted'));
        return redirect()->back();
    }

    private function prepareCalendarEvents($employeeShifts)
    {
        $events = [];
        $processedShifts = [];

        foreach ($employeeShifts as $shift) {
            if ($shift->status == 1) { // شيفت
                if ($shift->days) {
                    // شيفت متكرر
                    $shiftKey = 'shift_' . $shift->shift_id . '_' . $shift->id;

                    if (!in_array($shiftKey, $processedShifts)) {
                        $daysOfWeek = [];
                        $day = Day::find($shift->day_id);
                        $dayName = app()->getLocale() == 'en' ? $day->name_en : $day->name_ar;
                        // معالجة الأيام
                        if (is_array($shift->days) || is_object($shift->days)) {
                            foreach ($shift->days as $dayId) {
                                $day = Day::find($dayId);
                                if ($day) {
                                    $daysOfWeek[] = $this->convertDayToFullCalendarFormat($day->id);
                                }
                            }
                        }

                        // عنوان الحدث مع الأيام
                        $dayNamesStr = !empty($dayName) ? $dayName : '';

                        $events[] = [
                            'id' => $shift->id,
                            'title' => $shift->shift->name . $dayNamesStr,
                            'daysOfWeek' => $daysOfWeek,
                            'startTime' => $shift->shift->start_time ?? '09:00',
                            'endTime' => $shift->shift->end_time ?? '17:00',
                            'color' => '#3788d8',
                            'display' => 'block',
                            'extendedProps' => [
                                'type' => 'recurring_shift',
                                'shift_id' => $shift->shift_id,
                                'employee_id' => $shift->employee_id,
                                'days' => $shift->days
                            ]
                        ];

                        $processedShifts[] = $shiftKey;
                    }

                } elseif ($shift->date) {
                    // شيفت ليوم محدد
                    $events[] = [
                        'id' => $shift->id,
                        'title' => $shift->shift->name,
                        'start' => $shift->date . 'T' . ($shift->shift->start_time ?? '09:00'),
                        'end' => $shift->date . 'T' . ($shift->shift->end_time ?? '17:00'),
                        'color' => '#3788d8',
                        'extendedProps' => [
                            'type' => 'specific_shift'
                        ]
                    ];
                }
            } else { // إجازة
                if ($shift->dateA) {
                    if (strpos($shift->dateA, ' - ') !== false) {
                        $dates = explode(' - ', $shift->dateA);
                        $startDate = Carbon::parse($dates[0]);
                        $endDate = Carbon::parse($dates[1]);

                        $events[] = [
                            'id' => $shift->id,
                            'title' => 'إجازة',
                            'start' => $startDate->format('Y-m-d'),
                            'end' => $endDate->copy()->addDay()->format('Y-m-d'),
                            'color' => '#f39c12',
                            'allDay' => true,
                            'extendedProps' => [
                                'type' => 'holiday',
                                'start_date' => $startDate->format('Y-m-d'),
                                'end_date' => $endDate->format('Y-m-d')
                            ]
                        ];
                    } else {
                        $date = Carbon::parse($shift->dateA);
                        $events[] = [
                            'id' => $shift->id,
                            'title' => 'إجازة',
                            'start' => $date->format('Y-m-d'),
                            'end' => $date->copy()->addDay()->format('Y-m-d'),
                            'color' => '#f39c12',
                            'allDay' => true,
                            'extendedProps' => [
                                'type' => 'holiday',
                                'date' => $date->format('Y-m-d')
                            ]
                        ];
                    }
                }
            }
        }

        return $events;
    }

    private function convertDayToFullCalendarFormat($dayId)
    {

        $map = [
            1 => 1, // الاثنين
            2 => 2, // الثلاثاء
            3 => 3, // الأربعاء
            4 => 4, // الخميس
            5 => 5, // الجمعة
            6 => 6, // السبت
            7 => 0, // الأحد (في FullCalendar الأحد = 0)
        ];

        return $map[$dayId] ?? 0;
    }
}
