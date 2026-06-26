<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::user()->id_user;
        $today = now()->format('Y-m-d');

        $activeQueue = DB::table('appointments')
            ->join('doctor_schedules', 'appointments.id_schedule', '=', 'doctor_schedules.id_schedule')
            ->join('users', 'doctor_schedules.id_user', '=', 'users.id_user')
            ->select(
                'appointments.*',
                'doctor_schedules.room as clinic',
                'doctor_schedules.shift',
                'users.user_name as doctor_name'
            )
            ->where('appointments.id_user', $userId)
            ->whereIn('appointments.status', ['W', 'I'])
            ->whereDate('appointments.appointment_date', '>=', $today)
            ->orderBy('appointments.appointment_date', 'asc')
            ->first();

        $estimatedTime = '—';
        if ($activeQueue) {
            $waktuMulai = strtotime('08:00');
            
            if (stripos($activeQueue->shift, 'afternoon') !== false) {
                $waktuMulai = strtotime('13:00');
            } elseif (stripos($activeQueue->shift, 'evening') !== false) {
                $waktuMulai = strtotime('18:00');
            } elseif (strpos($activeQueue->shift, '-') !== false) {
                $shiftParts = explode('-', $activeQueue->shift);
                $waktuMulai = strtotime(trim($shiftParts[0]));
            }
            
            $tambahanMenit = ($activeQueue->queue_number - 1) * 30;
            $estimatedTime = date('H:i', strtotime("+$tambahanMenit minutes", $waktuMulai));
        }

        return view('dashboard', compact('activeQueue', 'estimatedTime'));
    }

    public function booking()
    {
        $doctors = DB::table('users')
                    ->whereIn('id_user', function($query) {
                        $query->select('id_user')->from('doctor_schedules');
                    })
                    ->select('id_user', 'user_name', 'user_dept as department')
                    ->get();

        return view('booking', compact('doctors'));
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function success()
    {
        return view('success');
    }

    public function ticket()
    {
        $userId = Auth::user()->id_user;
        $today = now()->format('Y-m-d');

        $activeQueue = DB::table('appointments')
            ->join('doctor_schedules', 'appointments.id_schedule', '=', 'doctor_schedules.id_schedule')
            ->join('users', 'doctor_schedules.id_user', '=', 'users.id_user')
            ->select(
                'appointments.*',
                'doctor_schedules.room as clinic',
                'doctor_schedules.shift',
                'users.user_name as doctor_name',
                'users.user_dept as specialty'
            )
            ->where('appointments.id_user', $userId)
            ->whereIn('appointments.status', ['W', 'I'])
            ->whereDate('appointments.appointment_date', '>=', $today)
            ->orderBy('appointments.appointment_date', 'asc')
            ->first();

        if (!$activeQueue) {
            return redirect('/patient/dashboard');
        }

        $waktuMulai = strtotime('08:00');
        if (stripos($activeQueue->shift, 'afternoon') !== false) {
            $waktuMulai = strtotime('13:00');
        } elseif (stripos($activeQueue->shift, 'evening') !== false) {
            $waktuMulai = strtotime('18:00');
        } elseif (strpos($activeQueue->shift, '-') !== false) {
            $shiftParts = explode('-', $activeQueue->shift);
            $waktuMulai = strtotime(trim($shiftParts[0]));
        }
        $tambahanMenit = ($activeQueue->queue_number - 1) * 30;
        $estimatedTime = date('H:i', strtotime("+$tambahanMenit minutes", $waktuMulai));

        return view('ticket', compact('activeQueue', 'estimatedTime'));
    }

    public function queueDetail()
    {
        $userId = Auth::user()->id_user;
        $today = now()->format('Y-m-d');

        $activeQueue = DB::table('appointments')
            ->join('doctor_schedules', 'appointments.id_schedule', '=', 'doctor_schedules.id_schedule')
            ->join('users', 'doctor_schedules.id_user', '=', 'users.id_user')
            ->select(
                'appointments.*',
                'doctor_schedules.room as clinic',
                'doctor_schedules.shift',
                'users.user_name as doctor_name',
                'users.user_dept as specialty'
            )
            ->where('appointments.id_user', $userId)
            ->whereIn('appointments.status', ['W', 'I'])
            ->whereDate('appointments.appointment_date', '>=', $today)
            ->orderBy('appointments.appointment_date', 'asc')
            ->first();

        if (!$activeQueue) {
            return redirect('/patient/dashboard');
        }

        $waktuMulai = strtotime('08:00');
        if (stripos($activeQueue->shift, 'afternoon') !== false) {
            $waktuMulai = strtotime('13:00');
        } elseif (stripos($activeQueue->shift, 'evening') !== false) {
            $waktuMulai = strtotime('18:00');
        } elseif (strpos($activeQueue->shift, '-') !== false) {
            $shiftParts = explode('-', $activeQueue->shift);
            $waktuMulai = strtotime(trim($shiftParts[0]));
        }
        $tambahanMenit = ($activeQueue->queue_number - 1) * 30;
        $estimatedTime = date('H:i', strtotime("+$tambahanMenit minutes", $waktuMulai));

        $aheadCount = DB::table('appointments')
            ->where('id_schedule', $activeQueue->id_schedule)
            ->whereDate('appointment_date', $activeQueue->appointment_date)
            ->whereIn('status', ['W', 'I'])
            ->where('queue_number', '<', $activeQueue->queue_number)
            ->count();
        
        $totalInSchedule = DB::table('appointments')
            ->where('id_schedule', $activeQueue->id_schedule)
            ->whereDate('appointment_date', $activeQueue->appointment_date)
            ->count();
        
        $progress = $totalInSchedule > 0 ? round((($totalInSchedule - $aheadCount - 1) / $totalInSchedule) * 100) : 0;
        if ($progress < 0) $progress = 0;
        if ($activeQueue->status == 'I') $progress = 90;

        return view('queue-detail', compact('activeQueue', 'estimatedTime', 'aheadCount', 'progress'));
    }

    public function history()
    {
        $userId = Auth::user()->id_user;

        $histories = DB::table('appointments')
            ->join('doctor_schedules', 'appointments.id_schedule', '=', 'doctor_schedules.id_schedule')
            ->join('users', 'doctor_schedules.id_user', '=', 'users.id_user')
            ->select(
                'appointments.*',
                'doctor_schedules.room as clinic',
                'users.user_name as doctor_name',
                'users.user_dept as specialty'
            )
            ->where('appointments.id_user', $userId)
            ->whereNotIn('appointments.status', ['W', 'I'])
            ->orderBy('appointments.appointment_date', 'desc')
            ->get();

        return view('history', compact('histories'));
    }

    public function visitDetail(Request $request)
    {
        $appointmentId = $request->input('id');
        $userId = Auth::user()->id_user;

        $detail = DB::table('appointments')
            ->join('doctor_schedules', 'appointments.id_schedule', '=', 'doctor_schedules.id_schedule')
            ->join('users', 'doctor_schedules.id_user', '=', 'users.id_user')
            ->leftJoin('medical_records', 'appointments.id_appointments', '=', 'medical_records.id_appointments')
            ->select(
                'appointments.*',
                'doctor_schedules.room as clinic',
                'users.user_name as doctor_name',
                'users.user_dept as specialty',
                'medical_records.diagnosis',
                'medical_records.notes',
                'medical_records.id_med_records'
            )
            ->where('appointments.id_appointments', $appointmentId)
            ->where('appointments.id_user', $userId)
            ->first();

        if (!$detail) {
            return redirect('/patient/history');
        }

        $prescriptions = [];
        if (!empty($detail->id_med_records)) {
            $prescriptions = DB::table('medicines_record_medicine')
                ->join('medicines', 'medicines_record_medicine.id_med', '=', 'medicines.id_med')
                ->select(
                    'medicines.med_name', 
                    'medicines.med_unit', 
                    'medicines_record_medicine.quantity', 
                    'medicines_record_medicine.dosage'
                )
                ->where('medicines_record_medicine.id_med_records', $detail->id_med_records)
                ->get();
        }

        return view('visit-detail', compact('detail', 'prescriptions'));
    }

    public function profile()
    {
        $userId = Auth::user()->id_user;

        $profile = DB::table('users')
            ->leftJoin('patient_profiles', 'users.id_user', '=', 'patient_profiles.id_user')
            ->select('users.*', 'patient_profiles.*')
            ->where('users.id_user', $userId)
            ->first();

        return view('patient-profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $userId = Auth::user()->id_user;

        $fullName = $request->input('first_name') . ' ' . $request->input('last_name');
        
        DB::table('users')->where('id_user', $userId)->update([
            'user_name'  => $fullName,
            'user_phone' => $request->input('phone_number'),
        ]);

        $existingProfile = DB::table('patient_profiles')->where('id_user', $userId)->first();

        if ($existingProfile) {
            DB::table('patient_profiles')->where('id_user', $userId)->update([
                'gender'        => $request->input('gender'),
                'date_of_birth' => $request->input('date_of_birth'),
            ]);
        } else {
            DB::table('patient_profiles')->insert([
                'id_patient'    => 'PT-' . rand(100000, 999999), 
                'id_user'       => $userId,
                'nim_nip'       => $userId, 
                'gender'        => $request->input('gender'),
                'date_of_birth' => $request->input('date_of_birth'),
                'address'       => '-',
                'blood_type'    => '-',
            ]);
        }

        return redirect('/patient/profile');
    }

    public function storeBooking(Request $request)
    {
        $userId = Auth::user()->id_user;

        $doctorId = $request->input('doctor_id');
        $dateRaw = $request->input('date_raw');
        $shiftName = $request->input('slot'); 
        $clinicName = $request->input('clinic');

        $schedule = DB::table('doctor_schedules')
            ->where('id_user', $doctorId)
            ->whereDate('schedule_date', $dateRaw)
            ->where('shift', 'LIKE', "%$shiftName%")
            ->first();

        if (!$schedule) {
            $idSchedule = 'SC-' . rand(100000, 999999);
            DB::table('doctor_schedules')->insert([
                'id_schedule'   => $idSchedule,
                'id_user'       => $doctorId,
                'schedule_date' => $dateRaw,
                'shift'         => $shiftName,
                'room'          => $clinicName . ' - R.101',
                'quota'         => 50
            ]);
        } else {
            $idSchedule = $schedule->id_schedule;
        }

        $lastQueue = DB::table('appointments')
            ->where('id_schedule', $idSchedule)
            ->whereDate('appointment_date', $dateRaw)
            ->max('queue_number');
        
        $newQueue = $lastQueue ? $lastQueue + 1 : 1;
        $appointmentId = 'AP-' . rand(100000, 999999);

        DB::table('appointments')->insert([
            'id_appointments'  => $appointmentId,
            'id_user'          => $userId,
            'id_schedule'      => $idSchedule,
            'appointment_date' => $dateRaw,
            'queue_number'     => $newQueue,
            'status'           => 'W',
        ]);

        return redirect('/patient/dashboard');
    }

    public function cancelAppointment(Request $request)
    {
        $userId = Auth::user()->id_user;
        $appointmentId = $request->input('appointment_id');

        DB::table('appointments')
            ->where('id_appointments', $appointmentId)
            ->where('id_user', $userId)
            ->update(['status' => 'C']);

        return redirect('/patient/dashboard');
    }

    public function getDoctorShifts(Request $request)
    {
        $doctorId = $request->query('doctor_id');
        $date = $request->query('date');

        $shifts = DB::table('doctor_schedules')
            ->where('id_user', $doctorId)
            ->whereDate('schedule_date', $date)
            ->get();

        return response()->json($shifts);
    }
}