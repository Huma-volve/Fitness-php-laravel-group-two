<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PackageController extends Controller
{
    use ApiResponse;


    public function index()
    {
        $packages = Package::all();


        return $this->success(PackageResource::collection($packages), 'Packages fetched successfully', 200);
    }


    public function show($id)
    {
        $package = Package::find($id);

        if (!$package) {
            return $this->error('Package not found', 404, null);
        }

        return $this->success($package, 'Package fetched successfully', 200);
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate(Package::rules());



            $package = Package::create($validated);






            return $this->success($package, 'Package created successfully', 201);
        } catch (ValidationException $e) {

            return $this->success($e->errors(), 'Validation failed', 422);
        }
    }


    public function update(Request $request, $id)
    {
        $package = Package::find($id);

        if (!$package) {
            return $this->error('Package not found', 404, null);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|in:Single Pack,Monthly Pack,Premium Pack',
            'sessions_count' => 'nullable|integer',
            'price' => 'sometimes|numeric',
        ]);

        $package->update($data);

        return $this->success($package, 'Package updated successfully', 200);
    }


    public function destroy($id)
    {
        $package = Package::find($id);

        if (!$package) {
            return $this->error('Package not found', 404, null);
        }

        $package->delete();

        return $this->success(null, 'Package deleted successfully', 200);
    }
}
