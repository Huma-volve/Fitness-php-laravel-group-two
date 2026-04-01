<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    use ApiResponse;
    public function index()
    {
        $bookings = Booking::with('trainerPackage.package', 'trainerPackage.trainer', 'user')->get();


        return $this->success(BookingResource::collection($bookings), 'Bookings fetched successfully', 200);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate(Booking::rules());
            $exists = Booking::where('trainer_package_id', $validated['trainer_package_id'])
                ->where('date', $validated['date'])
                ->where('time', $validated['time'])
                ->exists();

            if ($exists) {
                return $this->error('This time slot is already booked for this trainer.', 409);
            }



            $booking = Booking::create($validated);







            return $this->success($booking, 'Booking fetched successfully', 200);
        } catch (ValidationException $e) {
            return $this->success($e->errors(), 'Validation failed', 422);
        }
    }

    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'status' => 'confirmed'
        ]);


        return $this->success($booking, 'Booking confirmed successfully', 200);
    }


    public function cancel($id)
    {
        $bookings = Booking::findOrFail($id);

        $bookings->update([
            'status' => 'cancelled'
        ]);
        return $this->success($bookings, 'Booking cancelled successfully', 200);
    }
    public function reschedule(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);


        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
        ]);

        // التحقق من توافر الوقت مع نفس المدرب
        $exists = Booking::where('trainer_package_id', $booking->trainer_package_id)
            ->where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->where('id', '!=', $booking->id)
            ->exists();

        if ($exists) {
            return $this->error('This time slot is already booked for this trainer.', 409);
        }

        $booking->update($validated);

        return $this->success(
            $booking,
            'Booking rescheduled successfully',
            200
        );
    }
}
